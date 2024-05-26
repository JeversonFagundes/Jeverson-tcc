<?php

// Conectar ao BD
include("../conecta.php");

// receber os dados do formulário
$id = $_GET['id'];

$sql2 = "SELECT caminho FROM entrega_atividade WHERE id_entrega_atividade = $id";

$resultado = mysqli_query($mysql, $sql2);

$result = $resultado->fetch_assoc();

$caminho = $result['caminho'];

$sql = "DELETE FROM entrega_atividade WHERE id_entrega_atividade = $id";

//excutar o comando sql.
mysqli_query($mysql, $sql);

if ($mysql->error) {
    
    die ("Falha ao exckuir está atividade complementar entregue no sistema!");

}else {
    
    unlink($caminho);

    header("location: ../inicialAluno.php");

}
?>