<?php

//conectar com o banco de dados.
include("conecta.php");

if (isset($_POST['email']) and isset($_POST['senha'])) {

    if (strlen($_POST['email']) == 0) {

        echo "Preencha corretamente com o seu email!";
    } else {

        if (strlen($_POST['senha']) == 0) {

            echo "Preencha corretamente com a sua senha!";
        } else {

            //Limpar os campos.
            $email = $mysql->real_escape_string($_POST['email']);

            $senha = $mysql->real_escape_string($_POST['senha']);

            
        }
    }
}

