<?php
$email = $_POST['email'];
$token = $_POST['token'];
$senha = $_POST['senha'];
$repetirSenha = $_POST['repetirSenha'];

require_once "../conecta.php";

$mysql = conectar();

$sql = "SELECT * FROM recuperar_senha WHERE email='$email' AND 
        token='$token'";

$resultado = excutarSQL($mysql, $sql);

$recuperar = mysqli_fetch_assoc($resultado);

if ($recuperar == null) {
    echo "Email ou token incorreto. Tente fazer um novo pedido 
          de recuperação de senha.";
    die();
} else {
    // verificar a validade do pedido (data_criacao)
    // verificar se o link jah foi usado
    date_default_timezone_set('America/Sao_Paulo');
    $agora = new DateTime('now');
    $data_criacao = DateTime::createFromFormat(
        'Y-m-d H:i:s',
        $recuperar['data_criacao']
    );
    $umDia = DateInterval::createFromDateString('1 day');
    $dataExpiracao = date_add($data_criacao, $umDia);

    if ($agora > $dataExpiracao) {
        echo "Essa solicitação de recuperação de senha expirou!
              Faça um novo pedido de recuperação de senha.";
        die();
    }

    if ($recuperar['usado'] == 1) {
        echo "Esse pedido de recuperação de senha já foi utilizado
        anteriormente! Para recuperar a senha faça um novo pedido
        de recuperação de senha.";
        die();
    }
    if ($senha != $repetirSenha) {
        echo "A senha que você digitou é diferente da senha que
              você digitou no repetir senha. Por favor tente 
              novamente!";
        die();
    }

    $nova_senha = password_hash($senha, PASSWORD_ARGON2ID);

    // Verifica se o e-mail existe na tabela de alunos.
    $consulta_alunos = excutarSQL($mysql, "SELECT COUNT(*) FROM aluno WHERE email = '$email'");
    $quantidade_alunos = mysqli_fetch_row($consulta_alunos)[0];

    // Verifica se o e-mail existe na tabela de coordenadores.
    $consulta_coordenadores = excutarSQL($mysql, "SELECT COUNT(*) FROM coordenador_curso WHERE email = '$email'");
    $quantidade_coordenadores = mysqli_fetch_row($consulta_coordenadores)[0];

    // Verifica se o e-mail existe na tabela de administradores.
    $consulta_administradores = excutarSQL($mysql, "SELECT COUNT(*) FROM administrador WHERE email = '$email'");
    $quantidade_administradores = mysqli_fetch_row($consulta_administradores)[0];

    if ($quantidade_alunos != 0) {

        $sql2 = "UPDATE aluno SET senha='$nova_senha' WHERE 
         email='$email'";
        excutarSQL($mysql, $sql2);

        $sql3 = "UPDATE recuperar_senha SET usado=1 WHERE 
         email='$email' AND token='$token'";
        excutarSQL($mysql, $sql3);

        echo "Nova senha cadastrada com sucesso! Faça o login para 
      acessar o sistema.<br>";
        echo "<a href='../index.php'>Acessar sistema</a>";

        die();
    }
    if ($quantidade_coordenadores != 0) {


        $sql2 = "UPDATE coordenador_curso SET senha='$nova_senha' WHERE 
         email='$email'";
        excutarSQL($mysql, $sql2);

        $sql3 = "UPDATE recuperar_senha SET usado=1 WHERE 
         email='$email' AND token='$token'";
        excutarSQL($mysql, $sql3);

        echo "Nova senha cadastrada com sucesso! Faça o login para 
      acessar o sistema.<br>";
        echo "<a href='index.php'>Acessar sistema</a>";

        die();
    }

    if ($quantidade_administradores != 0) {


        $sql3 = "UPDATE administrador SET senha='$nova_senha' WHERE 
         email='$email'";
        excutarSQL($mysql, $sql3);

        $sql4 = "UPDATE recuperar_senha SET usado=1 WHERE 
         email='$email' AND token='$token'";
        excutarSQL($mysql, $sql4);

        echo "Nova senha cadastrada com sucesso! Faça o login para 
      acessar o sistema.<br>";
        echo "<a href='../index.php'>Acessar sistema</a>";

        die();
    }
}
