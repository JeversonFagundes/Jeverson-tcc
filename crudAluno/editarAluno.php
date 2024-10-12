<?php

//EDITARALUNO.PHP

//inicluir o arquivo que exibe as notificações do sistema.
require_once "../boasPraticas/notificacoes.php";

//conectar com o banco de dados jeverson-tcc.
require_once "../conecta.php";

//declarar a variável de conexão com o banco de dados jeverson-tcc. Essa variavél vem do arquivo conecta.php.
$mysql = conectar();

//receber os dados vindos do formulário do arquivo perfil.php
$id = $_POST['id'];
$nome = $_POST['nome'];
$matricula = $_POST['matricula'];
$email = $_POST['email'];
$curso = $_POST['curso'];

//atribuir a veriavél sql ($sql) o comando sql de alteração de informações no banco de dados.
$sql = "UPDATE aluno SET nome = '$nome', matricula = '$matricula', email = '$email', id_curso = '$curso' WHERE id_aluno = $id";

//excutar o comando sql ($sql).
excutarSQL($mysql, $sql);

//com a sessão iniciada podemos atribuir os novos valores as posições do array da sessão aluno, sem precisar delogar o aluno.
$_SESSION['aluno'][0] = $nome;

$_SESSION['aluno'][2] = $curso;

//gerar a notificação de alterações realizadas com sucesso.
notificacoes(1, "Alterações realizadas com sucesso");

//após as alterações redirecionamos o aluno para o arquivo do seu perfil onde apareceram as suas informações alteradas.
header("location: perfil.php");
