<?php

//variavel de conexão.
$mysql = mysqli_connect('localhost', 'root', '', 'password_hash');

if ($_POST) {

    //SENHA
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuario WHERE nome = '$nome'";

    $query = mysqli_query($mysql, $sql);

    if ($mysql->error) {

        echo "Falha ao listar:" . $mysql->error;
    } else {

        $usuario = $query->fetch_assoc();

        if (password_verify($senha, $usuario['senha'])) {

            echo "A senha confere!";
        } else {

            echo "A senha não confere!";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de login</title>

</head>

<body>

    <h1>Tela de login</h1>

    <form action="" method="post">

        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome"><br><br>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha"><br><br>

        <input type="submit" value="Logar">
    </form>

    <a href="cadastrar.php"> Cadastrar-se</a>
</body>

</html>