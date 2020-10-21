<?php
//8PM
class CSV
{

    private $data;
    public $connection;
    public function __construct($file = 'Vehicle.csv')
    {
        $this->connection = (new Connection())->getConnection();
        $this->data = $this->init($file);
    }

    public function init($fileName)
    {
        $csv = [];
        $file = fopen($fileName, "r");
        $header = explode('|', fgetcsv($file)[0]);
        $header = array_map('trim', $header);
        $i = 0;
        while (($line = fgetcsv($file)) !== FALSE) {
            $row = array_map('trim',explode('|', implode(' ', $line)));
            if(count($header) == count($row)){
                $csv[] = array_combine($header,$row);
            }else{
                $i++;
            }
        }
        fclose($file);
        return $csv;
    }

    public function createCompany()
    {
        $companyData = array_values(unique_multidim_array($this->data,'CompanyID'));
        foreach($companyData as $val){
            $company = new Company($val);
            $company->updateOrCreate();
        }

        return $companyData;
    }

    public function syncCar()
    {
        $this->connection->query("TRUNCATE TABLE `vehicle_photos`");
        $companyData = group_assoc($this->data,'CompanyID');
        foreach($companyData as $key => $cars){
            $company = Company::getCompany($key);
            if($company['is_sync']){
                foreach ($cars as $car) {
                    $carObj = new Car($company['id'], $car);
                    $carObj->getVehicle();
                }
            }
        }
        return $companyData;
    }
}
