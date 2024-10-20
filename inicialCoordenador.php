<?php

//INICIALCOORDENADOR.PHP

//conectar com o bonco de dados jeverson-tcc.
require_once "conecta.php";

//incluir o arquivo onde é feitas as notificações do sistema.
require_once "boasPraticas/notificacoes.php";

//declarar a veriavél de conexão com o banco de dados jeverson-tcc. Esta variavél vem do arquivo conecta.php.
$mysql = conectar();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <!--Import Google Icon Font-->
    <!--<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">-->
    <!--Import materialize.css-->
    <!--<link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela inicial do coordenador de curso</title>

    <!--Estiização em formato de card da exibição dos nomes dos alunos que cadastraram atividades complementares de curso para á avaliação do coordenador-->
    <style>
        .card {
            background-color: white;
            width: 40%;
            height: 100px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px rgba(0, 0, 0, 0.19);
        }
    </style>

</head>

<body>

    <!--Para que não seja necessário criar toda vez um header com uma nav em todas as telas dos usuários, então aqui incluimos a pasta onde esta o arquivo onde está criado o header e o nav.-->
    <?php require_once "boasPraticas/headerNav.php"; ?>

    <main>

        <!--Sessão com o valor do nome do coordenador de curso.-->
        <h1><?php echo $_SESSION['coordenador'][0]; ?></h1>

        <p><a href="crudAtividade/formcadAtividade.php">Cadastrar atividade complementar</a></p>

        <!--<button onclick="gerar();">Gerar tabela de atividades complementares de curso</button>-->

        <hr>

        <?php

        //selecionar todos os itens da tebala de atividades complementares
        $sql = "SELECT * FROM atividade_complementar WHERE id_curso = " . $_SESSION['coordenador'][2];

        //excutar o comando sql acima.
        $resultado = mysqli_query($mysql, $sql);

        //caso dê erro
        if ($mysql->error) {

            die("Falha ao listar os itens!" . $mysql->error);
        } else {

            $quantidade = $resultado->num_rows;

            if ($quantidade == 0) {

                echo "Você não tem atividade complementar cadastradas no sistema!";
            } else {

        ?>

                <table border="1" id="tabela">
                    <thead>
                        <tr>
                            <th>Natureza da atividade</th>
                            <th>Descriçãoda atividade</th>
                            <th>Carga horaria máxima</th>
                            <th colspan=3>Opções</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php

                        while ($dados = mysqli_fetch_assoc($resultado)) {
                            echo '<tr>';
                            echo '<td>' . $dados['natureza'] . '</td>';
                            echo '<td>' . $dados['descricao'] . '</td>';
                            echo '<td>' . $dados['carga_horaria_maxima'] . '</td>';
                            echo '<td> <a href="crudAtividade/formeditAtividade.php?id=' . $dados['id_atividade_complementar'] . '"> Alterar </a> </td>';
                            echo '<td> <a href="crudAtividade/excluirAtividade?id=' . $dados['id_atividade_complementar'] . '"> Excluir </a> </td>';
                            echo '</tr>';
                        }

                        ?>

                    </tbody>
                </table>
        <?php
                /*echo '<div id="tabela">';
                echo '<h3>Tabela de atividades complemenatres</h3>';
                //Lista os itens
                echo '<table border=1">

                <tr>
                <th>Natureza da atividade</th>
                <th>Descrição da atividade</th>
                <th>Carga horaria máxima</th>
                <th colspan=3>Opções</th>
                </tr>';*/

                /*while ($dados = mysqli_fetch_assoc($resultado)) {
                    echo '<tr>';
                    echo '<td>' . $dados['natureza'] . '</td>';
                    echo '<td>' . $dados['descricao'] . '</td>';
                    echo '<td>' . $dados['carga_horaria_maxima'] . '</td>';
                    echo '<td> <a href="crudAtividade/formeditAtividade.php?id=' . $dados['id_atividade_complementar'] . '"> Alterar </a> </td>';
                    echo '<td> <a href="crudAtividade/excluirAtividade?id=' . $dados['id_atividade_complementar'] . '"> Excluir </a> </td>';
                    echo '</tr>';
                }*/

                //echo '</table>' . '<br><br>';

                //echo '</div>';
            }
        }

        echo '<hr>';
        echo '<h1>Lista de alunos que entregaram atividades complementares para validaçao no sistema </h1>';

        //buscar todos os alunos que cadastraram atividades complementares de curso para validação, unindo a tabela dos alunos com o coordenador de curso para seja possivél buscar apenas os alunos que tenham o mesmo curso que o coordenador de curso logado atualmente no sistema. Depois unimos os alunos que foram retornado com a tabela entrega_atividades para que seja possivél além de buscar alunos que tenham o mesmo curso que o coordenador de curso, agora fazemos uma filtragem para apenas os alunos que cadastraram atividades para a validação. Com tudo isso podemos buscar por dados duplicados, ou seja, um aluno pode ter cadastrado mais de uma atividade no sistema, então ele pode aparecer duas ou mais vezes, para resolver isso usamos o comando slq DISTINVT que é usada para eliminar valores duplicados em uma consulta, retornando apenas os registros únicos.
        $sql1 = "SELECT DISTINCT 
        a.id_aluno, 
        a.nome, 
        a.matricula 
        FROM aluno a
        INNER JOIN coordenador_curso cc 
        ON a.id_curso = " . $_SESSION['coordenador'][2] . " AND cc.id_curso = " . $_SESSION['coordenador'][2] . "
        INNER JOIN entrega_atividade ea 
        ON a.id_aluno = ea.id_aluno 
        ;";

        //atribuir a variavél resultado1 ($resultado1) a execução do comando sql ($sql1).
        $resultado1 = excutarSQL($mysql, $sql1);

        //verificar se houve algum erro com a conexão com o banco de dados jeverson-tcc
        if ($mysql->error) {

            die("Falha ao unir as informações! " . $mysql->error);
        } else {

            //se deu certo, atribuimos a veriavel quantidade1, a quantidade de linhas que foram retornadas do banco de dados.
            $quantidade1 = $resultado1->num_rows;

            //tendo em mãos a quantidade de linhas retornadas do banco de dados, agora podemos fazer verificações referentes a essa informção.
            if ($quantidade1 == 0) {

                echo "<p>Os alunos ainda não cadastraram atividade complementares para validação. </p>";

                echo "<p>Aguarde por favor!</p>";
            } else {

                //se deu certo, atribuimos a variavél dados1 ($dados1) um array associativo com os dados dos alunos que foram buscados no banco de dados e seram repetidos e imprimidos na tela do coordenador de curso enqunanto houver dados dentro desse array.
                while ($dados1 = mysqli_fetch_assoc($resultado1)) {

                    echo '<div class="card">';
                    echo '<div class="card-body">';
                    echo '<h1 class="card-title">' . '<a href="validacao/validar.php?id=' . $dados1['id_aluno'] . '">' . $dados1['nome'] . '</a>' . '</h1>';
                    echo '<p class="card-text">' . 'Matricula do aluno:' . ' ' . $dados1['matricula'] . '</p>';
                    echo '</div>';
                    echo '</div>';
                }
            }
        }

        ?>
    </main>
    <!--Import jQuery before materialize.js-->
    <!--<script type="text/javascript" src="js/materialize.min.js"></script>-->
</body>

</html>