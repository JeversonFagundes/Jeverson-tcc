<?php

//EDITARCURSO.PHP

//conectar com o banco de dados jeverson-tcc.
require_once "../conecta.php";

//incluir o arquivo de notificações do sistema.
require_once "../boasPraticas/notificacoes.php";

//declarar a variavel de conexão com o banco de dados jeverson-tcc.
$mysql = conectar();

//receber os dados vindos do formulário de lateração de curso do arquivo formeditcurso.php

//O trim() em PHP é utilizado para remover os espaços em branco (ou outros caracteres) do início e do final de uma string. Isso é útil quando você deseja limpar entradas de dados de usuários ou formatar strings de maneira mais adequada.

//O real_escape_string() é usado para escapar caracteres especiais em uma string, tornando-a segura para ser usada em uma consulta SQL, evitando que caracteres especiais quebrem a excução do comando sql.

$id = $_POST['id'];
$nome = trim($mysql->real_escape_string($_POST['nome']));
$carga = trim($_POST['carga']);

//atribuir a variavél sql ($sql) o comando para alteração do curso no banco de dados.
$sql = "UPDATE curso SET nome_curso = '$nome', carga_horaria = $carga WHERE id_curso = $id";

//excutar o comando sql ($sql).
excutarSQL($mysql, $sql);

notificacoes(1, "Alterações no curso feitas com sucesso!");

//redirecionar o administrador para a sua tel inicial.
header("location: formeditCurso.php?id=$id");
