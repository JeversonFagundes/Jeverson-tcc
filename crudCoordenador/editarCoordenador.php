<?php

//EDITARCOORDENADOR.PHP

//conectar com o banco de dados jeverson-tcc.
require_once "../conecta.php";

//incluir o arquivo de notificações do sistema.
require_once "../boasPraticas/notificacoes.php";

//declarar a variavel de conexão com o banco de dados.
$mysql = conectar();

//receber os dados vindos do formulário de alteração do coordenador de curso que está no arquivo formeditcoordenador.php.
$nome = $_POST['nome'];
$curso = $_POST['curso'];
$email = $_POST['email'];
$id = $_POST['id'];

//atribuir a variavél sql ($sql) o comando alteração do banco de dados.
$sql = "UPDATE coordenador_curso SET nome = '$nome', email = '$email', id_curso = $curso WHERE id_coordenador = $id";

//excutar o comando sql ($sql).
excutarSQL($mysql, $sql);

notificacoes(1, "Alterações realizadas com sucesso!");

//redirecionar o administrador para a sua tela inicial.
header("location:formeditCoordenador.php?id=$id");
