<?php

//EDITARCONTCO.PHP

//conectar com o banco de dados jeverson-tcc.
require_once "../conecta.php";

//incluir o arquivo de notificações do sistema.
require_once "../boasPraticas/notificacoes.php";

//declarar a variavel de conexão com o banco de dados jeverson-tcc.
$mysql = conectar();

//receber os dados vindos do do formulário do perfil do coordenador de curso "perfil.php".

//O trim() em PHP é utilizado para remover os espaços em branco (ou outros caracteres) do início e do final de uma string. Isso é útil quando você deseja limpar entradas de dados de usuários ou formatar strings de maneira mais adequada.

//O real_escape_string() é usado para escapar caracteres especiais em uma string, tornando-a segura para ser usada em uma consulta SQL, evitando que caracteres especiais quebrem a excução do comando sql.

$id = $_POST['id'];
$nome = trim($mysql->real_escape_string($_POST['nome']));
$email = trim($_POST['email']);
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
