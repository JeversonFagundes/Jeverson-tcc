<?php

//conectar com o banco de dados.
include ("../conecta.php");

//receber os dados.
$nome = $_POST['nome'];
$curso = $_POST['curso'];
$email = $_POST['email'];
$senha = $_POST['senha'];

//comando sql.
$sql = "INSERT INTO coordenador_curso (nome_coordenador, email, senha, id_curso) VALUES ('$nome', '$email', '$senha', $curso)";

//excutar o comando sql acima.
mysqli_query($mysql, $sql);

//caso dê algum erro.
if ($mysql->error) {
    
    die ("Falha ao cadastrar um coordenador de curso no sistema! " . $mysql->error);

}else {
    
    header("location: ../inicialAdmin.php");
}
?>