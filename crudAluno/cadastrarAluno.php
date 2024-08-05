<?php

//conectar com o banco de dados.
require_once "../conecta.php";

//variável de conexão.
$mysql = conectar();

//receber os dados.
$nome = $_POST['nome'];
$curso = $_POST['curso'];
$matricula = $_POST['matricula'];
$email = $_POST['email'];
$senha = $_POST['senha'];

//criptografar a senha.
$nova_senha = password_hash($senha, PASSWORD_ARGON2ID);

//verificar se o email digitado existe no banco de dados.

// Verifica se o e-mail existe na tabela de alunos.
$consulta_alunos = excutarSQL($mysql, "SELECT COUNT(*) FROM aluno WHERE email = '$email'");
$quantidade_alunos = mysqli_fetch_row($consulta_alunos)[0];

// Verifica se o e-mail existe na tabela de coordenadores.
$consulta_coordenadores = excutarSQL($mysql, "SELECT COUNT(*) FROM coordenador_curso WHERE email = '$email'");
$quantidade_coordenadores = mysqli_fetch_row($consulta_coordenadores)[0];

// Verifica se o e-mail existe na tabela de administradores.
$consulta_administradores = excutarSQL($mysql, "SELECT COUNT(*) FROM administrador WHERE email = '$email'");
$quantidade_administradores = mysqli_fetch_row($consulta_administradores)[0];


if ($quantidade_alunos > 0 || $quantidade_coordenadores > 0 || $quantidade_administradores > 0) {
    echo "E-mail: " . " " . $email . " " . " já está cadastrado no sistema!<p><a href = \"formcadAluno.php\">Voltar</a></p>";
} else {

    $consulta_alunos_matricula = excutarSQL($mysql, "SELECT COUNT(*) FROM aluno WHERE matricula = '$matricula'");
    $quantidade_alunos_matricula = mysqli_fetch_row($consulta_alunos_matricula)[0];

    if ($quantidade_alunos_matricula > 0) {

        echo "Essa matricula: " . " " . $matricula . " " . " já está cadastrada no sistema!<p><a href = \"formcadAluno.php\">Voltar</a></p>";
    } else {

        $sql = "INSERT INTO aluno (nome_aluno, matricula, email, senha, id_curso)
        VALUES ('$nome', '$matricula', '$email', '$nova_senha', $curso)";

        $query = excutarSQL($mysql, $sql);

        header("location: ../index.php");
    }
}
