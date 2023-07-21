<?php
session_start();
include('db.php');

// Variável para armazenar a mensagem de erro
$erro = '';

// Verifica se o formulário de login foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados do formulário
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Consulta SQL para verificar as credenciais do administrador
    $query = "SELECT * FROM administradores WHERE email = '$email'";
    $resultado = mysqli_query($conexao, $query);
    $administrador = mysqli_fetch_assoc($resultado);

    // Verifica se o administrador foi encontrado
    if ($administrador && password_verify($password, $administrador['password'])) {
        // Define a sessão com o nome "logado"
        $_SESSION['logado'] = true;
        $_SESSION['email'] = $administrador['email'];

        // Redireciona para a página desejada após o login
        header("Location: lista_alunos.php");
        exit();
    } else {
        // Define a mensagem de erro
        $erro = "Credenciais inválidas.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="icon" type="image/x-icon" href="/logo.gif">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <style>
        body {
            background-image: url(biblioteca.jpg);
            background-repeat: no-repeat;
            background-position: auto;
            background-size: cover;
        }
    </style>
</head>

<body>
    <section class="gradient-custom mt-4">
        <div class="container">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-4 text-center">
                            <div class="mb-md-2 mt-md-4 pb-2">
                                <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                                <?php if ($erro) { ?>
                                    <div class="alert alert-danger">
                                        <?php echo $erro; ?>
                                    </div>
                                <?php } ?>
                                <p class="text-white-50 mb-3">Insira o seu email e password!</p>
                                <form method="POST" action="">
                                    <div class="form-outline form-white mb-4">
                                        <label class="form-label" for="typeEmailX">Email</label>
                                        <input type="email" name="email" class="form-control form-control-lg"
                                            required />
                                    </div>
                                    <div class="form-outline form-white mb-3">
                                        <label class="form-label" for="typePasswordX">Password</label>
                                        <input type="password" name="password" class="form-control form-control-lg"
                                            required />
                                    </div>
                                    <button class="btn btn-outline-light btn-lg px-5" type="submit">Login</button>
                                </form>
                            </div>
                            <div>
                                <p>Não tem conta? <a href="register.php" class="text-white-50 fw-bold">Registe-se</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
</body>

</html>