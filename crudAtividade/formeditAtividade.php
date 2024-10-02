<?php
//buscar da url o valor necessário para buscar pela atividade que o coordenador de curso deseja alterar.
$id = $_GET['id'];

//conectar com o banco de dados jeverson-tcc.
require_once "../conecta.php";

//declarar a variavel de conexão com o banco de dados jeverson-tcc. Essa variavél vem do arquivo conecta.php.
$mysql = conectar();

//atribuir a veriavél sql ($sql) a busca pelos dados do atividade_complementar que o coordenador de curso selecionou para á alteração.
$sql = "SELECT * FROM atividade_complementar WHERE id_atividade_complementar = $id";

//atribuir a variavél resultado ($resultado) a execução do comando sql ($sql).
$resultado = excutarSQL($mysql, $sql);

//atribuir a variavél dados ($dados) o array associativo com os valores gerados da execução do comando sql.
$dados = mysqli_fetch_assoc($resultado);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>