<?php

//conectar com o banco de dados.
require_once "../conecta.php";

//variavel de conexão.
$mysql = conectar();

//receber os dados.
$nome = $_POST['nome'];
$curso = $_POST['curso'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$nova_senha = password_hash($senha, PASSWORD_ARGON2ID);

//verificar se o email digitado existe no banco de dados.

// Verifica se o e-mail existe na tabela de alunos.
$consulta_alunos = excutarSQL($mysql, "SELECT COUNT(*) FROM aluno WHERE email = '$email'");
$quantidade_alunos = mysqli_fetch_row($consulta_alunos)[0];

// Verifica se o e-mail existe na tabela de coordenadores.
$consulta_coordenadores = excutarSQL($mysql, "SELECT COUNT(*) FROM coordenador_curso WHERE email = '$email'");
$quantidade_coordenadores = mysqli_fetch_row($consulta_coordenadores)[0];

// Verifica se o e-mail existe na tabela de administradores.
$consulta_administradores = excutarSQL($mysql, "SELECT COUNT(*) FROM administrador WHERE email = '$email'");
$quantidade_administradores = mysqli_fetch_row($consulta_administradores)[0];

var_dump($quantidade_alunos);
var_dump($quantidade_coordenadores);
var_dump($quantidade_administradores);

if ($quantidade_alunos > 0 || $quantidade_coordenadores > 0 || $quantidade_administradores > 0) {
    echo "E-mail: " . " " . $email . " " . " já está cadastrado no sistema!<p><a href = \"formcadCoordenador.php\">Voltar</a></p>";
} else {

    $sql = "INSERT INTO coordenador_curso (nome_coordenador, email, senha, id_curso)
    VALUES ('$nome', '$email', '$nova_senha', $curso)";

    $query = excutarSQL($mysql, $sql);

    header("location: ../index.php");
}
