<?php

                                           //INICIALADMIN.PHP

//conectar com o banco de dados jeverson-tcc.
require_once "conecta.php";

//incluir o arquivo onde é feito a proteção do sistema..
require_once "protecao.php";

//declarar a veriável de conexão com o banco de dados jeverson-tcc. Esta veriavel vem do conecta.php.
$mysql = conectar();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela inicial do administrador</title>

</head>

<body>

    <!--Para que não seja necessário criar toda vez um header com uma nav em todas as telas dos usuários, então aqui incluimos a pasta onde esta o arquivo onde está criado o header e o nav.-->
    <?php require_once "boasPraticas/headerNav.php"; ?>
    <main>
        <h1>Bem vindo!</h1>

        <!--Sessão com o valor do email do administrador.-->
        <h2><?php echo $_SESSION['administrador'][0]; ?></h2>

        <p><a href="crudCurso/formcadcurso.html">Cadastrar curso</a></p>

        <p><a href="crudCoordenador/formcadCoordenador.php">Cadastrar coordenador de curso</a></p>

        <hr>

        <?php

        //Buscar todos os cursos cadastrados no sistema e lista-los em ordem alfabética.
        $sql = "SELECT * FROM curso ORDER BY nome_curso ASC";

        //Atribuir a veriavel resultado ($resultado) o valor da excução do comando sql ($sql).
        $resultado = excutarSQL($mysql, $sql);

        //verificar se houve algum erro na excução do comando sql ($sql).
        if ($mysql->error) {

            die("Falha ao listar" . $mysql->error);
        } else {

            //Se não houve erro, listamos todos os cursos em uma tabela.
            echo '<table border=4;">
            <tr>
            <th>Nome do curso</th>
            <th>Carga horaria</th>

            <th colspan=3>Opções</th>
            </tr>';

            //Atribuir um array associativo com todos os resultados que vieram do banco de dados jeverson-tcc, tabela curso a veriavél dados f($dados).
            while ($dados = mysqli_fetch_assoc($resultado)) {
                echo '<tr>';
                echo '<td>' . $dados['nome_curso'] . '</td>';
                echo '<td>' . $dados['carga_horaria'] . '</td>';

                echo '<td> <a href="crudCurso/formeditCurso.php?id=' . $dados['id_curso'] . '"> Alterar</a> </td>';

                echo '<td> <a href="crudCurso/excluirCurso?id=' . $dados['id_curso'] . '"> Excluir </a> </td>';

                echo '</tr>';
            }

            echo '</table> <br><br>';
        }

        echo '</table>';

        //Buscar todos os coordenadores de curso da tebela coordenador_curso, inindo a tebala coordenador_curso com a tabela curso para que seja possivél buscar todos os coordenador de curso com o seu respectivo curso.
        $sql2 = "SELECT cc.id_coordenador, cc.nome, cc.email, c.nome_curso FROM coordenador_curso cc

        INNER JOIN curso c

        ON cc.id_curso = c.id_curso

        ORDER BY cc.nome ASC

        ;";

        //Atribuir a resultado ($resultado2) o valor da execução do comando sql ($sql2).
        $resultado2 = excutarSQL($mysql, $sql2);

        //Verificar se houve algum erro na hora de conectar com o banco de dados jeverson-tcc.
        if ($mysql->error) {

            die("Falha ao listar" . $mysql->error);
        } else {

            //Se deu certo, listamos todos os coordenador de curso com o seu respectivo curso dentro de uma tabela.
            echo '<table border=4;">
            <tr>
            <th>Nome do coordenador de curso</th>
            <th>Email</th>
            <th>Curso</th>

            <th colspan=3>Opções</th>
            </tr>';

            //Atribuir a variavél dados ($dados2) o array associativo com os valores que vieram do banco dados jeverson-tcc ($resultado2) que será repetido e imprimido na tela enquanto houver dados.
            while ($dados2 = mysqli_fetch_assoc($resultado2)) {
                echo '<tr>';
                echo '<td>' . $dados2['nome'] . '</td>';
                echo '<td>' . $dados2['email'] . '</td>';
                echo '<td>' . $dados2['nome_curso'] . '</td>';

                echo '<td> <a href="crudCoordenador/formeditCoordenador.php?id=' . $dados2['id_coordenador'] . '"> Alterar</a> </td>';

                echo '<td> <a href="crudCoordenador/excluirCoordenador?id=' . $dados2['id_coordenador'] . '"> Excluir </a> </td>';

                echo '</tr>';
            }

            echo '</table> <br><br>';
        }

        echo '</table> <br><br>';


        ?>

    </main>

</body>

</html>