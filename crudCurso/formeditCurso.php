<?php
// Recebe o id da historia
$id = $_GET['id'];

// Conectar ao BD
require_once "../conecta.php";

//variavel de conexão.
$mysql = conectar();

// Seleciona os dados da historia da tabela historia
$sql = "SELECT * FROM curso WHERE id_curso = $id";

// Executa o Select
$resultado = excutarSQL($mysql, $sql);

// Gera o vetor com os dados buscados
$dados = mysqli_fetch_assoc($resultado);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar um curso</title>

</head>

<body>

    <h1>Formulário de alteração dos cursos!</h1>

    <form action="editarCurso.php" method="post">

        <label for="nome">Nome do curso:</label>
        <input type="text" value="<?php echo $dados['nome_curso']; ?>" name="nome"><br><br>

        <label for="carga">Carga horaria do curso</label>
        <input type="text" value="<?php echo $dados['carga_horaria']; ?>" name="carga"><br><br>

        <input type="hidden" value="<?php echo $dados['id_curso']; ?>" name="id" />

        <input type="submit" value="Alterar">
    </form>

    <button><a href="../inicialAdmin.php">Voltar</a></button>

</body>

</html>