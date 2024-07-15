<?php

if (!isset($_SESSION)) {
    session_start();
}

//conectar com o banco de dados.
include("../conecta.php");

$sql1 = "SELECT * FROM entrega_atividade WHERE id_aluno = " . $_SESSION['aluno'][1];

$query = mysqli_query($mysql, $sql1);

$quantidade = $query->fetch_assoc();

if ($quantidade != 0) {

    echo "Você não pode excluir esta conta! Pois há atividades cadastradas no sistema.<p><a href = \"../inicialAluno.php\">Voltar</a></p>";
} else {

    $sql = "DELETE FROM aluno WHERE id_aluno = " . $_SESSION['aluno'][1];

    mysqli_query($mysql, $sql);

    if ($mysql->error) {

        die("Falha ao excluir sua conta !" . $mysql->error);
    } else {

        header("location: ../logout.php");
    }
}
