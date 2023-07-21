<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BibliotecApp</title>
    <link rel="icon" type="image/x-icon" href="/logo.gif">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <style>
        body {
            background-image: url(biblioteca.jpg);
            background-repeat: no-repeat;
            background-position: auto;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .landing-container {
            width: 500px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            color: black;
            text-align: center;
        }

        .landing-heading {
            font-size: 36px;
            margin-bottom: 20px;
        }

        .landing-subheading {
            font-size: 18px;
            margin-bottom: 40px;
        }

        .landing-buttons {
            display: flex;
            justify-content: center;
        }

        .landing-buttons a {
            margin: 0 10px;
        }
    </style>
</head>

<body>
    <div class="landing-container">
        <h1 class="landing-heading">Bem-vindo ao BibliotecApp</h1>
        <p class="landing-subheading">Sistema de Gestão da Biblioteca</p>
        <div class="landing-buttons">
            <a href="login.php" class="btn btn-primary">Login</a>
            <a href="register.php" class="btn btn-secondary">Registar</a>
        </div>
    </div>
</body>

</html>