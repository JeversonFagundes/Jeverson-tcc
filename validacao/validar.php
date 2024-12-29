<?php

//buscar da url o id do aluno.
$id = $_GET['id'];

//conecctar com o banco de dados jeverson-tcc.
require_once "../conecta.php";

//incluir o arquivo de notificações do sistema. Dentro desse arquivo também inciamos a sessão (session_start()).
require_once "../boasPraticas/notificacoes.php";

//declarar a variavel de conexão com o banco de dados jeverson-tcc.
$mysql = conectar();

//declarar a pasta de destino dos arquivos.
$pastaDestino = "../certificados/";

//buscar pelos dados do aluno unindo com os dados da tabela entrega_atividade, que onde estão os dados da entrega das atividades que o aluno entregou no sistema.
$sql = "SELECT a.id_aluno, a.nome, a.matricula, a.email,

 ea.id_entrega_atividade, ea.status,

 ea.carga_horaria_certificado, ea.carga_horaria_aprovada, 

 ea.status, ea.certificado, ea.caminho, ea.titulo_certificado,

 ea.observacoes, ac.descricao,

 ac.natureza, c.carga_horaria

 FROM aluno a

INNER JOIN entrega_atividade ea 

ON a.id_aluno = $id AND ea.id_aluno = $id

INNER JOIN atividade_complementar ac

ON ea.id_atividade_complementar = ac.id_atividade_complementar

INNER JOIN curso c 

ON a.id_curso AND c.id_curso = " . $_SESSION['coordenador'][2] . "
";

//executar o comando sql ($sql).
$resultado = excutarSQL($mysql, $sql);

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
    <title>Visualização das atividades entregues por um aluno</title>

    <style>
        .relatorio {
            margin-bottom: 15px;
        }

        .total {
            font-size: 20px;
        }

        .espacamento {
            margin-right: 30px;
        }

        .span {
            margin-bottom: 20px;
        }

        .myModal {
            width: 75%;
            /* Ajuste a largura conforme necessário */
            height: 55%;
            /* Ajuste a altura conforme necessário */
        }

        p,
        a,
        h2,
        h1,
        span {
            color: black;
        }

        .contagem {
            font-size: 20px;
        }

        .teste {
            justify-content: center;
            text-align: center;
        }
    </style>

</head>

<body>

    <!--incluir a navbar.-->
    <?php
    require_once "../boasPraticas/headerNav.php";
    ?>

    <main class="container">

        <h2 class="center-align">Atividades entregues</h2><br>

        <?php

        //chamar a função que exibe a notificação
        exibirNotificacoes();

        //chamar a função que limpa a notificação da sessão.
        limpaNotificacoes();

        //definir o array associativo com todos os valores vindos do banco de dados.
        $entrega = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

        //contar o total de horas deferidas que o aluno tem.
        $sql_total_horas = "SELECT SUM(ea.carga_horaria_aprovada ) FROM entrega_atividade ea WHERE ea.status = 'Deferido' AND ea.id_aluno = $id";

        //executar o comando de comtagem do total de horas aprovadas que o aluno tem
        $execucao_total_horas = excutarSQL($mysql, $sql_total_horas);

        //criar um array associativo com os valores da contagem total de horas aprovadas.
        $horas_totais_aprovadas = mysqli_fetch_assoc($execucao_total_horas);

        //verificar se a contagem total de horas totais aprovadas é igual a 0.
        if ($horas_totais_aprovadas['SUM(ea.carga_horaria_aprovada )'] == 0) {

            $quantidade_total_horas = 0;
        } else {

            $quantidade_total_horas = $horas_totais_aprovadas['SUM(ea.carga_horaria_aprovada )'];
        }

        $imprimido = false;

        foreach ($entrega as $contagem_total) {
            if (!$imprimido) {

        ?>

                <p class="contagem"><strong>Total de horas aprovadas : <?php echo $quantidade_total_horas . " " . "/" . " " . $contagem_total['carga_horaria'] ?></strong></p>
                <?php
                $imprimido = true;
            }
        }

        //se o total de horas aprovadas for maior o igual ao total de horas que o curso pode aprovar, então quer dizer que o aluno completou todas as suas horas complementares de curso.

        $imprimido_certificado = false;

        foreach ($entrega as $certificado) {
            if ($quantidade_total_horas >= $certificado['carga_horaria']) {
                if (!$imprimido_certificado) {
                ?>
                    <a href="relatorio.php?id=<?php echo $id; ?>"
                        class="btn waves-effect waves-light #1565c0 blue darken-3 lighten-3 relatorio">
                        <i class="material-icons right">assignment</i>Gerar relatório
                    </a>
        <?php

                    $sql_atualizacao = "UPDATE aluno a SET a.conclusao_horas = 1 WHERE id_aluno = $id";

                    $execucao = excutarSQL($mysql, $sql_atualizacao);

                    $imprimido_certificado = true;
                }
            }
        }
        ?>

        <table>
            <thead>
                <tr>
                    <th>Título da entrega</th>
                    <th>Situação</th>
                    <th class="teste">Carga horária entregue</th>
                    <th class="teste">Carga horária deferida</th>
                    <th colspan="1">Avaliar</th>
                </tr>
            </thead>

            <tbody>

                <?php
                // Definir a estrutura de repetição que irá mostrar os dados na tela do coordenador de curso.
                foreach ($entrega as $informacoes_entrega) {

                    if ($informacoes_entrega['status'] == "Deferido") {

                        //imprimimos com a cor verde a linha da tabela.

                        echo "<tr class=\"#a5d6a7 green lighten-3\">";
                        echo "<td>" . $informacoes_entrega['titulo_certificado'] . "</td>";
                        echo "<td>" . $informacoes_entrega['status'] . "</td>";
                        echo "<td class=\"teste\">" . $informacoes_entrega['carga_horaria_certificado'] . "</td>";
                        echo "<td class=\"teste\">" . $informacoes_entrega['carga_horaria_aprovada'] . "</td>";

                        echo '<td> <a href="#modal' . $informacoes_entrega['id_entrega_atividade'] . '" class="btn-floating btn-small waves-effect waves-light #1565c0 blue darken-3 modal-trigger"><i class="material-icons">rate_review</i></a> </td>';

                        echo "</tr>";

                ?>

                        <!-- Modal Structure -->
                        <div id="modal<?php echo $informacoes_entrega['id_entrega_atividade']; ?>" class="modal myModal">

                            <div class="modal-footer">
                                <form action="mudarSituacao.php" method="POST">

                                    <!--dados invisiveis.-->
                                    <input type="hidden" name="id_atividade" value="<?php echo $informacoes_entrega['id_entrega_atividade']; ?>">
                                    <input type="hidden" name="aluno" value="<?php echo $informacoes_entrega['id_aluno']; ?>">
                                    <input type="hidden" name="nome" value="<?php echo $informacoes_entrega['nome']; ?>">
                                    <input type="hidden" name="matricula" value="<?php echo $informacoes_entrega['matricula']; ?>">
                                    <input type="hidden" name="email" value="<?php echo $informacoes_entrega['email']; ?>">
                                    <input type="hidden" name="certificado" value="<?php echo $informacoes_entrega['titulo_certificado']; ?>">
                                    <input type="hidden" name="descricao" value="<?php echo $informacoes_entrega['descricao']; ?>">

                                    <div class="input-field col s12">
                                        <textarea id="textarea2" disabled class="materialize-textarea"><?php echo $informacoes_entrega['descricao'] ?></textarea>
                                        <label for="textarea2">Descrição da natureza : </label>
                                    </div>

                                    <div class="input-field col s12">
                                        <input placeholder="Carga horária desenvolvida" id="cargahorariadesenvolvida" value="<?php echo $informacoes_entrega['carga_horaria_certificado'] ?>" type="text" class="validate" disabled>
                                        <label for="cargahorariadesenvolvida">Carga horária desenvolvida : </label>
                                    </div>

                                    <div class="input-field col s12">
                                        <input placeholder="Digite a carga que se deseja deferir" id="argaDef" name="cargaDefe" value="<?php echo $informacoes_entrega['carga_horaria_aprovada'] ?>" type="text" class="validate" pattern="^\d{1,2}$" required>
                                        <label for="cargDef">Carga horária deferida : </label>
                                        <span class="helper-text" data-error="Você deve digitar a carga horária que se deseja deferir"></span>
                                    </div>

                                    <div class="input-field col s12">
                                        <textarea id="textarea1" name="observacoes" class="materialize-textarea"><?php echo $informacoes_entrega['observacoes'] ?></textarea>
                                        <label for="textarea1">Adicionar observações : </label>
                                    </div>

                                    <button type="submit" name="deferir" value="Deferir" class="modal-action modal-close waves-red btn green darken-1">
                                        Deferir </button>

                                    <button type="submit" name="indeferir" value="Indeferir" class="modal-action modal-close  btn waves-light red">
                                        Indeferir </button>

                                </form>
                            </div>

                        </div>
                        <?php
                    } else {

                        if ($informacoes_entrega['status'] == "Indeferido") {

                            //imprimimos com a cor vermelha a linha da tabela.

                            echo "<tr class=\"#ef9a9a red lighten-3\">";
                            echo "<td>" . $informacoes_entrega['titulo_certificado'] . "</td>";
                            echo "<td>" . $informacoes_entrega['status'] . "</td>";
                            echo "<td class=\"teste\">" . $informacoes_entrega['carga_horaria_certificado'] . "</td>";
                            echo "<td class=\"teste\">" . $informacoes_entrega['carga_horaria_aprovada'] . "</td>";

                            echo '<td> <a href="#modal' . $informacoes_entrega['id_entrega_atividade'] . '" class="btn-floating btn-small waves-effect waves-light #1565c0 blue darken-3 modal-trigger"><i class="material-icons">rate_review</i></a> </td>';

                            echo "</tr>";

                        ?>

                            <!-- Modal Structure -->
                            <div id="modal<?php echo $informacoes_entrega['id_entrega_atividade']; ?>" class="modal myModal">

                                <div class="modal-footer">
                                    <form action="mudarSituacao.php" method="POST">

                                        <!--dados invisiveis.-->
                                        <input type="hidden" name="id_atividade" value="<?php echo $informacoes_entrega['id_entrega_atividade']; ?>">
                                        <input type="hidden" name="aluno" value="<?php echo $informacoes_entrega['id_aluno']; ?>">
                                        <input type="hidden" name="nome" value="<?php echo $informacoes_entrega['nome']; ?>">
                                        <input type="hidden" name="matricula" value="<?php echo $informacoes_entrega['matricula']; ?>">
                                        <input type="hidden" name="email" value="<?php echo $informacoes_entrega['email']; ?>">
                                        <input type="hidden" name="certificado" value="<?php echo $informacoes_entrega['titulo_certificado']; ?>">
                                        <input type="hidden" name="descricao" value="<?php echo $informacoes_entrega['descricao']; ?>">

                                        <div class="input-field col s12">
                                            <textarea id="textarea2" disabled class="materialize-textarea"><?php echo $informacoes_entrega['descricao'] ?></textarea>
                                            <label for="textarea2">Descrição da natureza : </label>
                                        </div>

                                        <div class="input-field col s12">
                                            <input placeholder="Carga horária desenvolvida" id="cargahorariadesenvolvida" value="<?php echo $informacoes_entrega['carga_horaria_certificado'] ?>" type="text" class="validate" disabled>
                                            <label for="cargahorariadesenvolvida">Carga horária desenvolvida : </label>
                                        </div>

                                        <div class="input-field col s12">
                                            <input placeholder="Digite a carga que se deseja deferir" id="argaDef" name="cargaDefe" value="<?php echo $informacoes_entrega['carga_horaria_aprovada'] ?>" type="text" class="validate" pattern="^\d{1,2}$" required>
                                            <label for="cargDef">Carga horária deferida : </label>
                                            <span class="helper-text" data-error="Você deve digitar a carga horária que se deseja deferir"></span>
                                        </div>

                                        <div class="input-field col s12">
                                            <textarea id="textarea1" name="observacoes" class="materialize-textarea"><?php echo $informacoes_entrega['observacoes'] ?></textarea>
                                            <label for="textarea1">Adicionar observações : </label>
                                        </div>

                                        <button type="submit" name="deferir" value="Deferir" class="modal-action modal-close waves-red btn green darken-1">
                                            Deferir </button>

                                        <button type="submit" name="indeferir" value="Indeferir" class="modal-action modal-close  btn waves-light red">
                                            Indeferir </button>

                                    </form>
                                </div>

                            </div>
                        <?php
                        } else {

                            //imprimimos com a cor laranja a linha da tabela.

                            echo "<tr class=\"#ffcc80 orange lighten-3\">";
                            echo "<td>" . $informacoes_entrega['titulo_certificado'] . "</td>";
                            echo "<td>" . $informacoes_entrega['status'] . "</td>";
                            echo "<td class=\"teste\">" . $informacoes_entrega['carga_horaria_certificado'] . "</td>";
                            echo "<td class=\"teste\">" . $informacoes_entrega['carga_horaria_aprovada'] . "</td>";

                            echo '<td> <a href="#modal' . $informacoes_entrega['id_entrega_atividade'] . '" class="btn-floating btn-small waves-effect waves-light #1565c0 blue darken-3 modal-trigger"><i class="material-icons">rate_review</i></a> </td>';

                            echo "</tr>";

                        ?>

                            <!-- Modal Structure -->
                            <div id="modal<?php echo $informacoes_entrega['id_entrega_atividade']; ?>" class="modal myModal">

                                <div class="modal-footer">
                                    <form action="mudarSituacao.php" method="POST">

                                        <!--dados invisiveis.-->
                                        <input type="hidden" name="id_atividade" value="<?php echo $informacoes_entrega['id_entrega_atividade']; ?>">
                                        <input type="hidden" name="aluno" value="<?php echo $informacoes_entrega['id_aluno']; ?>">
                                        <input type="hidden" name="nome" value="<?php echo $informacoes_entrega['nome']; ?>">
                                        <input type="hidden" name="matricula" value="<?php echo $informacoes_entrega['matricula']; ?>">
                                        <input type="hidden" name="email" value="<?php echo $informacoes_entrega['email']; ?>">
                                        <input type="hidden" name="certificado" value="<?php echo $informacoes_entrega['titulo_certificado']; ?>">
                                        <input type="hidden" name="descricao" value="<?php echo $informacoes_entrega['descricao']; ?>">

                                        <div class="input-field col s12">
                                            <textarea id="textarea2" disabled class="materialize-textarea"><?php echo $informacoes_entrega['descricao'] ?></textarea>
                                            <label for="textarea2">Descrição da natureza : </label>
                                        </div>

                                        <div class="input-field col s12">
                                            <input placeholder="Carga horária desenvolvida" id="cargahorariadesenvolvida" value="<?php echo $informacoes_entrega['carga_horaria_certificado'] ?>" type="text" class="validate" disabled>
                                            <label for="cargahorariadesenvolvida">Carga horária desenvolvida : </label>
                                        </div>

                                        <div class="input-field col s12">
                                            <input placeholder="Digite a carga que se deseja deferir" id="argaDef" name="cargaDefe" value="<?php echo $informacoes_entrega['carga_horaria_aprovada'] ?>" type="text" class="validate" pattern="^\d{1,2}$" required>
                                            <label for="cargDef">Carga horária deferida : </label>
                                            <span class="helper-text" data-error="Você deve digitar a carga horária que se deseja deferir"></span>
                                        </div>

                                        <div class="input-field col s12">
                                            <textarea id="textarea1" name="observacoes" class="materialize-textarea"><?php echo $informacoes_entrega['observacoes'] ?></textarea>
                                            <label for="textarea1">Adicionar observações : </label>
                                        </div>

                                        <button type="submit" name="deferir" value="Deferir" class="modal-action modal-close waves-red btn green darken-1">
                                            Deferir </button>

                                        <button type="submit" name="indeferir" value="Indeferir" class="modal-action modal-close  btn waves-light red">
                                            Indeferir </button>

                                    </form>
                                </div>

                            </div>
                <?php
                        }
                    }
                }
                ?>

            </tbody>
        </table>

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

        document.addEventListener('DOMContentLoaded', function() {
            const materialboxElems = document.querySelectorAll('.materialboxed');
            M.Materialbox.init(materialboxElems);
        });

        $('#textarea1').val('New Text');
        M.textareaAutoResize($('#textarea1'));

        $('#textarea2').val('New Text');
        M.textareaAutoResize($('#textarea2'));
    </script>

</body>

</html>