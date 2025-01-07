<?php

//FORMCADEBTREGA.PHP

//conectar com o banco de dados jeverson-tcc.
require_once "../conecta.php";

//incluir o arquivo de notificações do sistema.
require_once "../boasPraticas/notificacoes.php";

//incluir a navbar
require_once "../boasPraticas/headerNav.php";

//declarar a variavel de conexão com o banco de dados.
$mysql = conectar();

//atribuir a variavél sql ($sql) a busca por todos os cursos relacionados com o curso do aluno logado no momento.
$sql = "SELECT ea.natureza, ea.descricao, ea.carga_horaria_maxima,

c.carga_horaria

FROM atividade_complementar ea 

INNER JOIN curso c 

ON ea.id_curso = c.id_curso

WHERE ea.id_curso = "  . $_SESSION['aluno'][2];

//atribuir a variavél resultado ($resultado) a execução do comando sql ($sql).
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
    <title>Formulário de entrega de atividade complementar</title>

    <style>
        .espacamento{
            margin-bottom: 30px;
        }
    </style>

</head>

<body>

    <main class="container">

        <h1 class="center-align">Tabela de atividades complementares</h1>

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

                    while ($dados = mysqli_fetch_assoc($resultado)) {
                        echo '<tr>';
                        echo '<td>' . $dados['natureza'] . '</td>';
                        echo '<td>' . $dados['descricao'] . '</td>';
                        echo '<td>' . $dados['carga_horaria_maxima'] . '</td>';

                        echo '</tr>';
                    }

                    ?>
                </tbody>
            </table>

            <?php

            mysqli_data_seek($resultado, 0);

            $total_horas = mysqli_fetch_assoc($resultado);

            ?>

            <p> <strong> Total de horas exigidas pelo PCC : <?php echo $total_horas['carga_horaria'] ?> horas </strong> </p>

            <br>

            <!--(enctype="multipart/form-data") é utilizado em formulários HTML para especificar como os dados do formulário devem ser codificados ao serem enviados para o servidor. Este valor é essencial quando o formulário inclui uploads de arquivos, como imagens ou documentos-->
            <form action="cadastrarEntrega.php" method="post" enctype="multipart/form-data">

                <?php

                //atribuir a variavél sql2 ($sql2) a busca pelo id e natureza das atividades complementares de curso relacionadas ao curso do aluno que está logado no momento.
                $sql2 = "SELECT id_atividade_complementar, descricao FROM atividade_complementar WHERE id_curso = " . $_SESSION['aluno'][2];

                //atribuir a variavél resultado2 ($resultado2) a execução do comando sql2 ($sql2).
                $resultado2 = excutarSQL($mysql, $sql2);
                ?>

                <label>Qual é a natureza do seu certificado?</label>
                <!--As tags selects e options são usadas para criar menus suspensos (dropdowns) ou listas de opções em formulários.-->
                <!--SELECT cria um menu suspenso que permite ao usuário escolher uma ou mais opções.-->
                <select equired id="select" name="atividade_complementar" class="browser-default">
                    <?php

                    //atribuir a variavél dados ($dados) os valores do array associativo gerado no busca do comando sql2 ($sql2). Essa variavél será repetida enquanto houver dados.
                    while ($dados = mysqli_fetch_assoc($resultado2)) {

                    ?>
                        <!--declarar o resto das opções da lista de seleção. Agora essas opções tem os valores vindos do banco de dados que estão dentro da variavél dados ($dados) acima.-->
                        <option value="<?php echo $dados['id_atividade_complementar'] ?>">

                            <?php echo $dados['descricao'] ?>

                        </option>
                    <?php
                    }
                    ?>
                </select>

                <br>

                <div class="input-field col s12 espacamento">
                    <!--<i class="material-icons prefix">person_outline</i>-->
                    <input placeholder="Digite o titulo do seu certificado" id="titulo" name="titulo" type="text" class="validate" pattern="^[^']+$" required>
                    <label for="titulo">Titulo certificado</label>
                    <span class="helper-text" data-error="Você deve preenchar esse campo corretamente, não se deve usar aspas simples"></span>
                </div>

                <div class="input-field col s12">
                    <!--<i class="material-icons prefix">person_outline</i>-->
                    <input placeholder="Digite a carga horária do seu certificado" id="carga" name="carga" type="text" class="validate" pattern="^\d{1,2}$" required>
                    <label for="tcarga">Carga horaria do certificado</label>
                    <span class="helper-text" data-error="Este campo deve ser preenchido com no máximo dois digitos numericos"></span>
                </div>

                <input type="hidden" name="cargaDefe" value="0">
                <input type="hidden" name="status" value="Em análise">

                <div class="file-field input-field">
                    <div class="btn">
                        <span>Certificado</span>
                        <input type="file" id="certi" name="certificado" required>
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" placeholder="Faça o upload do seu certificado">
                    </div>
                </div>

                <div class="row">
                    <div class="col s12">
                        <p class="center-align">
                            <button class="btn waves-effect waves-light #2e7d32 green darken-3 lighten-3" type="submit" name="action">Entregar atividade
                                <i class="material-icons right">send</i> </button>
                        </p>
                    </div>
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