<?php

//EXCLUIRCURSO.PHP

//conectar com o banco de dados jeverson-tcc.
require_once "../conecta.php";

//declarar a variavel de conexão com o banco de dados jeverson-tcc.
$mysql = conectar();

//buscar da url os valores necessários para a exclusão do curso.
$id = $_GET['id'];

//verificar se existe alunos e coordenadores de curso no curso que se deseja excluir. Se houver não podemos deixar excluir..

//O comando COUNT(*) é usado para contar o número total de registros (linhas) em uma tabela sem retornar o valor dos registros.

//O comando sql mysqli_fetch_row() é usado para obter uma linha de dados de um conjunto de resultados e retorná-la como um array enumerado

// Verificar se existe alunos na tabela aluno que usam o curso que vai ser excluido.
$consulta_alunos = excutarSQL($mysql, "SELECT COUNT(*) FROM aluno WHERE id_curso = '$id'");
$quantidade_alunos = mysqli_fetch_row($consulta_alunos)[0];

// Verificar se existe coordenadoes de curso na tabela coordenador_curso que usam o curso que vai ser excluido.
$consulta_coordenador = excutarSQL($mysql, "SELECT COUNT(*) FROM coordenador_curso WHERE id_curso = '$id'");
$quantidade_coordenador = mysqli_fetch_row($consulta_coordenador)[0];

// Verificar se existe atividades complementares de curso na tabela atividades_complementar que usam o curso que vai ser excluido.
$consulta_atividade = excutarSQL($mysql, "SELECT COUNT(*) FROM atividade_complementar WHERE id_curso = '$id'");
$quantidade_atividade = mysqli_fetch_row($consulta_atividade)[0];

//se pelos uma das tabelas retornar uma valor maior do que zero, não podemos continuar com a exclusão do curso.

if ($quantidade_alunos > 0 and $quantidade_coordenador > 0 and $quantidade_atividade > 0) {

    echo "Esse curso não pode ser excluido do sistema, porque há coordenadores de curso, alunos  e atividades complementares de curso usando esse curso! <p><a href = \"../inicialAdmin.php\">Voltar para a tela inicial</a></p>";

    die();
} 
if ($quantidade_alunos > 0) {

    echo "Esse curso não pode ser excluido do sistema, porque há alunos usando esse curso! <p><a href = \"../inicialAdmin.php\">Voltar para a tela inicial</a></p>";

    die();
}

if ($quantidade_coordenador > 0 ) {

    echo "Esse curso não pode ser excluido do sistema, porque há coordenadores de curso usando esse curso! <p><a href = \"../inicialAdmin.php\">Voltar para a tela inicial</a></p>";

    die();
}

if ($quantidade_atividade > 0) {

    echo "Esse curso não pode ser excluido do sistema, porque há atividades complementares de curso usando esse curso! <p><a href = \"../inicialAdmin.php\">Voltar para a tela inicial</a></p>";

    die();
}else {

    //se não houver nem alunos nem coordenadores de curso e nem atividades complementares de curso usando esse curso, podemos continuar com a exclusão.

    //atribuir a veriavél sql ($sql) o comando para deletar o curso do banco de dados.
    $sql = "DELETE FROM curso WHERE id_curso = $id";

    //excutar o comando sql ($sql).
    excutarSQL($mysql, $sql);

    //redirecionar o administrador para a sua tela inicial.
    header("location: ../inicialAdmin.php");
}
