<?php

//incluir o arquivo de notificações do sitema
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
    <title>Formulário para recuperação da sua senha</title>

    <style>
        p {
            font-size: 20px;
        }
    </style>
</head>

<body>

    <!--conteudo principal-->
    <main class="container">

        <h1 class="center-align">Recuperar senha</h1>

        <?php

        //chamar a função que exibe a notificação
        exibirNotificacoes();

        //chamar a função que limpa a notificação da sessão.
        limpaNotificacoes();

        ?>
        
        <div class="card-panel">

            <p>Digite o seu email para que você possa criar uma nova senha.</p>
            <p>Será enviado um email com um link de recuperação que você usurá para criar uma nova senha.</p>

            <br>

            <form action="recuperar.php" method="post">

                <div class="input-field col s12">
                    <input placeholder="Digite o email para recuperação de senha" id="email" name="email" type="text" class="validate" pattern="^.+$" required>
                    <label for="email">Email</label>
                    <span class="helper-text" data-error="Você deve preenchar esse campo"></span>
                </div>

                <a href="../index.php">Voltar para tela inicial</a>

                <div class="row">
                    <div class="col s12">
                        <p class="center-align">
                            <button class="btn waves-effect waves-light #00c853 green accent-4 lighten-3" type="submit" name="action">Enviar email de recuperação de senha
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