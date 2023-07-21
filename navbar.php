<?php
include('db.php');

// Verifica se o administrador está logado
if (isset($_SESSION['logado']) && $_SESSION['logado'] === true) {
    // Obtém o email do administrador logado
    $email = $_SESSION['email'];

    // Consulta SQL para obter o nome do administrador
    $query = "SELECT name FROM administradores WHERE email = '$email'";
    $resultado = mysqli_query($conexao, $query);
    $administrador = mysqli_fetch_assoc($resultado);
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="/logo.gif">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>
    <nav class=" navbar navbar-dark bg-dark sticky-top navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand me-5 fs-4 fw-bold" href="lista_alunos.php">
                <img src="logo.gif" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                BibliotecApp</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <a class="btn btn-secondary rounded-pill me-2" href="lista_alunos.php" type="button">
                        <i class="bi-house-fill"></i> Home
                    </a>

                    <li class=" dropdown me-2">
                        <button class="btn btn-secondary dropdown-toggle rounded-pill" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi-person-fill"></i> Alunos
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" type="button" href="lista_alunos.php">Lista Alunos</a></li>
                            <li><a class="dropdown-item" type="button" href="criar_aluno.php">Criar Aluno</a></li>
                            <li><a class="dropdown-item" type="button" href="perfil_aluno.php">Perfil Aluno</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle rounded-pill" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi-journal"></i> Atividades
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item mt-2" type="button" href="lista_atividades.php">Lista de
                                    Atividades</a></li>
                            <li><a class="dropdown-item" type="button" href="historico_atividades.php">Histórico de
                                    Atividades</a></li>
                            <li><a class="dropdown-item" type="button" href="atividades_decorrer.php">Atividades em
                                    Andamento</a></li>
                            <li><a class="dropdown-item" type="button" href="criar_atividade.php">Criar Atividade</a>
                            </li>
                            <li><a class="dropdown-item" type="button" href="atribuir_atividades.php">Atribuir
                                    Atividade</a></li>
                            <li><a class="dropdown-item" type="button" href="atribuir_saida.php">Atribuir Saída</a></li>
                            <li><a class="dropdown-item" type="button" href="estatisticas.php">Estatísticas</a></li>

                        </ul>
                    </li>

                </ul>
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($administrador)) { ?>
                        <li class="nav-item">
                            <span class="nav-link text-white mx-2">Olá,
                                <?php echo $administrador['name']; ?>
                            </span>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-danger rounded-pill" href="logout.php">Logout</a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">Register</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>
    
    <script src="https://unpkg.com/@popperjs/core@2"></script>
</body>

</html>