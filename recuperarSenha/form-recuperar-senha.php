<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <!--Import Google Icon Font-->
    <!--<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">-->
    <!--Import materialize.css-->
    <!--<link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário para recuperação da sua senha</title>

</head>

<body>

    <h1>Recuperar senha</h1>

    <p>Digite o seu email para que você possa criar uma nova senha.</p>
    <p>Será enviado um email com um link de recuperação que você usurá para criar uma nova senha.</p>

    <form action="recuperar.php" method="post">

        <label for="email">Email:</label>
        <input type="email" name="email" id="email"><br><br>

        <input type="submit" value="Enviar email para recuperação">
    </form><br>

    <a href="../index.php">Voltar para tela inicial</a>

    <!--Import jQuery before materialize.js-->
    <!--<script type="text/javascript" src="js/materialize.min.js"></script>-->
</body>

</html>