<?php
//conectar com o banco de dados.
require_once "../conecta.php";

//variável de conexão.
$mysql = conectar();

//receber os dados vindos do formulário de alteração de curso
$id = $_POST['id'];
$nome = $_POST['nome'];
$matricula = $_POST['matricula'];
$email = $_POST['email'];
$curso = $_POST['curso'];

//comando sql.
$sql = "UPDATE aluno SET nome_aluno = '$nome', matricula = '$matricula', email = '$email', id_curso = '$curso' WHERE id_aluno = $id";

//excutar o comando sql acima.
excutarSQL($mysql, $sql);

session_start();

$_SESSION['aluno'][0] = $nome;

$_SESSION['aluno'][2] = $curso;

header("location: perfil.php");
