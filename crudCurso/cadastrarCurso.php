<?php

//CADASTRARCURSO.PHP

//conectar com o banco de dados jeerson-tcc.
require_once "../conecta.php";

//incluir o arquivo de notificações do sistema.
require_once "../boasPraticas/notificacoes.php";

//declarar a variavel de conexão com o banco de dados jeverson-tcc.
$mysql = conectar();

//receber os dados vindos do forrmulário do arquivo formcadcurso.html.
$nome_curso = $_POST['nome'];
$carga = $_POST['cargaHoraria'];

//atribuir a veriavél sql ($sql) o comando inserção no banco de dados.
$sql = "INSERT INTO curso (nome_curso, carga_horaria) VALUES ('$nome_curso', $carga)";

//excutar o comando sql ($sql).
excutarSQL($mysql, $sql);

notificacoes(1, "Curso cadastrado com sucesso!");

//redirecionar o administrador para a sua tela inicial.
header("location: ../inicialAdmin.php");
