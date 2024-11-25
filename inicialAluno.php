<?php

//INICIALALUNO.PHP

//conectar com o banco de dados jeverson_tcc.
require_once "conecta.php";

//incluir o arquivo de notificações do sistema.
require_once "boasPraticas/notificacoes.php";

//criar a variavel de conexão com o banco de dados jeverson_tcc. Esta variavel vem do arquivo conecta.php
$mysql = conectar();

//pasta de destino para onde vão os certificados.
$pastaDestino = "certificados/";

//fazer uma verificação para definir qual o valor que a variavel $total_curso irá receber. Por exemplo "a carga horária obrigatória do curso de informática é de 60 horas".
if ($_SESSION['aluno'][2] == 9) {

    //Curso Técnico Integrado em Informática
    $total_curso = 60;
} else {

    if ($_SESSION['aluno'][2] == 11 or $_SESSION['aluno'][2] == 13) {

        //Curso Técnico Integrado em Administração e Curso de Markiting Subsequente
        $total_curso = 40;
    } else {

        if ($_SESSION['aluno'][2] == 12) {

            //Curso de Manutenção e Suporte em Informática (MSI)
            $total_curso = 50;
        }
    }
}
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
    <title>Tela inicial</title>

    <style>
        .espacamento {
            margin-right: 20px;
        }

        .espacamentoh2 {
            margin-left: 20px;
        }

        .deferido {
            background-color: #d4edda;
        }

        .indeferido {
            background-color: #f8d7da;
        }
    </style>

</head>

<body>

    <!--incluir a navbar.-->
    <?php
    require_once "boasPraticas/headerNav.php";
    ?>

    <main>

        <!--sessão com o valor do nome do aluno.-->
        <h2><?php echo $_SESSION['aluno'][0]; ?></h2>

        <hr>

        <h1>Minhas atividades complementares de curso.</h1>

        <!--busca no banco de dados.-->
        <?php

        //listar todas as atividades cadasttradas pelo aluno que está logado no sistema. Para isso buscamos na tebela entrega_atividade unindo coma tabela atividade_complementar e aluno, para que seja possível exibir as atividades cadastradas pelo aluno junto com as infromações da atividade complementar de curso que essa entrega está relacionada, como natureza, descrição etc.
        $sql = "SELECT 
        ac.descricao, 
        ac.natureza,
        ac.id_atividade_complementar,
        ea.id_entrega_atividade,
        ea.titulo_certificado, 
        ea.carga_horaria_certificado,
        ea.certificado, 
        ea.carga_horaria_aprovada, 
        ea.status,
        ea.caminho,
        ea.id_atividade_complementar,
        ea.observacoes,
        a.total_horas
        FROM entrega_atividade ea 
        INNER JOIN atividade_complementar ac 
        ON ea.id_atividade_complementar = ac.id_atividade_complementar
        INNER JOIN aluno a 
        ON a.id_aluno = ea.id_aluno
        WHERE 
        a.id_aluno = " . $_SESSION['aluno'][1];

        //atribuir a variavél query ($query) a excução do comando sql ($sql).
        $query = excutarSQL($mysql, $sql);

        //atribuir á variavél quantidade ($quantidade) a quantidade de linhas que foram retornadas no comando sql ($sql).
        $quantidade = $query->num_rows;

        //com a quantidade de linhas em mãos, agora é possivél fazer verificações com relação a isso.
        if ($quantidade == 0) {

        ?>

            <!--exibimos a mensagem de que o aluno não tem atividades cadastradas no sistema.-->
            <div class="container">
                <p class="center-align">Você não entregou nenhuma atividade complementar no sistema ainda!</p><br>

                <?php
                //bem acima das atividades que foram entregues no sistema, fica a mecanica de exibir notificações do sistema, que nesse caso exibi as nofiticações de "entrega realizada com sucesso no sistema!" qunado necessário.

                //exibir a mensagem de emtrega de atividade no sistema bem sucessedida.
                exibirNotificacoes();

                //limpar as notificações do sistema.
                limpaNotificacoes();
                ?>
            </div>

        <?php
            die();
        } else {

            //definir o array associativo com os valores vindos do banco de dados.
            $entrega = mysqli_fetch_assoc($query);

            //definir a variável que irá armazenar o total de horas aprovadas do aluno.
            $total_horas_aprovadas = $entrega['total_horas'];

            mysqli_data_seek($query, 0);

        ?>

            <!--mostramos todas as infromações referentes as entregas que o aluno faz no sistema.-->

            <div>

                <!--notificações do sistema.-->
                <?php

                //bem acima das atividades que foram entregues no sistema, fica a mecanica de exibir notificações do sistema, que nesse caso exibi as nofiticações de "entrega realizada com sucesso no sistema!" qunado necessário.

                //exibir a mensagem de emtrega de atividade no sistema bem sucessedida.
                exibirNotificacoes();

                //limpar as notificações do sistema.
                limpaNotificacoes();

                ?>
                <!--definir o contador de horas aprovadas do aluno.-->

                <p>Horas aprovadas : <?php echo $total_horas_aprovadas . " " . "/" . " " . $total_curso ?></p>

                <!--definir a tabela com as informações das atividades complementares de curso que o aluno entregou no sistema.-->
                <table>
                    <thead>
                        <tr>
                            <th>Natureza</th>
                            <th>Descrição</th>
                            <th>Horas Realizadas</th>
                            <th>Horas aprovadas</th>
                            <th>observações</th>
                            <th>Situação</th>
                            <th colspan="3">Opções</th>
                        </tr>
                    </thead>
                    <tbody>

                        <!--definição da estrutura de repetição para poder fazer a exibição dos dados para o aluno.-->

                        <?php

                        // Definir a estrutura de repetição que irá mostrar na tela do aluno, todas as atividades que ele entregou no sistema.
                        while ($dados = mysqli_fetch_assoc($query)) {

                            //dentro da repetição verificamos se o status e a observação são diferentes das configurações padrões do sistema. Se isso for verdadeiro, significa que o coordenador de curso adcionou uma correção a entrega do certificado, diante disso imprimimos as informações de status, observações que o coordenador de curso adicionou e a carga horária que foi aprovada.
                            if ($dados['status'] != "Em análise" or $dados['observacoes'] != "Sem observações") {

                                //agora devemos verificar qual é o status da entrega para poder imprimir as informações com as configurações de cores certas.

                                if ($dados['status'] == "Deferido") {

                                    //imprimimos com a cor verde a linha da tabela.

                                    echo "<tr>";
                                    echo "<td>" . $dados['descricao'] . "</td>";
                                    echo "<td>" . $dados['titulo_certificado'] . "</td>";
                                    echo "<td>" . $dados['carga_horaria_certificado'] . "</td>";
                                    echo "<td>" . $dados['carga_horaria_aprovada'] . "</td>";
                                    echo "<td>" . $dados['observacoes'] . "</td>";
                                    echo "<td>" . $dados['status'] . "</td>";

                                    echo '<td> <a href="crudEntrega/formeditEntrega.php?id=' . $dados['id_entrega_atividade'] . '" class="btn-floating btn-small waves-effect waves-light red modal-trigger"><i class="material-icons ">create</i></a> </td>';

                                    echo '<td> <a href="#modal' . $dados['id_entrega_atividade'] . '" class="btn-floating btn-small waves-effect waves-light red modal-trigger"><i class="material-icons">delete</i></a> </td>';

                                    echo "</tr>";

                        ?>

                                    <!-- Modal Structure -->
                                    <div id="modal<?php echo $dados['id_entrega_atividade']; ?>" class="modal">
                                        <div class="modal-content">
                                            <h2> Atenção! </h2>
                                            <p>Você confirma a exclusão desta entrega : <?php echo $dados['titulo_certificado']; ?> ?</p>
                                        </div>

                                        <div class="modal-footer">
                                            <form action="crudEntrega/excluirEntrega.php" method="POST">
                                                <input type="hidden" name="id" value="<?php echo $dados['id_entrega_atividade']; ?>">

                                                <button type="submit" name="btn-deletar" class="modal-action modal-close waves-red btn red darken-1">
                                                    Excluir </button>

                                                <button type="button" name="btn-cancelar" class="modal-action modal-close  btn waves-light green">
                                                    Cancelar </button>
                                            </form>

                                        </div>
                                    </div>
                                <?php

                                } elseif ($dados['status'] == "Indeferido") {

                                    //imprimimos com a cor cermelha a linha da tabela.

                                    echo "<tr>";
                                    echo "<td>" . $dados['descricao'] . "</td>";
                                    echo "<td>" . $dados['titulo_certificado'] . "</td>";
                                    echo "<td>" . $dados['carga_horaria_certificado'] . "</td>";
                                    echo "<td>" . $dados['carga_horaria_aprovada'] . "</td>";
                                    echo "<td>" . $dados['observacoes'] . "</td>";
                                    echo "<td>" . $dados['status'] . "</td>";

                                    echo '<td> <a href="crudEntrega/formeditEntrega.php?id=' . $dados['id_entrega_atividade'] . '" class="btn-floating btn-small waves-effect waves-light red modal-trigger"><i class="material-icons ">create</i></a> </td>';

                                    echo '<td> <a href="#modal' . $dados['id_entrega_atividade'] . '" class="btn-floating btn-small waves-effect waves-light red modal-trigger"><i class="material-icons">delete</i></a> </td>';

                                    echo "</tr>";

                                ?>

                                    <!-- Modal Structure -->
                                    <div id="modal<?php echo $dados['id_entrega_atividade']; ?>" class="modal">
                                        <div class="modal-content">
                                            <h2> Atenção! </h2>
                                            <p>Você confirma a exclusão desta entrega : <?php echo $dados['titulo_certificado']; ?> ?</p>
                                        </div>

                                        <div class="modal-footer">
                                            <form action="crudEntrega/excluirEntrega.php" method="POST">
                                                <input type="hidden" name="id" value="<?php echo $dados['id_entrega_atividade']; ?>">

                                                <button type="submit" name="btn-deletar" class="modal-action modal-close waves-red btn red darken-1">
                                                    Excluir </button>

                                                <button type="button" name="btn-cancelar" class="modal-action modal-close  btn waves-light green">
                                                    Cancelar </button>
                                            </form>

                                        </div>
                                    </div>
                                <?php
                                }
                            } else {

                                //imprimimos com a cor laranja a linha da tabela.

                                echo "<tr>";
                                echo "<td>" . $dados['descricao'] . "</td>";
                                echo "<td>" . $dados['titulo_certificado'] . "</td>";
                                echo "<td>" . $dados['carga_horaria_certificado'] . "</td>";
                                echo "<td>" . $dados['carga_horaria_aprovada'] . "</td>";
                                echo "<td>" . $dados['observacoes'] . "</td>";
                                echo "<td>" . $dados['status'] . "</td>";

                                echo '<td> <a href="crudEntrega/formeditEntrega.php?id=' . $dados['id_entrega_atividade'] . '" class="btn-floating btn-small waves-effect waves-light red modal-trigger"><i class="material-icons ">create</i></a> </td>';

                                echo '<td> <a href="#modal' . $dados['id_entrega_atividade'] . '" class="btn-floating btn-small waves-effect waves-light red modal-trigger"><i class="material-icons">delete</i></a> </td>';

                                echo "</tr>";

                                ?>

                                <!-- Modal Structure -->
                                <div id="modal<?php echo $dados['id_entrega_atividade']; ?>" class="modal">
                                    <div class="modal-content">
                                        <h2> Atenção! </h2>
                                        <p>Você confirma a exclusão desta entrega : <?php echo $dados['titulo_certificado']; ?> ?</p>
                                    </div>

                                    <div class="modal-footer">
                                        <form action="crudEntrega/excluirEntrega.php" method="POST">
                                            <input type="hidden" name="id" value="<?php echo $dados['id_entrega_atividade']; ?>">

                                            <button type="submit" name="btn-deletar" class="modal-action modal-close waves-red btn red darken-1">
                                                Excluir </button>

                                            <button type="button" name="btn-cancelar" class="modal-action modal-close  btn waves-light green">
                                                Cancelar </button>
                                        </form>

                                    </div>
                                </div>
                        <?php
                            }
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