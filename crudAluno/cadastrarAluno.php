<?php

//CADASTRARALUNO.PHP

//incluir o arquivo de notificações do sistema. Dentro desse arquivo também inciamos a sessão (session_start()).
require_once "../boasPraticas/notificacoes.php";

//conectar com o banco de dados jeverson-tcc.
require_once "../conecta.php";

//declarar a variável de conexão coim o banco de dados jeverson-tcc. Esssa variavél vem do arquivo conecta.php.
$mysql = conectar();

//receber os dados vindos do formulário "formcadAluno.php".

//O trim() em PHP é utilizado para remover os espaços em branco (ou outros caracteres) do início e do final de uma string. Isso é útil quando você deseja limpar entradas de dados de usuários ou formatar strings de maneira mais adequada.

//O real_escape_string() é usado para escapar caracteres especiais em uma string, tornando-a segura para ser usada em uma consulta SQL, evitando que caracteres especiais quebrem a excução do comando sql.

$nome = trim($mysql->real_escape_string($_POST['nome']));
$curso = $_POST['curso'];
$matricula = trim($_POST['matricula']);
$email = trim($_POST['email']);
$senha = trim($mysql->real_escape_string($_POST['senha']));
$senha2 = trim($mysql->real_escape_string($_POST['senha2']));

if ($senha === $senha2) {

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

        //gerar a notificação de que o email informado pelo a aluno já existe no sistema.
        notificacoes(2, "O email informado já está em uso no sistema.");

        //redirecionar o aluno para o formcadAluno.php
        header("location:formcadAluno.php");
    } else {

        //se as buscas acima retornaram o valor zera, agora por se tratar de um aluno temos que buscar se a matricula informada já está cadastrado no banco de dados.
        $consulta_alunos_matricula = excutarSQL($mysql, "SELECT COUNT(*) FROM aluno WHERE matricula = '$matricula'");
        $quantidade_alunos_matricula = mysqli_fetch_row($consulta_alunos_matricula)[0];

        //se o comando ( $consulta_alunos_matricula) retornou um valor maior que zero, então a matricula já está cadastrado no sistema e por isso não devemos permitir o seu cadastro porque as matriculas do alunos é unica, ou seja, não pode ter contas de alunos com a mesma matricula no sistema
        if ($quantidade_alunos_matricula > 0) {

            //gerar a notificação de que a matricula informada pelo a aluno já existe no sistema.
            notificacoes(2, "A matricula informada já está em uso no sistema.");

            //redirecionar o aluno para o formcadAluno.php
            header("location:formcadAluno.php");
        } else {

            //se o comando  $consulta_alunos_matricula retornou zero, então a metricula informada não está cadastrada no sistema e por isso podemos permitir o seu cadastro no banco de dados.

            //atribuir a variavél sql ($sql) o comando de inserção no banco de dados.
            $sql = "INSERT INTO aluno (nome, matricula, email, senha, id_curso)
            VALUES ('$nome', '$matricula', '$email', '$nova_senha', $curso)";

            //excutar o comando sql ($sql).
            $query = excutarSQL($mysql, $sql);

            //gerar a notificação de um novo aluno cadastrado no sistema.
            notificacoes(1, "Cadastro realizado com sucesso");

            //redirecionar o aluno para a tela de login após o seu cadastro. Agora com as suas informações cadastradas no sistema, o aluno poderá realizar o seu login e acessar o sistema.
            header("location: ../index.php");
        }
    }
} else {

    //gerar a notificação de que e senha que o aluno digitou no campo de senha e confirmar senha, não são as mesmas senhas.
    notificacoes(2, "Você deve repetir a mesma senha nos campos de 'Senha' e 'Confimar senha'.");

    //redirecior o aluno formcadAluno.php
    header("location:formcadAluno.php");
}
