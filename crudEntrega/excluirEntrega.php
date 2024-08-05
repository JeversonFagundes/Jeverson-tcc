<?php

// Conectar ao BD
require_once "../conecta.php";

//variavel de conexão.
$mysql = conectar();

// receber os dados do formulário
$id = $_GET['id'];

//pasta de destino.
$pastaDestino = "../certificados/";

$sql2 = "SELECT caminho FROM entrega_atividade WHERE id_entrega_atividade = $id";

$resultado = excutarSQL($mysql, $sql2);

$result = $resultado->fetch_assoc();

$caminho = $result['caminho'];

$sql = "DELETE FROM entrega_atividade WHERE id_entrega_atividade = $id";

//excutar o comando sql.
excutarSQL($mysql, $sql);

unlink($pastaDestino . $caminho);

header("location: ../inicialAluno.php");
