<?php

//EDITARCONTCO.PHP

//conectar com o banco de dados jeverson-tcc.
require_once "../conecta.php";

//incluir o arquivo de notificações do sistema.
require_once "../boasPraticas/notificacoes.php";

//declarar a variavel de conexão com o banco de dados jeverson-tcc.
$mysql = conectar();

//receber os dados vindos do do formulário do perfil do coordenador de curso "perfil.php".
$id = $_POST['id'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$curso = $_POST['curso'];

//atribuir a variavél sql ($sql) o comando alteração do banco de dados.
$sql = "UPDATE coordenador_curso SET nome = '$nome',  email = '$email', id_curso = '$curso' WHERE id_coordenador = $id";

//excutar o comando sql ($sql).
excutarSQL($mysql, $sql);

//com as variaveis de sessão inicadas podemos alterar os valores da variavel de sessão do coordenador de curso sem precisar desloga-lo do sistema.
$_SESSION['coordenador'][0] = $nome;

$_SESSION['coordenador'][2] = $curso;

notificacoes(1, "Alterações realizadas com sucesso!");

//após todas as alterações redirecionamos o coordenador de curso para a tela do seu perfil, onde estarão todas as informações já alteradas.
header("location: perfilCoordenador.php");
