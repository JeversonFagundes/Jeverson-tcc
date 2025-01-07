<?php

//CADASTRARCURSO.PHP

//conectar com o banco de dados jeerson-tcc.
require_once "../conecta.php";

//incluir o arquivo de notificações do sistema.
require_once "../boasPraticas/notificacoes.php";

//declarar a variavel de conexão com o banco de dados jeverson-tcc.
$mysql = conectar();

//receber os dados vindos do forrmulário do arquivo formcadcurso.html.

//O trim() em PHP é utilizado para remover os espaços em branco (ou outros caracteres) do início e do final de uma string. Isso é útil quando você deseja limpar entradas de dados de usuários ou formatar strings de maneira mais adequada.

//O real_escape_string() é usado para escapar caracteres especiais em uma string, tornando-a segura para ser usada em uma consulta SQL, evitando que caracteres especiais quebrem a excução do comando sql.

$nome_curso = trim($mysql->real_escape_string($_POST['nome']));
$carga = trim($_POST['cargaHoraria']);

//atribuir a veriavél sql ($sql) o comando inserção no banco de dados.
$sql = "INSERT INTO curso (nome_curso, carga_horaria) VALUES ('$nome_curso', $carga)";

//excutar o comando sql ($sql).
excutarSQL($mysql, $sql);

notificacoes(1, "Curso cadastrado com sucesso!");

//redirecionar o administrador para a sua tela inicial.
header("location: ../inicialAdmin.php");
