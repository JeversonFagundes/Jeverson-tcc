<?php

//PERFIL.PHP

//incluir o arquivo com as notificações do sistema para os alunos.
require_once "../boasPraticas/notificacoes.php";

// Conectar ao banco de dados jeverson-tcc.
require_once "../conecta.php";

//declarar a variável de conexão com o banco de dados jeverson-tcc. Esta veriavél vem do arquivo conecta.php.
$mysql = conectar();

// atribuir a variavél sql ($sql) a busca pelos dados do aluno que estpa logado no sistema no momento.
$sql = "SELECT nome, matricula, email, id_curso, id_aluno FROM aluno WHERE id_aluno = " . $_SESSION['aluno'][1];

//atribuir a variavél resultado ($resultado) o valor da execução do comando sql ($sql).
$resultado = excutarSQL($mysql, $sql);

//atribuir a variavél a aluno ($launo) o array associativo com os valores retornados da busca pelos dados do aluno.
$aluno = mysqli_fetch_assoc($resultado);

?>

<!DOCTYPE html>
<html lang="pt_br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Import Google Icon Font-->
    <!--<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">-->
    <!--Import materialize.css-->
    <!--<link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />-->
    <title>Editar sua conta</title>


</head>

<body>

    <main class="text-center">
        <h1>Informações da sua conta!</h1>

        <?php

        //chamar a função que exibe a notificação
        exibirNotificacoes();

        //chamar a função que limpa a notificação da sessão.
        limpaNotificações();
        ?>

        <form action="editarAluno.php" method="post">

            <label for="nome">Nome: </label>
            <input type="text" value="<?php echo $aluno['nome']; ?>" name="nome"><br><br>

            <label for="matricula">Matricula: </label>
            <input type="text" value="<?php echo $aluno['matricula']; ?>" name="matricula"><br><br>

            <label for="email">Email: </label>
            <input type="email" value="<?php echo $aluno['email']; ?>" name="email"><br><br>

            <?php

            //atribuir a variavél sql2 ($sql2) a busca por todos os cursos cadastrados no sistema e ordená-los por ordem alfabéticaF
            $sql2 = "SELECT id_curso, nome_curso FROM curso ORDER BY nome_curso ASC";

            //atribuir a variavél resultado2 ($resultado2) a excução do comando sql2 ($sql2).
            $resultado2 = excutarSQL($mysql, $sql2);

            ?>

            <label for="curso">Selecione o seu curso:</label>

            <!--Declarar um campo de selecão com as opções de curso que o aluno pode escolher para trocar o seu curso atual.-->
            <select id="curso" name="curso">

                <?php

                //dentro do campo de seleção atribuimos a veriavél dados ($dados) o array associativo com os valores do resultado da excução do comando sql2 ($sql2) que será repetido enquanto houver dados.
                while ($dados = mysqli_fetch_assoc($resultado2)) {

                ?>

                    <!--declarar o option que nada mais é do que as opções do select. Este option tem os valores que queremos do array associativo dados ($dados).-->
                    <option <?php

                            //aqui fazemos uma verificação de todos os cursos cadastrados no sistema, qual é o do aluno que está logado no momento e atribuimos o comando selected "seleciionado", ou  seja, a lista de opções já vai vir selecionada com o nome do curso do aluno que está logado no sistema. No caso está verificação sempre vai ser atendida, porque o aluno está logado no sistema, ou seja, ele está cadastrado no banco de dados e se ele esta cadastrado, ele tem que ter abrigatóriamente um curso
                            if ($aluno['id_curso'] == $dados['id_curso']) {

                                echo "selected";
                            }
                            ?> value="<?php echo $dados['id_curso'] ?>">
                        <?php echo $dados['nome_curso'] ?>
                    </option>
                <?php
                }
                ?>

            </select><br><br>

            <input type="hidden" value="<?php echo $aluno['id_aluno']; ?>" name="id">

            <input type="submit" value="Editar"><br><br>



        </form>

        <button id="btnExcluir" class="btn-excluir">Excluir sua conta</button>

        <p>Deseja <a href="../inicialAluno.php">Voltar!</a></p>

    </main>

    <!--Import jQuery before materialize.js-->
    <!--<script type="text/javascript" src="js/materialize.min.js"></script>-->

    <script>
        document.getElementById('btnExcluir').addEventListener('click', function() {
            let primeiraConfirmacao = confirm("Fique ciente de que realizar essa ação irá excluir todos os dados da sua conta e também as atividades que você entregou no sistema. Deseja excluir sua conta?");
            if (primeiraConfirmacao) {
                let segundaConfirmacao = confirm("Confirmar exclusão");
                if (segundaConfirmacao) {
                    window.location.href = 'excluirAluno.php';
                }
            }
        });
    </script>
</body>

</html>