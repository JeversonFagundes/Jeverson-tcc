<?php

//conectar com o banco de dados jeverson-tcc.
require_once "../conecta.php";

//incluir o arquivo que envia o email para o aluno quando a atividade é deferida ou indeferida.
require_once "funcaoEmail.php";

//incluir o arquivo de notificações do sistema. Dentro desse arquivo também inciamos a sessão (session_start()).
require_once "../boasPraticas/notificacoes.php";

//declarar a variavel de conexão com o banco de dados jeverson-tcc.
$mysql = conectar();

//verificar qual foi a opção que o coordenador de curso escolheu.
if ($_POST['deferir']) {

    //se escolheu a opção de indeferir o arquivo que foi entregue no sistema, realizamos o processedimento necessários.

    //receber os dados vindos do formulário que está no arquivo validar.php.
    $id = $_POST['id_atividade'];
    $cargaDefe = $_POST['cargaDefe'];
    $situacao = "Deferido";
    $observacoes = $_POST['observacoes'];
    $id_aluno = $_POST['aluno'];
    $nome = $_POST['nome'];
    $matricula = $_POST['matricula'];
    $email = $_POST['email'];
    $certificado = $_POST['certificado'];
    $descricao = $_POST['descricao'];

    //declarar o comando de alterar no banco de dados.
    $sql = "UPDATE entrega_atividade SET carga_horaria_aprovada = $cargaDefe, status = '$situacao', observacoes = '$observacoes' WHERE id_entrega_atividade = $id";

    //executar o comando sql ($sql).
    excutarSQL($mysql, $sql);

    // Agora você pode chamar a função email
    email($nome, $situacao, $email, $cargaDefe, $descricao, $matricula, $certificado, $observacoes, 1);

    notificacoes(1,"Atividade deferida com sucesso!");

    //redirecionar o coordenador de curso para a tela validação
    header("location: validar.php?id=" . $id_aluno);
} else {

    //se escolheu o opção de deferir o arquivo que foi entregue no sistema, realizamos o processedimento necessários.
    if ($_POST['indeferir']) {

        //receber os dados vindos do formulário que está no arquivo validar.php.
        $id = $_POST['id_atividade'];
        $cargaDefe = 0;
        $situacao = "Indeferido";
        $id_aluno = $_POST['aluno'];
        $observacoes = $_POST['observacoes'];
        $nome = $_POST['nome'];
        $matricula = $_POST['matricula'];
        $email = $_POST['email'];
        $certificado = $_POST['certificado'];
        $descricao = $_POST['descricao'];


        //declarar o comando sql de alteração no banco de dados
        $sql = "UPDATE entrega_atividade SET carga_horaria_aprovada = $cargaDefe, status = '$situacao', observacoes = '$observacoes' WHERE id_entrega_atividade = $id";

        //executar o comando sql ($sql).
        excutarSQL($mysql, $sql);

        // Agora você pode chamar a função email
        email($nome, $situacao, $email, $cargaDefe, $descricao, $matricula, $certificado, $observacoes, 2);

        notificacoes(1,"Atividade indeferida com sucesso!");
        
        //redirecionar o coordenador de curso para a tela de validação.
        header("location: validar.php?id=" . $id_aluno);
    }
}
