<?php
session_start();

// Verifica se o administrador está com a sessão inicida
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    // Redireciona para a página de login se não estiver com a sessão iniciada
    header("Location: login.php");
    exit();
}

include('db.php');

// Verifica se o formulário de edição foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $turma = $_POST['turma'];
    $numero_cartao = $_POST['numero_cartao'];
    $numero_processo = $_POST['numero_processo'];

    // Atualiza os detalhes do aluno na base de dados
    $query = "UPDATE alunos SET nome='$nome', turma='$turma', numero_cartao='$numero_cartao', numero_processo='$numero_processo' WHERE id='$id'";
    mysqli_query($conexao, $query);

    // Redireciona de volta para a página da lista de alunos
    header("Location: lista_alunos.php");
    exit();
}

$id = $_GET['id'];
$query = "SELECT * FROM alunos WHERE id='$id'";
$resultado = mysqli_query($conexao, $query);
$aluno = mysqli_fetch_assoc($resultado);
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <title>Editar Aluno</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="icon" type="image/x-icon" href="/logo.gif">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <h1>Editar Aluno</h1>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $aluno['id']; ?>">

            <div class="mb-3">
                <label for="nome" class="form-label">Nome:</label>
                <input class="form-control" type="text" name="nome" value="<?php echo $aluno['nome']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="turma" class="form-label">Turma:</label>
                <input class="form-control" type="text" name="turma" value="<?php echo $aluno['turma']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="numero_cartao" class="form-label">Número do Cartão:</label>
                <input class="form-control" type="text" name="numero_cartao"
                    value="<?php echo $aluno['numero_cartao']; ?>" required maxlength="10">
            </div>


            <div class="mb-3">
                <label for="numero_processo" class="form-label">Número do Processo:</label>
                <input class="form-control" type="text" name="numero_processo"
                    value="<?php echo $aluno['numero_processo']; ?>" required>
            </div>

            <input class="btn btn-primary" type="submit" value="Guardar">
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
</body>

</html>