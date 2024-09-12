<?php

//HEADERNAV.PHP

//o comando basename($_SERVER['SCRIPT_NAME']) é usado para obter o nome do arquivo atual.

//atribuir a variavél $pagina_corrente o valor do nome do arquivo atual.
$pagina_corrente = basename($_SERVER['SCRIPT_NAME']);

//com o nome do arquivo atual podemos fazer as devidas verificações para que o usuário possa navegar corretamente.
if ($pagina_corrente == 'inicialAluno.php') {

    $perfil = '<li><a href="crudAluno/perfil.php">Perfil</a></li>';

    $sair = '<li><a href="logout.php">Sair</a></li>';
} else {

    if ($pagina_corrente == 'inicialCoordenador.php') {

        $perfil = '<li><a href="crudContaCo/perfil.php">Perfil</a></li>';

        $sair = '<li><a href="logout.php">Sair</a></li>';
    } else {

        if ($pagina_corrente == 'inicialAdmin.php') {

            $perfil = '<li><a href="perfil.php">Perfil</a></li>';

            $sair = '<li><a href="logout.php">Sair</a></li>';
        }
    }
}
?>

<header>
    <nav>
        <ul>
            <?php echo $perfil ?>
            <?php echo $sair ?>
        </ul>
    </nav>
</header>