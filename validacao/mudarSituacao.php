<?php

//conectar com o banco de dados jeverson-tcc.
require_once "../conecta.php";

//incluir o arquivo que envia o email para o aluno quando a atividade é deferida ou indeferida.
require_once "funcaoEmail.php";

//incluir o arquivo de notificações do sistema. Dentro desse arquivo também inciamos a sessão (session_start()).
require_once "../boasPraticas/notificacoes.php";

//declarar a variavel de conexão com o banco de dados jeverson-tcc.
$mysql = conectar();

//O real_escape_string() é usado para escapar caracteres especiais em uma string, tornando-a segura para ser usada em uma consulta SQL, evitando que caracteres especiais quebrem a excução do comando sql.

//verificar qual foi a opção que o coordenador de curso escolheu.
if ($_POST['deferir']) {

    //se escolheu a opção de indeferir o arquivo que foi entregue no sistema, realizamos o processedimento necessários.

    //receber os dados vindos do formulário que está no arquivo validar.php.

    //O trim() em PHP é utilizado para remover os espaços em branco (ou outros caracteres) do início e do final de uma string. Isso é útil quando você deseja limpar entradas de dados de usuários ou formatar strings de maneira mais adequada.

    $id = $_POST['id_atividade'];
    $cargaDefe = trim($_POST['cargaDefe']);
    $situacao = "Deferido";
    $observacoes = trim($mysql->real_escape_string($_POST['observacoes']));
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

    $sql_busca_natureza = "SELECT ea.id_atividade_complementar FROM entrega_atividade ea WHERE ea.id_entrega_atividade = $id";

    $excutar_sql_busca_natureza = excutarSQL($mysql, $sql_busca_natureza);

    $natureza = mysqli_fetch_assoc($excutar_sql_busca_natureza);

    $sql_busca = "SELECT ac.carga_horaria_maxima, ac.descricao, ea.titulo_certificado, ea.carga_horaria_aprovada FROM atividade_complementar ac 
    INNER JOIN entrega_atividade ea 
    ON ac.id_atividade_complementar = ea.id_atividade_complementar AND ea.status = 'Deferido'
    WHERE ac.id_atividade_complementar = " . $natureza['id_atividade_complementar'];

    $excucao_sql_busca = excutarSQL($mysql, $sql_busca);

    $busca = mysqli_fetch_all($excucao_sql_busca, MYSQLI_ASSOC);

    $total_carga_horaria_aprovada = 0;

    foreach ($busca as $atividade) {
        $total_carga_horaria_aprovada += $atividade['carga_horaria_aprovada'];
    }

    if ($busca[0]['carga_horaria_maxima'] < $total_carga_horaria_aprovada) {

        $sql32 = "UPDATE entrega_atividade SET carga_horaria_aprovada = 0, status = 'Em análise', observacoes = 'Sem observações' WHERE id_entrega_atividade = $id";

        excutarSQL($mysql, $sql32);

        notificacoes(2, "Não é possível deferir mais horas para essa natureza, pois a carga horária máxima para a natureza \"" . $busca[0]['descricao'] . "\" é de " . $busca[0]['carga_horaria_maxima'] . " horas.");

        // Redirecionar o coordenador de curso para a tela de validação
        header("Location: validar.php?id=" . $id_aluno);
        exit(); // Certifique-se de que o script pare de executar após o redirecionamento

    } else {

        // Agora você pode chamar a função email
        email($nome, $situacao, $email, $cargaDefe, $descricao, $matricula, $certificado, $observacoes, 1);

        //chamar a função de notificação do sistema
        notificacoes(1, "Atividade deferida com sucesso!");

        //redirecionar o coordenador de curso para a tela validação
        header("location: validar.php?id=" . $id_aluno);
    }
} else {

    //se escolheu o opção de deferir o arquivo que foi entregue no sistema, realizamos o processedimento necessários.
    if ($_POST['indeferir']) {

        //receber os dados vindos do formulário que está no arquivo validar.php.

        //O trim() em PHP é utilizado para remover os espaços em branco (ou outros caracteres) do início e do final de uma string. Isso é útil quando você deseja limpar entradas de dados de usuários ou formatar strings de maneira mais adequada.

        $id = $_POST['id_atividade'];
        $cargaDefe = 0;
        $situacao = "Indeferido";
        $id_aluno = $_POST['aluno'];
        $observacoes = trim($mysql->real_escape_string($_POST['observacoes']));
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

        notificacoes(1, "Atividade indeferida com sucesso!");

        //redirecionar o coordenador de curso para a tela de validação.
        header("location: validar.php?id=" . $id_aluno);
    }
}
