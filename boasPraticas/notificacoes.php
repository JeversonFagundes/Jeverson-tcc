<?php

    //NOTIFICAÇÕES.PHP

//Esse é o arquivo onde são geradas as notificações do sistema.

//devemos incluir este arquivo onde irão aparecer notificações do sistema. Como iniciamos a sessão aqui, quando incluimos em outro arquivo, não iremos iniciar outra.

//iniciar a sessão.
session_start();

//o comando session_regenerate_id(true) serve para gerar um novo ID para sessão, removendo a sessão antiga, ajudando a proteger contra possíveis ataques.
session_regenerate_id(true);

//criar a função que pega recebe as notificações do sistema.
function notificacoes($notificacoes){
    
    //tendo as notificações do sistema, atribuimos a notificação a uma sessão.
    $_SESSION['notificacoes'] = $notificacoes;
}