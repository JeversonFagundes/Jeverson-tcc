<?php
$paginaCorrente = basename($_SERVER['SCRIPT_NAME']);
// Obtém o nome do arquivo atual e o armazena na variável $paginaCorrente.
// basename() retorna o nome do arquivo a partir de um caminho completo, e $_SERVER['SCRIPT_NAME'] fornece o caminho do script sendo executado.
?>

<div class="navbar-fixed">
    <!-- Cria um contêiner fixo para a barra de navegação. -->
    <nav class="brown  lighten-3">
        <!-- Define a barra de navegação com uma cor marrom clara. -->
        <div class="nav-wrapper container">
            <!-- Cria um contêiner para o conteúdo da navegação. -->
            <a href="#" data-target="mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <!-- Cria um ícone de menu para a navegação móvel. -->

            <ul class="right hide-on-med-and-down">
                <!-- Cria uma lista de navegação que é ocultada em dispositivos médios e pequenos. -->

                <li <?php if ($paginaCorrente == 'inicialAluno.php') {
                        echo 'class="active"';
                    } ?>>
                    <!-- Verifica se a página atual é inicialAluno.php e, se for, adiciona a classe "active" ao item da lista. -->
                    <a class="black-text" <?php if ($paginaCorrente != 'inicialAluno.php') {
                                                echo 'href="/Jeverson-tcc/inicialAluno.php"';
                                            } ?>>Tela inicial</a>
                    <!-- Se a página atual não for inicialAluno.php, define o atributo href para redirecionar para inicialAluno.php. Caso contrário, não faz nada. -->
                </li>

                <li <?php if ($paginaCorrente == 'perfilAluno.php') {
                        echo 'class="active"';
                    } ?>>
                    <!-- Verifica se a página atual é inicialAluno.php e, se for, adiciona a classe "active" ao item da lista. -->
                    <a class="black-text" <?php if ($paginaCorrente != 'inicialAluno.php') {
                                                echo 'href="/Jeverson-tcc/inicialAluno.php"';
                                            } ?>>Perfil</a>
                    <!-- Se a página atual não for inicialAluno.php, define o atributo href para redirecionar para inicialAluno.php. Caso contrário, não faz nada. -->
                </li>

                <li <?php if ($paginaCorrente == 'quem.php') {
                        echo 'class="active"';
                    } ?>>
                    <!-- Verifica se a página atual é quem.php e, se for, adiciona a classe "active" ao item da lista. -->
                    <a class="black-text" href="/quem.php">Nós!</a>
                    <!-- Define o link para /quem.php. -->
                </li>

                <li <?php if ($paginaCorrente == 'login.php') {
                        echo 'class="active"';
                    } ?>>
                    <!-- Verifica se a página atual é login.php e, se for, adiciona a classe "active" ao item da lista. -->
                    <a class="black-text" href="/login.php">Login</a>
                    <!-- Define o link para /login.php. -->
                </li>

                <li <?php if ($paginaCorrente == 'destinos.php') {
                        echo 'class="active"';
                    } ?>>
                    <!-- Verifica se a página atual é destinos.php e, se for, adiciona a classe "active" ao item da lista. -->
                    <a class="black-text" href="/destinos.php">Destinos</a>
                    <!-- Define o link para /destinos.php. -->
                </li>
            </ul>
        </div>
    </nav>
</div>