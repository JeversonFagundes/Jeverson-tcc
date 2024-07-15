<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//conectar no banco de dados.
require_once "../conc.php";

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

if ($quantidade_alunos == 0 && $quantidade_coordenadores == 0 && $quantidade_administradores == 0) {
    echo "E-mail: " . " " . $email . " " . " não está cadastrado no sistema!<p><a href = \"../index.php\">Voltar</a></p>";
} else {

    
}
