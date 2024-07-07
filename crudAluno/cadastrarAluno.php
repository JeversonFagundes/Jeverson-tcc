<?php

//conectar com o banco de dados.
include("../conecta.php");

//receber os dados.
$nome = $_POST['nome'];
$curso = $_POST['curso'];
$matricula = $_POST['matricula'];
$email = $_POST['email'];
$senha = $_POST['senha'];

$consulta_alunos = mysqli_query($mysql, "SELECT COUNT(*) FROM aluno WHERE email = '$email'");
$quantidade_alunos = mysqli_fetch_row($consulta_alunos)[0];

var_dump($quantidade_alunos);

// Verifica se o e-mail existe na tabela de coordenadores
$consulta_coordenadores = mysqli_query($mysql, "SELECT COUNT(*) FROM coordenador_curso WHERE email = '$email'");
$quantidade_coordenadores = mysqli_fetch_row($consulta_coordenadores)[0];

var_dump($quantidade_coordenadores);

// Verifica se o e-mail existe na tabela de administradores
$consulta_administradores = mysqli_query($mysql, "SELECT COUNT(*) FROM administrador WHERE email = '$email'");
$quantidade_administradores = mysqli_fetch_row($consulta_administradores)[0];

var_dump($quantidade_administradores);

if ($quantidade_alunos > 0 || $quantidade_coordenadores > 0 || $quantidade_administradores > 0) {
    echo "E-mail já cadastrado.";
} else {
    echo "E-mail não cadastrado.";
}