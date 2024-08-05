<?php

$pagina_corrente = basename($_SERVER['SCRIPT_NAME']);

if ($pagina_corrente == 'inicialAluno.php') {
    
    $perfil = '<li><a href="crudAluno/perfil.php">Perfil</a></li>';

    $sair = '<li><a href="logout.php">Sair</a></li>';
}else {
    
    if ($pagina_corrente == 'inicialCoordenador.php') {
        
        $perfil = '<li><a href="crudContaCo/perfil.php">Perfil</a></li>';
        $sair = '<li><a href="logout.php">Sair</a></li>';
    }else {
        
        if ($pagina_corrente == 'inicialAdministrador.php') {
            
            $perfil = '<li><a href="perfil.php">Perfil</a></li>';
            $sair = '<li><a href="logout.php">Sair</a></li>';
        }
    }
}
?>

<header>
        <nav>
            <ul>
                <?php echo $perfil?>
                <?php echo $sair?>
            </ul>
        </nav>
    </header>