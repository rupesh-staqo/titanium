<?php

class Car{
    public $car;
    public $connection;
    public function __construct($company_id, $car)
    {
        $this->connection = (new Connection())->getConnection();
        $this->car = $car;
        $this->company_id = $company_id;
    }

    public function getMakeId()
    {
        $stmt = $this->connection->prepare("SELECT id from car_make WHERE make=:make");
        $stmt->execute(['make' => $this->car['Make']]); 
        $make = $stmt->fetch();
        if(empty($make)){
            $sql = "INSERT INTO car_make (`make`) values(?)";
            $this->connection->prepare($sql)->execute([$this->car['Make']]);
            return $this->connection->lastInsertId();
        }
        return $make['id'];
    }

    public function getYearId()
    {
        $stmt = $this->connection->prepare("SELECT id from car_year WHERE year=:year");
        $stmt->execute(['year' => $this->car['Year']]); 
        $year = $stmt->fetch();

        if(empty($year)){
            $sql = "INSERT INTO car_year (`year`) values(?)";
            $this->connection->prepare($sql)->execute([$this->car['Year']]);
            return $this->connection->lastInsertId();
        }
        return $year['id'];
    }    

    public function getModelId()
    {
        $data = [
            'make_id' => $this->getMakeId(),
            'year_id' => $this->getYearId(),
            'model_name' => $this->car['Model']
        ];
        $stmt = $this->connection->prepare("SELECT id from car_model WHERE make_id=:make_id AND year_id=:year_id AND model_name=:model_name");
        $stmt->execute($data);
        $model = $stmt->fetch();

        if(empty($model)){
            $sql = "INSERT INTO car_model (`make_id`, `year_id`, `model_name`) values(:make_id,:year_id,:model_name)";
            $this->connection->prepare($sql)->execute($data);
            return $this->connection->lastInsertId();
        }
        return $model['id'];
    }

    public function savePhotos($car_id, $photos)
    {
        $query = "INSERT INTO vehicle_photos (vehicle_id, position,filename) VALUES %s";
        $values = [];
        foreach($photos as $key => $photo)
        {
            $values[]= "($car_id,". ($key+1).", 'http://$photo')";
        }
        $values = implode(',',$values);

        $this->connection->query(sprintf($query, $values));
    }

    public function getVehicle()
    {
        $data = [
            'company_id' => $this->company_id,
            'vin' => $this->car['Vin'],
            'make' => $this->getMakeId(),
            'year' => $this->getYearId(),
            'stockNumber' => $this->getModelId(),
            'publishedTrim' => $this->car['Trim'],
            'odometer' => $this->car['KMS'],
            'odometer' => $this->car['KMS'],
            'extColour' => $this->car['Exterior Color'],
            'intColour' => $this->car['Interior Color'],
            'fuel' => $this->car['FuelType'],
            'engine' => $this->car['Engine Size'],
            'transmission' => $this->car['Transmission'],
            'cylinders' => $this->car['Cylinder'],
            'regularPrice' => $this->car['Price'],
            'vehicleDescription' => $this->car['AdDescription'],
        ];

        $photos = array_filter(explode('http://',ltrim($this->car['OtherPhoto'],'"')));
        array_unshift($photos,str_replace('http://','', $this->car['MainPhoto']));


        $stmt = $this->connection->prepare("SELECT vehicle_id from vehicle_info WHERE vin=:vin");
        $car = $stmt->execute(['vin' => $this->car['Vin']]);
        $car = $stmt->fetch();
        
        $dataKeys = array_keys($data);
        $carId = '';
        if(empty($car)){
            $column = implode(',',$dataKeys);
            $valueColumn = ':'.implode(', :',array_keys($data));
            $sql = "INSERT INTO vehicle_info ($column) values($valueColumn)";
            $this->connection->prepare($sql)->execute($data);
            $carId =  $this->connection->lastInsertId();
        }else{
            $update = 'SET ';
            foreach ($dataKeys as $key) {
                $update .= $key . '=:'.$key.',';
            }
            $update = substr($update, 0, -1);            
            $sql = "UPDATE vehicle_info ${update} WHERE vehicle_id=".$car['vehicle_id'];
            $this->connection->prepare($sql)->execute($data);
            $carId = $car['vehicle_id'];
        }

        if(!empty($carId) && !empty($photos)){
            $this->savePhotos($carId, $photos);
        }
    }
}