<?php

//este é o arquivo de conexão com o banco de dados jeverson_tcc.

//Informações necessárias:
$bdServidor = "localhost";
$bdUsuario = "root";
$bdSenha = "";
$bdBanco = "jeverson_tcc";

$mysql = mysqli_connect($bdServidor, $bdUsuario, $bdSenha, $bdBanco);

//caso algum erro na conexão.
if ($mysql->error) {
    
    die("Falha na conexão com o banco de dados: " . $mysql->error);
    
}else {


}

?>