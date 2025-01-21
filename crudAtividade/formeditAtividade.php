<?php

//incluir o arquivo de notificações e de inicialização da sessão.
require_once "../boasPraticas/notificacoes.php";

//buscar da url o valor necessário para buscar pela atividade que o coordenador de curso deseja alterar.
$id = $_GET['id'];

//conectar com o banco de dados jeverson-tcc.
require_once "../conecta.php";

//declarar a variavel de conexão com o banco de dados jeverson-tcc. Essa variavél vem do arquivo conecta.php.
$mysql = conectar();

//atribuir a veriavél sql ($sql) a busca pelos dados do atividade_complementar que o coordenador de curso selecionou para á alteração.
$sql = "SELECT * FROM atividade_complementar WHERE id_atividade_complementar = $id";

//atribuir a variavél resultado ($resultado) a execução do comando sql ($sql).
$resultado = excutarSQL($mysql, $sql);

//atribuir a variavél dados ($dados) o array associativo com os valores gerados da execução do comando sql.
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
    <title>Alterar um atividade complementar</title>

</head>

<body>

    <?php

    //incluir a navBar do sistema
    require_once "../boasPraticas/headerNav.php";

    ?>

    <!--conteudo principal.-->
    <main class="container">

        <h1 class="center-align">Alteração da atividade complementar</h1>

        <?php

        //chamar a função que exibe a notificação para o aluno.
        exibirNotificacoes();

        //limpar a notificação de dentro da sessão.
        limpaNotificacoes();

        ?>

        <div class="card-panel">

            <form action="editarAtividade.php" method="post">

                <input type="hidden" value="<?php echo $dados['id_atividade_complementar']; ?>" name="id">

                <div class="input-field col s12">
                    <input placeholder="Por exemplo : 12 ou 1" value="<?php echo $dados['natureza']; ?>" id="natureza" name="natureza" type="text" class="validate" pattern="^.+$" required>
                    <label for="natureza">Natureza</label>
                    <span class="helper-text" data-error="O campo deve conter apenas caracteres numéricos com apenas duas casas."></span>
                </div>

                <div class="input-field col s12">
                    <input placeholder="Por exemplo : 60" value="<?php echo $dados['carga_horaria_maxima']; ?>" id="carga" name="carga" type="text" class="validate" pattern="^\d{1,3}$" required>
                    <label for="carga">Aproveitamento máximo</label>
                    <span class="helper-text" data-error="O campo deve conter apenas caracteres numéricos com apenas duas casas."></span>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <textarea id="textarea1" name="descricao" class="materialize-textarea" class="validate" pattern="^(?!\s*$).+" required ><?php echo $dados['descricao']; ?></textarea>
                        <span class="helper-text" data-error="O campo deve ser preenchido corretamente."></span>
                        <label for="textarea1">Descrição da atividade</label>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12">
                        <p class="center-align">
                            <button class="btn waves-effect waves-light  #1565c0 blue darken-3 lighten-3" type="submit" name="action">Editar atividade
                                <i class="material-icons right">create</i> </button>
                        </p>
                    </div>
                </div>

            </form>

        </div>

    </main>


    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="../materialize/js/materialize.min.js"></script>

    <script>
        $('#textarea1').val('New Text');
        M.textareaAutoResize($('#textarea1'));
    </script>

</body>

</html>