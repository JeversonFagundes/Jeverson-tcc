<?php

//conectar com o banco de dados.
include ("../conecta.php");

//receber os dados.
$nome = $_POST['nome'];
$curso = $_POST['curso'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$id = $_POST['id'];

//comando sql.
$sql = "UPDATE coordenador_curso SET nome_coordenador = '$nome', email = '$email', senha = '$senha', id_curso = $curso WHERE id_coordenador = $id";

//excutar o comando sql acima.
mysqli_query($mysql, $sql);

//caso dê algum erro.
if ($mysql->error) {
    
    die ("Falha ao alterar um coordenador de curso no sistema!" . $mysql->error);

}else {
    
    header("location: ../inicialAdmin.php");
}
?>