<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once "../conecta.php";

//variavel de conexão.
$mysql = conectar();

//receber os dados.
$email = $_POST['email'];

// Verifica se o e-mail existe na tabela de alunos.
$consulta_alunos = excutarSQL($mysql, "SELECT COUNT(*) FROM aluno WHERE email = '$email'");
$quantidade_alunos = mysqli_fetch_row($consulta_alunos)[0];

// Verifica se o e-mail existe na tabela de coordenadores.
$consulta_coordenadores = excutarSQL($mysql, "SELECT COUNT(*) FROM coordenador_curso WHERE email = '$email'");
$quantidade_coordenadores = mysqli_fetch_row($consulta_coordenadores)[0];

// Verifica se o e-mail existe na tabela de administradores.
$consulta_administradores = excutarSQL($mysql, "SELECT COUNT(*) FROM administrador WHERE email = '$email'");
$quantidade_administradores = mysqli_fetch_row($consulta_administradores)[0];

//se todas as tabelas retornaram 0 então esse email não está cadastrado no sistema.
if ($quantidade_alunos == 0 && $quantidade_coordenadores == 0 && $quantidade_administradores == 0) {
    echo "E-mail: " . " " . $email . " " . " não está cadastrado no sistema!<p><a href = \"../index.php\">Voltar</a></p>";

    die();
} else {

    if ($quantidade_alunos != 0) {

        $sql = "SELECT email, nome FROM aluno WHERE email = '$email'";

        $resultado = excutarSQL($mysql, $sql);

        $usuario = mysqli_fetch_assoc($resultado);
    }
    if ($quantidade_coordenadores != 0) {

        $sql = "SELECT email, nome FROM coordenador_curso WHERE email = '$email'";

        $resultado = excutarSQL($mysql, $sql);

        $usuario = mysqli_fetch_assoc($resultado);
    }
    if ($quantidade_administradores != 0) {

        $sql = "SELECT email FROM administrador WHERE email = '$email'";

        $resultado = excutarSQL($mysql, $sql);

        $usuario = mysqli_fetch_assoc($resultado);

        //gerar um token unico
        $token = bin2hex(random_bytes(50));

        require_once 'PHPMailer/src/PHPMailer.php';
        require_once 'PHPMailer/src/SMTP.php';
        include '../config2.php';

        $mail = new PHPMailer(true);
        try {
            // configurações
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->setLanguage('br');
            //$mail->SMTPDebug = SMTP::DEBUG_OFF;  //tira as mensagens
            $mail->SMTPDebug = SMTP::DEBUG_SERVER; //imprime as mensagens
            $mail->isSMTP();                       //envia o email usando SMTP
            $mail->Host = 'smtp.gmail.com';        //Set the SMTP server to send through
            $mail->SMTPAuth = true;                //Enable SMTP authentication
            $mail->Username = $config['email'];    //SMTP username
            $mail->Password = $config['senha_email']; //SMTP password
            //Enable implicit TLS encryption
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            // TCP port to connect to; use 587 if you have set 
            //`SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS` 
            $mail->Port = 587;
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            //Recipients
            $mail->setFrom($config['email'], 'Recuperação de senha');
            $mail->addAddress($usuario['email'], $usuario['email']);     //Add a recipient
            $mail->addReplyTo($config['email'], 'Recuperação de senha');

            //Content
            $mail->isHTML(true);        //Set email format to HTML
            $mail->Subject = 'Recuperação de Senha do Sistema';
            $mail->Body = 'Olá!<br>
        Você solicitou a recuperação da sua conta no nosso sistema.
        Para isso, clique no link abaixo para realizar a troca de senha:<br>
        <a href="' . $_SERVER['SERVER_NAME'] . '/jeverson-tcc/recuperarSenha/nova_senha.php?email='
                . $usuario['email'] . '&token=' . $token .
                '">Clique aqui para recuperar o acesso à sua conta!</a><br>
        <br>
        Atenciosamente<br>
        Equipe do sistema...';

            $mail->send();
            echo 'Email enviado com sucesso!<br>Confira o seu email.';

            echo '<p><a href = "../index.php">Voltar para a tela inicial</a></p>';

            // gravar as informações na tabela recuperar-senha
            date_default_timezone_set('America/Sao_Paulo');
            $data = new DateTime('now');
            $agora = $data->format('Y-m-d H:i:s');

            $sql2 = "INSERT INTO recuperar_senha 
             (email, token, data_criacao, usado)
             VALUES ('" . $usuario['email'] . "', '$token', 
             '$agora', 0)";

            excutarSQL($mysql, $sql2);
        } catch (Exception $e) {
            echo "Não foi possível enviar o email. 
          Mailer Error: {$mail->ErrorInfo}";
        }
    }

    die ();
    

    //gerar um token unico
    $token = bin2hex(random_bytes(50));

    require_once 'PHPMailer/src/PHPMailer.php';
    require_once 'PHPMailer/src/SMTP.php';
    include '../config2.php';

    $mail = new PHPMailer(true);
    try {
        // configurações
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';
        $mail->setLanguage('br');
        //$mail->SMTPDebug = SMTP::DEBUG_OFF;  //tira as mensagens
        $mail->SMTPDebug = SMTP::DEBUG_SERVER; //imprime as mensagens
        $mail->isSMTP();                       //envia o email usando SMTP
        $mail->Host = 'smtp.gmail.com';        //Set the SMTP server to send through
        $mail->SMTPAuth = true;                //Enable SMTP authentication
        $mail->Username = $config['email'];    //SMTP username
        $mail->Password = $config['senha_email']; //SMTP password
        //Enable implicit TLS encryption
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        // TCP port to connect to; use 587 if you have set 
        //`SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS` 
        $mail->Port = 587;
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        //Recipients
        $mail->setFrom($config['email'], 'Recuperação de senha');
        $mail->addAddress($usuario['email'], $usuario['nome']);     //Add a recipient
        $mail->addReplyTo($config['email'], 'Recuperação de senha');

        //Content
        $mail->isHTML(true);        //Set email format to HTML
        $mail->Subject = 'Recuperação de Senha do Sistema';
        $mail->Body = 'Olá!<br>
        Você solicitou a recuperação da sua conta no nosso sistema.
        Para isso, clique no link abaixo para realizar a troca de senha:<br>
        <a href="' . $_SERVER['SERVER_NAME'] . '/jeverson-tcc/recuperarSenha/nova_senha.php?email='
            . $usuario['email'] . '&token=' . $token .
            '">Clique aqui para recuperar o acesso à sua conta!</a><br>
        <br>
        Atenciosamente<br>
        Equipe do sistema...';

        $mail->send();
        echo 'Email enviado com sucesso!<br>Confira o seu email.';

        echo '<p><a href = "../index.php">Voltar para a tela inicial</a></p>';

        // gravar as informações na tabela recuperar-senha
        date_default_timezone_set('America/Sao_Paulo');
        $data = new DateTime('now');
        $agora = $data->format('Y-m-d H:i:s');

        $sql2 = "INSERT INTO recuperar_senha 
             (email, token, data_criacao, usado)
             VALUES ('" . $usuario['email'] . "', '$token', 
             '$agora', 0)";

        excutarSQL($mysql, $sql2);
    } catch (Exception $e) {
        echo "Não foi possível enviar o email. 
          Mailer Error: {$mail->ErrorInfo}";
    }
}
/*
$email = $_POST['email'];
$sql = "SELECT * FROM usuario WHERE email='$email'";
$resultado = executarSQL($conexao, $sql);

$usuario = mysqli_fetch_assoc($resultado);
if ($usuario == null) {
    echo "Email não cadastrado! Faça o cadastro e 
          em seguida realize o login.";
    die();
}
//gerar um token unico
$token = bin2hex(random_bytes(50));

require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';
require_once 'PHPMailer/src/Exception.php';
include 'config.php';


$mail = new PHPMailer(true);
try {
    // configurações
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';
    $mail->setLanguage('br');
    //$mail->SMTPDebug = SMTP::DEBUG_OFF;  //tira as mensagens
    $mail->SMTPDebug = SMTP::DEBUG_SERVER; //imprime as mensagens
    $mail->isSMTP();                       //envia o email usando SMTP
    $mail->Host = 'smtp.gmail.com';        //Set the SMTP server to send through
    $mail->SMTPAuth = true;                //Enable SMTP authentication
    $mail->Username = $config['email'];    //SMTP username
    $mail->Password = $config['senha_email']; //SMTP password
    //Enable implicit TLS encryption
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    // TCP port to connect to; use 587 if you have set 
    //`SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS` 
    $mail->Port = 587;
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    //Recipients
    $mail->setFrom($config['email'], 'Aula de Tópicos');
    $mail->addAddress($usuario['email'], $usuario['nome']);     //Add a recipient
    $mail->addReplyTo($config['email'], 'Aula de Tópicos');

    //Content
    $mail->isHTML(true);        //Set email format to HTML
    $mail->Subject = 'Recuperação de Senha do Sistema';
    $mail->Body = 'Olá!<br>
        Você solicitou a recuperação da sua conta no nosso sistema.
        Para isso, clique no link abaixo para realizar a troca de senha:<br>
        <a href="' . $_SERVER['SERVER_NAME'] . '/recuperar-senha/nova-senha.php?email='
        . $usuario['email'] . '&token=' . $token .
        '">Clique aqui para recuperar o acesso à sua conta!</a><br>
        <br>
        Atenciosamente<br>
        Equipe do sistema...';

    $mail->send();
    echo 'Email enviado com sucesso!<br>Confira o seu email.';

    // gravar as informações na tabela recuperar-senha
    date_default_timezone_set('America/Sao_Paulo');
    $data = new DateTime('now');
    $agora = $data->format('Y-m-d H:i:s');

    $sql2 = "INSERT INTO `recuperar-senha` 
             (email, token, data_criacao, usado)
             VALUES ('" . $usuario['email'] . "', '$token', 
             '$agora', 0)";

    executarSQL($conexao, $sql2);
} catch (Exception $e) {
    echo "Não foi possível enviar o email. 
          Mailer Error: {$mail->ErrorInfo}";
}
*/
