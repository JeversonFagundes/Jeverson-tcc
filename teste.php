<?php

//FORCADALUNO.PHP

//inicluir o arquivo que exibe as notificações do sistema.
require_once "boasPraticas/notificacoes.php";

//conectar ao banco de dados jeverson-tcc.
require_once "conecta.php";

//declarar a veriavél de conexão com o banco de dados jeverson-tcc. Essa veriavél vem do arquivo conecta.php.
$mysql = conectar();

$senha = "123";

$senha1 = password_hash($senha,  PASSWORD_ARGON2ID);

echo "$senha1";

//buscar pelos curso de exibi-los em ordem alfabética.
$sql = "SELECT id_curso, nome_curso FROM curso ORDER BY nome_curso ASC";

//atribuir a veriavél resultado ($resultado) o valor da excução do comando sql ($sql).
$resultado = excutarSQL($mysql, $sql);
?>
