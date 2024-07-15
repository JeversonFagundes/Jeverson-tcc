<?php

/** 
 *Faz uma conexão com o banco de dados MYSQL.
 *na base de dados recuperar-senha.
 *
 * @return \mysqli  uma conexão conexão com o banco de dados, ou 
 * em caso de falha, mata a excução e exibe o erro
 */
function conectar()
{

    require_once "config.php";

    $mysql = mysqli_connect(

        $config['host'],
        $config['user'], 
        $config['password'], 
        $config['banco']
    
    );

    if ($mysql === false) {

        echo "Erro ao conectar com o banco de dados. N° do erro:" . mysqli_connect_errno() . " " . mysqli_connect_error();

        die();
    }

    return $mysql;
}

function excutarSQL($mysql, $sql)
{

    $resultado = mysqli_query($mysql, $sql);

    if ($resultado === false) {

        echo "Erro ao excutar o comando sql" . ' ' . mysqli_errno($mysql) . ' ' . ':' . ' ' . mysqli_error($mysql);

        die ();
    }

    return $resultado;
}
