<?php

session_start();

// Verifica se o administrador está com a sessão inicida
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    // Redireciona para a página de login se não estiver com a sessão iniciada
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/x-icon" href="/logo.gif">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <title>Criar Aluno</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <style>
        .container {
            max-width: 400px;
            margin-top: 50px;
        }

        .form-label {
            font-weight: bold;
        }

        .btn-next,
        .btn-previous {
            width: 100px;
        }
    </style>
</head>

<body>
    
<?php include('navbar.php') ?>
    <div class="container">
        <h1 class="text-center">Criar Aluno</h1>

        <?php
        include('db.php');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['numero_cartao']) && isset($_POST['nome']) && isset($_POST['turma']) && isset($_POST['numero_processo'])) {
                $numero_cartao = $_POST['numero_cartao'];
                $nome = $_POST['nome'];
                $turma = $_POST['turma'];
                $numero_processo = $_POST['numero_processo'];

                // Verificar se o aluno já existe na base de dados
                $query_verificar = "SELECT * FROM alunos WHERE numero_cartao = '$numero_cartao'";
                $resultado_verificar = mysqli_query($conexao, $query_verificar);

                if (mysqli_num_rows($resultado_verificar) > 0) {
                    $_SESSION['notificacao_erro'] = "O aluno já existe na base de dados.";
                } else {
                    // Adicionar o aluno à base de dados
                    $query_adicionar = "INSERT INTO alunos (numero_cartao, nome, turma, numero_processo, data_entrada) VALUES ('$numero_cartao', '$nome', '$turma', '$numero_processo', CURDATE())";
                    $resultado_adicionar = mysqli_query($conexao, $query_adicionar);

                    if ($resultado_adicionar) {
                        $_SESSION['notificacao_sucesso'] = "Aluno criado com sucesso";
                    } else {
                        $_SESSION['notificacao_erro'] = "Erro ao adicionar o aluno.";
                    }
                }
            }
        }
        ?>

        <form id="form-aluno" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div id="etapa-1">
                <div class="mb-3">
                    <label for="numero_cartao" class="form-label">Número do Cartão:</label>
                    <input type="text" class="form-control" id="numero_cartao" name="numero_cartao" required>
                </div>
                <button type="button" class="btn btn-primary btn-next">Próximo</button>
            </div>

            <div id="etapa-2" style="display: none;">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome:</label>
                    <input type="text" class="form-control" id="nome" name="nome" required>
                </div>

                <div class="mb-3">
                    <label for="turma" class="form-label">Turma:</label>
                    <input type="text" class="form-control" id="turma" name="turma" required>
                </div>

                <div class="mb-3">
                    <label for="numero_processo" class="form-label">Número do Processo:</label>
                    <input type="text" class="form-control" id="numero_processo" name="numero_processo" required>
                </div>

                <button type="button" class="btn btn-secondary btn-previous">Anterior</button>
                <button type="submit" class="btn btn-primary">Criar Aluno</button>
            </div>
        </form>
    </div>

    <div id="toast-container" class="position-fixed top-0 end-0 p-3" style="z-index: 9999;"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function proximo() {
            var etapa1 = document.getElementById('etapa-1');
            var etapa2 = document.getElementById('etapa-2');
            etapa1.style.display = 'none';
            etapa2.style.display = 'block';
        }

        function anterior() {
            var etapa1 = document.getElementById('etapa-1');
            var etapa2 = document.getElementById('etapa-2');
            etapa1.style.display = 'block';
            etapa2.style.display = 'none';
        }

        document.getElementById('numero_cartao').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        var btnNext = document.querySelector('.btn-next');
        var btnPrevious = document.querySelector('.btn-previous');

        btnNext.addEventListener('click', function() {
            proximo();
        });

        btnPrevious.addEventListener('click', function() {
            anterior();
        });
    </script>

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



