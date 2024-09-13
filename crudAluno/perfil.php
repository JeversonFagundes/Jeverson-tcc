<?php

//PERFIL.PHP

// Conectar ao banco de dados jeverson-tcc.
require_once "../conecta.php";

//conectar com a o arquivo onde é feita a proteção do sistema.
require_once "../protecao.php";

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
    <title>Editar sua conta</title>


</head>

<body>

    <main>
        <h1>Informações da sua conta!</h1>

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

            
            <select id="curso" name="curso">

                <?php

                while ($dados = mysqli_fetch_assoc($resultado2)) {

                ?>
                    <option <?php

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

        <button><a href="excluirAluno.php">Excluir sua conta!</a></button><br><br>

        <p>Deseja <a href="../inicialAluno.php">Voltar!</a></p>

    </main>

</body>

</html>