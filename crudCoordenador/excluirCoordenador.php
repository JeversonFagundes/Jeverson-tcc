<?php

// Conectar ao BD
include("../conecta.php");

// receber os dados do formulário
$id = $_GET['id'];

//comando sql.
$sql = "DELETE FROM coordenador_curso WHERE id_coordenador = $id";

//excutar o comando sql acima.
mysqli_query($mysql, $sql);

//caso de erro
if ($mysql->error) {
    
    die ("Falha ao excluir este coordenador de curso no sistema!" . $mysql->error);

}else {
    
    header("location: ../inicialAdmin.php");
}

?>