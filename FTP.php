<?php
//7 PM Cron
class FTP
{
    // FTP server details
    private $host   = 'ftp1.trader.com';
    private $username = 'CAGE_ebunch';
    private $password = ':X!fy39ntL';
    private $localFile = 'Vehicle.csv';
    private $serverFile = 'Transformed3505.csv';
    private $connection = '';
    private $login = '';

    public function __construct()
    {
        $this->connection = ftp_connect($this->host) or die("Couldn't connect to $this->host");
        $this->login = ftp_login($this->connection, $this->username, $this->password);
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function getLogin()
    {
        return $this->login;   
    }

    public function downloadCsv()
    {
        if (ftp_get($this->connection, $this->localFile, $this->serverFile, FTP_BINARY)) {
            echo "Successfully written to ".$this->localFile."\n";
        }
        else {
            echo "There was a problem\n";
        }
    }
}
