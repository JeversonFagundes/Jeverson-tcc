<?php

//FORMEDITCURSO.PHP

//incluir o arquivo de notificações do sistema.
require_once "../boasPraticas/notificacoes.php";

//buscar da url os valores necessários para buscar pelas informações do curso que se deseja alterar.
$id = $_GET['id'];

//conectar com o banco de dados jeverson-tcc
require_once "../conecta.php";

//declarar a variavel de conexão com o banco de dados jeverson-tcc.
$mysql = conectar();

//atribuir a veriavél sql ($sql) a busca por todos os dados do curso.
$sql = "SELECT * FROM curso WHERE id_curso = $id";

//atribuir a veriavél resultado ($resultado) a execução do comando sql ($sql).
$resultado = excutarSQL($mysql, $sql);

//atribuir a variavél dados ($dados) os valores do array associativo gerado pela execução do comando sql ($sql).
$dados = mysqli_fetch_assoc($resultado);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="../materialize/css/materialize.min.css" media="screen,projection" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar um curso</title>

</head>

<body>

    <?php

    require_once "../boasPraticas/headerNav.php";
    ?>

    <!--conteudo principal-->
    <main class="container">

        <h1 class="center-align">Alteração do curso</h1>

        <?php

        //chamar a função que exibe a notificação
        exibirNotificacoes();

        //chamar a função que limpa a notificação da sessão.
        limpaNotificacoes();
        ?>

        <div class="card-panel">

            <form action="editarCurso.php" method="post">

                <input type="hidden" value="<?php echo $dados['id_curso']; ?>" name="id" />

                <div class="input-field col s12">
                    <input placeholder="Digite o nome do curso" id="nome" name="nome" value="<?php echo $dados['nome_curso']; ?>" type="text" class="validate" pattern="^.+$" required>
                    <label for="nome">Nome do curso : </label>
                    <span class="helper-text" data-error="Você deve preenchar esse campo."></span>
                </div>

                <div class="input-field col s12">
                    <input placeholder="Por exemplo : 10" id="carga" name="carga" value="<?php echo $dados['carga_horaria']; ?>" type="text" class="validate" pattern="^\d+$" required>
                    <label for="carga">Carga horaria do curso : </label>
                    <span class="helper-text" data-error="ste campo deve conter apenas caracteres numéricos."></span>
                </div>


                <div class="row">
                    <div class="col s12">
                        <p class="center-align">
                            <button class="btn waves-effect waves-light #1565c0 blue darken-3 lighten-3" type="submit" name="action">Alterar curso
                                <i class="material-icons right">create</i> </button>
                        </p>
                    </div>
                </div>
            </form>

        </div>

    </main>

    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="../materialize/js/materialize.min.js"></script>
</body>

</html>