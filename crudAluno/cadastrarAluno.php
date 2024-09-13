<?php

//CADASTRARALUNO.PHP

//conectar com o banco de dados jeverson-tcc.
require_once "../conecta.php";

//declarar a variável de conexão coim o banco de dados jeverson-tcc. Esssa variavél vem do arquivo conecta.php.
$mysql = conectar();

//receber os dados vindos do formulário "formcadAluno.php".
$nome = $_POST['nome'];
$curso = $_POST['curso'];
$matricula = $_POST['matricula'];
$email = $_POST['email'];
$senha = $_POST['senha'];

//criptografar a senha.
$nova_senha = password_hash($senha, PASSWORD_ARGON2ID);

//verificar se o email digitado já existe no banco de dados.

//O comando COUNT(*) é usado para contar o número total de registros (linhas) em uma tabela sem retornar o valor dos registros.
//O comando sql mysqli_fetch_row() é usado para obter uma linha de dados de um conjunto de resultados e retorná-la como um array enumerado

// Verifica se o e-mail informado existe na tabela de alunos.
$consulta_alunos = excutarSQL($mysql, "SELECT COUNT(*) FROM aluno WHERE email = '$email'");
$quantidade_alunos = mysqli_fetch_row($consulta_alunos)[0];

// Verifica se o e-mail informado existe na tabela de coordenadores.
$consulta_coordenadores = excutarSQL($mysql, "SELECT COUNT(*) FROM coordenador_curso WHERE email = '$email'");
$quantidade_coordenadores = mysqli_fetch_row($consulta_coordenadores)[0];

// Verifica se o e-mail existe na tabela de administradores.
$consulta_administradores = excutarSQL($mysql, "SELECT COUNT(*) FROM administrador WHERE email = '$email'");
$quantidade_administradores = mysqli_fetch_row($consulta_administradores)[0];

//se ambas as consultas retornaram valores maiores de zero, então o email informado já está cadastrado no sistema.
if ($quantidade_alunos > 0 || $quantidade_coordenadores > 0 || $quantidade_administradores > 0) {
    echo "E-mail: " . " " . $email . " " . " já está cadastrado no sistema!<p><a href = \"formcadAluno.php\">Voltar</a></p>";
} else {

    //se as buscas a cima retornaram o valor zera, agora por se tratar de um aluno temos que buscar se a matricula informada já está cadastrado no banco de dados.
    $consulta_alunos_matricula = excutarSQL($mysql, "SELECT COUNT(*) FROM aluno WHERE matricula = '$matricula'");
    $quantidade_alunos_matricula = mysqli_fetch_row($consulta_alunos_matricula)[0];

    //se o comando ( $consulta_alunos_matricula) retornou um valor maior que zero, então a matricula já está cadastrado no sistema e por isso não devemos permitir o seu cadastro porque as matriculas do alunos é unica, ou seja, não pode ter contas de alunos com a mesma matricula no sistema
    if ($quantidade_alunos_matricula > 0) {

        echo "Essa matricula: " . " " . $matricula . " " . " já está cadastrada no sistema!<p><a href = \"formcadAluno.php\">Voltar</a></p>";
    } else {

        //se o comando  $consulta_alunos_matricula retornou zero, então a metricula informada não está cadastrada no sistema e por isso podemos permitir o seu cadastro no banco de dados.

        //atribuir a variavél sql ($sql) o comando de inserção no banco de dados.
        $sql = "INSERT INTO aluno (nome, matricula, email, senha, id_curso)
        VALUES ('$nome', '$matricula', '$email', '$nova_senha', $curso)";

        //excutar o comando sql ($sql).
        $query = excutarSQL($mysql, $sql);

        //redirecionar o aluno para a tela de login após o seu cadastro. Agora com as suas informações cadastradas no sistema, o aluno poderá realizar o seu login e acessar o sistema.
        header("location: ../index.php");
    }
}
