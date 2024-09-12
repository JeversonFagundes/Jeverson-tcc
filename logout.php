<?php

//LOGOUT.PHP

//iniciar as veriaveis de sessão ativas no momento.
session_start();

//destrui-lás
session_destroy();

//e redirecionar o usuário para a tela de login.
header("location: index.php");
