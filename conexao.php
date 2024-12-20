<?php 
    $host = "localhost";
    $user = "root";
    $password = "";
    $dbname = "motivegym";
    $port = "3306";

    try{
        $conn = new PDO("mysql:host=$host;port=$port;dbname=" . $dbname, $user, $password);
        //echo "SUCESSO: Conexão com o banco de dados realizada com sucesso!";
    } catch(Exception $ex) {
        echo "ERRO: Falha na conexão com o banco de dados";
    }
?>