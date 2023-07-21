<?php
session_start();

// Verifica se o administrador está com sessão iniciada
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    // Redireciona para a página de login se não estiver sessão iniciada
    header("Location: login.php");
    exit();
}

include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Perfil do Aluno</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="/logo.gif">

</head>

<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <h1 class="card-header text-center">Perfil do Aluno</h1>
                    <div class="card-body">
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="numero_cartao" class="form-label">Número do Cartão:</label>
                                <input type="text" class="form-control" id="numero_cartao" name="numero_cartao"
                                    maxlength="10" required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Exibir Perfil</button>
                            </div>
                        </form>
                    </div>

                    <?php
                    include('db.php');

                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        // Verifica se o número do cartão foi enviado
                        if (isset($_POST['numero_cartao'])) {
                            $numero_cartao = $_POST['numero_cartao'];

                            // Consulta SQL para obter o perfil do aluno pelo número do cartão
                            $query = "SELECT * FROM alunos WHERE numero_cartao = '$numero_cartao'";
                            $resultado = mysqli_query($conexao, $query);
                            $aluno = mysqli_fetch_assoc($resultado);

                            // Verifica se o aluno foi encontrado
                            if ($aluno) {
                                // Exibe as informações do perfil do aluno
                                echo '<div class="card mt-4">';
                                echo '<div class="card-body">';
                                echo '<h2 class="card-header">Informações do Aluno</h2>';
                                echo '<div class="list-group list-group-flush">';
                                echo '<p class="list-group-item"><strong>Nome:</strong> ' . $aluno['nome'] . '</p>';
                                echo '<p class="list-group-item"><strong>Turma:</strong> ' . $aluno['turma'] . '</p>';
                                echo '<p class="list-group-item"><strong>Número do Cartão:</strong> ' . $aluno['numero_cartao'] . '</p>';
                                echo '<p class="list-group-item"><strong>Número do Processo:</strong> ' . $aluno['numero_processo'] . '</p>';
                                echo '<p class="list-group-item"><strong>Data de Entrada:</strong> ' . $aluno['data_entrada'] . '</p>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';

                                // Consulta SQL para obter o histórico de atividades do aluno
                                $query_atividades = "SELECT atribuicoes.id, atribuicoes.data_inicio, atribuicoes.hora_saida, atividades.nome, atividades.descricao_atividade 
                                                     FROM atribuicoes INNER JOIN atividades ON atribuicoes.id_atividade = atividades.id 
                                                     WHERE atribuicoes.id_aluno = " . $aluno['id'];
                                $resultado_atividades = mysqli_query($conexao, $query_atividades);
                                $atividades = mysqli_fetch_all($resultado_atividades, MYSQLI_ASSOC);

                                // Verifica se o aluno possui atividades no histórico
                                if ($atividades) {
                                    echo '<div class="card mt-4">';
                                    echo '<div class="card-body">';
                                    echo '<h2 class="card-header text-center">Histórico de Atividades</h2>';
                                    echo '<table class="table">';
                                    echo '<tr>';
                                    echo '<th>ID</th>';
                                    echo '<th>Nome</th>';
                                    echo '<th>Descrição</th>';
                                    echo '<th>Data de Início</th>';
                                    echo '<th>Hora de Saída</th>';
                                    echo '</tr>';

                                    foreach ($atividades as $atividade) {
                                        echo '<tr>';
                                        echo '<td>' . $atividade['id'] . '</td>';
                                        echo '<td>' . $atividade['nome'] . '</td>';
                                        echo '<td>' . $atividade['descricao_atividade'] . '</td>';
                                        echo '<td>' . $atividade['data_inicio'] . '</td>';
                                        echo '<td>' . $atividade['hora_saida'] . '</td>';
                                        echo '</tr>';
                                    }

                                    echo '</table>';
                                    echo '</div>';
                                    echo '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
                                        <script src="https://unpkg.com/@popperjs/core@2"></script>';
                                    echo '</div>';
                                } else {
                                    echo '<div class="card mt-4">';
                                    echo '<div class="card-body">';
                                    echo '<p class="text-center">Não há atividades no histórico.</p>';
                                    echo '</div>';
                                    echo '</div>';
                                }

                                exit();
                            } else {
                                echo '<div class="card mt-4">';
                                echo '<div class="card-body">';
                                echo '<p class="text-center">Aluno não encontrado.</p>';
                                echo '</div>';
                                echo '</div>';
                            }
                        } else {
                            echo '<div class="card mt-4">';
                            echo '<div class="card-body">';
                            echo '<p class="text-center">Número do cartão não fornecido.</p>';
                            echo '</div>';
                            echo '</div>';
                        }
                    }

                    mysqli_close($conexao);
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>

    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script>
        // Obtém o input do número do cartão
        var numeroCartaoInput = document.getElementById('numero_cartao');

        numeroCartaoInput.addEventListener('keypress', function (event) {
            var key = event.which || event.keyCode;
            var allowedKeys = [8, 9, 13, 27]; // Backspace, Tab, Enter, Escape

            // Verifica se a tecla pressionada é um número
            if (key < 48 || key > 57) {
                event.preventDefault();
            }

            // Verifica se a tecla pressionada é uma tecla permitida
            if (allowedKeys.indexOf(key) !== -1) {
                return;
            }

            // Verifica se o campo já possui 10 caracteres (número típico do cartão escolar)
            if (numeroCartaoInput.value.length >= 10) {
                event.preventDefault();
            }
        });

        // Evento de colar para remover caracteres não numéricos
        numeroCartaoInput.addEventListener('paste', function (event) {
            var pastedText = event.clipboardData.getData('text/plain');
            var sanitizedText = pastedText.replace(/[^\d]/g, '');
            numeroCartaoInput.value = sanitizedText;
            event.preventDefault();
        });
    </script>



</body>

</html>