<?php

//buscar da url o id do aluno.
$id = $_GET['id'];

//conecctar com o banco de dados jeverson-tcc.
require_once "../conecta.php";

//declarar a variavel de conexão com o banco de dados jeverson-tcc.
$mysql = conectar();

//declarar a pasta de destino dos arquivos.
$pastaDestino = "../certificados/";

//buscar pelos dados do aluno unindo com os dados da tabela entrega_atividade, que onde estão os dados da entrega das atividades que o aluno entregou no sistema.
$sql = "SELECT a.id_aluno, a.nome, a.matricula, a.email,

 ea.id_entrega_atividade, 

 ea.carga_horaria_certificado, ea.carga_horaria_aprovada, 

 ea.status, ea.certificado, ea.caminho, ea.titulo_certificado,

 ea.observacoes, ac.descricao

 FROM aluno a

INNER JOIN entrega_atividade ea 

ON a.id_aluno = $id AND ea.id_aluno = $id

INNER JOIN atividade_complementar ac

ON ea.id_atividade_complementar = ac.id_atividade_complementar

";

//executar o comando sql ($sql).
$resultado = excutarSQL($mysql, $sql);

//verificar se houve algum arro na conexão.
if ($mysql->error) {

    die("Falha ao ver os resultados! " . $mysql->error);
} else {

    //se não houve erro, não aconte nada.
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <!--Import Google Icon Font-->
    <!--<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">-->
    <!--Import materialize.css-->
    <!--<link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualização das atividade entregues por um aluno</title>

    <!--estilização em formato de card para os dados que serão mostrados na tela de validação do coordenador de curso.-->
    <style>
        .card {
            background-color: white;
            width: 40%;
            height: 520px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px rgba(0, 0, 0, 0.19);
            margin-bottom: 20px;
        }

        textarea {
            width: 450px;

            height: 100px;

            resize: none;

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

    //daclarar a variavél dados ($dados) que receberá os valores do array associativo que foi gerado na busca $sql. Esses dados serão repetidos enquanto houver dados.
    while ($dados = mysqli_fetch_assoc($resultado)) {

        //abrir o formulário com os dados da variavél $dados.
        echo '<form action = "mudarSituacao.php" method = "post" >';

        echo '<div class="card">';

        echo '<div class="card-body">';

        echo '<h1 class="card-title">' . 'Titulo do certificado:' . '' . $dados['titulo_certificado'] . '</h1>';

        echo '<p class="card-text">' . 'Nome do aluno: ' . '' . $dados['nome'] . '</p>';

        echo '<p class="card-text">' . 'Matricula: ' . '' . $dados['matricula'] . '</p>';

        echo '<p class="card-text">' . 'E-mail: ' . '' . $dados['email'] . '</p>';

        echo '<p class="card-title">' . 'O certificado:' . ' ' . '<a href="' . $pastaDestino . $dados['caminho'] . '">' . $dados['certificado'] . '</a>' . '</p>';

        echo '<p class="card-text">' . 'Descrição da atividade realizada: ' . '' . $dados['descricao'] . '</p>';

        echo '<p class="card-text">' . 'Carga horaria do certificado: ' . '' . $dados['carga_horaria_certificado'] . '</p>';

        echo '<p class="card-text">' . 'Carga horaria deferida: ' . '<input type = "number" value = "' . $dados['carga_horaria_aprovada'] . '" name = "cargaDefe">' . '</p>';

        echo '<p class="card-text">' . 'Situação:' . ' ' . $dados['status'] . '</p>';

    ?>

        <!--"<textarea name="" id=""></textarea>" é utilizado para criar uma área de texto multilinha em um formulário, permitindo que os usuários insiram uma quantidade significativa de texto livre, como comentários ou feedback.-->

        <!--declarar um text area para que o coordenador de curso possa cadastrar suas observações sobre o arquivo que ele está validando.-->
        <label for="obser">Adicionar observações:</label><br>
        <textarea name="observacoes" id="obser"><?php echo $dados['observacoes']; ?></textarea><br><br>

    <?php

        echo '<input type = "hidden" value = "' . $dados['id_entrega_atividade'] . '" name = "id_atividade">';

        echo '<input type = "hidden" value = "' . $dados['id_aluno'] . '" name = "aluno">';

        echo '<input type = "hidden" value = "' . $dados['nome'] . '" name = "nome">';

        echo '<input type = "hidden" value = "' . $dados['matricula'] . '" name = "matricula">';

        echo '<input type = "hidden" value = "' . $dados['email'] . '" name = "email">';

        echo '<input type = "hidden" value = "' . $dados['titulo_certificado'] . '" name = "certificado">';

        echo '<input type = "hidden" value = "' . $dados['descricao'] . '" name = "descricao">';

        echo '<input type = "submit" value = "Deferir" name = "deferir">';

        echo '<input type = "submit" value = "Indeferir" name = "indeferir">';

        echo '</div>';

        echo '</div>';

        echo '</form>';
    }

    ?>

    <!--Import jQuery before materialize.js-->
    <!--<script type="text/javascript" src="js/materialize.min.js"></script>-->
</body>

</html>