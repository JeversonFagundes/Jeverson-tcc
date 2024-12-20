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
    <title>Visualização das atividade entregues por um aluno</title>

<style>

.relatorio{
    margin-bottom: 15px;
}
.total{
    font-size: 20px;
}
</style>

</head>

<body>

    <!--incluir a navbar.-->
    <?php
    require_once "../boasPraticas/headerNav.php";
    ?>

    <main class="container">

        <h2 class="center-align">Tela de validação da atividade entregue</h3><br>

            <?php

            //chamar a função que exibe a notificação
            exibirNotificacoes();

            //chamar a função que limpa a notificação da sessão.
            limpaNotificacoes();

            //definir o array associativo com os valores vindos do banco de dados.
            $entrega = mysqli_fetch_assoc($resultado);

            $sql_total_horas = "SELECT SUM(ea.carga_horaria_aprovada) FROM entrega_atividade ea WHERE ea.id_aluno = $id AND ea.status = 'Deferido'";

            $execucao_total_horas = excutarSQL($mysql, $sql_total_horas);

            //definir a variável que irá armazenar o total de horas aprovadas do aluno.
            $total_horas_aprovadas = mysqli_fetch_assoc($execucao_total_horas);

            mysqli_data_seek($resultado, 0);

            ?>

            <p class="total" >Total de horas aprovadas : <strong> <?php echo $total_horas_aprovadas['SUM(ea.carga_horaria_aprovada)'] . " " . "/" . " " . $entrega['carga_horaria'] ?></strong></p>

            <?php

            //se o total de horas aprovadas que o aluno tem, for maior ou igual a quantidade de horas o curso disponibiliza
            if ($total_horas_aprovadas['SUM(ea.carga_horaria_aprovada)'] >= $entrega['carga_horaria']) {

                //disponibilizamos a funcionalidade de imprimir relatório, usando para isso um link
            ?>

                <a href='relatorio.php?id=<?php echo $entrega['id_aluno']; ?>' class="#1565c0 blue darken-3 lighten-3 waves-effect waves-light btn relatorio ">
                    <i class="material-icons right">ssignment</i>Gerar relatório
                </a>
            <?php

            }
            ?>

            <a href='../relatorio.php?id=<?php echo $entrega['id_aluno']; ?>' class="#1565c0 blue darken-3 lighten-3 waves-effect waves-light btn relatorio">
                <i class="material-icons right"> assignment</i>Gerar relatório
            </a>

            <?php

            //daclarar a variavél dados ($dados) que receberá os valores do array associativo que foi gerado na busca $sql. Esses dados serão repetidos enquanto houver dados.
            while ($dados = mysqli_fetch_assoc($resultado)) {

            ?>

                <form action="mudarSituacao.php" method="post">

                    <div class="card-panel">

                        <div class="row">

                            <!--dados invisiveis.-->
                            <input type="hidden" name="id_atividade" value="<?php echo $dados['id_entrega_atividade']; ?>">
                            <input type="hidden" name="aluno" value="<?php echo $dados['id_aluno']; ?>">
                            <input type="hidden" name="nome" value="<?php echo $dados['nome']; ?>">
                            <input type="hidden" name="matricula" value="<?php echo $dados['matricula']; ?>">
                            <input type="hidden" name="email" value="<?php echo $dados['email']; ?>">
                            <input type="hidden" name="certificado" value="<?php echo $dados['titulo_certificado']; ?>">
                            <input type="hidden" name="descricao" value="<?php echo $dados['descricao']; ?>">

                            <div class="input-field col s12">
                                <input placeholder="Situaçao" id="situacao" type="text" value="<?php echo $dados['status'] ?>" disabled>
                                <label for="situacao">Situação : </label>
                            </div>

                            <div class="input-field col s12">
                                <input placeholder="Natureza" id="natureza" type="text" value="<?php echo $dados['natureza'] ?>" disabled>
                                <label for="natureza">Natureza da entrega : </label>
                            </div>

                            <div class="input-field col s12">
                                <textarea id="textarea2" disabled class="materialize-textarea"><?php echo $dados['descricao'] ?></textarea>
                                <label for="textarea2">Descrição da natureza : </label>
                            </div>

                            <div class="input-field col s12">
                                <input placeholder="Descrição da atividade desenvolvida" id="descricao" value="<?php echo $dados['titulo_certificado'] ?>" type="text" disabled>
                                <label for="descricao">Descrição da atividade desenvolvida : </label>
                            </div>

                            <div class="input-field col s12">
                                <input placeholder="Carga horária desenvolvida" id="cargahorariadesenvolvida" value="<?php echo $dados['carga_horaria_certificado'] ?>" type="text" class="validate" disabled>
                                <label for="cargahorariadesenvolvida">Carga horária desenvolvida : </label>
                            </div>

                            <!--aqui passamos um link para que o aluno possa var o arquivo que ele cadastrou no sistema.-->
                            <p>Visualizar atividade entregue : <a class="waves-effect waves-light btn" href=" <?php echo $pastaDestino . $dados['caminho']; ?>"><?php echo $dados['titulo_certificado']; ?></a>
                            </p>

                            <div class="input-field col s12">
                                <input placeholder="Digite a carga que se deseja deferir" id="argaDef" name="cargaDefe" value="<?php echo $dados['carga_horaria_aprovada'] ?>" type="text" class="validate" pattern="^\d{1,2}$" required>
                                <label for="cargDef">Carga horária deferida : </label>
                                <span class="helper-text" data-error="Você deve digitar a carga horária que se deseja deferir"></span>
                            </div>

                            <div class="input-field col s12">
                                <textarea id="textarea1" name="observacoes" class="materialize-textarea"><?php echo $dados['observacoes'] ?></textarea>
                                <label for="textarea1">Adicionar observações : </label>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col s12">
                                <p class="center-align">
                                    <button class="btn waves-effect waves-light #2e7d32 green darken-3 lighten-3" type="submit" name="deferir" value="Deferir">Deferir
                                        <i class="material-icons right">thumb_up</i> </button>
                                </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col s12">
                                <p class="center-align">
                                    <button class="btn waves-effect waves-light #e64a19 deep-orange darken-2 lighten-3" type="submit" name="indeferir" value="Indeferir">Indeferir
                                        <i class="material-icons right">thumb_down</i> </button>
                                </p>
                            </div>
                        </div>

                    </div>

                </form>

            <?php
            }
            ?>

    </main>

    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="../materialize/js/materialize.min.js"></script>
    <script>
        $('#textarea1').val('New Text');
        M.textareaAutoResize($('#textarea1'));

        $('#textarea2').val('New Text');
        M.textareaAutoResize($('#textarea2'));
    </script>

</body>

</html>