<?php
session_start();

// Verifica se o administrador está com a sessão iniciada
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    // Redireciona para a página de login se não estiver com a sessão iniciada
    header("Location: login.php");
    exit();
}

include('db.php');
include('navbar.php');

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados do formulário
    $nome = $_POST['nome'];
    $descricao_atividade = $_POST['descricao_atividade'];

    // Verifica se já existe uma atividade com o mesmo nome
    $queryVerificarAtividade = "SELECT nome FROM atividades WHERE nome = '$nome'";
    $resultadoVerificarAtividade = mysqli_query($conexao, $queryVerificarAtividade);

    if (mysqli_num_rows($resultadoVerificarAtividade) > 0) {
        // Exibe uma mensagem de erro se a atividade já existir
        $_SESSION['notificacao_erro'] = "Já existe uma atividade com o mesmo nome.";
    } else {
        // Insere a atividade na base de dados
        $query = "INSERT INTO atividades (nome, descricao_atividade) VALUES ('$nome', '$descricao_atividade')";
        $resultado = mysqli_query($conexao, $query);

        if ($resultado) {
            // Exibe uma mensagem de sucesso
            $_SESSION['notificacao_sucesso'] = "Atividade criada com sucesso";
        } else {
            // Exibe uma mensagem de erro em caso de falha
            $_SESSION['notificacao_erro'] = "Erro ao adicionar a atividade.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <title>Criar Atividade</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="icon" type="image/x-icon" href="/logo.gif">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>

<body>
    <div id="toast-container" class="position-fixed top-0 end-0 p-3" style="z-index: 9999;"></div>

    <div class="container">
        <h2 class="mt-4">Criar Atividade</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="mb-3">
                <label for="descricao_atividade" class="form-label">Descrição:</label>
                <textarea class="form-control" id="descricao_atividade" name="descricao_atividade" rows="3"
                    required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Criar</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>

    <script>
        var toastContainer = document.getElementById('toast-container');

        function exibirNotificacao(mensagem, tipo) {
            var toast = document.createElement('div');
            toast.classList.add('toast', 'bg-' + tipo, 'text-white');
            toast.setAttribute('role', 'alert');
            toast.setAttribute('aria-live', 'assertive');
            toast.setAttribute('aria-atomic', 'true');

            var toastBody = document.createElement('div');
            toastBody.classList.add('toast-body');
            toastBody.textContent = mensagem;

            toast.appendChild(toastBody);
            toastContainer.appendChild(toast);

            var bootstrapToast = new bootstrap.Toast(toast);
            bootstrapToast.show();
        }

        <?php
        if (isset($_SESSION['notificacao_sucesso'])) {
            echo 'exibirNotificacao("' . $_SESSION['notificacao_sucesso'] . '", "success");';
            unset($_SESSION['notificacao_sucesso']);
        }

        if (isset($_SESSION['notificacao_erro'])) {
            echo 'exibirNotificacao("' . $_SESSION['notificacao_erro'] . '","danger");';
            unset($_SESSION['notificacao_erro']);
        }
        ?>
    </script>
</body>

</html>
