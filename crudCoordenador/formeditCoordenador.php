<?php
// Recebe o id da historia
$id = $_GET['id'];

// Conectar ao BD
require_once "../conecta.php";

//variavel de conexão.
$mysql = conectar();

// Seleciona os dados da historia da tabela historia
$sql = "SELECT * FROM coordenador_curso WHERE id_coordenador = $id";

// Executa o Select
$resultado = excutarSQL($mysql, $sql);

// Gera o vetor com os dados buscados
$coordenador = mysqli_fetch_assoc($resultado);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar um coordenador</title>

</head>

<body>

    <h1>Formulário de alteração de um coordenador!</h1>

    <form action="editarCoordenador.php" method="post">

        <label for="nome">Nome do coordenador de curso:</label>
        <input type="text" value="<?php echo $coordenador['nome_coordenador']; ?>" name="nome"><br><br>

        <?php

        //selecionar os itens.
        $sql2 = "SELECT id_curso, nome_curso FROM curso ORDER BY nome_curso ASC";
        $resultado2 = excutarSQL($mysql, $sql2);

        ?>

        <label for="curso">Selecione o seu curso:</label>
        <select id="curso" name="curso" required>

            <?php

            while ($dados = mysqli_fetch_assoc($resultado2)) {

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

        <label for="email">Email:</label>
        <input type="text" value="<?php echo $coordenador['email']; ?>" name="email"><br><br>

        <label for="senha">Senha:</label>
        <input type="text" value="<?php echo $coordenador['senha']; ?>" name="senha"><br><br>

        <input type="hidden" value="<?php echo $coordenador['id_coordenador']; ?>" name="id" />

        <input type="submit" value="Alterar">
    </form>

    <button><a href="../inicialAdmin.php">Voltar</a></button>

</body>

</html>