<?php 
$host = 'localhost';
$dbname = 'phpTest';
$db_user = 'root';
$db_pass = 'Hello*111#';
$db_option = [
    PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE =>PDO::FETCH_ASSOC
];
function openConnection(){
    global $host;
    global $db_user;
    global $dbname;
    global $db_pass;
    global $db_option;
    try{
        $conn = new PDO("mysql:host=$host;dbname=$dbname",$db_user,$db_pass,$db_option);
      return $conn;
    }
    catch(Exception $e){
        echo $e->getMessage();
    }

}