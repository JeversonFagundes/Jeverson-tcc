<?php

//conectar com o banco de dados.
require_once "../conecta.php";

//variavel de conexão.
$mysql = conectar();

if ($_POST['deferir']) {

    //receber os dados.
    $id = $_POST['id_atividade'];
    $cargaDefe = $_POST['cargaDefe'];
    $situacao = "Deferido";
    $id_aluno = $_POST['aluno'];

    $sql = "UPDATE entrega_atividade SET carga_horaria_aprovada = $cargaDefe, status = '$situacao' WHERE id_entrega_atividade = $id";

    excutarSQL($mysql, $sql);

    header("location: validar.php?id=" . $id_aluno);
} else {

    if ($_POST['indeferir']) {

        //receber os dados.
        $natureza = $_POST['natureza'];
        $id = $_POST['id_atividade'];
        $cargaDefe = 0;
        $situacao = "Indeferido";
        $id_aluno = $_POST['aluno'];

        $sql = "UPDATE entrega_atividade SET carga_horaria_aprovada = $cargaDefe, status = '$situacao' WHERE id_entrega_atividade = $id";

        excutarSQL($mysql, $sql);

        header("location: validar.php?id=" . $id_aluno);
    }
}
