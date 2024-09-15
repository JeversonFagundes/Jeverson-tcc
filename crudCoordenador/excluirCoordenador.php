<?php

//EXCLUIRCOORDENADOR.PHP

//conectar vom o banco de dados jeverson-tcc
require_once "../conecta.php";

//declarar a variavel de conexão com o banco de dados jeverson-tcc.
$mysql = conectar();

//buscar da url os valores necessários para a exclusão do coordenador de curso ddo banco de dados.
$id = $_GET['id'];

//atribuir a variavél sql ($sql) o omando para deletar o coordenador de curso do banco de dados.
$sql = "DELETE FROM coordenador_curso WHERE id_coordenador = $id";

//excutar o comando sql ($sql).
excutarSQL($mysql, $sql);

//redirecionar o administrador para a seu tela inicial.
header("location: ../inicialAdmin.php");
