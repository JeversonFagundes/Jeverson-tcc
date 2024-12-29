<?php

//INICIALADMIN.PHP

//conectar com o banco de dados jeverson-tcc.
require_once "conecta.php";

require_once "boasPraticas/notificacoes.php";

//declarar a veriável de conexão com o banco de dados jeverson-tcc. Esta veriavel vem do conecta.php.
$mysql = conectar();

//Buscar todos os cursos cadastrados no sistema e lista-los em ordem alfabética.
$sql = "SELECT * FROM curso ORDER BY nome_curso ASC";

//Atribuir a veriavel resultado ($resultado) o valor da excução do comando sql ($sql).
$resultado = excutarSQL($mysql, $sql);

//pegar a quantidade de cursos retornados.
$quantidade_cursos = $resultado->num_rows;

//Buscar todos os coordenadores de curso da tebela coordenador_curso, unindo a tebala coordenador_curso com a tabela curso para que seja possivél buscar todos os coordenador de curso com o seu respectivo curso.
$sql2 = "SELECT cc.id_coordenador, cc.nome, cc.email, c.nome_curso FROM coordenador_curso cc

        INNER JOIN curso c

        ON cc.id_curso = c.id_curso

        ORDER BY cc.nome ASC

        ;";

//Atribuir a resultado ($resultado2) o valor da execução do comando sql ($sql2).
$resultado2 = excutarSQL($mysql, $sql2);

//pegar a quantidade de coordenador de cursos retornados
$quantidade_coordenadores_curso = $resultado2->num_rows;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="materialize/css/materialize.min.css" media="screen,projection" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela inicial do administrador</title>

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
        .p{
            font-size: 20px;
        }
        .link{
           margin-left: 2px;
           margin-right: 2px;
        }
    </style>

</head>

<body>

    <!--conteudo principal-->
    <main>

        <!--incluir a navbar.-->
        <?php
        require_once "boasPraticas/headerNav.php";
        ?>

        <div class="container">

            <h2>Bem-vindo ao Sistema</h2>
            <hr>

            <br>

            <?php

            //bem acima das atividades que foram entregues no sistema, fica a mecanica de exibir notificações do sistema, que nesse caso exibi as nofiticações de "entrega realizada com sucesso no sistema!" qunado necessário.

            //exibir a mensagem de emtrega de atividade no sistema bem sucessedida.
            exibirNotificacoes();

            //limpar as notificações do sistema.
            limpaNotificacoes();

            ?>

            <h2>Cursos cadastrados</h2>
            <?php

            if ($quantidade_cursos == 0) {

            ?>

                <p class="p">Não há cursos cadastrados no sistema ainda!</p>
            <?php

            } else {

            ?>

                <table class="highlight">
                    <thead>
                        <tr>
                            <th>Nome do curso</th>
                            <th class="teste">Carga horária</th>
                            <th colspan="2">Opções</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php

                        while ($dados = mysqli_fetch_assoc($resultado)) {

                            echo "<tr>";
                            echo "<td> " . $dados['nome_curso'] . "</td>";
                            echo "<td class=\"teste\"> " . $dados['carga_horaria'] . "</td>";

                            echo '<td > <a c href="crudCurso/formeditCurso.php?id=' . $dados['id_curso'] .  '" class="btn-floating btn-small waves-effect waves-light #1565c0 blue darken-3 modal-trigger link"><i class="material-icons ">create</i></a> </td>';

                            echo '<td> <a href="#modal' . $dados['id_curso'] . '" class="btn-floating btn-small waves-effect waves-light red modal-trigger link"><i class="material-icons">delete</i></a> </td>';

                            echo "</tr>";

                        ?>

                            <!-- Modal Structure -->
                            <div id="modal<?php echo $dados['id_curso']; ?>" class="modal">
                                <div class="modal-content">
                                    <h2> Atenção! </h2>
                                    <p>Você confirma a exclusão deste curso : <?php echo $dados['nome_curso']; ?> ?</p>
                                </div>

                                <div class="modal-footer">
                                    <form action="crudCurso/excluirCurso.php" method="POST">
                                        <input type="hidden" name="id" value="<?php echo $dados['id_curso']; ?>">

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

            <br>

            <h2>Coordenadores de curso cadastrados no sistema</h2>

            <?php

            if ($quantidade_coordenadores_curso == 0) {

            ?>

                <p class="p">Não há coordenadores de curso cadastrados no sistema ainda!</p>
            <?php
            } else {

            ?>

                <table class="highlight">
                    <thead>
                        <tr>
                            <th>Nome coordenador</th>
                            <th>Email</th>
                            <th>Curso</th>
                            <th colspan="2">Opções</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php

                        while ($dados = mysqli_fetch_assoc($resultado2)) {

                            echo "<tr>";
                            echo "<td> " . $dados['nome'] . "</td>";
                            echo "<td> " . $dados['email'] . "</td>";
                            echo "<td> " . $dados['nome_curso'] . "</td>";

                            echo '<td> <a href="crudCoordenador/formeditCoordenador.php?id=' . $dados['id_coordenador'] . '" class="btn-floating btn-small waves-effect waves-light #1565c0 blue darken-3 modal-trigger"><i class="material-icons ">create</i></a> </td>';

                            echo '<td> <a href="#modal' . $dados['id_coordenador'] . '" class="btn-floating btn-small waves-effect waves-light red modal-trigger"><i class="material-icons">delete</i></a> </td>';

                            echo "</tr>";

                        ?>

                            <!-- Modal Structure -->
                            <div id="modal<?php echo $dados['id_coordenador']; ?>" class="modal">
                                <div class="modal-content">
                                    <h2> Atenção! </h2>
                                    <p>Você confirma a exclusão deste coordenador de curso : <?php echo $dados['nome']; ?> ?</p>
                                </div>

                                <div class="modal-footer">
                                    <form action="crudCoordenador/excluirCoordenador.php" method="POST">
                                        <input type="hidden" name="id" value="<?php echo $dados['id_coordenador']; ?>">

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

        </div>

    </main>

    <br><br>

    <!-- Rodapé -->
    <footer>
        <div class="container">
            <p>Complementa Iffar - Jeverson Miguel Rios Fagundes</p>
        </div>
    </footer>

    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="materialize/js/materialize.min.js"></script>

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
            sidenav.style.width = '300px'; // Ajuste a largura conforme necessário
        });
    </script>

</body>

</html>