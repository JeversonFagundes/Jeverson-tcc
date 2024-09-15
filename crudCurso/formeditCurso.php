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