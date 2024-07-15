<?php
//conectar com o banco de dados.
include ("../conecta.php");

//receber os dados vindos do formulário de alteração de curso
$id = $_POST['id'];
$nome = $_POST['nome'];
$matricula = $_POST['matricula'];
$email = $_POST['email'];
$curso = $_POST['curso'];
$senha = $_POST['senha'];

//comando sql.
$sql = "UPDATE aluno SET nome_aluno = '$nome', matricula = '$matricula', email = '$email', senha = '$senha', id_curso = '$curso' WHERE id_aluno = $id";

//excutar o comando sql acima.
mysqli_query($mysql, $sql);

//caso dê algum erro.
if ($mysql->error) {
    
    die ("Falha ao alterar este aluno no sistema!" . $mysql->error);

}else {

    session_start();

    $_SESSION['aluno'][0] = $nome;

    $_SESSION['aluno'][2] = $curso;
    
    header("location: perfil.php");
}
?>