<?php
session_start();

// Verifica se o administrador está com a sessão inicida
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    // Redireciona para a página de login se não estiver com a sessão iniciada
    header("Location: login.php");
    exit();
}

date_default_timezone_set('Europe/Lisbon');

include('db.php');

// Consulta SQL para procurar as atividades a decorrer
$query = "SELECT a.id, a.nome, a.turma, a.numero_cartao, a.numero_processo, at.nome AS nome_atividade, atb.hora_saida
          FROM alunos AS a
          LEFT JOIN atribuicoes AS atb ON a.id = atb.id_aluno
          LEFT JOIN atividades AS at ON atb.id_atividade = at.id 
          WHERE atb.hora_saida IS NULL AND at.nome IS NOT NULL"; // Considera apenas os alunos que não possuem hora de saída preenchida

$resultado = mysqli_query($conexao, $query);
$alunos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

// Verifica se o formulário para atribuir hora de saída foi submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_aluno = $_POST['id_aluno'];
    $hora_saida = date('Y-m-d H:i:s'); // Obtém a hora de saída atual

    $query = "UPDATE atribuicoes SET hora_saida = '$hora_saida' WHERE id_aluno = '$id_aluno' AND hora_saida IS NULL";

    if (mysqli_query($conexao, $query)) {
        $_SESSION['notificacao_sucesso'] = "Hora de saída atribuída com sucesso!";
        header("Location: " . $_SERVER['PHP_SELF']); // Redireciona para a própria página
        exit(); // Encerra a execução do script
    } else {
        $_SESSION['notificacao_erro'] = "Erro ao atribuir hora de saída: " . mysqli_error($conexao);
    }
}

// Consulta SQL para procurar as atividades disponíveis
$query_atividades = "SELECT * FROM atividades";
$resultado_atividades = mysqli_query($conexao, $query_atividades);
$atividades = mysqli_fetch_all($resultado_atividades, MYSQLI_ASSOC);

// Fecha a conexão com a base de dados
mysqli_close($conexao);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Atribuir Hora de Saída</title>
    <link rel="icon" type="image/x-icon" href="/logo.gif">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
    <div id="toast-container" class="position-fixed top-0 end-0 p-3" style="z-index: 9999;"></div>

    <?php include 'navbar.php'; ?>
    <div class="container">
        <h1 class="mt-4">Atribuir Hora de Saída</h1>

        <!-- Formulário para selecionar aluno e atribuir hora de saída -->
        <form method="POST" action="">
            <div class="row">
                <div class="col-sm-7">
                    <label for="id_aluno" class="form-label">Selecione o Aluno:</label>
                    <select class="form-select" aria-label="Selecione Aluno" name="id_aluno">
                        <?php foreach ($alunos as $aluno) {
                            if (!empty($_POST['numero_processo']) && $aluno['numero_processo'] != $_POST['numero_processo']) {
                                continue; // Salta a iteração se o número do processo não corresponder à pesquisa
                            }
                            ?>
                            <option value="<?php echo $aluno['id']; ?>"><?php echo $aluno['numero_processo']; ?> - <?php echo $aluno['nome']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Atribuir Hora de Saída</button>
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