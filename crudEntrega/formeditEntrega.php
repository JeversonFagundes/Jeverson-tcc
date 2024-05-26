<?php

//conectar com o banco de atividadeComplementar.
include ("../conecta.php");

include ("../protecao.php");

//selecionar os atividadeComplementar das atividades complementares cadastradas no sistema.
$sql = "SELECT natureza, descricao, carga_horaria_maxima FROM atividade_complementar WHERE id_curso = " . $_SESSION['id_curso'];

$resultado = mysqli_query($mysql, $sql);

if ($mysql->error) {
    
    die("Falha ao listar" . $mysql->error);

}else {

    echo '<h1>Formulário de alteração de atividade complementar!</h1>';

    echo '<h3>Tabela de atividades complementares.</h3>';
    
    //Lista os itens
echo '<table border=4;">
<tr>
<th>Natureza</th>
<th>Descrição</th>
<th>Carga horaria máxima</th>
</tr>';
$atividadesComplementares = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
foreach ($atividadesComplementares as $atividadeComplementar) {
    echo '<tr>';    
    echo '<td>'.$atividadeComplementar['natureza'].'</td>';
    echo '<td>'.$atividadeComplementar['descricao'] .'</td>';
    echo '<td>'.$atividadeComplementar['carga_horaria_maxima'] .'</td>';

    echo '</tr>';
    }
}

echo '</table>'.'<br><br>';

// Recebe o id da historia
$id = $_GET['id'];

// Seleciona os atividadeComplementar da historia da tabela historia
$sql = "SELECT * FROM entrega_atividade WHERE id_entrega_atividade = $id";

// Executa o Select
$resultado = mysqli_query($mysql,$sql);

// Gera o vetor com os atividadeComplementar buscados
$entrega = mysqli_fetch_assoc($resultado);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de entrega de atividade complementar</title>

</head>

<body>

<form action="editarEntrega.php" method="post" enctype="multipart/form-data">

<select name="natureza">

<?php 

foreach ($atividadesComplementares as $atividadeComplementar) {
    
    ?>
    <option 
    <?php

if ($entrega['natureza'] == $atividadeComplementar['descricao']) {
    
    echo "selected";
}
    ?>
    value="<?php echo $atividadeComplementar['natureza'] ?>">
        <?php echo $atividadeComplementar['descricao'] ?>
    </option>
<?php 
} 
?>

</select><br><br>


    <label for="titulo">Titulo do certificado:</label>
    <input type="text" value="<?php echo $entrega['titulo_certificado']; ?>" id="titulo" name="titulo"><br><br>

    <label for="carga">Carga horaria do certificado:</label>
    <input type="number" value="<?php echo $entrega['carga_horaria_certificado']; ?>" id="carga" name="carga"><br><br>

    <input  type="hidden" value="<?php echo $entrega['id_entrega_atividade'];?>" name="id"/>

    <input  type="hidden" value="<?php echo $entrega['caminho'];?>" name="caminho"/>

    <label for="certi">Certificado:</label>
    <input type="file" id="certi" name="certificado"><br><br>

    <a href="<?php echo $entrega['caminho']; ?>" ><?php echo $entrega['certificado'];?></a><br><br>

    <input type="submit" value="Editar">

    </form>



<a href="../inicialAluno.php">Voltar</a>
    
</body>

</html>