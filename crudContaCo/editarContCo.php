<?php
//conectar com o banco de dados.
include ("../conecta.php");

//receber os dados vindos do formulário de alteração de curso
$id = $_POST['id'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$curso = $_POST['curso'];

//comando sql.
$sql = "UPDATE coordenador_curso SET nome_coordenador = '$nome',  email = '$email', id_curso = '$curso' WHERE id_coordenador = $id";

//excutar o comando sql acima.
mysqli_query($mysql, $sql);

//caso dê algum erro.
if ($mysql->error) {
    
    die ("Falha ao alterar este aluno no sistema!" . $mysql->error);

}else {

    session_start();

    $_SESSION['coordenador'][0] = $nome;

    $_SESSION['coordenador'][2] = $curso;

    

    
    header("location: perfil.php");
}
?>