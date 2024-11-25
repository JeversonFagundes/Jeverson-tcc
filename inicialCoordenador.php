<?php

//INICIALCOORDENADOR.PHP

//conectar com o banco de dados jeverson_tcc.
require_once "conecta.php";

//incluir o arquivo onde são feitas as notificações do sistema.
require_once "boasPraticas/notificacoes.php";

//declarar a variavel de conexão com o banco de dados jeverson_tcc.
$mysql = conectar();

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
    <title>Tela inicial do coordenador de curso.</title>

</head>

<body>

    <!--incluir a navbar.-->
    <?php
    require_once "boasPraticas/headerNav.php";
    ?>

    <main>

        <!--Sessão como o valor do nome do coordenador de curso.-->
        <h2><?php echo $_SESSION['coordenador'][0]; ?></h2>

        <hr>

        <h2>Lista de alunos que entregaram atividades complementares para validação no sistema.</h2>

        <!--buscar no banco de dados.-->
        <?php

        //buscar todos os alunos que cadastraram atividades complementares de curso para validação, unindo a tabela dos alunos com o coordenador de curso para seja possivél buscar apenas os alunos que tenham o mesmo curso que o coordenador de curso logado atualmente no sistema. Depois unimos os alunos que foram retornado com a tabela entrega_atividades para que seja possivél além de buscar alunos que tenham o mesmo curso que o coordenador de curso, agora fazemos uma filtragem para apenas os alunos que cadastraram atividades para a validação. Com tudo isso podemos buscar por dados duplicados, ou seja, um aluno pode ter cadastrado mais de uma atividade no sistema, então ele pode aparecer duas ou mais vezes, para resolver isso usamos o comando slq DISTINVT que é usada para eliminar valores duplicados em uma consulta, retornando apenas os registros únicos.

        //O comando DISTINCT é usado para selecionar valores únicos de uma coluna ou combinações de colunas em uma consulta SQL, eliminando os valores duplicados.

        $sql = "SELECT DISTINCT 
        a.id_aluno, 
        a.nome, 
        a.matricula,
        a.total_horas
        FROM aluno a
        INNER JOIN coordenador_curso cc 
        ON a.id_curso = " . $_SESSION['coordenador'][2] . " AND cc.id_curso = " . $_SESSION['coordenador'][2] . "
        INNER JOIN entrega_atividade ea 
        ON a.id_aluno = ea.id_aluno 
        ;";

        //atribuir a variavél resultado ($resultado) a execução do comando sql ($sql1).
        $resultado = excutarSQL($mysql, $sql);

        //pegar a quantidade de linhas retornadas do banco de dados.
        $quatidade_linhas = $resultado->num_rows;

        //tendo em mãos a quantidade de linhas retornadas do banco de dados, agora podemos fazer verificações referentes a essa informção.
        if ($quatidade_linhas == 0) {

            //quer dizer que nenhum aluno entregou atividades complementares de curso para validação no sistema.
        ?>
            <p>Nenhum aluno entregou atividade complementares para validação no sistema.</p>
            <p>Aguarde por favor!</p>
        <?php

        } else {

            //quer dizer que temos alunos que entregaram atividades complementares para avalição no sistema.
        ?>

            <!--tabela dos alunos.-->
            <table>
                <thead>
                    <tr>
                        <th>Nome do aluno</th>
                        <th>Matricula</th>
                        <th>Total de horas aprovadas</th>
                        <th>Visualizar</th>
                    </tr>
                </thead>
                <tbody>

                    <!--definir a estrutura de repetição que irá mostrar os dados para o coordenador de curso.-->
                    <?php

                    while ($dados = mysqli_fetch_assoc($resultado)) {

                        echo "<tr>";
                        echo "<td>" . $dados['nome'] . "</td>";
                        echo "<td>" . $dados['matricula'] . "</td>";
                        echo "<td>" . $dados['total_horas'] . "</td>";
                        echo '<td> <a href="validacao/validar.php?id=' . $dados['id_aluno'] . '" class="btn-floating btn-small waves-effect waves-light red modal-trigger"><i class="material-icons ">remove_red_eye</i></a> </td>';
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        <?php

        }

        ?>

    </main>

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