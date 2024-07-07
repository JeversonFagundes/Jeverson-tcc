<?php

/*use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//conectar no banco de dados.
require_once "conecta.php";

//variavel de conexão.
$mysql = conectar();

//receber os dados.
$email = $_POST['email'];

$sql = "SELECT * FROM usuario WHERE email = '$email'";

$resultado = excutarSQL($mysql, $sql);

$usuario = mysqli_fetch_assoc($resultado);

if ($usuario == null) {

    echo "Email não cadastrado no sistema! Faça o cadastro e em seguida realize o login";

    die();
}

//gerar um token unico
$token = bin2hex(random_bytes(50));

require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';
require_once 'PHPMailer/src/Exception.php';
include("config.php");

$mail = new PHPMailer(true);

try {
    //configurações 
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';
    $mail->setLanguage('br');
    //$mail->SMTPDebug = SMTP::DEBUG_OFF; //tira as mensagens de erro
    $mail->SMTPDebug = SMTP::DEBUG_SERVER; // imprime as mensagens de erro
    $mail->isSMTP(); // envia o email usuando SMTP
    $mail->Host = 'smtp.gmail.com'; //
    $mail->SMTPAuth = true;
    $mail->Username = $config['email'];
    $mail->Password = $config['senha_email'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->SMTPOptions = array(

        'ssl' => array(

            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )

    );

    //Recepientes
    $mail->setFrom($config['email'], 'Aula de tópicos IIII');
    $mail->addAddress($usuario['email'], $usuario['nome']);
    $mail->addReplyTo($config['email'], 'Aula de tópicos IIII');


    //Conteudo
    $mail->isHTML(true);
    $mail->Subject = 'Recuperar senha do sistema';
    $mail->Body = 'Olá <br>
    Você solicitou a recuperação da sua conta no nosso sistema.
    Para isso, clique no link abaixo para realizar a troca de senha: <br>
    <a href="' . $_SERVER['SERVER_NAME'] . '/resgatar-senha/nova-senha.php?email=' . $usuario['email'] .
        '&token=' . $token . '">Clique aqui para recuperar o acesso da sua conta!</a><br>
    <br>
    Atenciosamente <br>
    Equipe so sistema...';

    $mail->send();
    echo "Email enviado com sucesso<br> Confira o seu email!";

    $data = new DateTime('now');
    $agora = $data->format('Y-m-d H:i:s');

    //gravar as informações na tabela recuperar.
    $sql2 = "INSERT INTO recuperar 
    (email, token, datarecuperacao, usado) 
    
    VALUES ('" . $usuario['email']."', '$token','$agora' , 0)";



} catch (Exception $e) {
    echo "Não foi possivél enviar o email.
    Mailer Error: {$mail->ErrorInfo}";
}
 */


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//conectar com o banco de dados.
include("../conecta.php");

//receber o email que venho do formulário "form-recuperar-senha.html".
$email = $_POST['email'];

//listar o usuário onde existir o email.
$sql = "SELECT * FROM "; // problema "o valor pode estar em três tabelas diferentes, esperando pela orientação com o Thiago".


