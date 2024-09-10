<?php

// verificar o email
// verificar o token
$email = $_GET['email'];
$token = $_GET['token'];

require_once "../conecta.php";

$mysql = conectar();

$sql = "SELECT * FROM recuperar_senha WHERE email='$email' AND token='$token'";

$resultado = excutarSQL($mysql, $sql);

$recuperar = mysqli_fetch_assoc($resultado);

if ($recuperar == null) {

    echo "Email ou token incorreto. Tente fazer um novo pedido de recuperação de senha.";

    die();
} else {

    // verificar a validade do pedido (data_criacao)
    // verificar se o link jah foi usado

    date_default_timezone_set('America/Sao_Paulo');

    $agora = new DateTime('now');

    $data_criacao = DateTime::createFromFormat('Y-m-d H:i:s', $recuperar['data_criacao']);

    $umDia = DateInterval::createFromDateString('1 day');

    $dataExpiracao = date_add($data_criacao, $umDia);

    if ($agora > $dataExpiracao) {

        echo "Essa solicitação de recuperação de senha expirou! Faça um novo pedido de recuperação de senha.";

        die();
    }

    if ($recuperar['usado'] == 1) {

        echo "Esse pedido de recuperação de senha já foi utilizado anteriormente! Para recuperar a senha faça um novo pedido de recuperação de senha.";

        die();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Senha</title>
</head>

<body>
    <form action="salvar_nova_senha.php" method="post">
        <input type="hidden" name="email" value="<?= $email ?>">
        <input type="hidden" name="token" value="<?= $token ?>">Email: <?= $email ?><br><br>
        <label>Senha: <input type="password" name="senha"></label><br><br>
        <label>Repita a senha: <input type="password" name="repetirSenha"></label><br><br>
        <input type="submit" value="Salvar nova senha">
    </form>
</body>

</html>