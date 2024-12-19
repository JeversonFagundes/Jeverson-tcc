<?php

//FORMEDITCOORDENADOR.PHP

//incluir o arquivo de notificações do sistema.
require_once "../boasPraticas/notificacoes.php";

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
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="../materialize/css/materialize.min.css" media="screen,projection" />

    <title>Alterar um coordenador</title>

</head>

<body>

    <?php

    require_once "../boasPraticas/headerNav.php";
    ?>

    <main class="container">

        <h1 class="center-align">Formulário de alteração de um coordenador!</h1>

        <?php

        exibirNotificacoes();

        limpaNotificacoes();
        ?>

        <div class="card-panel">

            <form action="editarCoordenador.php" method="post">

                <input type="hidden" value="<?php echo $coordenador['id_coordenador']; ?>" name="id" />

                <div class="input-field col s12">
                    <i class="material-icons prefix">person_outline</i>
                    <input placeholder="Digite o nome do coordenador de curso" value="<?php echo $coordenador['nome']; ?>" id="nome" name="nome" type="text" class="validate" pattern="^.+$" required>
                    <label for="nome">Nome do coordenador de curso : </label>
                    <span class="helper-text" data-error="Você deve preenchar esse campo"></span>
                </div>

                <?php

                //atribuir a variavél sql2 ($sql2) a busca por todos os curso e ordena-los em ordem alfabética.
                $sql2 = "SELECT id_curso, nome_curso FROM curso ORDER BY nome_curso ASC";

                //atribuir a variavél resulltado2 ($resultado2) a execução do comando sql2 ($sql2)
                $resultado2 = excutarSQL($mysql, $sql2);

                ?>

                <label>Qual é o seu curso?</label>
                <!--As tags selects e options são usadas para criar menus suspensos (dropdowns) ou listas de opções em formulários.-->
                <!--SELECT cria um menu suspenso que permite ao usuário escolher uma ou mais opções.-->
                <select name="curso" class="browser-default ">
                    <!--OPTION define cada opção dentro do menu suspenso.-->
                    <option value="" disabled selected>Escolha o seu curso</option>

                    <!--selected é usado para definir uma opção como pré-selecionada quando a página é carregada.-->
                    <!--disabled é usado para tornar uma opção não selecionável.-->

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
                </select>

                <br>
                <div class="input-field col s12 espacamento">
                    <i class="material-icons prefix">mail_outline</i>
                    <input placeholder="Digite o seu email" value="<?php echo $coordenador['email']; ?>" id="email" name="email" type="text" class="validate" pattern="^.*@.*$" required>
                    <label for="email">Email</label>
                    <span class="helper-text" data-error="O campo deve conter o @, exemplo user@gmail.com"></span>
                </div>

                <div class="row">
                    <div class="col s12">
                        <p class="center-align">
                            <button class="btn waves-effect waves-light #2e7d32 green darken-3 lighten-3" type="submit" name="action">Cadastrar coordenador de curso
                                <i class="material-icons right">send</i> </button>
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