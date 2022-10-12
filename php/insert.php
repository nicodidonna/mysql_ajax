<?php 

require_once('config.php');

$nome = $_POST['nome'];
$cognome = $_POST['cognome'];
$email = $_POST['email'];


$sql = "INSERT INTO persone(nome, cognome, email) VALUES ('$nome', '$cognome', '$email')";

if($connessione->query($sql)==true){
    $data = [
        "messaggio" => "Riga inserita con successo",
        "response" => 1
    ];
    echo json_encode($data);
}else{
    $data = [
        "messaggio" => "Errore nell'inserimento della riga",
        "response" => 0
    ];
    echo json_encode($data);
}
?>