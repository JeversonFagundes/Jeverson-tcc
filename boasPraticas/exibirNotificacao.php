<?php

//incluir o arquivo que armazena as notificações do sistema
include_once "notificacoes.php";


// Verificar se existe algum tipo de notificação no sistema
if (isset($_SESSION['notificacoes'][0])) {

    //se existir verificamos qual é o tipo de nificação que ha.
    if ($_SESSION['notificacoes'][0] == 1) {

        //criamos uma paragrafo para imprimir a notificação, verde é porque algo deu certo.
        echo '<p style="color: green;">' . $_SESSION['notificacoes'][1] . '</p>';
    } else {

        if ($_SESSION['notificacoes'][0] == 2) {

            // Se houver, criamos um parágrafo para imprimi-la
            echo '<p style="color: red;">' . $_SESSION['notificacoes'][1] . '</p>';
        }
    }
}
// Limpar a notificação da sessão
unset($_SESSION['notificacoes']);
