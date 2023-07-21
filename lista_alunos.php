<?php
session_start();

// Verifica se o administrador está com a sessão iniciada
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    // Redireciona para a página de login se não estiver com a sessão iniciada
    header("Location: login.php");
    exit();
}

include('db.php');
include 'navbar.php';

// Definir a quantidade de alunos por página
$alunosPorPagina = 10;

// Obter o número da página atual
if (isset($_GET['pagina'])) {
    $paginaAtual = $_GET['pagina'];
} else {
    $paginaAtual = 1;
}

// Calcular o índice inicial do aluno na consulta
$indiceInicial = ($paginaAtual - 1) * $alunosPorPagina;

// Obter lista de alunos com paginação
$query = "SELECT * FROM alunos LIMIT $indiceInicial, $alunosPorPagina";
$resultado = mysqli_query($conexao, $query);
$alunos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

// Obter o total de alunos
$queryTotal = "SELECT COUNT(*) AS total FROM alunos";
$resultadoTotal = mysqli_query($conexao, $queryTotal);
$totalAlunos = mysqli_fetch_assoc($resultadoTotal)['total'];

// Calcular o total de páginas
$totalPaginas = ceil($totalAlunos / $alunosPorPagina);
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <title>Entradas na Biblioteca</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="icon" type="image/x-icon" href="/logo.gif">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>

<body>

    <div class="container">
        <h2 class="mt-4">Lista de Alunos</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Turma</th>
                    <th>Número do Cartão</th>
                    <th>Número do Processo</th>
                    <th>Data de Criação</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($alunos as $aluno) { ?>
                    <tr>
                        <td><?php echo $aluno['id']; ?></td>
                        <td><?php echo $aluno['nome']; ?></td>
                        <td><?php echo $aluno['turma']; ?></td>
                        <td><?php echo $aluno['numero_cartao']; ?></td>
                        <td><?php echo $aluno['numero_processo']; ?></td>
                        <td><?php echo $aluno['data_entrada']; ?></td>
                        <td>
                            <button class="btn btn-primary text-decoration-none">
                                <a href="editar_aluno.php?id=<?php echo $aluno['id']; ?>" onclick="return confirm('Tem certeza que deseja editar este aluno?')" class="text-decoration-none text-white">Editar</a>
                            </button>
                            <button class="btn btn-danger">
                                <a href="excluir_aluno.php?id=<?php echo $aluno['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir este aluno?')" class="text-decoration-none text-white">Excluir</a>
                            </button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Paginação -->
        <nav aria-label="Paginação">
            <ul class="pagination justify-content-center">
                <?php if ($paginaAtual > 1) { ?>
                    <li class="page-item">
                        <a class="page-link" href="?pagina=<?php echo $paginaAtual - 1; ?>" aria-label="Anterior">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php } ?>
                <?php for ($i = 1; $i <= $totalPaginas; $i++) { ?>
                    <li class="page-item <?php echo ($paginaAtual == $i) ? 'active' : ''; ?>">
                        <a class="page-link" href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php } ?>
                <?php if ($paginaAtual < $totalPaginas) { ?>
                    <li class="page-item">
                        <a class="page-link" href="?pagina=<?php echo $paginaAtual + 1; ?>" aria-label="Próxima">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </nav>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>
