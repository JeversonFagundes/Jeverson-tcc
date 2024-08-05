<?php
// Recebe o id da historia
$id = $_GET['id'];

// Conectar ao BD
require_once "../conecta.php";

//variavel de conexão.
$mysql = conectar();

// Seleciona os dados da historia da tabela historia
$sql = "SELECT * FROM atividade_complementar WHERE id_atividade_complementar = $id";

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
    <title>Alterar um atividade complementar</title>

</head>

<body>

    <h1>Formulário de alteração de atividade complementar!</h1>

    <form action="editarAtividade.php" method="post">

        <label for="nome">Natureza:</label>
        <input type="text" value="<?php echo $dados['natureza']; ?>" name="natureza"><br><br>

        <label for="carga">Carga horaria máxima da atividade</label>
        <input type="text" value="<?php echo $dados['carga_horaria_maxima']; ?>" name="carga"><br><br>

        <label for="descricao">Descrição</label><br>
        <textarea name="descricao" id="texto" cols="30" rows="10"><?php echo $dados['descricao']; ?></textarea><br><br>

        <input type="hidden" value="<?php echo $dados['id_atividade_complementar']; ?>" name="id">

        <input type="submit" value="Alterar"><br><br>
    </form>

    <button><a href="../inicialCoordenador.php">Voltar</a></button>

</body>

</html>