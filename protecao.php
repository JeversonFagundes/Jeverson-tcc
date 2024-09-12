<?php

//PROTECAO.PHP

//Neste arquivo são feitas as verificações de proteção do sistema.

//iniciar as variaveis de sessão ativas no momento.
session_start();

//o comando session_regenerate_id(true) serve para gerar um novo ID para sessão, removendo a sessão antiga, ajudando a proteger contra possíveis ataques.
session_regenerate_id(true);
