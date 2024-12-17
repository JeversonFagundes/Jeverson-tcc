<?php

//SALVAR_NOVA_SENHA.PHP

//receber os dados vindos do formulário que está no arquivo "nova_senha.php".
$email = $_POST['email'];
$token = $_POST['token'];
$senha = $_POST['senha'];
$repetirSenha = $_POST['repetirSenha'];

//conectar com o banco de dados jeverson-tcc.
require_once "../conecta.php";

//declarar a veriavél de conexão com o banco de dados jeverson-tcc.
$mysql = conectar();

//conectar no arquivo de notificações do sistema.
require_once "../boasPraticas/notificacoes.php";

//buscar por todos os dados da tabela recuperar_senha com a condição de ser onde o email e o token forem os que acabamos de receber.
$sql = "SELECT * FROM recuperar_senha WHERE email='$email' AND token='$token'";

//executar o comando sql ($sql).
$resultado = excutarSQL($mysql, $sql);

//atribuir a variavél recuperar ($recuperar) os valores retornados da execução do comando $sql.
$recuperar = mysqli_fetch_assoc($resultado);

//fazer a primeira verificação.
if ($recuperar == null) {

    notificacoes(2, "Email ou token incorreto. Tente fazer um novo pedido de recuperação de senha");

    header("location:form-recuperar-senha.php");

    die();
} else {

    // verificar a validade do pedido (data_criacao)
    // verificar se o link já foi usado

    date_default_timezone_set('America/Sao_Paulo'); //Esta função define o fuso horário padrão para todas as funções de data e hora no script. No caso, está configurando o fuso horário para "America/Sao_Paulo

    $agora = new DateTime('now'); //Cria uma nova instância da classe DateTime representando a data e hora atuais. A string 'now' indica que queremos a data e hora do momento da execução do código.

    $data_criacao = DateTime::createFromFormat('Y-m-d H:i:s', $recuperar['data_criacao']); //Cria uma instância de DateTime a partir de uma string de data e hora no formato 'Y-m-d H:i:s' (ano-mês-dia hora:minuto:segundo). A variável $recuperar['data_criacao'] deve conter essa string de data e hora.

    $umDia = DateInterval::createFromDateString('1 day'); //Cria um objeto DateInterval que representa um intervalo de tempo de 1 dia. Esse objeto pode ser usado para adicionar ou subtrair tempo de um objeto DateTime

    $dataExpiracao = date_add($data_criacao, $umDia); //Adiciona o intervalo de 1 dia ($umDia) à data de criação ($data_criacao). O resultado é uma nova data e hora armazenada em $dataExpiracao, que representa a data de expiração.

    //fazer a segunda verificação.
    if ($agora > $dataExpiracao) {

        notificacoes(2, "Essa solicitação de recuperação de senha expirou! Faça um novo pedido de recuperação de senha");

        header("location:form-recuperar-senha.php");

        die();
    }

    //fazer a terceira verificação.
    if ($recuperar['usado'] == 1) {

        notificacoes(2, "Esse pedido de recuperação de senha já foi utilizado 
        anteriormente! Para recuperar a senha faça um novo pedido de recuperação de senha");

        header("location:form-recueprar-senha.php");

        die();
    }

    //verificar se o campo senha e o campo repetir senha tem o mesmo valor.
    if ($senha != $repetirSenha) {

        notificacoes(2, "A senha que você digitou é diferente da senha que você digitou no repetir senha. Por favor tente novamente!");

        header("location:nova_senha.php?email=$email&token=$token");

        die();
    }

    //criptografar a senha informada para que ela seja guardada no banco de dados de forma segura.
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

    // Verifica se o e-mail informado existe na tabela de administradores.
    $consulta_administradores = excutarSQL($mysql, "SELECT COUNT(*) FROM administrador WHERE email = '$email'");
    $quantidade_administradores = mysqli_fetch_row($consulta_administradores)[0];

    if ($quantidade_alunos != 0) {

        //se o email pertence a tabela dos alunos, antão atualizamos a senha anterior do aluno para a nova senha.
        $sql2 = "UPDATE aluno SET senha='$nova_senha' WHERE email='$email'";
        excutarSQL($mysql, $sql2);

        //atualizamos o usado de 0 para 1 para informar que esse pedido de recuperação senha já foi usado dentro do limite de tempo.
        $sql3 = "UPDATE recuperar_senha SET usado=1 WHERE email='$email' AND token='$token'";
        excutarSQL($mysql, $sql3);

        notificacoes(1, "Nova senha cadastrada com sucesso! Faça o login para acessar o sistema");

        header("location:../index.php");

        die();
    }
    if ($quantidade_coordenadores != 0) {

        //se o email pertence a tabela dos coordenadores de curso, antão atualizamos a senha anterior do coordenador para a nova senha.
        $sql2 = "UPDATE coordenador_curso SET senha='$nova_senha' WHERE email='$email'";
        excutarSQL($mysql, $sql2);

        //atualizamos o usado de 0 para 1 para informar que esse pedido de recuperação senha já foi usado dentro do limite de tempo.
        $sql3 = "UPDATE recuperar_senha SET usado=1 WHERE email='$email' AND token='$token'";
        excutarSQL($mysql, $sql3);

        notificacoes(1, "Nova senha cadastrada com sucesso! Faça o login para acessar o sistema");

        header("location:../index.php");

        die();
    }

    if ($quantidade_administradores != 0) {

        //se o email pertence a tabela do administrador, antão atualizamos a senha anterior do administrador para a nova senha.
        $sql3 = "UPDATE administrador SET senha='$nova_senha' WHERE email='$email'";
        excutarSQL($mysql, $sql3);

        //atualizamos o usado de 0 para 1 para informar que esse pedido de recuperação senha já foi usado dentro do limite de tempo.
        $sql4 = "UPDATE recuperar_senha SET usado=1 WHERE email='$email' AND token='$token'";
        excutarSQL($mysql, $sql4);

        notificacoes(1, "Nova senha cadastrada com sucesso! Faça o login para acessar o sistema");

        header("location:../index.php");

        die();
    }
}
