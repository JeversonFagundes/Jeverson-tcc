<?php

include ("../conecta.php");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de cadastro</title>

</head>

<body>
    
<h1>Formulário de cadastro</h1>

<form action="cadastrarAluno.php" method="post">

    <label for="nome">Nome: </label>
    <input type="text" name="nome" id="nome"><br><br>

    
    <?php

    //selecionar os itens.
    $sql = "SELECT id_curso, nome_curso FROM curso ORDER BY nome_curso ASC";
    $resultado = mysqli_query($mysql, $sql);
    ?>

    <select name="curso">

    <option selected disabled value="">Escolha um curso</option>
    
    <?php 
    
    while ($dados = mysqli_fetch_assoc($resultado)) { 
        
        ?>
        <option value="<?php echo $dados['id_curso'] ?>">

            <?php echo $dados['nome_curso'] ?>

        </option>
    <?php 
} 
?>

    </select><br><br>

    <label for="matricula">Matricula: </label>
    <input type="text" name="matricula" id="matricula"><br><br>

    <label for="email"> Email: </label>
    <input type="email" name="email" id="email"><br><br>

    <label for="senha">Senha:</label>
    <input type="password" name="senha" id="senha"><br><br>

    <input type="submit" value="Cadastrar"><br>

    <p><a href="../logout.php">Voltar</a></p>
</form>

</body>

</html>