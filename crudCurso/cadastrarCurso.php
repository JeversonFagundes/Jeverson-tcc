<?php

//conectar com o banco de dados.
include ("../conecta.php");

//receber os dados.
$nome_curso = $_POST['nome'];
$carga = $_POST['cargaHoraria'];

//comando sql.
$sql = "INSERT INTO curso (nome_curso, carga_horaria) VALUES ('$nome_curso', $carga)";

//excutar o comando sql acima.
mysqli_query($mysql, $sql);

//caso dê algum erro.
if ($mysql->error) {
    
    die ("Falha ao cadastrar um curso no banco de dados! " . $mysql->error);

}else {
    
    header("location: ../inicialAdmin.php");
}

?>