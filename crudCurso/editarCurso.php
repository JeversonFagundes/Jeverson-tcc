<?php

//EDITARCURSO.PHP

//conectar com o banco de dados jeverson-tcc.
require_once "../conecta.php";

//declarar a variavel de conexão com o banco de dados jeverson-tcc.
$mysql = conectar();

//receber os dados vindos do formulário de lateração de curso do arquivo formeditcurso.php
$id = $_POST['id'];
$nome = $_POST['nome'];
$carga = $_POST['carga'];

//atribuir a variavél sql ($sql) o comando para alteração do curso no banco de dados.
$sql = "UPDATE curso SET nome_curso = '$nome', carga_horaria = $carga WHERE id_curso = $id";

//excutar o comando sql ($sql).
excutarSQL($mysql, $sql);

//redirecionar o administrador para a sua tel inicial.
header("location: ../inicialAdmin.php");
