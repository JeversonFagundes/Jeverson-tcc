<?php

//conectar com o banco de dados.
include ("../conecta.php");

//receber os dados.
$natureza = $_POST['natureza'];
$carga = $_POST['carga'];
$descricao = $_POST['descricao'];
$curso = $_POST['curso'];

//comando sql.
$sql = "INSERT INTO atividade_complementar (natureza, descricao, carga_horaria_maxima, id_curso) VALUES ('$natureza', '$descricao', $carga, $curso)";

//excutar o comando acima.
mysqli_query($mysql, $sql);

//caso dê erro.
if ($mysql->error) {
    
    die ("Falha ao cadastrar uma atividade complementar no sistema!" . $mysql->error);

}else {

    header("location: ../inicialCoordenador.php");
}
?>