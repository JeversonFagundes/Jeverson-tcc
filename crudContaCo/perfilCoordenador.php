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
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="../materialize/css/materialize.min.css" media="screen,projection" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do coordenador de curso</title>

</head>

<body>

    <!--incluir a navbar-->
    <?php require_once "../boasPraticas/headerNav.php"; ?>

    <!--conteúdo principal-->
    <main class="container">

        <h1 class="center-align">Informações da sua conta!</h1>
        <?php

        //chamar a função que exibe a notificação
        exibirNotificacoes();

        //chamar a função que limpa a notificação da sessão.
        limpaNotificacoes();
        ?>

        <form action="editarContCo.php" method="post">

            <div class="card-panel">

                <div class="input-field col s12">
                    <i class="material-icons prefix">person_outline</i>
                    <input placeholder="Digite o seu nome" value="<?php echo $coordenador['nome']; ?>" id="nome" name="nome" type="text" class="validate" pattern="^.+$" required>
                    <label for="nome">Nome</label>
                    <span class="helper-text" data-error="Você deve preenchar esse campo"></span>
                </div>

                <div class="input-field col s12">
                    <i class="material-icons prefix">mail_outline</i>
                    <input placeholder="Digite o seu email" value="<?php echo $coordenador['email']; ?>" id="email" name="email" type="text" class="validate" pattern="^.*@.*$" required>
                    <label for="email">Email</label>
                    <span class="helper-text" data-error="O campo deve conter o @, exemplo user@gmail.com"></span>
                </div>

                <?php

                //atribuir a variavél sql2 ($sql2) a busca por todos os cursos cadastrados no sistema e ordená-los por ordem alfabéticaF
                $sql2 = "SELECT id_curso, nome_curso FROM curso ORDER BY nome_curso ASC";

                //atribuir a variavél resultado2 ($resultado2) a excução do comando sql2 ($sql2).
                $resultado2 = excutarSQL($mysql, $sql2);

                ?>

                <label>Qual é o seu curso?</label>
                <!--As tags selects e options são usadas para criar menus suspensos (dropdowns) ou listas de opções em formulários.-->
                <!--SELECT cria um menu suspenso que permite ao usuário escolher uma ou mais opções.-->
                <select name="curso" class="browser-default">
                    <?php

                    //dentro do campo de seleção atribuimos a veriavél dados ($dados) o array associativo com os valores do resultado da excução do comando sql2 ($sql2) que será repetido enquanto houver dados.
                    while ($dados = mysqli_fetch_assoc($resultado2)) {

                    ?>

                        <!--declarar o option que nada mais é do que as opções do select. Este option tem os valores que queremos do array associativo dados ($dados).-->
                        <option <?php

                                //aqui fazemos uma verificação de todos os cursos cadastrados no sistema, qual é o do aluno que está logado no momento e atribuimos o comando selected "seleciionado", ou  seja, a lista de opções já vai vir selecionada com o nome do curso do aluno que está logado no sistema. No caso está verificação sempre vai ser atendida, porque o aluno está logado no sistema, ou seja, ele está cadastrado no banco de dados e se ele esta cadastrado, ele tem que ter abrigatóriamente um curso
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
            </div>


            <input type="hidden" value="<?php echo $coordenador['id_coordenador']; ?>" name="id">

            <div class="row">
                <div class="col s12">
                    <p class="center-align">
                        <button class="btn waves-effect waves-light #2e7d32 green darken-3 lighten-3" type="submit" name="action">Editar conta
                            <i class="material-icons right">create</i> </button>
                    </p>
                </div>

            </div>

        </form>

        <div class="col s12">
            <p class="center-align">
                <a href="#modal<?php echo $coordenador['id_coordenador']; ?>" class="waves-effect waves-light #e64a19 deep-orange darken-2 lighten-3 btn modal-trigger"><i class="material-icons right">delete</i>Excluir conta</a>
            </p>
        </div>
        </div>

        <!-- Modal Structure -->
        <div id="modal<?php echo $coordenador['id_coordenador']; ?>" class="modal">
            <div class="modal-content">
                <h2> Atenção! </h2>
                <hr>
                <p>Você confirma a exclusão da sua conta! : <strong><?php echo $coordenador['nome']; ?></strong> ?</p>
                <hr>
            </div>

            <div class="modal-footer">
                <form action="../crudCoordenador/excluirCoordenador.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $coordenador['id_coordenador']; ?>">

                    <button type="submit" name="btn-deletar" class="modal-action modal-close waves-red btn red darken-1">
                        Excluir </button>

                    <button type="button" name="btn-cancelar" class="modal-action modal-close  btn waves-light green">
                        Cancelar </button>
                </form>
            </div>

    </main>

    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="../materialize/js/materialize.min.js"></script>

    <script>
        // M.AutoInit();
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('.modal');
            var instances = M.Modal.init(elems, {
                opacity: 0.7, // Opacidade do background (0.0 a 1.0)
                inDuration: 1000, // Duração da animação de abertura em milissegundos
                outDuration: 1200, // Duração da animação de fechamento em milissegundos
                dismissible: true, // Permite fechar ao clicar fora do modal
                startingTop: '10%', // Posição inicial do modal em relação ao topo
                endingTop: '15%' // Posição final do modal em relação ao topo
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Inicializa a sidenav
            var elems = document.querySelectorAll('.sidenav');
            var instances = M.Sidenav.init(elems, {
                edge: 'left'
            });

            // Configura a largura da sidenav
            var sidenav = document.querySelector('.sidenav');
            sidenav.style.width = '250px'; // Ajuste a largura conforme necessário
        });
    </script>

</body>

</html>