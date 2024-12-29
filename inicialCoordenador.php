<?php

//INICIALCOORDENADOR.PHP

//conectar com o banco de dados jeverson_tcc.
require_once "conecta.php";

//incluir o arquivo onde são feitas as notificações do sistema.
require_once "boasPraticas/notificacoes.php";

//declarar a variavel de conexão com o banco de dados jeverson_tcc.
$mysql = conectar();

//buscar no banco de dados

//buscar todos os alunos que cadastraram atividades complementares de curso para validação, unindo a tabela dos alunos com o coordenador de curso para seja possivél buscar apenas os alunos que tenham o mesmo curso que o coordenador de curso logado atualmente no sistema. Depois unimos os alunos que foram retornado com a tabela entrega_atividades para que seja possivél além de buscar alunos que tenham o mesmo curso que o coordenador de curso, agora fazemos uma filtragem para apenas os alunos que cadastraram atividades para a validação. Com tudo isso podemos buscar por dados duplicados, ou seja, um aluno pode ter cadastrado mais de uma atividade no sistema, então ele pode aparecer duas ou mais vezes, para resolver isso usamos o comando slq DISTINVT que é usada para eliminar valores duplicados em uma consulta, retornando apenas os registros únicos.

//O comando DISTINCT é usado para selecionar valores únicos de uma coluna ou combinações de colunas em uma consulta SQL, eliminando os valores duplicados.

$sql = "SELECT DISTINCT a.id_aluno, a.nome, a.matricula,a.email, a.conclusao_horas FROM aluno a 

INNER JOIN coordenador_curso cc 

ON cc.id_curso = " . $_SESSION['coordenador'][2] . " AND a.id_curso = " . $_SESSION['coordenador'][2] . "

INNER JOIN entrega_atividade ea 

ON ea.id_aluno = a.id_aluno 

INNER JOIN curso c 

ON c.id_curso = cc.id_curso";

//atribuir a variavél resultado ($resultado) a execução do comando sql ($sql1).
$resultado = excutarSQL($mysql, $sql);

//pegar a quantidade de linhas retornadas do banco de dados.
$quatidade_linhas = $resultado->num_rows;

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
    <title>Tela inicial do coordenador de curso</title>

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
    </style>

</head>

<body>

    <!-- Conteúdo Principal -->
    <main>

        <!--incluir a navbar.-->
        <?php
        require_once "boasPraticas/headerNav.php";
        ?>

        <div class="container">

            <h2>Bem-vindo ao Sistema</h2>
            <hr>

            <?php

            //tendo em mãos a quantidade de linhas retornadas do banco de dados, agora podemos fazer verificações referentes a essa informção.
            if ($quatidade_linhas == 0) {

                //quer dizer que nenhum aluno entregou atividades complementares de curso para validação no sistema.

            ?>

                <p>Nenhum aluno entregou atividades complementares para validação no sistema.</p>
                <p>Aguarde por favor!</p>

            <?php

            } else {

                //quer dizer que temos alunos que entregaram atividades complementares para avalição no sistema.

            ?>

                <h3 class="center-aling">Lista de alunos para validação de horas complementares</h3>

                <!--tabela dos alunos.-->
                <table>
                    <thead>
                        <tr>
                            <th>Nome do aluno</th>
                            <th class="teste">Matricula</th>
                            <th class="teste">Email</th>
                            <th class="teste">Visualizar</th>
                        </tr>
                    </thead>

                    <tbody>

                        <!--definir a estrutura de repetição que irá mostrar os dados para o coordenador de curso.-->
                        <?php

                        while ($dados = mysqli_fetch_assoc($resultado)) {

                            if ($dados['conclusao_horas'] == 1) {

                                //quer dizer que o aluno concluiu todas as suas horas complementares de curso e por esse motivo, imprimimos a linha com a cor verde.

                                echo "<tr class=\"#a5d6a7 green lighten-3\">";

                                echo "<td>" . $dados['nome'] . "</td>";
                                echo "<td class=\"teste\">" . $dados['email'] . "</td>";
                                echo "<td class=\"teste\" >" . $dados['matricula'] . "</td>";
                                
                                echo '<td class="teste"> <a href="validacao/validar.php?id=' . $dados['id_aluno'] . '" class="btn-floating btn-small waves-effect waves-light red modal-trigger"><i class="material-icons ">remove_red_eye</i></a> </td>';

                                echo "</tr>";
                            } else {

                                //quer dizer que o aluno ainda não concluiu todas as suas horas complementares de curso e por esse motivo, imprimimos a linha com a cor laranja.

                                echo "<tr class=\"#ffcc80 orange lighten-3\">";

                                echo "<td>" . $dados['nome'] . "</td>";
                                echo "<td class=\"teste\" >" . $dados['email'] . "</td>";
                                echo "<td class=\"teste\" >" . $dados['matricula'] . "</td>";
                                echo '<td class="teste"> <a href="validacao/validar.php?id=' . $dados['id_aluno'] . '" class="btn-floating btn-small waves-effect waves-light red modal-trigger"><i class="material-icons ">remove_red_eye</i></a> </td>';

                                echo "</tr>";
                            }
                        }
                        ?>
                    </tbody>

                </table>

            <?php
            }
            ?>

        </div>

    </main>

    <!-- Rodapé -->
    <footer>
        <div class="container">
            <p>Complementa Iffar - Jeverson Miguel Rios Fagundes</p>
        </div>
    </footer>

    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="materialize/js/materialize.min.js"></script>

    <script>
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