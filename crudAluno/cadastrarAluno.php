<?php 

//conectar com o banco de dados.
include ("../conecta.php");

//receber os dados.
$nome = $_POST['nome'];
$curso = $_POST['curso'];
$matricula = $_POST['matricula'];
$email = $_POST['email'];
$senha = $_POST['senha'];

//puxar os dados dos alunos já cadastrados no sistema.
$sql1 = "SELECT * FROM aluno";

//excutar o comando acima.
$query = mysqli_query($mysql, $sql1);

//quantas linhas retornou.
$quantidade = $query->num_rows;

//verificar se existem alunos acdastrados no sistema.
if ($quantidade == 0 ) {
    
    //cadastrar normalmente o aluno no sistema.
    $sql = "INSERT INTO aluno (nome_aluno, matricula, email, senha, id_curso) VALUES ('$nome', '$matricula', '$email', '$senha', $curso)";

    //excutar o comando acima.
    mysqli_query($mysql, $sql);

    //caso dê erro
    if ($mysql->error) {
        
        die ("Falha ao cadastrar uma aluno no sistema!" . $mysql->error);

    }else {
        
        header("location: ../logout.php");
    }
}else {
    
    if ($quantidade != 0 ) {
        
        $aluno = $query->fetch_assoc();

        if ($aluno['email'] == $email) {
            
            die ("Este email já estam em uso no sistema.");

        }else {
            
            //cadastrar normalmente o aluno no sistema.
            $sql = "INSERT INTO aluno (nome_aluno, matricula, email, senha, id_curso) VALUES ('$nome', '$matricula', '$email', '$senha', $curso)";

            //excutar o comando acima.
            mysqli_query($mysql, $sql);

            //caso dê erro
            if ($mysql->error) {
        
           die ("Falha ao cadastrar uma aluno no sistema!" . $mysql->error);

    }else {
        
        header("location: ../logout.php");
    }
        }
    }
}

?>