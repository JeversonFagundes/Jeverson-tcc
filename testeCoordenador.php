<?php

//FORMCADATIVIDADE.PHP

//conectar no banco de dados jeverson_tcc.
require_once "../conecta.php";

//variavél de conexão.
$mysql = conectar();

//incluir o arquivo de notificações do sistema.
require_once "../boasPraticas/notificacoes.php";

//listar todas as atividades complementares de curso do curso do coordenador de curso.
$sql = "SELECT c.nome_curso, c.carga_horaria, ac.id_atividade_complementar, ac.natureza, ac.descricao, ac.carga_horaria_maxima FROM atividade_complementar ac

INNER JOIN curso c

ON ac.id_curso AND c.id_curso = " . $_SESSION['coordenador'][2] . "

WHERE ac.id_curso = " . $_SESSION['coordenador'][2] . "
;";

//executar o comando sql.
$query = excutarSQL($mysql, $sql);

//pegar a quantidade de linhas afetas/retornadas do banco de dados.
$quantidade = $query->num_rows;

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
    <title>Tela de cadastro de atividades complementares de curso</title>

</head>

<style>
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        margin: 0;
    }

    main {
        flex: 1 0 auto;
    }

    .container {
        margin-top: 50px;
    }

    table {
        margin-top: 20px;
    }

    footer {
        background-color: #f5f5f5;
        padding: 10px 0;
        text-align: center;
        color: #757575;
    }

    .teste {
        justify-content: center;
        text-align: center;
    }

    .testeP {
        font-size: 20px;
    }
</style>

<body>

    <!-- Conteúdo Principal -->
    <main>

        <!--incluir a navbar.-->
        <?php
        require_once "../boasPraticas/headerNav.php";
        ?>

        <div class="container">

            <h2 class="center-align">Cadastro de atividades complementares de curso</h2>
            <hr>

            <br>
            <form action="cadastrarAtividade.php" method="post">

                <input type="hidden" value="<?php echo  $_SESSION['coordenador'][2]; ?>" name="curso">

                <div class="row">

                    <div class="input-field col s12">
                        <input placeholder="Digite a natureza da atividade complementar" id="natureza" name="natureza" type="text" class="validate" pattern="^\d{1,2}$" required>
                        <label for="natureza">Natureza</label>
                        <span class="helper-text" data-error="O campo deve conter apenas caracteres numéricos com apenas duas casas"></span>
                    </div>

                    <div class="input-field col s12">
                        <input placeholder="Digite a carga horária máxima a ser aprovada nesta atividade" id="carga" name="carga" type="text" class="validate" pattern="^\d{1,3}$" required>
                        <label for="carga">Carga horária máxima</label>
                        <span class="helper-text" data-error="O campo deve conter apenas caracteres numéricos com apenas duas casas"></span>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <textarea id="textarea1" class="materialize-textarea" name="descricao" class="validate" pattern="^(?!.*').*$" required></textarea>
                            <span class="helper-text" data-error="O campo não pode conter aspas simples"></span>
                            <label for="textarea1">Descrição da atividade</label>
                        </div>
                    </div>

                    <div class="center-align">
                        <a class="waves-effect waves-light btn"><i class="material-icons right">send</i>Cadastrar</a>
                    </div>

            </form>

            <br>

            <h2 class="center-align">Lista de atividades cadastradas</h2>
            <hr>

            <!--verificar a quantidade de linhas afetas.-->
            <?php

            if ($quantidade == 0) {

                //quer dizer que não atividades cadastradas no sistema

            ?>

                <p>Não há atividade cadastradas no sistema!</p>

            <?php

            } else {

            ?>

                <!--definir a tabela onde as informações serão exibidas para o coordenador de curso.-->
                <table>
                    <thead>
                        <tr>
                            <th>Natureza</th>
                            <th>Descrição</th>
                            <th class="teste">Carga horária máxima</th>
                            <th colspan="2"></th>
                        </tr>
                    </thead>
                    <tbody>

                        <!--definir a estrutura de repetição que irá exibir as informações na tela do coordenador de curso.-->
                        <?php

                        while ($dados = mysqli_fetch_assoc($query)) {

                            echo "<tr>";
                            echo "<td>" . $dados['natureza'] . "</td>";
                            echo "<td>" . $dados['descricao'] . "</td>";
                            echo "<td class=\"teste\">" . $dados['carga_horaria_maxima'] . "</td>";

                            echo '<td> <a href="crudEntrega/formeditEntrega.php?id=' . $dados['id_atividade_complementar'] . '" class="btn-floating btn-small waves-effect waves-light #1565c0 blue darken-3 modal-trigger"><i class="material-icons ">create</i></a> </td>';

                            echo '<td> <a href="#modal' . $dados['id_atividade_complementar'] . '" class="btn-floating btn-small waves-effect waves-light red modal-trigger"><i class="material-icons">delete</i></a> </td>';

                            echo "</tr>";

                        ?>

                            <!-- Modal Structure -->
                            <div id="modal<?php echo $dados['id_atividade_complementar']; ?>" class="modal">
                                <div class="modal-content">
                                    <h2> Atenção! </h2>
                                    <p>Você confirma a exclusão desta atividade : <?php echo $dados['descricao']; ?> ?</p>
                                </div>

                                <div class="modal-footer">
                                    <form action="crudEntrega/excluirEntrega.php" method="POST">
                                        <input type="hidden" name="id" value="<?php echo $dados['id_atividade_complementar']; ?>">

                                        <button type="submit" name="btn-deletar" class="modal-action modal-close waves-red btn red darken-1">
                                            Excluir </button>

                                        <button type="button" name="btn-cancelar" class="modal-action modal-close  btn waves-light green">
                                            Cancelar </button>
                                    </form>

                                </div>
                            </div>
                        <?php

                        }
                        ?>

                    </tbody>
                </table>
            <?php
            }


            ?>

            <?php

            mysqli_data_seek($query, 0);

            $todas_atividades = mysqli_fetch_assoc($query);

            ?>

            <p class="teste testeP"><strong>Total de horas que podem ser aprovadas : <?php echo $todas_atividades['carga_horaria'] ?> horas </strong></p>
        </div>

    </main>

    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="../materialize/js/materialize.min.js"></script>

    <script>
        $('#textarea1').val('New Text');
        M.textareaAutoResize($('#textarea1'));

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