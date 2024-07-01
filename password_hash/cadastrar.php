<?php

$mysql = mysqli_connect('localhost', 'root', '', 'password_hash');

if ($_POST) {

    $nome = $_POST['nome'];
    $senha = $_POST['senha'];

    $nova_senha = password_hash($senha, PASSWORD_ARGON2ID);

    $sql = "INSERT INTO usuario (nome, senha) VALUES ('$nome', '$nova_senha')";

    mysqli_query($mysql, $sql);

    if ($mysql->error) {

        echo "O erro foi:" . $mysql->error;
    } else {

        header("location: index.php");
    }
}else {
    
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de cadastro</title>

</head>

<body>

    <h1>Tela de cadastro de usuários</h1>

    <form action="" method="post">

        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome"><br><br>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha"><br><br>

        <input type="submit" value="Cadastrar">
    </form>

</body>

</html>