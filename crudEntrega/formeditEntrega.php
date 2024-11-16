<?php

//FORMEDITENTREGA.PHP

//conectar com o banco de dados jeverson-tcc.
require_once "../conecta.php";

//incluir o arquivo de notificações do sistema.
require_once "../boasPraticas/notificacoes.php";

//incluir o headerNav
require_once "../boasPraticas/headerNav.php";

//declarar a variavel de conexão com o banco de dados jeverson-tcc.
$mysql = conectar();

//declarar a pasta de destino dos arquivos.
$pasta = "../certificados/";

//atribuir a variavél sql ($sql) a busca por todas as atividades complementares de curso cadastradas no sistema que são relacionadas ao curso do aluno que esta logado no sistema no momento.
$sql = "SELECT id_atividade_complementar, natureza, descricao, carga_horaria_maxima FROM atividade_complementar WHERE id_curso = " . $_SESSION['aluno'][2];

//excutar o comando sql ($sql).
$resultado = excutarSQL($mysql, $sql);

//atribuir a variavél atividades_comlementares ($atividades_comlementares) o array associativo com todos os valores da busca $sql.
$atividades_complementares = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

//receber o id da atividade entregue, que se deseja alterar.
$id = $_GET['id'];

//selecionar os dados da tabela de entrega de atividades.
$sql2 = "SELECT * FROM entrega_atividade WHERE id_entrega_atividade = $id";

//excutar o comando sql2 acima.
$resultado2 = excutarSQL($mysql, $sql2);

//gerar o vetor com os resultados.
$entrega = mysqli_fetch_assoc($resultado2);

/**/

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
    <title>Formulário de alteração de atividade complementar</title>

</head>

<body>

    <h1 class="center-align">Formulário de alteração da sua atividade complementar entregue!</h1>

    <h3 class="center-align">Tabela de atividades complementares.</h3>

    <main class="container">

        <?php

        //chamar as funções reerentes as notificações do sistema.

        //exibe as notificações do sistema.
        exibirNotificacoes();

        //limpa as nnotificações do sistema.
        limpaNotificacoes();

        ?>
        <div class="card-panel">

            <table class="highlight responsive-table">
                <thead>
                    <tr>
                        <th>Natureza</th>
                        <th>Descrição</th>
                        <th>Carga Horária Máxima</th>
                    </tr>
                </thead>

                <tbody>

                    <?php

                    //percorre o vetor criado [$atividades_complementares].
                    foreach ($atividades_complementares as $atividade_complementar) {

                        echo '<tr>';

                        echo '<td>' . $atividade_complementar['natureza'] . '</td>';

                        echo '<td>' . $atividade_complementar['descricao'] . '</td>';

                        echo '<td>' . $atividade_complementar['carga_horaria_maxima'] . '</td>';

                        echo '</tr>';
                    }

                    ?>
                </tbody>
            </table>

            <br>

            <form action="editarEntrega.php" method="post" enctype="multipart/form-data">

                <!--Abrir um campo select para a selção dos itens.-->
                <label>Escolha a natureza do certificado</label>
                <select class="browser-default" id="select" required name="atividade_complementar">

                    <?php

                    //percorre o vetor de atividades complementares de curso
                    foreach ($atividades_complementares as $atividade_complementar) {

                    ?>
                        <!--declarar as opções desse campo de seleção.-->
                        <option <?php

                                //aqui dentro do option fazemos a verificação de que, se o valor da variavél $entrega['id_atividade_complementar'] é igual ao da variavél $atividade_complementar['id_atividade_complementar']. Se for igual passamos o comando selected e no caso sempre vai ser atendida essa condição, porque estamos alterando uma atividade que está cadastrada no banco de dados.
                                if ($entrega['id_atividade_complementar'] == $atividade_complementar['id_atividade_complementar']) {

                                    echo "selected";
                                }
                                ?> value=" <?php echo $atividade_complementar['id_atividade_complementar']; ?>">

                            <?php echo $atividade_complementar['natureza']; ?>

                        </option>

                    <?php
                    }

                    ?>
                </select>
                <br>

                <div class="input-field col s12">
                    <!--<i class="material-icons prefix">person_outline</i>-->
                    <input placeholder="Digite o titulo do seu certificado" id="titulo" name="titulo" type="text" class="validate" pattern="^[^']+$" required value="<?php echo $entrega['titulo_certificado']; ?>">
                    <label for="titulo">Titulo certificado</label>
                    <span class="helper-text" data-error="Você deve preenchar esse campo corretamente, não se deve usar aspas simples"></span>
                </div>

                <div class="input-field col s12">
                    <!--<i class="material-icons prefix">person_outline</i>-->
                    <input placeholder="Digite a carga horária do seu certificado" id="carga" name="carga" type="text" class="validate" pattern="^\d{1,2}$" required value="<?php echo $entrega['carga_horaria_certificado']; ?>">
                    <label for="tcarga">Carga horaria do certificado</label>
                    <span class="helper-text" data-error="Este campo deve ser preenchido com no máximo dois digitos numericos"></span>
                </div>

                <input type="hidden" name="id" value=" <?php echo $entrega['id_entrega_atividade']; ?>">

                <input type="hidden" name="caminho" value="<?php echo $entrega['caminho']; ?>">

                <div class="file-field input-field">
                    <div class="btn">
                        <span>Certificado</span>
                        <input type="file" id="certi" name="certificado">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" placeholder="Faça o upload do seu certificado">
                    </div>
                </div>
                <!--aqui passamos um link para que o aluno possa var o arquivo que ele cadastrou no sistema.-->
                <p>Seu certificado : <a class="waves-effect waves-light btn" href=" <?php echo $pasta . $entrega['caminho']; ?>"><?php echo $entrega['certificado']; ?></a>
                </p>

                <div class="row">
                    <div class="col s12">
                        <p class="center-align">
                            <button class="btn waves-effect waves-light brown  lighten-3" type="submit" name="action">Entregar atividade
                                <i class="material-icons right">send</i> </button>
                        </p>
                    </div>
                </div>

            </form>

        </div>
    </main>

    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="../materialize/js/materialize.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('select');
            var instances = M.FormSelect.init(elems, options);
        });

        // Or with jQuery

        $(document).ready(function() {
            $('select').formSelect();
        });
    </script>
</body>

</html>