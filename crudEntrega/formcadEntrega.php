<?php

//conectar com o banco de dados.
include ("../conecta.php");

include ("../protecao.php");

//selecionar os dados das atividades complementares cadastradas no sistema.
$sql = "SELECT natureza, descricao, carga_horaria_maxima FROM atividade_complementar WHERE id_curso = " . $_SESSION['id_curso'];

$resultado = mysqli_query($mysql, $sql);

if ($mysql->error) {
    
    die("Falha ao listar" . $mysql->error);

}else {

    echo '<h1>Formulário de entrega de atividade complementar!</h1>';

    echo '<h3>Tabela de atividades complementares.</h3>';
    
    //Lista os itens
echo '<table border=4;">
<tr>
<th>Natureza</th>
<th>Descrição</th>
<th>Carga horaria máxima</th>
</tr>';

while ($dados = mysqli_fetch_assoc($resultado)) {
    echo '<tr>';    
    echo '<td>'.$dados['natureza'].'</td>';
    echo '<td>'.$dados['descricao'] .'</td>';
    echo '<td>'.$dados['carga_horaria_maxima'] .'</td>';

    echo '</tr>';
    }
}

echo '</table>'.'<br><br>';

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de entrega de atividade complementar</title>

</head>

<body>


<form action="cadastrarEntrega.php" method="post" enctype="multipart/form-data">

<?php

       $sql = "SELECT descricao FROM atividade_complementar WHERE id_curso = " . $_SESSION['id_curso'];
       $resultado = mysqli_query($mysql, $sql);
    ?>

    <select name="natureza">

    <option selected disabled value="">Escolha a natureza do seu certificado</option>
    
    <?php 
    
    while ($dados = mysqli_fetch_assoc($resultado)) { 
        
        ?>
        <option value="<?php echo $dados['descricao'] ?>">

            <?php echo $dados['descricao'] ?>

        </option>
    <?php 
} 
?>

    </select><br><br>


    <label for="titulo">Titulo do certificado:</label>
    <input type="text" id="titulo" name="titulo"><br><br>

    <label for="carga">Carga horaria do certificado:</label>
    <input type="number" id="carga" name="carga"><br><br>

    <input type="hidden"  name="cargaDefe" value="0">

    <input type="hidden"  name="status" value="Em análise">

    <label for="certi">Certificado:</label>
    <input type="file" id="certi" name="certificado"><br><br>

    <input type="submit" value="Enviar">

    </form>

<a href="../inicialAluno.php">Voltar</a>
    
</body>

</html>