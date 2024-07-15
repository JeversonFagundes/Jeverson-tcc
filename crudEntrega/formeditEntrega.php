<?php

//connectar com o banco de dados.
include ("../conecta.php");

//conectar com a proteção.
include ("../protecao.php");

//selecionar as atividades complementares cadastradas no sistema.
$sql = "SELECT natureza, descricao, carga_horaria_maxima FROM atividade_complementar WHERE id_curso = " . $_SESSION['aluno'][2] ;

//excutar o comando sql acima.
$resultado = mysqli_query($mysql, $sql);

//veriifcar se deu algum erro.
if ($mysql->error) {
    
    die ("Falha ao listar as atividades complementares cadastradas no sistema! " . $mysql->error);

}else {
    
//transformar o resultado da consulta no banco de dados em vetor.
$atividades_complementares = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

echo '<h1>Formulário de alteração da sua atividade complementar entregue!</h1>';

echo '<h3>Tabela de atividades complementares.</h3>';

//abrir uma tabela para listar os itens.
echo '<table border = 4 

<tr>

<th>Natureza</th>
<th>Descrição</th>
<th>Carga horária máxima</th>

</tr>';

//percorre o vetor criado [$atividades_complementares]
foreach ($atividades_complementares as $atividade_complementar) {
    
    echo '<tr>';

    echo '<td>' . $atividade_complementar['natureza'] . '</td>';

    echo '<td>' . $atividade_complementar['descricao'] . '</td>';

    echo '<td>' . $atividade_complementar['carga_horaria_maxima'] . '</td>';
    
    echo '</tr>';
}

}

echo '</table>' . '<br><br>';

//receber o id da atividade entregue, que se deseja alterar.
$id = $_GET['id'];

//selecionar os dados da tabela de entrega de atividades.
$sql2 = "SELECT * FROM entrega_atividade WHERE id_entrega_atividade = $id";

//excutar o comando sql acima.
$resultado = mysqli_query($mysql, $sql2);

//varificar se houve algum erro.
if ($mysql->error) {
    
    die ("Falha ao listar a entrega da atividade complementar no sistema! " . $mysql->error);

}else {
    
    //gerar o vetor com os resultados.
    $entrega = mysqli_fetch_assoc($resultado);
}


/**/

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

 <!--Abrir um campo select para a selção dos itens.-->

 <select name="natureza">

 <?php

  //percorre o vetor
 foreach ($atividades_complementares as $atividade_complementar) {

    ?>

    <option

    <?php

    if ($entrega ['natureza'] == $atividade_complementar['natureza']) {

       echo "selected";
    
    }
       ?>

       value = " <?php echo $atividade_complementar['natureza']; ?>">
    
            <?php echo $atividade_complementar['descricao']; ?>

      </option>

      <?php
    }

 ?>

 </select><br><br>

 <label for="titulo">Titulo do certificado:</label>
 <input type="text" name="titulo" id="titulo" value="<?php echo $entrega['titulo_certificado']; ?>"> <br><br>

 <label for="carga">Carga horaria do certificado:</label>
 <input type="number" name="carga" id="carga" value="<?php echo $entrega['carga_horaria_certificado']; ?>"> <br><br>

 <input type="hidden" name="id" value=" <?php echo $entrega['id_entrega_atividade']; ?>">

 <input type="hidden" name="caminho" value="<?php echo $entrega['caminho']; ?>">

 <label for="certi">Certificado:</label>
 <input type="file" name="certificado" id="certi"> <br><br>

 <a href=" <?php echo $entrega['caminho']; ?>"> <?php echo $entrega['certificado']; ?></a> <br><br>

 <input type="submit" value="Editar">

</form>

<a href="../inicialAluno.php">Voltar</a>
    
</body>

</html>