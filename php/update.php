<?php 

require_once('config.php');

$id = $_POST['id_persona'];
$email = $_POST['email'];

$sql = "UPDATE persone SET email='$email' WHERE id_persona = $id";

if($connessione->query($sql) == true){
    $data = [
        "messaggio" => "Riga aggiornata con successo",
        "response" => 1
    ];
    echo json_encode($data);
}else{
    $data = [
        "messaggio" => "Impossibile aggiornare email",
        "response" => 0
    ];
    echo json_encode($data);
}

?>