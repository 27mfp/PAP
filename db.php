<?php
$host = "localhost";
$utilizador = "root";
$password = "";
$db = "biblioteca";

$conexao = mysqli_connect($host, $utilizador, $password, $db);

if (mysqli_connect_errno()) {
    echo "Falha ao conectar com o MySQL: " . mysqli_connect_error();
    exit();
}

date_default_timezone_set('Europe/Lisbon');
