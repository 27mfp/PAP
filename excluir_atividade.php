<?php
session_start();

// Verifica se o administrador está com a sessão inicida
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    // Redireciona para a página de login se não estiver com a sessão iniciada
    header("Location: login.php");
    exit();
}

include('db.php');

$id = $_GET['id'];

$query = "DELETE FROM atividades WHERE id='$id'";
mysqli_query($conexao, $query);

header("Location: lista_atividades.php");
exit();
