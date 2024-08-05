<?php
//conectar com o banco de dados.
require_once "../conecta.php";

//variavel de conexão.
$mysql = conectar();

//receber os dados vindos do formulário de alteração de curso
$id = $_POST['id'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$curso = $_POST['curso'];

//comando sql.
$sql = "UPDATE coordenador_curso SET nome_coordenador = '$nome',  email = '$email', id_curso = '$curso' WHERE id_coordenador = $id";

//excutar o comando sql acima.
excutarSQL($mysql, $sql);

session_start();

$_SESSION['coordenador'][0] = $nome;

$_SESSION['coordenador'][2] = $curso;

header("location: perfil.php");
