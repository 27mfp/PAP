<?php
session_start();

// Verifica se o administrador está com a sessão inicida
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    // Redireciona para a página de login se não estiver com a sessão iniciada
    header("Location: login.php");
    exit();
}

include('db.php');

// Verifica se o ID da atividade foi fornecido
if (!isset($_GET['id'])) {
    echo "ID da atividade não fornecido.";
    exit();
}

$id = $_GET['id'];

// Obtém os detalhes da atividade pelo ID
$query = "SELECT * FROM atividades WHERE id = '$id'";
$resultado = mysqli_query($conexao, $query);
$atividade = mysqli_fetch_assoc($resultado);

// Verifica se a atividade foi encontrada
if (!$atividade) {
    echo "Atividade não encontrada.";
    exit();
}

// Verifica se o formulário de edição foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descricao_atividade = $_POST['descricao_atividade'];

    // Atualiza os detalhes da atividade na base de dados
    $query = "UPDATE atividades SET nome = '$nome', descricao_atividade = '$descricao_atividade' WHERE id = '$id'";
    mysqli_query($conexao, $query);

    // Redireciona de volta para a página de lista de atividades
    header("Location: lista_atividades.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Editar Atividade</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="icon" type="image/x-icon" href="/logo.gif">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

</head>

<body>
<?php include('navbar.php'); ?>
    <div class="container mt-5">
        <h1>Editar Atividade</h1>

        <!-- Formulário de edição da atividade -->
        <form method="POST" action="">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome da Atividade:</label>
                <input class="form-control" type="text" name="nome" value="<?php echo isset($atividade['nome']) ? $atividade['nome'] : ''; ?>" required>
            </div>

            <div class="mb-3">
                <label for="descricao_atividade" class="form-label">Descrição da Atividade:</label>
                <input class="form-control" type="text" name="descricao_atividade" value="<?php echo isset($atividade['descricao_atividade']) ? $atividade['descricao_atividade'] : ''; ?>" required>
            </div>

            <input class="btn btn-primary" type="submit" value="Guardar Alterações">
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>