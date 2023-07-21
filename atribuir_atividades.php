<?php
session_start();

// Verifica se o administrador está com a sessão inicida
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    // Redireciona para a página de login se não estiver com a sessão iniciada
    header("Location: login.php");
    exit();
}

include('db.php');

date_default_timezone_set('Europe/Lisbon');

// Consulta SQL para procurar os alunos
$query_alunos = "SELECT * FROM alunos";
$resultado_alunos = mysqli_query($conexao, $query_alunos);
$alunos = mysqli_fetch_all($resultado_alunos, MYSQLI_ASSOC);

// Consulta SQL para procurar as atividades
$query_atividades = "SELECT * FROM atividades";
$resultado_atividades = mysqli_query($conexao, $query_atividades);
$atividades = mysqli_fetch_all($resultado_atividades, MYSQLI_ASSOC);

// Verifica se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_aluno = $_POST['id_aluno'];
    $id_atividade = $_POST['id_atividade'];

    // Verifica se o aluno já possui uma atividade em andamento
    $query_verificacao = "SELECT * FROM atribuicoes WHERE id_aluno = '$id_aluno' AND hora_saida IS NULL";
    $resultado_verificacao = mysqli_query($conexao, $query_verificacao);
    $atividade_em_andamento = mysqli_fetch_assoc($resultado_verificacao);

    if ($atividade_em_andamento) {
        $_SESSION['notificacao_erro'] = "Erro: O aluno já possui uma atividade em andamento.";
    } else {
        $data_inicio = date('Y-m-d H:i:s'); // Obtém a data e hora atuais

        $query = "INSERT INTO atribuicoes (id_aluno, id_atividade, data_inicio) VALUES ('$id_aluno', '$id_atividade', '$data_inicio')";

        if (mysqli_query($conexao, $query)) {
            $_SESSION['notificacao_sucesso'] = "Atividade atribuída com sucesso!";

            header("Location: " . $_SERVER['PHP_SELF']); // Redireciona para a própria página        
            exit(); // Encerra a execução do script
        } else {
            $_SESSION['notificacao_erro'] = "Erro ao atribuir atividade: " . mysqli_error($conexao);
        }
    }
}

// Fecha a conexão com a base de dados
mysqli_close($conexao);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Atribuir Atividade</title>
    <link rel="icon" type="image/x-icon" href="/logo.gif">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div id="toast-container" class="position-fixed top-0 end-0 p-3" style="z-index: 9999;"></div>

    <?php include 'navbar.php'; ?>
    <div class="container">
        <h1 class="mt-4">Atribuir Atividade</h1>

        <!-- Formulário para selecionar aluno e atividade -->
        <form method="POST" action="">
            <div class="mb-3">
                <label for="id_aluno" class="form-label">Selecione o Aluno:</label>
                <select class="form-select" name="id_aluno">
                    <!-- Opções de alunos -->
                    <?php foreach ($alunos as $aluno) { ?>
                        <option value="<?php echo $aluno['id']; ?>"><?php echo $aluno['numero_processo']; ?> - <?php echo $aluno['nome']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="id_atividade" class="form-label">Selecione a Atividade:</label>
                <select class="form-select" name="id_atividade">
                    <!-- Opções de atividades -->
                    <?php foreach ($atividades as $atividade) { ?>
                        <option value="<?php echo $atividade['id']; ?>"><?php echo $atividade['nome']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Atribuir Atividade</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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