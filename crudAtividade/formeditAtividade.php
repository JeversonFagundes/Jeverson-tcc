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
    <!--Import Google Icon Font-->
    <!--<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">-->
    <!--Import materialize.css-->
    <!--<link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />-->
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

    <!--Import jQuery before materialize.js-->
    <!--<script type="text/javascript" src="js/materialize.min.js"></script>-->
</body>

</html>