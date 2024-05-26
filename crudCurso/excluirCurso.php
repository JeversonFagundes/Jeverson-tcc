<?php

// Conectar ao BD
include("../conecta.php");

// receber os dados do formulário
$id = $_GET['id'];

//comando sql.
$sql = "DELETE FROM curso WHERE id_curso = $id";

//excutar o comando sql acima.
mysqli_query($mysql, $sql);

//caso de erro
if ($mysql->error) {
    
    die ("Falha ao excluir este curso no sistema!" . $mysql->error);

}else {
    
    header("location: ../inicialAdmin.php");
}

?>