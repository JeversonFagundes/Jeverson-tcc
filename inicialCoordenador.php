<?php 

//conectar com o bonco de dados.
include ("conecta.php");

include ("protecao.php");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela inicial do coordenador de curso</title>

    <style>
        .card{
            background-color: white;
            width: 40%;
            height: 100px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px rgba(0, 0, 0, 0.19);
}
    </style>

</head>

<body>

<nav>
    <ul>
        <li><a href="crudContaCo/perfil.php">Perfil</a></li>
        <li><a href="logout.php">Sair</a></li>
    </ul>
</nav>
<h1><?php echo $_SESSION['nome_coordenador']; ?></h1>

<p><a href="crudAtividade/formcadAtividade.php">Cadastrar atividade complementar</a></p>

<hr>

<?php

//selecionar todos os itens da tebala de atividades complementares
$sql = "SELECT * FROM atividade_complementar WHERE id_curso = " . $_SESSION['id_curso'] ;

//excutar o comando sql acima.
$resultado = mysqli_query($mysql, $sql);

//caso dê erro
if ($mysql->error) {
    
    die ("Falha ao listar os itens!" . $mysql->error);

}else {
    
    $quantidade = $resultado->num_rows;

    if ($quantidade == 0) {

        echo "Você não tem atividade complementar cadastradas no sistema!";

    }else {
        
        echo '<h3>Tabela de atividades complemenatres</h3>';
        //Lista os itens
echo '<table border=1>
<tr>
<th>Natureza da atividade</th>
<th>Descrição da atividade</th>
<th>Carga horaria máxima</th>
<th colspan=3>Opções</th>
</tr>';

while ($dados = mysqli_fetch_assoc($resultado)) {
    echo '<tr>';    
    echo '<td>'.$dados['natureza'].'</td>';
    echo '<td>'.$dados['descricao'] .'</td>';
    echo '<td>'.$dados['carga_horaria_maxima'] .'</td>';
    echo '<td> <a href="crudAtividade/formeditAtividade.php?id='.$dados['id_atividade_complementar'].'"> Alterar </a> </td>';
    echo '<td> <a href="crudAtividade/excluirAtividade?id='.$dados['id_atividade_complementar'].'"> Excluir </a> </td>';
    echo '</tr>';
    }
    
    echo '</table>'. '<br><br>';
    }
}

echo '<hr>';

echo '<h1>Lista de alunos que entregaram atividades complementares para validaçao no sistema </h1>';

$sql1 = "SELECT DISTINCT a.id_aluno, a.nome_aluno, a.matricula FROM aluno a
INNER JOIN coordenador_curso cc 
ON a.id_curso = " . $_SESSION['id_curso'] . " AND cc.id_curso = " . $_SESSION['id_curso'] . "
INNER JOIN entrega_atividade ea 
ON a.id_aluno = ea.id_aluno 
;";

$resultado1 = mysqli_query($mysql, $sql1);

if ($mysql->error) {
    
    die ("Falha ao unir as informações! " . $mysql->error);

}else {
    
    while ($dados1 = mysqli_fetch_assoc($resultado1)) {

        echo '<div class="card">';
        echo '<div class="card-body">';
        echo '<h1 class="card-title">'. '<a href="validacao/validar.php?id='.$dados1['id_aluno'].'">'. $dados1['nome_aluno'].'</a>'.'</h1>';
        echo '<p class="card-text">'. 'Matricula do aluno:'. ' ' .$dados1['matricula'].'</p>';
        echo '</div>';
        echo '</div>';

    }
}
/*
        
        */
?>
</body>

</html>