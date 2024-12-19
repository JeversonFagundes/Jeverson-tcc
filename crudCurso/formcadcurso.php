<?php

require_once "../boasPraticas/notificacoes.php";
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
    <title>Formulário de cadastro de curso</title>

</head>

<body>

    <?php

    require_once "../boasPraticas/headerNav.php";
    ?>

    <!--conteudo principal-->
    <main class="container">

        <h1 class="center-align">Formulário de cadastro de curso</h1>

        <div class="card-panel">

            <form action="cadastrarCurso.php" method="post">

                <div class="input-field col s12">
                    <input placeholder="Digite o nome do curso" id="nome" name="nome" type="text" class="validate" pattern="^.+$" required>
                    <label for="nome">Nome do curso : </label>
                    <span class="helper-text" data-error="Você deve preenchar esse campo"></span>
                </div>

                <div class="input-field col s12">
                    <input placeholder="Digite a carga horária do curso" id="carga" name="cargaHoraria" type="text" class="validate" pattern="^.+$" required>
                    <label for="carga">Carga horaria: </label>
                    <span class="helper-text" data-error="Você deve preenchar esse campo"></span>
                </div>

                <div class="row">
                    <div class="col s12">
                        <p class="center-align">
                            <button class="btn waves-effect waves-light #2e7d32 green darken-3 lighten-3" type="submit" name="action">Cadastrar curso
                                <i class="material-icons right">send</i> </button>
                        </p>
                    </div>
                </div>

            </form>

        </div>

    </main>

    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="../materialize/js/materialize.min.js"></script>
</body>

</html>