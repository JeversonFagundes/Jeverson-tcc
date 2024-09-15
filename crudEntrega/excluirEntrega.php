<?php

//EXCLUIRENTREGA.PHP

//conectar com o banco de dados jeverson-tcc
require_once "../conecta.php";

//declarara a variavel de conexão com o banco de dados jeverson-tcc.
$mysql = conectar();

//buscar da url os valores necessários para a exclução do arquivo do banco de dados.
$id = $_GET['id'];

//declarar a pasta de destino.
$pastaDestino = "../certificados/";

//atribuir a variavél sq ($sql) a busca pelo caminho do arquivo que foi cadastrado no sistema.
$sql = "SELECT caminho FROM entrega_atividade WHERE id_entrega_atividade = $id";

//atribuir a variavál resultado ($resultado) a execução do comando sql ($sql).
$resultado = excutarSQL($mysql, $sql);

//atribuir a variavél result ($result) o array associativo que foi gerado na busca pelo caminho do arquivo que se deseja excluir.
$result = $resultado->fetch_assoc();

//atribuir a variavél caminho ($caminho) o valor de $result.
$caminho = $result['caminho'];

//atribuir a variavél sql2 ($sql2) o comando para a exclusão do arquivo do banco de dados.
$sql2 = "DELETE FROM entrega_atividade WHERE id_entrega_atividade = $id";

//excutar o comando sql2 ($sql2).
excutarSQL($mysql, $sql2);

//"unlink()" é utilizado para deletar um arquivo do sistema de arquivos.

//excluir da pasta destino o arquivo que acabou de ser excluido do banco de dados.
unlink($pastaDestino . $caminho);

//redirecionar o aluno para a sua tela inicial.
header("location: ../inicialAluno.php");
