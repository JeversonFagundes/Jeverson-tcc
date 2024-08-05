<?php
//conectar com o banco de dados.
require_once "../conecta.php";

//variavel de conexão.
$mysql = conectar();

//receber os dados vindos do formulário de alteração de curso
$id = $_POST['id'];
$nome = $_POST['nome'];
$carga = $_POST['carga'];

//comando sql.
$sql = "UPDATE curso SET nome_curso = '$nome', carga_horaria = $carga WHERE id_curso = $id";

//excutar o comando sql acima.
excutarSQL($mysql, $sql);

header("location: ../inicialAdmin.php");
