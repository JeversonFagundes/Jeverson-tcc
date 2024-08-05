<?php

//conectar com o banco de dados.
require_once "../conecta.php";

//variavel de conexão.
$mysql = conectar();

//receber os dados.
$natureza = $_POST['natureza'];
$carga = $_POST['carga'];
$descricao = $_POST['descricao'];
$curso = $_POST['curso'];

//comando sql.
$sql = "INSERT INTO atividade_complementar (natureza, descricao, carga_horaria_maxima, id_curso) VALUES ('$natureza', '$descricao', $carga, $curso)";

//excutar o comando acima.
excutarSQL($mysql, $sql);

header("location: ../inicialCoordenador.php");
