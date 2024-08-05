<?php

if (!isset($_SESSION)) {
    session_start();
}

//conectar com o banco de dados.
require_once "../conecta.php";

//variável de conexão.
$mysql = conectar();

$sql1 = "SELECT * FROM entrega_atividade WHERE id_aluno = " . $_SESSION['aluno'][1];

$query = excutarSQL($mysql, $sql1);

$quantidade = $query->fetch_assoc();

if ($quantidade != 0) {

    echo "Você não pode excluir esta conta! Pois há atividades cadastradas no sistema.<p><a href = \"../inicialAluno.php\">Voltar</a></p>";
} else {

    $sql = "DELETE FROM aluno WHERE id_aluno = " . $_SESSION['aluno'][1];

    excutarSQL($mysql, $sql);

    header("location: ../logout.php");
}
