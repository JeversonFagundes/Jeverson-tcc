<?php

//CADASTRARCOORDENADOR.PHP

//conectar com o banco de dados jeverson-tcc.
require_once "../conecta.php";

//declarar a variavel de conexão com o banco de dados jeverson-tcc.
$mysql = conectar();

//receber os dados do formulário de cadastrado de coordenador de curdo que está no arquivo formcadcoordenador.php.
$nome = $_POST['nome'];
$curso = $_POST['curso'];
$email = $_POST['email'];
$senha = $_POST['senha'];

//criptografar a senha recebida.
$nova_senha = password_hash($senha, PASSWORD_ARGON2ID);

//verificar se o email digitado existe no banco de dados.

//O comando COUNT(*) é usado para contar o número total de registros (linhas) em uma tabela sem retornar o valor dos registros.
//O comando sql mysqli_fetch_row() é usado para obter uma linha de dados de um conjunto de resultados e retorná-la como um array enumerado

// Verifica se o e-mail informado existe na tabela de alunos.
$consulta_alunos = excutarSQL($mysql, "SELECT COUNT(*) FROM aluno WHERE email = '$email'");
$quantidade_alunos = mysqli_fetch_row($consulta_alunos)[0];

// Verifica se o e-mail informado existe na tabela de coordenadores.
$consulta_coordenadores = excutarSQL($mysql, "SELECT COUNT(*) FROM coordenador_curso WHERE email = '$email'");
$quantidade_coordenadores = mysqli_fetch_row($consulta_coordenadores)[0];

// Verifica se o e-mail informado existe na tabela de administradores.
$consulta_administradores = excutarSQL($mysql, "SELECT COUNT(*) FROM administrador WHERE email = '$email'");
$quantidade_administradores = mysqli_fetch_row($consulta_administradores)[0];

var_dump($quantidade_alunos);
var_dump($quantidade_coordenadores);
var_dump($quantidade_administradores);

//o número de linhas que foram efetadas com busca pelo respectivo email, podemos agora fazer as devidas verificações com relação a ele.
if ($quantidade_alunos > 0 || $quantidade_coordenadores > 0 || $quantidade_administradores > 0) {
    echo "E-mail: " . " " . $email . " " . " já está cadastrado no sistema!<p><a href = \"formcadCoordenador.php\">Voltar</a></p>";
} else {

    //se o email informado não existe em nenhuma das três tabelas de usuários, quer dizer que o emial não está cadastrado no sistema e por isso podemos permitir o seu cadastro.

    //atribuir a variavél sql ($ql) o comando de inserção no banco de dados.
    $sql = "INSERT INTO coordenador_curso (nome, email, senha, id_curso)
    VALUES ('$nome', '$email', '$nova_senha', $curso)";

    //atribuir a variavél query ($query) a execução do comando sql ($sql).
    $query = excutarSQL($mysql, $sql);

    //redirecionar para a tela de login.
    header("location: ../inicialAdmin.php");
}
