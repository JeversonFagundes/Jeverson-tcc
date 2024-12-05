<?php

function verificarConexaoInternet($url = 'http://www.google.com')
{
    $conectado = @fsockopen($url, 80);
    if ($conectado) {
        fclose($conectado);
        return true;
    } else {
        return false;
    }
}

if (verificarConexaoInternet()) {
    echo "Conectado à internet.";
} else {
    echo "Sem conexão com a internet.";
}
