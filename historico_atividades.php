<?php
session_start();
include('db.php');
include 'navbar.php';

// Obter histórico de atividades
$query = "SELECT atr.id_atividade, al.numero_processo, atr.data_inicio, atr.hora_saida, at.nome AS nome_atividade, al.nome AS nome_aluno
          FROM atribuicoes atr
          LEFT JOIN atividades at ON atr.id_atividade = at.id
          LEFT JOIN alunos al ON atr.id_aluno = al.id
          WHERE atr.hora_saida IS NOT NULL";
$resultado = mysqli_query($conexao, $query);
$atividades = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <title>Histórico de Atividades</title>
    <link rel="icon" type="image/x-icon" href="/logo.gif">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>

<body>

    <div class="container mt-5">
        <h2 class="text-center">Histórico de Atividades</h2>
        <?php if (count($atividades) > 0) { ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID Atividade</th>
                        <th>Nome da Atividade</th>
                        <th>Número do Processo</th>
                        <th>Nome do Aluno</th>
                        <th>Hora de Início</th>
                        <th>Hora de Saída</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($atividades as $atividade) { ?>
                        <tr>
                            <td><?php echo $atividade['id_atividade']; ?></td>
                            <td><?php echo $atividade['nome_atividade']; ?></td>
                            <td><?php echo $atividade['numero_processo']; ?></td>
                            <td><?php echo $atividade['nome_aluno']; ?></td>
                            <td><?php echo $atividade['data_inicio']; ?></td>
                            <td><?php echo $atividade['hora_saida']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p class="text-muted text-center">Não há histórico de atividades.</p>
        <?php } ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>
