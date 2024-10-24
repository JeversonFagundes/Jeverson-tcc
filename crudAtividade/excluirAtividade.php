<?php

//conectar com o banco de dados jeverson-tcc.
require_once "../conecta.php";

//incluir o arquivo de notificações do sistema.
require_once "../boasPraticas/notificacoes.php";

//declara a variavel de conexão com o banco de dados jeverson-tcc. Essa variavél vem do arquivo conecta.php.
$mysql = conectar();

//buscar da url o valor necessário para a exclusão da atividade_complementar. Esse valor vem do arquivo formeditatividade.php
$id = $_GET['id'];

//atribuir a veriavél sql ($sql) o comando para deletar a atividade_complementar do banco de dados.
$sql = "DELETE FROM atividade_complementar WHERE id_atividade_complementar = $id";

//excutar o comando sql ($sql).
excutarSQL($mysql, $sql);

notificacoes(1, "Atividade complementar excluida com sucesso!");

//redirecionar o coordenador de curso novamente para a sua tela inicial.
header("location: ../inicialCoordenador.php");
