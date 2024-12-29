<?php

//conectar com o banco de dados jeverson-tcc.
require_once "../conecta.php";

//incluir o arquivo de notificações do sistema.
require_once "../boasPraticas/notificacoes.php";

//declarar a variavel de conexão com o banco de dados jeverson-tcc. Essa variavel vem do arquivo conecta.php..
$mysql = conectar();

//receber os dados vindos do formulário de cadastro de atividades complementares de curso que está no arquivo formcadatividade.php.

//O trim() em PHP é utilizado para remover os espaços em branco (ou outros caracteres) do início e do final de uma string. Isso é útil quando você deseja limpar entradas de dados de usuários ou formatar strings de maneira mais adequada.

$natureza = trim($_POST['natureza']);
$carga = trim($_POST['carga']);
$descricao = trim($_POST['descricao']);
$curso = $_POST['curso'];

//atribuir a veriavél sql ($sql) o comando sql de inserção no banco de dados.
$sql = "INSERT INTO atividade_complementar (natureza, descricao, carga_horaria_maxima, id_curso) VALUES ('$natureza', '$descricao', $carga, $curso)";

//excutar o comando sql ($sql).
excutarSQL($mysql, $sql);

//gerar a notificação de um novo aluno cadastrado no sistema.
notificacoes(1, "Cadastro da atividade complementar realizada com sucesso!");

//redirecionar o coordenador de novamente para a sua tela inicial.
header("location: formcadAtividade.php");
