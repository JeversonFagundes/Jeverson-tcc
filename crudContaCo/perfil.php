<?php

// Conectar ao BD.
require_once "../conecta.php";

//incluir a protação.
require_once "../protecao.php";

//variavel de conexão.
$mysql = conectar();

// Seleciona os dados da historia da tabela historia
$sql = "SELECT nome, email, id_curso, id_coordenador FROM coordenador_curso WHERE id_coordenador = " . $_SESSION['coordenador'][1];

// Executa o Select
$resultado = excutarSQL($mysql, $sql);

// Gera o vetor com os dados buscados
$coordenador = mysqli_fetch_assoc($resultado);

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

    <h1>Informações da sua conta!</h1>

    <form action="editarContCo.php" method="post">

        <label for="nome">Nome: </label>
        <input type="text" value="<?php echo $coordenador['nome']; ?>" name="nome"><br><br>

        <label for="email">Email: </label>
        <input type="email" value="<?php echo $coordenador['email']; ?>" name="email"><br><br>

        <?php

        //selecionar os itens.
        $sql = "SELECT id_curso, nome_curso FROM curso ORDER BY nome_curso ASC";
        $resultado = excutarSQL($mysql, $sql);

        ?>

        <label for="curso">Selecione o seu curso: </label>
        <select id="curso" name="curso" required>

            <?php

            while ($dados = mysqli_fetch_assoc($resultado)) {

            ?>
                <option <?php

                        if ($coordenador['id_curso'] == $dados['id_curso']) {

                            echo "selected";
                        }
                        ?> value="<?php echo $dados['id_curso'] ?>">
                    <?php echo $dados['nome_curso'] ?>
                </option>
            <?php
            }
            ?>

        </select><br><br>

        <input type="hidden" value="<?php echo $coordenador['id_coordenador']; ?>" name="id">

        <input type="submit" value="Editar"><br><br>



    </form>

    <button><a href="excluirContCo.php">Excluir sua conta!</a></button><br><br>

    <p>Deseja <a href="../inicialCoordenador.php">Voltar!</a></p>


</body>

</html>