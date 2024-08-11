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
$id = $_POST['id'];

//comando sql.
$sql = "UPDATE coordenador_curso SET nome = '$nome', email = '$email', senha = '$senha', id_curso = $curso WHERE id_coordenador = $id";

//excutar o comando sql acima.
excutarSQL($mysql, $sql);

header("location: ../inicialAdmin.php");
