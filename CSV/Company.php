<?php

class Company
{
    protected $CompanyID;
    protected $CompanyName;
    public $connection;

    public function __construct($company)
    {
        $this->connection = (new Connection())->getConnection();
        $this->CompanyID = $company['CompanyID'];
        $this->CompanyName = $company['CompanyName'];
    }

    public static function getCompany($companyId)
    {
        $connection = (new Connection())->getConnection();
        $stmt = $connection->prepare("SELECT * from company WHERE company_id=:company_id");
        $stmt->execute(['company_id' => $companyId]);
        $company = $stmt->fetch();        
        return $company;
    }

    public function updateOrCreate()
    {
        $data = [
            'company_id' => $this->CompanyID,
            'name' => $this->CompanyName     
        ];
        $stmt = $this->connection->prepare("SELECT id from company WHERE company_id=:company_id");
        $company = $stmt->execute(['company_id' => $this->CompanyID]);
        $company = $stmt->fetch();
        if(empty($company)){
            $sql = "INSERT INTO company (`company_id`,`name`) values(:company_id,:name)";
            $this->connection->prepare($sql)->execute($data);
            return $this->connection->lastInsertId();
        }else{
            $sql = "UPDATE company SET name=:name WHERE company_id=:company_id";
            $this->connection->prepare($sql)->execute($data);
            return $company['id'];
        }
    }
}
