<?php

//EXCLUIRCURSO.PHP

//conectar com o banco de dados jeverson-tcc.
require_once "../conecta.php";

//declarar a variavel de conexão com o banco de dados jeverson-tcc.
$mysql = conectar();

//buscar da url os valores necessários para a exclusão do curso.
$id = $_GET['id'];

//atribuir a veriavél sql ($sql) o comando para deletar o curso do banco de dados.
$sql = "DELETE FROM curso WHERE id_curso = $id";

//excutar o comando sql ($sql).
excutarSQL($mysql, $sql);

//redirecionar o administrador para a sua tela inicial.
header("location: ../inicialAdmin.php");
