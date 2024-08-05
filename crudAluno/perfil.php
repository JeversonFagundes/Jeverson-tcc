<?php

// Conectar ao BD
require_once "../conecta.php";

//conectar com a proteção
require_once "../protecao.php";

//variável de conexão.
$mysql = conectar();

// Seleciona os dados da historia da tabela historia
$sql = "SELECT nome_aluno, matricula, email, id_curso, id_aluno FROM aluno WHERE id_aluno = " . $_SESSION['aluno'][1];

// Executa o Select
$resultado = excutarSQL($mysql, $sql);

// Gera o vetor com os dados buscados
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
            <input type="text" value="<?php echo $aluno['nome_aluno']; ?>" name="nome"><br><br>

            <label for="matricula">Matricula: </label>
            <input type="text" value="<?php echo $aluno['matricula']; ?>" name="matricula"><br><br>

            <label for="email">Email: </label>
            <input type="email" value="<?php echo $aluno['email']; ?>" name="email"><br><br>

            <?php

            //selecionar os itens.
            $sql = "SELECT id_curso, nome_curso FROM curso ORDER BY nome_curso ASC";
            $resultado = excutarSQL($mysql, $sql);

            ?>

            <label for="curso">Selecione o seu curso</label>

            <select id="curso" name="curso">

                <?php

                while ($dados = mysqli_fetch_assoc($resultado)) {

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