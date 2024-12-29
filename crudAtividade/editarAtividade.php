<?php

//EDITARATIVIDADE.PHP

//conectar com o banco de dados jeverson-tcc.
require_once "../conecta.php";

//incluir o arquivo de notificações do sistema.
require_once "../boasPraticas/notificacoes.php";

//declarar a variavál de conexão com o banco de dados jeverson-tcc.
$mysql = conectar();

//receber os dados vindos do formulário de alteração de curso. Esses dados vem do arquivo formeditatividade.php

//O trim() em PHP é utilizado para remover os espaços em branco (ou outros caracteres) do início e do final de uma string. Isso é útil quando você deseja limpar entradas de dados de usuários ou formatar strings de maneira mais adequada.

$id = $_POST['id'];
$natureza = trim($_POST['natureza']);
$descricao = trim($_POST['descricao']);
$carga = trim($_POST['carga']);
$curso = $_POST['curso'];

//atribuir a veriavél sql ($sql) o comando de alteração no banco de dados.
$sql = "UPDATE atividade_complementar SET natureza = '$natureza', carga_horaria_maxima = $carga, descricao = '$descricao' WHERE id_atividade_complementar = $id";

//excutar o comando sql ($sql).
excutarSQL($mysql, $sql);

//gerar a notificação de um novo aluno cadastrado no sistema.
notificacoes(1, "Alterações na atividade complementar realizadas com sucesso!");

//redirecionar o coordenador de curso novamente para a tela de alterações da atividade.
header("location: formeditAtividade.php?id=$id");
