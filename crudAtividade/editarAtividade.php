<?php

//EDITARATIVIDADE.PHP

//conectar com o banco de dados jeverson-tcc.
require_once "../conecta.php";

//incluir o arquivo de notificações do sistema.
require_once "../boasPraticas/notificacoes.php";

//declarar a variavál de conexão com o banco de dados jeverson-tcc.
$mysql = conectar();

//receber os dados vindos do formulário de alteração de curso. Esses dados vem do arquivo formeditatividade.php
$id = $_POST['id'];
$natureza = $_POST['natureza'];
$descricao = $_POST['descricao'];
$carga = $_POST['carga'];
$curso = $_POST['curso'];

//atribuir a veriavél sql ($sql) o comando de alteração no banco de dados.
$sql = "UPDATE atividade_complementar SET natureza = '$natureza', carga_horaria_maxima = $carga, descricao = '$descricao' WHERE id_atividade_complementar = $id";

//excutar o comando sql ($sql).
excutarSQL($mysql, $sql);

//gerar a notificação de um novo aluno cadastrado no sistema.
notificacoes(1, "Alterações na atividade complementar realizada com sucesso!");

//redirecionar o coordenador de curso novamente para a sua tela inicial.
header("location: ../inicialCoordenador.php");
