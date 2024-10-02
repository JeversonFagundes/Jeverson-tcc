<?php

//FORMEDITCURSO.PHP

//buscar da url os valores necessários para buscar pelas informações do curso que se deseja alterar.
$id = $_GET['id'];

//conectar com o banco de dados jeverson-tcc
require_once "../conecta.php";

//declarar a variavel de conexão com o banco de dados jeverson-tcc.
$mysql = conectar();

//atribuir a veriavél sql ($sql) a busca por todos os dados do curso.
$sql = "SELECT * FROM curso WHERE id_curso = $id";

//atribuir a veriavél resultado ($resultado) a execução do comando sql ($sql).
$resultado = excutarSQL($mysql, $sql);

//atribuir a variavél dados ($dados) os valores do array associativo gerado pela execução do comando sql ($sql).
$dados = mysqli_fetch_assoc($resultado);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>