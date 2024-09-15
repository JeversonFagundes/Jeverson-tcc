<?php

//EDITARCOORDENADOR.PHP

//conectar com o banco de dados jeverson-tcc.
require_once "../conecta.php";

//declarar a variavel de conexão com o banco de dados.
$mysql = conectar();

//receber os dados vindos do formulário de alteração do coordenador de curso que está no arquivo formeditcoordenador.php.
$nome = $_POST['nome'];
$curso = $_POST['curso'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$id = $_POST['id'];

//atribuir a variavél sql ($sql) o comando alteração do banco de dados.
$sql = "UPDATE coordenador_curso SET nome = '$nome', email = '$email', senha = '$senha', id_curso = $curso WHERE id_coordenador = $id";

//excutar o comando sql ($sql).
excutarSQL($mysql, $sql);

//redirecionar o administrador para a sua tela inicial.
header("location: ../inicialAdmin.php");
