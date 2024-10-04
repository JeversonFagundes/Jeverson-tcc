<?php

//FORMCADCOORDENADOR.PHP

//conectar com o banco de dados jeverosn-tcc.
require_once "../conecta.php";

//declarar a variavel de conexão com o banco de dados jeverson-tcc.
$mysql = conectar();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Import Google Icon Font-->
    <!--<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">-->
    <!--Import materialize.css-->
    <!--<link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />-->
    <title>Cdastrar coordenador de curso</title>

</head>

<body>

    <h1>Cdastrar coordenador de curso</h1>

    <form action="cadastrarCoordenador.php" method="post">
        <label for="nome"> Nome do coordenador de curso: </label>
        <input type="text" name="nome" id="nome"><br><br>

        <?php

        //atribuir a variavél sql ($sql) a busca por todos os curso cadastrados no sistema e ordena-los em ordem alfabética.
        $sql = "SELECT id_curso, nome_curso FROM curso ORDER BY nome_curso ASC";

        //atribuir a veriavél resultado ($resultado) a execução do comando sql ($sql).
        $resultado = excutarSQL($mysql, $sql);
        ?>

        <label for="curso">Selecione o seu curso:</label>

        <!--declarar um campo de seleção.-->
        <select id="curso" name="curso" required>

            <!--declarar o primeiro option com selecionado e dasabilitado.-->
            <option selected disabled value="">Escolha um curso: </option>

            <?php

            //agora vamos declarar as outras opções de escolha de curso para cadastrar o coordenador de curso no sistema. Atribuimos a variavél dados ($dados) os valores do array associativo que gerado com a execução do comando sql ($sql) que serão repetidos enquanto houver dados.
            while ($dados = mysqli_fetch_assoc($resultado)) {

            ?>
                <option value="<?php echo $dados['id_curso'] ?>">

                    <?php echo $dados['nome_curso'] ?>

                </option>
            <?php
            }
            ?>

        </select><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email"><br><br>

        <label for="senha">Senha: </label>
        <input type="password" name="senha" id="senha"><br><br>

        <input type="submit" value="Cadastrar">

    </form>

    <button><a href="../inicialAdmin.php">Voltar</a></button>

    <!--Import jQuery before materialize.js-->
    <!--<script type="text/javascript" src="js/materialize.min.js"></script>-->
</body>

</html>