<?php
//conectar com o banco de dados.
include ("../conecta.php");

//receber os dados vindos do formulário de alteração de curso
$id = $_POST['id'];
$nome = $_POST['nome'];
$carga = $_POST['carga'];

//comando sql.
$sql = "UPDATE curso SET nome_curso = '$nome', carga_horaria = $carga WHERE id_curso = $id";

//excutar o comando sql acima.
mysqli_query($mysql, $sql);

//caso dê algum erro.
if ($mysql->error) {
    
    die ("Falha ao alterar este curso no sistema!" . $mysql->error);

}else {
    
    header("location: ../inicialAdmin.php");
}
?>