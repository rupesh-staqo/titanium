<?php

class Connection
{

    private  $server = "mysql:host=localhost;dbname=ebunch_titanium";
    private  $user = "root";
    private  $pass = "sfl@2019";
    private  $options  = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,);
    protected $conn;

    public function __construct()
    {
        try {
            $this->conn = new PDO($this->server, $this->user, $this->pass, $this->options);
        } catch (PDOException $e) {
            echo "There is some problem in connection: " . $e->getMessage();
        }
    }
    

    public function __destruct()
    {
        $this->conm = null;
    }

    public function getConnection()
    {
        return ($this->conn);
    }

    public function insert(object $company)
    {
        
    }

    public function batchInsert(array $companies)
    {
        
    }    
}
