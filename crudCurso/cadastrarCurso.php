<?php

//conectar com o banco de dados.
require_once "../conecta.php";

//variavel de conexão.
$mysql = conectar();

//receber os dados.
$nome_curso = $_POST['nome'];
$carga = $_POST['cargaHoraria'];

//comando sql.
$sql = "INSERT INTO curso (nome_curso, carga_horaria) VALUES ('$nome_curso', $carga)";

//excutar o comando sql acima.
excutarSQL($mysql, $sql);

header("location: ../inicialAdmin.php");
