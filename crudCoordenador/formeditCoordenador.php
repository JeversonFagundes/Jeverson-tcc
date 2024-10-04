<?php

//FORMEDITCOORDENADOR.PHP

//buscar da url os valores necessários para buscar os dados do coordenador que se deseja alterar
$id = $_GET['id'];

//conectar com o banco de dados jeverson-tcc
require_once "../conecta.php";

//declarar a variavel de conexão com o banco de dados jeverson-tcc.
$mysql = conectar();

//atribuir a variavél sql ($sql) a busca por todos os dados do coordenador de curso que se deseja alterar
$sql = "SELECT * FROM coordenador_curso WHERE id_coordenador = $id";

//atribuir a variavél resultado ($resultado) a execução do comando sql ($sql).
$resultado = excutarSQL($mysql, $sql);

//atribuir a veriavél coordenador ($coordenador) os valores do array associativo gerado na busca pelos da coordenador de curso.
$coordenador = mysqli_fetch_assoc($resultado);

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
    <title>Alterar um coordenador</title>

</head>

<body>

    <h1>Formulário de alteração de um coordenador!</h1>

    <form action="editarCoordenador.php" method="post">

        <label for="nome">Nome do coordenador de curso:</label>
        <input type="text" value="<?php echo $coordenador['nome']; ?>" name="nome"><br><br>

        <?php

        //atribuir a variavél sql2 ($sql2) a busca por todos os curso e ordena-los em ordem alfabética.
        $sql2 = "SELECT id_curso, nome_curso FROM curso ORDER BY nome_curso ASC";

        //atribuir a variavél resulltado2 ($resultado2) a execução do comando sql2 ($sql2)
        $resultado2 = excutarSQL($mysql, $sql2);

        ?>

        <label for="curso">Selecione o seu curso:</label>

        <!--declarar um campo de seleção.-->
        <select id="curso" name="curso" required>

            <?php

            //atribuir a variavél dados ($dados) os valores do array associativo gerado na busca por todos os curso e repetir enquanto houver dados.
            while ($dados = mysqli_fetch_assoc($resultado2)) {

            ?>

                <!--declarar as opções do campo, essas opções serão os curso que buscamos do banco de dados.-->
                <option <?php

                        //com as informações do coordenador de curso e do curso, podemos fazer a verificação de todos os cursos, qual é o do coordenador logado no momento e adicionar o comando selected que irá marcar o curso do coordenador como a opção selecionada.
                        if ($coordenador['id_curso'] == $dados['id_curso']) {

                            echo "selected";
                        }
                        ?> value="<?php echo $dados['id_curso'] ?>">
                    <?php echo $dados['nome_curso'] ?>
                </option>
            <?php
            }
            ?>

        </select><br><br>

        <label for="email">Email:</label>
        <input type="text" value="<?php echo $coordenador['email']; ?>" name="email"><br><br>

        <label for="senha">Senha:</label>
        <input type="text" value="<?php echo $coordenador['senha']; ?>" name="senha"><br><br>

        <input type="hidden" value="<?php echo $coordenador['id_coordenador']; ?>" name="id" />

        <input type="submit" value="Alterar">
    </form>

    <button><a href="../inicialAdmin.php">Voltar</a></button>

    <!--Import jQuery before materialize.js-->
    <!--<script type="text/javascript" src="js/materialize.min.js"></script>-->
</body>

</html>