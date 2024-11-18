<?php

//INICIALALUNO.PHP

//conectar com o banco de dados jeverson-tcc
require_once "conecta.php";

//incluir o arquivo de notificações do sistema.
require_once "boasPraticas/notificacoes.php";

//criar a variavél de conexão com o banco de dados jeverson-tcc. Esta variavél vem do arquivo conecta.php.
$mysql = conectar();

//pasta de destino para onde vão os certificados.
$pasta = "certificados/";

//fazer uma verificação para definir a variavél que irá receber o total de horas do curso. Por exemplo "a carga horaria obrigatório do curso de informática é 60 horas".

if ($_SESSION['aluno'][2] == 9) {

    $total_curso = 60;
} else {

    if ($_SESSION['aluno'][2] == 11 or $_SESSION['aluno'][2] == 13) {

        $total_curso = 40;
    } else {

        if ($_SESSION['aluno'][2] == 12) {

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
        .analizando {
            border: 2px solid orange;
        }

        .deferido {
            border: 2px solid green;
        }

        .indeferido {
            border: 2px solid red;
        }

        .espacamento {
            margin-right: 10px;
        }
        .especamentoh2{
            margin-left: 20px;
        }
    </style>
</head>

<body class="#f5f5f5 grey lighten-4">

    <!--Para que não seja necessário criar toda vez um header com uma nav em todas as telas dos usuários, então aqui incluimos a pasta onde esta o arquivo onde está criado o header e o nav.-->
    <?php require_once "boasPraticas/headerNav.php"; ?>

    <main>

        <!--Sessão com o valor do nome aluno.-->
        <h2 class="especamentoh2"><?php echo $_SESSION['aluno'][0]; ?></h2>

        <hr>

        <h1 class="center-align">Minhas atividade complementares de curso</h1>

        <?php

        //listar todas as atividades cadastradas pelo aluno que está logado no sistema. Para isso buscamos na tabela entrega_atividade unindo ela com a tabela atividade_complementar e aluno, para que seja possivél exibir as atividades cadastradas pelo aluno junto a com as informações da atividades complementar de curso que essa entrega está relacionada, como natureza, descricão etc.
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
        ea.observacoes
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

            <div class="container">
                <p class="center-align">Você não entregou nenhuma atividade complementar no sistema ainda!</p><br>


                <a href='crudEntrega/formcadEntrega.php' class="brown lighten-3 waves-effect waves-light btn"><i class="material-icons right">add</i>Inserir</a>

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

        ?>

            <div class="container">

                <?php
                echo "<a href='crudEntrega/formcadEntrega.php' class=\"brown lighten-3 waves-effect waves-light btn\"><i class=\"material-icons right\">add</i>Inserir</a> <br><br>";

                //definir a variavél que irá receber a soma total de horas das atividades aprovadas pelo coordenador de curso.
                $total = 0;

                //definir a estrutura de repetição que será responsável por pegar o valor das horas do banco de dados jeverson_tcc e soma-las.
                while ($entrega_atividades = mysqli_fetch_assoc($query)) {

                    //aqui  ocorre a soma das horas que foram aprovadas pelo coordenador de curso.
                    $total = $total +  $entrega_atividades['carga_horaria_aprovada'];

                    //aqui eu faço uma verificação de que o aluno já concluiu as suas horas complementares de curso aprovadas
                    if ($total > $total_curso) {
                        echo "Você completou as suas horas complementares de curso! <br>";
                    }
                }
                echo "Total de horas aprovadas: " . $total . " " . "/" . " " . $total_curso . '<br>'; // Imprimir o total após o while

                //para que o proximo while funcione corretamente, pricisamos redefinir o ponteiro de dados no resultado de uma consulta para uma linha específica
                mysqli_data_seek($query, 0); // Reseta o ponteiro de dados do query

                //mysqli_data_seek(); redefine o ponteiro de dados no resultado de uma consulta para uma linha específica

                //bem acima das atividades que foram entregues no sistema, fica a mecanica de exibir notificações do sistema, que nesse caso exibi as nofiticações de "entrega realizada com sucesso no sistema!" qunado necessário.

                //exibir a mensagem de emtrega de atividade no sistema bem sucessedida.
                exibirNotificacoes();

                //limpar as notificações do sistema.
                limpaNotificacoes();

                //definir a estrutura de repetição que irá mostrar na tela do aluno, todas as atividades que ele entregou no sistema.
                while ($dados = mysqli_fetch_assoc($query)) {

                    //dentro da repetição verificamos se o status e a observação são diferentes das configurações padrões do sistema. Se isso for verdadeiro, significa que o coordenador de curso adcionou uma correção a entrega do certificado, diante disso imprimimos as informações de status, observações que o coordenador de curso adicionou e a carga horária que foi aprovada.
                    if ($dados['status'] != "Em análise" or $dados['observacoes'] != "Sem observações") {

                        //agora devemos verificar qual é o status da entrega para poder imprimir as informações com as configurações de cores certas.
                        if ($dados['status'] == "Deferido") {

                ?>
                            <!--quer dizer que o cordenador de curso aceitou a entrega do aluno, por esse motivo imprimimos o card com a borda verde-->
                            <div class="card deferido">
                                <div class="card-content">
                                    <span class="card-title activator grey-text text-darken-4">Titulo : <?php echo $dados['titulo_certificado'] ?><i class="material-icons right">more_vert</i></span><br>

                                    <p>Situação : <?php echo $dados['status'] ?> </p><br>

                                    <p>Certificado : <a href="<?php echo $pasta . $dados['caminho'] ?>"><?php echo $dados['certificado'] ?></a> </p><br>

                                    <p>Carga horária aprovada: <?php echo $dados['carga_horaria_aprovada']; ?></p><br>

                                    <p>Observações : <?php echo $dados['observacoes']; ?></p><br>

                                    <a href="crudEntrega/formeditEntrega.php?id=<?php echo $dados['id_entrega_atividade']; ?>" class="btn-floating btn-small waves-effect waves-light#00c853 green accent-4 lighten-3 modal-trigger espacamento"><i class="material-icons">create</i></a>

                                    <a href="#modal<?php echo $dados['id_entrega_atividade']; ?>" class="btn-floating btn-small waves-effect waves-light red modal-trigger"><i class="material-icons">delete</i></a>

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

                                </div>
                                <div class="card-reveal">
                                    <span class="card-title grey-text text-darken-4"><?php echo $dados['titulo_certificado'] ?><i class="material-icons right">close</i></span>

                                    <p>Natureza : <?php echo $dados['natureza']; ?></p>
                                    <p>Descrição da natureza : <?php echo $dados['descricao']; ?></p>
                                    <p>Carga horária do certificado: <?php echo $dados['carga_horaria_certificado']; ?></p>

                                </div>
                            </div>
                            <?php
                        } else {

                            if ($dados['status'] == "Indeferido") {

                            ?>
                                <!--quer dizer que o cordenador de curso não aceitou a entrega do aluno, por esse motivo imprimimos o card com a borda vermelha-->
                                <div class="card indeferido">
                                    <div class="card-content">
                                        <span class="card-title activator grey-text text-darken-4">Titulo : <?php echo $dados['titulo_certificado'] ?><i class="material-icons right">more_vert</i></span><br>

                                        <p>Situação : <?php echo $dados['status'] ?> </p><br>

                                        <p>Certificado : <a href="<?php echo $pasta . $dados['caminho'] ?>"><?php echo $dados['certificado'] ?></a> </p><br>

                                        <p>Carga horária aprovada: <?php echo $dados['carga_horaria_aprovada']; ?></p><br>

                                        <p>Observações : <?php echo $dados['observacoes']; ?></p><br>

                                        <a href="crudEntrega/formeditEntrega.php?id=<?php echo $dados['id_entrega_atividade']; ?>" class="btn-floating btn-small waves-effect waves-light#00c853 green accent-4 lighten-3 modal-trigger espacamento"><i class="material-icons">create</i></a>

                                        <a href="#modal<?php echo $dados['id_entrega_atividade']; ?>" class="btn-floating btn-small waves-effect waves-light red modal-trigger"><i class="material-icons">delete</i></a>

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

                                    </div>
                                    <div class="card-reveal">
                                        <span class="card-title grey-text text-darken-4"><?php echo $dados['titulo_certificado'] ?><i class="material-icons right">close</i></span>

                                        <p>Natureza : <?php echo $dados['natureza']; ?></p>
                                        <p>Descrição da natureza : <?php echo $dados['descricao']; ?></p>
                                        <p>Carga horária do certificado: <?php echo $dados['carga_horaria_certificado']; ?></p>

                                    </div>
                                </div>
                        <?php
                            }
                        }
                    } else {

                        ?>
                        <!--quer dizer que o cordenador de curso não realizou nenhuma correção na entrega do aluno, por isso a entrega ainda está em analize, por esse motivo imprimimos o card com a borda laranja-->
                        <div class="card analizando">
                            <div class="card-content">
                                <span class="card-title activator grey-text text-darken-4">Titulo : <?php echo $dados['titulo_certificado'] ?><i class="material-icons right">more_vert</i></span><br>

                                <p>Situação : <?php echo $dados['status'] ?> </p><br>

                                <p>Certificado : <a href="<?php echo $pasta . $dados['caminho'] ?>"><?php echo $dados['certificado'] ?></a> </p><br>

                                <p>Carga horária aprovada: <?php echo $dados['carga_horaria_aprovada']; ?></p><br>

                                <a href="crudEntrega/formeditEntrega.php?id=<?php echo $dados['id_entrega_atividade']; ?>" class="btn-floating btn-small waves-effect waves-light#00c853 green accent-4 lighten-3 modal-trigger espacamento"><i class="material-icons">create</i></a>

                                <a href="#modal<?php echo $dados['id_entrega_atividade']; ?>" class="btn-floating btn-small waves-effect waves-light red modal-trigger"><i class="material-icons">delete</i></a>

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

                            </div>
                            <div class="card-reveal">
                                <span class="card-title grey-text text-darken-4"><?php echo $dados['titulo_certificado'] ?><i class="material-icons right">close</i></span>

                                <p>Natureza : <?php echo $dados['natureza']; ?></p>
                                <p>Descrição da natureza : <?php echo $dados['descricao']; ?></p>
                                <p>Carga horária do certificado: <?php echo $dados['carga_horaria_certificado']; ?></p>
                                <p>Observações : <?php echo $dados['observacoes'] ?>

                            </div>
                        </div>
            <?php
                    }
                }


                /*

            //definir a estrutura de repetição que irá mostrar na tela do aluno, todas as atividades que ele entregou no sistema.
            while ($dados = mysqli_fetch_assoc($query)) {

                //dentro da repetição verificamos se o status e a observação são diferentes das configurações padrões do sistema. Se isso for verdadeiro, significa que o coordenador de curso adcionou uma correção a entrega do certificado, diante disso imprimimos as informações de status, observações que o coordenador de curso adicionou e a carga horária que foi aprovada.
                if ($dados['status'] != "Em análise" or $dados['observacoes'] != "Sem observações") {

                    //agora devemos verificar qual é o status da entrega para poder imprimir as informações com as configurações de cores certas.
                    if ($dados['status'] == "Deferido") {
                    } else {

                        if ($dados['status'] == "Indeferido") {
                        }
                    }
                } else {
                }
            }
            
            */
            }
            ?>
            </div>
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