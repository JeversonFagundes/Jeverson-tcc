<?php

//FORMCADATIVIDADE.PHP

//iniciar as veriaveis de sessão para que possamos buscar da sessão o curso do coordenador de curso logado no sistema no momento.
session_start();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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

        <input type="hidden" value="<?php echo  $_SESSION['coordenador'][2]; ?>" name="curso">

        <input type="submit" value="Cadastrar"><br><br>
    </form>

    <a href="../inicialCoordenador.php">Voltar</a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>