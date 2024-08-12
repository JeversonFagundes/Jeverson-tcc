<?php

//receber o id do aluno.
$id = $_GET['id'];

//conecctar com o banco de dados.
require_once "../conecta.php";

//variavel de conexão.
$mysql = conectar();

$pastaDestino = "../certificados/";

$sql = "SELECT a.id_aluno, a.nome, a.matricula, a.email,

 ea.id_entrega_atividade, 

 ea.carga_horaria_certificado, ea.carga_horaria_aprovada, 

 ea.status, ea.certificado, ea.caminho, ea.titulo_certificado

 FROM aluno a

INNER JOIN entrega_atividade ea 

ON a.id_aluno = $id AND ea.id_aluno = $id

";

$resultado = excutarSQL($mysql, $sql);

if ($mysql->error) {

    die("Falha ao ver os resultados! " . $mysql->error);
} else {
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualização das atividade entregues por um aluno</title>

    <style>
        .card {
            background-color: white;
            width: 40%;
            height: 500px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px rgba(0, 0, 0, 0.19);
            margin-bottom: 20px;
        }
    </style>

</head>

<body>

    <nav>
        <ul>
            <li><a href="../inicialCoordenador.php">Voltar</a></li>
        </ul>
    </nav>

    <h1>Informações da atividade complementar entregue no sistema para validação</h1>

    <?php

    while ($dados = mysqli_fetch_assoc($resultado)) {

        echo '<form action = "mudarSituacao.php" method = "post" >';

        echo '<div class="card">';

        echo '<div class="card-body">';

        echo '<h1 class="card-title">' . 'Titulo do certificado:' . '' . $dados['titulo_certificado'] . '</h1>';

        echo '<p class="card-text">' . 'Nome do aluno: ' . '' . $dados['nome'] . '</p>';

        echo '<p class="card-text">' . 'Matricula: ' . '' . $dados['matricula'] . '</p>';

        echo '<p class="card-text">' . 'E-mail: ' . '' . $dados['email'] . '</p>';

        echo '<p class="card-title">' . 'O certificado:' . ' ' . '<a href="'.$pastaDestino . $dados['caminho'] . '">' . $dados['certificado'] . '</a>' . '</p>';

        echo '<p class="card-text">' . 'Carga horaria do certificado: ' . '' . $dados['carga_horaria_certificado'] . '</p>';

        echo '<p class="card-text">' . 'Carga horaria deferida: ' . '<input type = "number" value = "' . $dados['carga_horaria_aprovada'] . '" name = "cargaDefe">' . '</p>';

        echo '<p class="card-text">' . 'Situação:' . ' ' . $dados['status'] . '</p>';

        echo '<input type = "hidden" value = "' . $dados['id_entrega_atividade'] . '" name = "id_atividade">';

        echo '<input type = "hidden" value = "' . $dados['id_aluno'] . '" name = "aluno">';

        echo '<input type = "submit" value = "Deferir" name = "deferir">';

        echo '<input type = "submit" value = "Indeferir" name = "indeferir">';

        echo '</div>';

        echo '</div>';

        echo '</form>';
    }

    ?>

</body>

</html>