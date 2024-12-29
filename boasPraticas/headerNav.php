<?php
$paginaCorrente = basename($_SERVER['SCRIPT_NAME']);
// Obtém o nome do arquivo atual e o armazena na variável $paginaCorrente.
// basename() retorna o nome do arquivo a partir de um caminho completo, e $_SERVER['SCRIPT_NAME'] fornece o caminho do script sendo executado.

if (isset($_SESSION['aluno'])) {

?>

    <!-- Navbar -->
    <nav>
        <div class="nav-wrapper blue"> <a href="#" data-target="mobile" class="sidenav-trigger"> <i class="material-icons" style="color: black;">menu</i> </a>
            <ul id="nav-mobile" class="left hide-on-med-and-down">
                <li><a <?php if ($paginaCorrente == 'inicialAluno.php') {
                            echo 'style="text-decoration: underline;"';
                        } ?> href="/jeverson-tcc/inicialAluno.php">Tela Inicial</a></li>
                <li><a <?php if ($paginaCorrente == 'formcadEntrega.php') {
                            echo 'style="text-decoration: underline;"';
                        } ?> href="/jeverson-tcc/crudEntrega/formcadEntrega.php">Entregar Atividade</a></li>
                <li><a <?php if ($paginaCorrente == 'perfilAluno.php') {
                            echo 'style="text-decoration: underline;"';
                        } ?> href="/jeverson-tcc/crudAluno/perfilAluno.php">
                        Perfil</a></li>
                <li><a href="/jeverson-tcc/logout.php">Sair</a></li>
            </ul>
        </div>
    </nav>

    <!-- Sidenav para Mobile -->
    <ul id="mobile" class="sidenav">
        <li><a href="/jeverson-tcc/inicialAluno.php"><i class="material-icons">home</i>Tela inicial</a></li>
        <li><a href="/jeverson-tcc/crudEntrega/formcadEntrega.php"><i class="material-icons">home</i>Entregar atividade</a></li>
        <li><a href="/jeverson-tcc/crudAluno/perfilAluno.php"><i class="material-icons">person_outline</i>Perfil</a></li>
        <li><a href="/jeverson-tcc/logout.php"><i class="material-icons">exit_to_app</i>Sair</a></li>

    </ul>

    <?php
} else {

    if (isset($_SESSION['coordenador'])) {

    ?>

        <!-- Navbar -->
        <nav>
            <div class="nav-wrapper blue"> <a href="#" data-target="mobile" class="sidenav-trigger"> <i class="material-icons" style="color: black;">menu</i> </a>
                <ul id="nav-mobile" class="left hide-on-med-and-down">
                    <li><a <?php if ($paginaCorrente == 'inicialCoordenador.php') {
                                echo 'style="text-decoration: underline;"';
                            } ?> href="/jeverson-tcc/inicialCoordenador.php">Tela Inicial</a></li>
                    <li><a <?php if ($paginaCorrente == 'formcadAtividade.php') {
                                echo 'style="text-decoration: underline;"';
                            } ?> href="/jeverson-tcc/crudAtividade/formcadAtividade.php">Cadastrar Atividade Complementar de Curso</a></li>
                    <li><a <?php if ($paginaCorrente == 'perfilCoordenador.php') {
                                echo 'style="text-decoration: underline;"';
                            } ?> href="/jeverson-tcc/crudContaCo/perfilCoordenador.php">
                            Perfil</a></li>
                    <li><a href="/jeverson-tcc/logout.php">Sair</a></li>
                </ul>
            </div>
        </nav>

        <!-- Sidenav para Mobile -->
        <ul id="mobile" class="sidenav">
            <li><a href="/jeverson-tcc/inicialCoordenador.php"><i class="material-icons">home</i>Tela inicial</a></li>
            <li><a href="/jeverson-tcc/crudAtividade/formcadAtividade.php"><i class="material-icons">home</i>Cadastrar Atividade</a></li>
            <li><a href="/jeverson-tcc/crudContaCo/perfilCoordenador.php"><i class="material-icons">person_outline</i>Perfil</a></li>
            <li><a href="/jeverson-tcc/logout.php"><i class="material-icons">exit_to_app</i>Sair</a></li>

        </ul>

        <?php
    } else {

        if (isset($_SESSION['administrador'])) {

        ?>

            <!-- Navbar -->
            <nav>
                <div class="nav-wrapper blue"> <a href="#" data-target="mobile" class="sidenav-trigger"> <i class="material-icons" style="color: black;">menu</i> </a>
                    <ul id="nav-mobile" class="left hide-on-med-and-down">
                        <li><a <?php if ($paginaCorrente == 'inicialAdmin.php') {
                                    echo 'style="text-decoration: underline;"';
                                } ?> href="/jeverson-tcc/inicialAdmin.php">Tela Inicial</a></li>
                        <li><a <?php if ($paginaCorrente == 'formcadcurso.php') {
                                    echo 'style="text-decoration: underline;"';
                                } ?> href="/jeverson-tcc/crudCurso/formcadcurso.php">Cadastrar curso</a></li>

                        <li><a <?php if ($paginaCorrente == 'formcadCoordenador.php') {
                                    echo 'style="text-decoration: underline;"';
                                } ?> href="/jeverson-tcc/crudCoordenador/formcadCoordenador.php">Cadastrar coordenador de curso</a></li>

                       
                        <li><a href="/jeverson-tcc/logout.php">Sair</a></li>
                    </ul>
                </div>
            </nav>

            <!-- Sidenav para Mobile -->
            <ul id="mobile" class="sidenav">
                <li><a href="/jeverson-tcc/inicialAdmin.php"><i class="material-icons">home</i>Tela inicial</a></li>
                <li><a href="/jeverson-tcc/crudCurso/formcadcurso.php"><i class="material-icons">border_color</i>Cadastrar curso</a></li>
                <li><a href="/jeverson-tcc/crudCoordenador/formcadCoordenador.php"><i class="material-icons">border_color</i>Cadastro Coordenador</a></li>
                <li><a href="/jeverson-tcc/logout.php"><i class="material-icons">exit_to_app</i>Sair</a></li>

            </ul>

<?php

        }
    }
}


?>