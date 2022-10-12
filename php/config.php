<?php 

$host = "localhost";
$user = "root";
$password = "";
$database = "test";

$connessione = new mysqli($host, $user, $password, $database);

if($connessione == false){
    die("Errore durante la connessione ". $connessione->connect_error);
};

?>