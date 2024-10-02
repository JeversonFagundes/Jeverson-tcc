<?php

//FORMEDITENTREGA.PHP

//conectar com o banco de dados jeverson-tcc.
require_once "../conecta.php";

//incluir o arquivo onde é feita proteção do sistema.
require_once "../protecao.php";

//declarar a variavel de conexão com o banco de dados jeverson-tcc.
$mysql = conectar();

//declarar a pasta de destino dos arquivos.
$pasta = "../certificados/";

//atribuir a variavél sql ($sql) a busca por todas as atividades complementares de curso cadastradas no sistema que são relacionadas ao curso do aluno que esta logado no sistema no momento.
$sql = "SELECT id_atividade_complementar, natureza, descricao, carga_horaria_maxima FROM atividade_complementar WHERE id_curso = " . $_SESSION['aluno'][2];

//excutar o comando sql ($sql).
$resultado = excutarSQL($mysql, $sql);

//atribuir a variavél atividades_comlementares ($atividades_comlementares) o array associativo com todos os valores da busca $sql.
$atividades_complementares = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

echo '<h1>Formulário de alteração da sua atividade complementar entregue!</h1>';

echo '<h3>Tabela de atividades complementares.</h3>';

//abrir uma tabel para listar as atividades complementares de curso que ofram retornadas.
echo '<table border = 4 

<tr>

<th>Natureza</th>
<th>Descrição</th>
<th>Carga horária máxima</th>

</tr>';

//percorre o vetor criado [$atividades_complementares].
foreach ($atividades_complementares as $atividade_complementar) {

    echo '<tr>';

    echo '<td>' . $atividade_complementar['natureza'] . '</td>';

    echo '<td>' . $atividade_complementar['descricao'] . '</td>';

    echo '<td>' . $atividade_complementar['carga_horaria_maxima'] . '</td>';

    echo '</tr>';
}

echo '</table>' . '<br><br>';

//receber o id da atividade entregue, que se deseja alterar.
$id = $_GET['id'];

//selecionar os dados da tabela de entrega de atividades.
$sql2 = "SELECT * FROM entrega_atividade WHERE id_entrega_atividade = $id";

//excutar o comando sql2 acima.
$resultado2 = excutarSQL($mysql, $sql2);

//gerar o vetor com os resultados.
$entrega = mysqli_fetch_assoc($resultado2);

/**/

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de entrega de atividade complementar</title>

</head>

<body>

    <!--(enctype="multipart/form-data") é utilizado em formulários HTML para especificar como os dados do formulário devem ser codificados ao serem enviados para o servidor. Este valor é essencial quando o formulário inclui uploads de arquivos, como imagens ou documentos-->
    <form action="editarEntrega.php" method="post" enctype="multipart/form-data">

        <label for="select">Escolha a natureza do certificado:</label>

        <!--Abrir um campo select para a selção dos itens.-->
        <select id="select" required name="atividade_complementar">

            <?php

            //percorre o vetor de atividades complementares de curso
            foreach ($atividades_complementares as $atividade_complementar) {

            ?>
                <!--declarar as opções desse campo de seleção.-->
                <option <?php

                        //aqui dentro do option fazemos a verificação de que, se o valor da variavél $entrega['id_atividade_complementar'] é igual ao da variavél $atividade_complementar['id_atividade_complementar']. Se for igual passamos o comando selected e no caso sempre vai ser atendida essa condição, porque estamos alterando uma atividade que está cadastrada no banco de dados.
                        if ($entrega['id_atividade_complementar'] == $atividade_complementar['id_atividade_complementar']) {

                            echo "selected";
                        }
                        ?> value=" <?php echo $atividade_complementar['id_atividade_complementar']; ?>">

                    <?php echo $atividade_complementar['natureza']; ?>

                </option>

            <?php
            }

            ?>

        </select><br><br>

        <label for="titulo">Titulo do certificado:</label>
        <input type="text" name="titulo" id="titulo" value="<?php echo $entrega['titulo_certificado']; ?>"> <br><br>

        <label for="carga">Carga horaria do certificado:</label>
        <input type="number" name="carga" id="carga" value="<?php echo $entrega['carga_horaria_certificado']; ?>"> <br><br>

        <input type="hidden" name="id" value=" <?php echo $entrega['id_entrega_atividade']; ?>">

        <input type="hidden" name="caminho" value="<?php echo $entrega['caminho']; ?>">

        <label for="certi">Certificado:</label>
        <input type="file" name="certificado" id="certi"> <br><br>

        <!--aqui passamos um link para que o aluno possa var o arquivo que ele cadastrou no sistema.-->
        <a href=" <?php echo $pasta . $entrega['caminho']; ?>"> <?php echo $entrega['certificado']; ?></a> <br><br>

        <input type="submit" value="Editar">

    </form>

    <a href="../inicialAluno.php">Voltar</a>

    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="js/materialize.min.js"></script>
</body>

</html>