<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include "./helpers.php";
include "./FTP.php";
include "./CSV.php";
include "./Connection.php";

spl_autoload_register(function ($class) {
    include 'CSV/' . $class . '.php';
});

$input = ['download','company','car'];

if(!isset($_GET['cron']) || !in_array($_GET['cron'], $input)){
    die("Provide desired input");
} 


switch ($_GET['cron']) {
    //7PM
    case 'download':
        $ftp = new FTP();
        echo $ftp->downloadCsv();
    break;
    //8PM
    case 'company':
        $csv = new CSV('Vehicle.csv');
        $data = $csv->createCompany();
        echo "Company has beeen successfully synced";
    break;
    //8:30PM
    case 'car':
        $csv = new CSV('Vehicle.csv');
        $data = $csv->syncCar();
        echo "Car has beeen successfully synced";
    break;
    
    default:
        # code...
        break;
}

// $csv = new CSV();

// $csv->getCsv();

// $connection = new Connection();
// print_r($connection);