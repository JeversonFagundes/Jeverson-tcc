<?php
//conectar com o banco de dados.
include ("../conecta.php");

//receber os dados vindos do formulário de alteração de curso
$id = $_POST['id'];
$natureza = $_POST['natureza'];
$descricao = $_POST['descricao'];
$carga = $_POST['carga'];
$curso = $_POST['curso'];

//comando sql.
$sql = "UPDATE atividade_complementar SET natureza = '$natureza', carga_horaria_maxima = $carga, descricao = '$descricao' WHERE id_atividade_complementar = $id";

//excutar o comando sql acima.
mysqli_query($mysql, $sql);

//caso dê algum erro.
if ($mysql->error) {
    
    die ("Falha ao alterar esta atividade complementar no sistema!" . $mysql->error);

}else {
    
    header("location: ../inicialCoordenador.php");
}
?>