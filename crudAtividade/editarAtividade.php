<?php
//conectar com o banco de dados.
require_once "../conecta.php";

//variael de conexão.
$mysql = conectar();

//receber os dados vindos do formulário de alteração de curso
$id = $_POST['id'];
$natureza = $_POST['natureza'];
$descricao = $_POST['descricao'];
$carga = $_POST['carga'];
$curso = $_POST['curso'];

//comando sql.
$sql = "UPDATE atividade_complementar SET natureza = '$natureza', carga_horaria_maxima = $carga, descricao = '$descricao' WHERE id_atividade_complementar = $id";

//excutar o comando sql acima.
excutarSQL($mysql, $sql);

header("location: ../inicialCoordenador.php");
