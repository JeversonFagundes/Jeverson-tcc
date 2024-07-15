
<?php 

//conectar com o banco de dados.
include ("../conecta.php");

include ("../protecao.php");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de atividade complementar</title>

</head>

<body>

<h1>Formulário de cadastro de atividade complementar.</h1>

<form action="cadastrarAtividade.php" method="post">

<label for="natureza">Natureza da atividade complementar:</label>
<input type="text" name="natureza" id="natureza"><br><br>

<label for="carga">Carga horaria máxima:</label>
<input type="number" name="carga" id="carga"><br><br>

<label for="descricao">Descriçao</label><br>
<textarea name="descricao" id="descricao"></textarea><br><br>

<input type="hidden" value="<?php echo $_SESSION['coordenador'][2]; ?>" name="curso">

<input type="submit" value="Cadastrar"><br><br>
</form>

<a href="../inicialCoordenador.php">Voltar</a>
    
</body>

</html>