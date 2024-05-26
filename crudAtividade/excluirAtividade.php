<?php

// Conectar ao BD
include("../conecta.php");

// receber os dados do formulário
$id = $_GET['id'];

//comando sql.
$sql = "DELETE FROM atividade_complementar WHERE id_atividade_complementar = $id";

//excutar o comando sql acima.
mysqli_query($mysql, $sql);

//caso de erro
if ($mysql->error) {
    
    die ("Falha ao excluir esta atividade complementar no sistema!" . $mysql->error);

}else {
    
    header("location: ../inicialCoordenador.php");
}

?>