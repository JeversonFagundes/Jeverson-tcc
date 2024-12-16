<?php
function estaConectadoInternet()
{
    $conexao = @fsockopen("www.google.com", 80);
    if ($conexao) {
        fclose($conexao);
        return true;
    } else {
        return false;
    }
}

// Verificar a conexão com a internet
if (estaConectadoInternet()) {
    echo "Você está conectado à internet.";
} else {
    echo "Você não está conectado à internet.";
}
