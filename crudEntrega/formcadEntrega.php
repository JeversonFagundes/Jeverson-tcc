<?php

//FORMCADEBTREGA.PHP

//conectar com o banco de dados jeverson-tcc.
require_once "../conecta.php";

//incluir o arquivo de notificações do sistema.
require_once "../boasPraticas/notificacoes.php";

//declarar a variavel de conexão com o banco de dados.
$mysql = conectar();

//atribuir a variavél sql ($sql) a busca por todos os cursos relacionados com o curso do aluno logado no momento.
$sql = "SELECT natureza, descricao, carga_horaria_maxima FROM atividade_complementar WHERE id_curso = " . $_SESSION['aluno'][2];

//atribuir a variavél resultado ($resultado) a execução do comando sql ($sql).
$resultado = excutarSQL($mysql, $sql);

echo '<h1>Formulário de entrega de atividades complementares.</h1>';

echo '<h3>Tabela de atividades complementares.</h3>';

//listar as atividades complementares de curso retornadas na busca $sql, dentro de uma tabela.
echo '<table border=4;">
<tr>
<th>Natureza</th>
<th>Descrição</th>
<th>Carga horaria máxima</th>
</tr>';

//atribuir a variavél dados ($dados) os valores do array associativo gerado na busca por todas as atividades complementares de curso. Esses dados serão repetidos enquanto houver dados.
while ($dados = mysqli_fetch_assoc($resultado)) {
    echo '<tr>';
    echo '<td>' . $dados['natureza'] . '</td>';
    echo '<td>' . $dados['descricao'] . '</td>';
    echo '<td>' . $dados['carga_horaria_maxima'] . '</td>';

    echo '</tr>';
}

echo '</table>' . '<br><br>';

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
    <title>Formulário de entrega de atividade complementar</title>

</head>

<body>

    <!--(enctype="multipart/form-data") é utilizado em formulários HTML para especificar como os dados do formulário devem ser codificados ao serem enviados para o servidor. Este valor é essencial quando o formulário inclui uploads de arquivos, como imagens ou documentos-->
    <form action="cadastrarEntrega.php" method="post" enctype="multipart/form-data">

        <?php

        //atribuir a variavél sql2 ($sql2) a busca pelo id e natureza das atividades complementares de curso relacionadas ao curso do aluno que está logado no momento.
        $sql2 = "SELECT id_atividade_complementar, natureza FROM atividade_complementar WHERE id_curso = " . $_SESSION['aluno'][2];

        //atribuir a variavél resultado2 ($resultado2) a execução do comando sql2 ($sql2).
        $resultado2 = excutarSQL($mysql, $sql2);
        ?>

        <?php

        //exibir as notificações do sistema
        exibirNotificacoes();

        //limpar as notificações do sistema
        limpaNotificações();

        ?>
        <label for="select">Escolha a natureza do seu certificado:</label>

        <!--declarar um campo de seleção.-->
        <select id="select" required name="atividade_complementar">

            <!--a primeira opção da lista de opções que o aluno pode escolhar estará selecionada e dasabilitada. Ela mostra "Natureza".-->
            <option selected disabled value="">Natureza</option>

            <?php

            //atribuir a variavél dados ($dados) os valores do array associativo gerado no busca do comando sql2 ($sql2). Essa variavél será repetida enquanto houver dados.
            while ($dados = mysqli_fetch_assoc($resultado2)) {

            ?>
                <!--declarar o resto das opções da lista de seleção. Agora essas opções tem os valores vindos do banco de dados que estão dentro da variavél dados ($dados) acima.-->
                <option value="<?php echo $dados['id_atividade_complementar'] ?>">

                    <?php echo $dados['natureza'] ?>

                </option>
            <?php
            }
            ?>

        </select><br><br>


        <label for="titulo">Titulo do certificado:</label>
        <input type="text" id="titulo" name="titulo"><br><br>

        <label for="carga">Carga horaria do certificado:</label>
        <input type="number" id="carga" name="carga"><br><br>

        <input type="hidden" name="cargaDefe" value="0">

        <input type="hidden" name="status" value="Em análise">

        <label for="certi">Certificado:</label>
        <input type="file" id="certi" name="certificado"><br><br>

        <input type="submit" value="Enviar">

    </form>

    <a href="../inicialAluno.php">Voltar</a>

    <!--Import jQuery before materialize.js-->
    <!--<script type="text/javascript" src="js/materialize.min.js"></script>-->
</body>

</html>