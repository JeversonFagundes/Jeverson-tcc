<?php

    //NOTIFICAÇÕES.PHP

//Esse é o arquivo onde são geradas as notificações do sistema.

//devemos incluir este arquivo onde irão aparecer notificações do sistema. Como iniciamos a sessão aqui, quando incluimos em outro arquivo, não iremos iniciar outra.

//iniciar a sessão.
session_start();

//o comando session_regenerate_id(true) serve para gerar um novo ID para sessão, removendo a sessão antiga, ajudando a proteger contra possíveis ataques.
session_regenerate_id(true);

//criar a função que recebe o tipo de notificação (de sucesso, erre etc) e a notificação (mensagem que aparece para o usuário que excutou a ação).
function notificacoes($tipoNotificacao, $notificacao){
    
    //tendo o tipo de notificação e notificação em mãos, agora atribuimos esses valores a uma sesão.
    $_SESSION['notificacoes'][0] = $tipoNotificacao;
    $_SESSION['notificacoes'][1] = $notificacao;
}