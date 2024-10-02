<?php

//EXCLUIR ALUNO.PHP

//iniciar as variaveis de sessão.
session_start();

//conectar com o banco de dados jeverson-tcc.
require_once "../conecta.php";

//declarar a variável de conexão com o banco de dados jeverson-tcc. Esta variavél de conexão vem do arquivo conecta.php.
$mysql = conectar();

//atribuir a variavél sql1 ($sql1) a busca na tabela de entrega_atividade, as atividades que foram entregues pelo respectivo a aluno que está logado no sistema no momento.
$sql1 = "SELECT * FROM entrega_atividade WHERE id_aluno = " . $_SESSION['aluno'][1];

//atribuir a veriavél query ($query) o valor a excução do comando sql1 ($sql1) de busca pelas atividades cadastradas no sistema pelo a aluno que quer excluir a sua conta.
$query = excutarSQL($mysql, $sql1);

//atribuir a variavél quantidade ($quantidade) o array associativo com os valores retornados na excução do comando sql1 ($sql1).
$quantidade = $query->fetch_assoc();

//se a quantidade de valores retornados for diferente de zero, ou seja, maior do zero, então quer dizer que o aluno em questão entregou atividades no sistema (cadastrou atividades no sistema) e por isso ele não pode excluir a sua conta antes de excluir as suas entregas de atividades porque seão o banco de dados ficará INCONSISTENTE, ele ficará com atividades cadastradas em nome de aluno que não existe mais.
if ($quantidade != 0) {

    echo "Você não pode excluir esta conta! Pois você entregou atividades no sistema.<p><a href = \"../inicialAluno.php\">Voltar</a></p>";
} else {

    //se a quantidade for zero, antão quer dizer que não tem atividades cadastradas a por isso o aluno pode excluir do sistema a sua conta.

    //atribuir a variavél sql ($sql) o comando de exclusão do aluno.
    $sql = "DELETE FROM aluno WHERE id_aluno = " . $_SESSION['aluno'][1];

    //excutar o comando sql ($sql) de exclusão do aluno.
    excutarSQL($mysql, $sql);

    //redirecionar o aluno para a página de logout onde aém de excluimos a sua conta do sistema, que foi o que acabamos de fazer, demos deloga-lo do sistema também.
    header("location: ../logout.php");
}

/*
$sql = "SELECT * FROM entrega_atividade WHERE id_aluno =". $_SESSION['aluno'][1];
$resultado = excutarSQL($mysql, $sql);

while ($dados = mysqli_fetch_assoc($resultado)) {
    
    unlink($pastaDestino . $dados['caminho']);

} 
*/

