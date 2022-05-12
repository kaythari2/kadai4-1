<?php 

$db_driver="mysql";
$db_host="127.0.0.1";
$databaseName="car_manage_project";
$username="root";
$password="root";
$dsn=$db_driver.':host='.$db_host.';dbname='.$databaseName;
try{
	$connector=new PDO($dsn,$username,$password);
}catch(Exception $ex){
	echo $ex->getMessage();
}
