<?php

session_start();

// Verifica se o administrador está com a sessão inicida
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    // Redireciona para a página de login se não estiver com a sessão iniciada
    header("Location: login.php");
    exit();
}

include('db.php');
include('navbar.php');

// Consulta SQL para obter o número de alunos
$queryAlunos = "SELECT COUNT(*) AS totalAlunos FROM alunos";
$resultadoAlunos = mysqli_query($conexao, $queryAlunos);
$totalAlunos = mysqli_fetch_assoc($resultadoAlunos)['totalAlunos'];

// Consulta SQL para obter o número de atividades
$queryAtividades = "SELECT COUNT(*) AS totalAtividades FROM atividades";
$resultadoAtividades = mysqli_query($conexao, $queryAtividades);
$totalAtividades = mysqli_fetch_assoc($resultadoAtividades)['totalAtividades'];

// Consulta SQL para obter o número de atividades em andamento
$queryAtividadesAndamento = "SELECT COUNT(*) AS totalAtividadesAndamento FROM atribuicoes WHERE hora_saida IS NULL";
$resultadoAtividadesAndamento = mysqli_query($conexao, $queryAtividadesAndamento);
$totalAtividadesAndamento = mysqli_fetch_assoc($resultadoAtividadesAndamento)['totalAtividadesAndamento'];

// Fechar a conexão com o banco de dados
mysqli_close($conexao);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Estatísticas</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1 class="mt-4">Estatísticas</h1>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total de Alunos</h5>
                        <p class="card-text"><?php echo $totalAlunos; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total de Atividades</h5>
                        <p class="card-text"><?php echo $totalAtividades; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Atividades em Andamento</h5>
                        <p class="card-text"><?php echo $totalAtividadesAndamento; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
</body>

</html>
