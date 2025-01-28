<?php

//conectar com o banco de dados jeverson-tcc.
require_once "../conecta.php";

//incluir o arquivo de notificações do sistema.
require_once "../boasPraticas/notificacoes.php";

//declara a variavel de conexão com o banco de dados jeverson-tcc. Essa variavél vem do arquivo conecta.php.
$mysql = conectar();

//buscar o valor necessário para a exclusão da atividade_complementar. Esse valor vem do arquivo formeditatividade.php
$id = $_POST['id'];

//buscar pelas entregas de atividade complementares de curso relacionadas a à atividade complementar de curso que será excluida do sistema.
$sql_busca_chave_estrangeira = "SELECT * FROM entrega_atividade WHERE id_atividade_complementar = $id";

//executar o comando $sql_busca_chave_estrangeira.
$execucao_sql_busca_chave_estrangeira = excutarSQL($mysql, $sql_busca_chave_estrangeira);

//pegar a quantidade de linhas retornadas.
$quantidade_linhas = $execucao_sql_busca_chave_estrangeira->num_rows;

//verificar a quantidade de linhas afetadas.
if ($quantidade_linhas > 0) {

    //se a quantidade de linhas retornadas for maior do que 0, quer dizer que há entrega relacionadas com à atividade complementar de curso que se deseja excluir. Portanto não devemos deixar que o processo de exlusão continue.

    notificacoes(2, "Não é possível excluir esta atividade complementar de curso, pois há entregas relacionadas a ela!");

    header("location:formcadAtividade");

    die();
} else {

    //atribuir a veriavél sql ($sql) o comando para deletar a atividade_complementar do banco de dados.
    $sql = "DELETE FROM atividade_complementar WHERE id_atividade_complementar = $id";

    //excutar o comando sql ($sql).
    excutarSQL($mysql, $sql);

    notificacoes(1, "Atividade complementar de curso excluída com sucesso!");

    //redirecionar o coordenador de curso novamente para a sua tela inicial.
    header("location: formcadAtividade.php");
}
