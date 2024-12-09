<?php

//PERFIL.PHP

//conectar com o banco de dados jeverson-tcc
require_once "../conecta.php";

//incluir o arquivo de notificações do sistema.
require_once "../boasPraticas/notificacoes.php";

//declarar a variavel de conexão com o banco de dados jeverson-tcc.
$mysql = conectar();

//atribuir a variavél sql ($sql) a busca pelos dados do coordenador de curso.
$sql = "SELECT nome, email, id_curso, id_coordenador FROM coordenador_curso WHERE id_coordenador = " . $_SESSION['coordenador'][1];

//atribuir a veriavél ressultado ($resultado) a execução do comando sql ($sql).
$resultado = excutarSQL($mysql, $sql);

//atribuir a veriavél coordenador ($coordenador) os valores do array associativo gerado com a execução do comando sql.
$coordenador = mysqli_fetch_assoc($resultado);

?>

<!DOCTYPE html>
<html lang="pt_br">

<head>
    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="../materialize/css/materialize.min.css" media="screen,projection" />
    
    <title>Editar sua conta</title>


</head>

<body>

    <?php require_once "../boasPraticas/headerNav.php"; ?>

    <h1>Informações da sua conta!</h1>

    <?php
    //chamar a função que imprime a notificação para o usuário.
    exibirNotificacoes();

    //chamar a função que limpa a notificação de dentro da sessão.
    limpaNotificacoes();
    ?>

    <form action="editarContCo.php" method="post">

        <label for="nome">Nome: </label>
        <input type="text" value="<?php echo $coordenador['nome']; ?>" name="nome"><br><br>

        <label for="email">Email: </label>
        <input type="email" value="<?php echo $coordenador['email']; ?>" name="email"><br><br>

        <?php

        //buscar por todos os curso cadastrados no sistema e ordena-los em ordem alfabética.
        $sql2 = "SELECT id_curso, nome_curso FROM curso ORDER BY nome_curso ASC";

        //atribuir a veriavél resultado2 ($resultado2) a execução do comando sql.
        $resultado2 = excutarSQL($mysql, $sql2);

        ?>

        <label for="curso">Selecione o seu curso: </label>

        <!--declarar o campo de selecção.-->
        <select id="curso" name="curso" required>

            <?php

            //atribuir a veriavél dados ($dados) os valores gerados no array associativo pela execução do comando sql ($sql2) que será repetido enquanto houver dados.
            while ($dados = mysqli_fetch_assoc($resultado2)) {

            ?>
                <!--declarar as opções do compo de seleção. Os valores estão vendo da variavél dados ($dados).-->
                <option <?php

                        //aqui tendo em maões os valores vindos do coordenador de curso que esta logado nomomento e dos cursos cadastrados no sistema, verificamos qual é o curso do coordenador e exibimos com opção selecionada o curso dele. No caso essa condição sempre vai ser atendida porque o coordenador de curso, assim com o alno estão cadastrados no sistema e por possuem obrigratóriamente um curso em seu cadastro.
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

        <input type="hidden" value="<?php echo $coordenador['id_coordenador']; ?>" name="id">

        <input type="submit" value="Editar"><br><br>



    </form>

    <button><a href="excluirContCo.php">Excluir sua conta!</a></button><br><br>

    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="../materialize/js/materialize.min.js"></script>
</body>

</html>