<?php

//incluir o arquivo que exibe as mensagens para o usuário
require_once "boasPraticas/notificacoes.php";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de login</title>

</head>

<body>

    <!--INDEX.PHP-->

    <!--Esta é a tela de login dos usuários do sistema.-->

    <main>
        <h1>Tela de login</h1>

        <?php

        //chamar a função que imprime a notificação para o usuário.
        exibirNotificacoes();

        //chamar a função que limpa a notificação de dentro da sessão.
        limpaNotificacoes();

        ?>
        <form action="login.php" method="post">

            <label for="email">Email: </label>
            <input type="email" name="email" id="email" required><br><br>

            <label for="senha">Senha: </label>
            <input type="password" name="senha" id="senha" required><br>

            <ul>
                <li><a href="recuperarSenha/form-recuperar-senha.php">Esqueci minha senha</a></li>
                <li><a href="crudAluno/formcadAluno.php">Não possui conta? Clique aqui!</a></li>
            </ul>

            <input type="submit" value="Entrar">
        </form>


    </main>
</body>

</html>