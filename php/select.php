<?php

require_once('config.php');

$sql = 'SELECT * FROM persone';

if($result = $connessione->query($sql)){

    if($result->num_rows >0){
        $data = [];
        while($row = $result->fetch_array(MYSQLI_ASSOC)){
            $tmp;
            $tmp['id_persona'] = $row['id_persona'];
            $tmp['nome'] = $row['nome'];
            $tmp['cognome'] = $row['cognome'];
            $tmp['email'] = $row['email'];
            array_push($data, $tmp);
        }
        echo json_encode($data);
    }else{
        echo json_encode($data);
        echo "Non ci sono righe disponibili";
    }

}else{
    echo "Errore nell'essecuzione di $sql ". $result->error;
}

?>