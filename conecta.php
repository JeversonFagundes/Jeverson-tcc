<?php

                                 //CONECTA.PHP

/** 
 *Faz uma conexão com o banco de dados MYSQL.
 *na base de dados jeverson-tcc.
 *
 * @return \mysqli  uma conexão conexão com o banco de dados, ou 
 * em caso de falha, mata a excução e exibe o erro
 */
function conectar()
{

    //incluir o arquivo com os dados necessários para poder realizar a conexão com o banco de dados jeverson-tcc
    require_once "config2.php";

    //criar a conexão.
    $mysql = mysqli_connect(

        $config['host'],
        $config['user'],
        $config['password'],
        $config['banco']

    );

    //verificar se houve falha na conexão com o banco de dados
    if ($mysql === false) {

        echo "Erro ao conectar com o banco de dados. N° do erro:" . mysqli_connect_errno() . " " . mysqli_connect_error();

        die();
    }

    return $mysql;
}

//função criada para que não seja feito mysqli_query() toda vez que temos que excutar comandos em sql.
function excutarSQL($mysql, $sql)
{

    $resultado = mysqli_query($mysql, $sql);

    if ($resultado === false) {

        echo "Erro ao excutar o comando sql" . ' ' . mysqli_errno($mysql) . ' ' . ':' . ' ' . mysqli_error($mysql);

        die();
    }

    return $resultado;
}
