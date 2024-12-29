<?php

//RECUPERAR.PHP

//O PHPMailer é uma biblioteca escrita em PHP que facilita o envio de e-mails.
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//conectar com o banco de dados jeverson-tcc
require_once "../conecta.php";

//declarar a variavel de conexão com o banco de dados jeverson-tcc. 
$mysql = conectar();

//incluir o arquivo de notificações do sistema.
require_once "../boasPraticas/notificacoes.php";

//receber os dados vindos do formulário de recuperação de senha que esta no arquivo form-recuperar-senha.html.

//O trim() em PHP é utilizado para remover os espaços em branco (ou outros caracteres) do início e do final de uma string. Isso é útil quando você deseja limpar entradas de dados de usuários ou formatar strings de maneira mais adequada.

$email = trim($_POST['email']);

//verificar se o email informado está cadastrado no sistema.

//O comando COUNT(*) é usado para contar o número total de registros (linhas) em uma tabela sem retornar o valor dos registros.
//O comando sql mysqli_fetch_row() é usado para obter uma linha de dados de um conjunto de resultados e retorná-la como um array enumerado

//Verifica se o e-mail informado existe na tabela de alunos.
$consulta_alunos = excutarSQL($mysql, "SELECT COUNT(*) FROM aluno WHERE email = '$email'");
$quantidade_alunos = mysqli_fetch_row($consulta_alunos)[0];

// Verifica se o e-mail informado existe na tabela de coordenadores.
$consulta_coordenadores = excutarSQL($mysql, "SELECT COUNT(*) FROM coordenador_curso WHERE email = '$email'");
$quantidade_coordenadores = mysqli_fetch_row($consulta_coordenadores)[0];

// Verifica se o e-mail informado existe na tabela de administradores.
$consulta_administradores = excutarSQL($mysql, "SELECT COUNT(*) FROM administrador WHERE email = '$email'");
$quantidade_administradores = mysqli_fetch_row($consulta_administradores)[0];

//se todas as tabelas retornaram 0 então esse email não está cadastrado no sistema.
if ($quantidade_alunos == 0 && $quantidade_coordenadores == 0 && $quantidade_administradores == 0) {

    notificacoes(2, "E-mail: " . " " . $email . " " . " não está cadastrado no sistema!");

    header("location:form-recuperar-senha.php");

    die();
} else {

    //se uma das tabelas retornou um valor diferente de 0 para a busca referente ao amil informado, devemos ver qual tabela foi.

    if ($quantidade_alunos != 0) {

        //se foi a tabela aluno que retornou linhas afetadas pela busca pelo email informado, então buscamos o nome do aluno ao qual o email informado pertence.
        $sql = "SELECT email, nome FROM aluno WHERE email = '$email'";

        //executamos o comando sql ($sql).
        $resultado = excutarSQL($mysql, $sql);

        //atribuimos a variavél usuario ($usuario) os resultados da execução do comando sql ($sql).
        $usuario = mysqli_fetch_assoc($resultado);
    }
    if ($quantidade_coordenadores != 0) {

        //se foi a tabela do coordenador de curso que retornou linhas afetadas pela busca pelo email informado, antão então buscamos o nome do coordenador ao qual o email informado pertence.
        $sql = "SELECT email, nome FROM coordenador_curso WHERE email = '$email'";

        //executamos o comando sql ($sql).
        $resultado = excutarSQL($mysql, $sql);

        //atribuimos a variavél usuario ($usuario) os resultados da execução do comando sql ($sql).
        $usuario = mysqli_fetch_assoc($resultado);
    }
    if ($quantidade_administradores != 0) {

        //no caso se foi a tabela do administrador, ele é uma excessão e acabamos fazendo todo o processo de recuperação da sua senha aqui dentro desse if.

        //buscar pelos dados do administrador ao qual pertence o email informado
        $sql = "SELECT email FROM administrador WHERE email = '$email'";

        //executar o comando sql ($sql) acima
        $resultado = excutarSQL($mysql, $sql);

        //atribuir a variavél usuario ($usuario) o valores de do array associativo gerado na busca $sql acima.
        $usuario = mysqli_fetch_assoc($resultado);

        //bin2hex(random_bytes(50)) é usado para gerar uma string hexadecimal de 100 caracteres, que representa 50 bytes de dados aleatórios.

        //random_bytes(50): Esta função gera uma string contendo 50 bytes de dados aleatórios criptograficamente seguros12. Esses bytes são selecionados de forma completamente aleatória, o que os torna adequados para usos como geração de chaves de criptografia.

        //bin2hex(): Esta função converte os dados binários (os bytes aleatórios gerados) em uma representação hexadecimal. Cada byte é representado por dois caracteres hexadecimais, resultando em uma string de 100 caracteres no total.

        //gerar um token unico
        $token = bin2hex(random_bytes(50));

        //incluir da biblioteca do PHPMailer os dados necessários.
        require_once 'PHPMailer/src/PHPMailer.php';
        require_once 'PHPMailer/src/SMTP.php';

        //incluir o arquivo de configurações do sistema.
        include '../config2.php';

        //Instanciação do Objeto PHPMailer:Cria uma nova instância da classe PHPMailer. Isso significa que você está criando um novo objeto $mail que pode ser usado para enviar emails.

        //Parâmetro true:O parâmetro true passado para o construtor da classe PHPMailer indica que exceções devem ser lançadas em caso de erro. Isso permite que você use blocos try...catch para capturar e tratar esses erros de forma mais controlada.
        $mail = new PHPMailer(true);

        //O comando try...catch em PHP é utilizado para tratar exceções, ou seja, erros que podem ocorrer durante a execução de um script. Aqui está uma explicação detalhada:

        //try: Este bloco contém o código que pode potencialmente lançar uma exceção. Se o código dentro do bloco try executa sem problemas, o bloco catch é ignorado.

        //catch: Este bloco é executado se uma exceção for lançada no bloco try. Ele captura a exceção e permite que você lide com o erro de uma maneira controlada, evitando que o script pare abruptamente.
        try {
            // configurações para o envio do email.
            $mail->CharSet = 'UTF-8'; // Define o conjunto de caracteres para UTF-8, garantindo que caracteres especiais sejam exibidos corretamente.
            $mail->Encoding = 'base64'; // Define a codificação do email para base64, que é adequada para conteúdo binário e texto.
            $mail->setLanguage('br'); // Define o idioma para mensagens de erro e outros textos gerados automaticamente para português do Brasil.
            $mail->SMTPDebug = SMTP::DEBUG_OFF;  //tira as mensagens
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER; //imprime as mensagens
            $mail->isSMTP();                       //envia o email usando SMTP
            $mail->Host = 'smtp.gmail.com';        // Define o servidor SMTP que será usado para enviar o email.
            $mail->SMTPAuth = true;                // Habilita a autenticação SMTP.
            $mail->Username = $config['email'];    // Define o nome de usuário para autenticação SMTP, geralmente o endereço de email.
            $mail->Password = $config['senha_email']; // Define a senha para autenticação SMTP.
            //Enable implicit TLS encryption
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Habilita a criptografia TLS para a conexão SMTP.
            // TCP port to connect to; use 587 if you have set 
            //`SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS` 
            $mail->Port = 587; // Define a porta TCP para a conexão SMTP, 587 é a porta padrão para STARTTLS.
            $mail->SMTPOptions = array( //Esta linha define opções adicionais para a conexão SMTP, especificando que essas opções serão configuradas em um array.
                'ssl' => array( // Aqui, estamos configurando opções específicas para a camada SSL (Secure Sockets Layer), que é usada para criptografar a conexão.
                    'verify_peer' => false, //Esta opção desativa a verificação do certificado SSL do servidor. Normalmente, essa verificação garante que o certificado do servidor seja válido e confiável. Definir como false pode ser útil em ambientes de desenvolvimento ou teste, mas não é recomendado para produção, pois pode comprometer a segurança. 
                    'verify_peer_name' => false, //Esta opção desativa a verificação do nome do host no certificado SSL. Novamente, isso pode ser útil em ambientes de desenvolvimento, mas não é recomendado para produção.
                    'allow_self_signed' => true //Esta opção permite o uso de certificados SSL autoassinados. Certificados autoassinados são aqueles que não são emitidos por uma autoridade certificadora confiável. Isso pode ser útil para testes locais, mas não é seguro para uso em produção. 
                )
            ); // Define opções adicionais para a conexão SSL, desabilitando a verificação de certificado.

            //Recipients
            $mail->setFrom($config['email'], 'Recuperação de senha'); // Define o endereço de email e o nome do remetente.
            $mail->addAddress($usuario['email'], $usuario['email']);     // Adiciona um destinatário.
            $mail->addReplyTo($config['email'], 'Recuperação de senha'); // Define um endereço de resposta.

            //Content
            $mail->isHTML(true);  // Define que o formato do email será HTML.
            $mail->Subject = 'Recuperação de Senha do Sistema'; // Define o assunto do email.
            $mail->Body = 'Olá!<br>
                    Você solicitou a recuperação da sua conta no nosso sistema.
                    Para isso, clique no link abaixo para realizar a troca de senha:<br>
                    <a href="' . $_SERVER['SERVER_NAME'] . '/jeverson-tcc/recuperarSenha/nova_senha.php?email=' . $usuario['email'] . '&token=' . $token . '">Clique aqui para recuperar o acesso à sua conta!</a><br>
                    <br>
                    Atenciosamente<br>
                    Equipe do sistema...'; // Define o corpo do email em HTML.

            //O comando $_SERVER['SERVER_NAME'] em PHP é utilizado para obter o nome do host do servidor onde o script está sendo executado1. Este valor é definido na configuração do servidor web e pode ser útil em várias situações.

            $mail->send(); //é utilizado para enviar o email configurado anteriormente com a biblioteca PHPMailer. Quando você chama este método, ele tenta enviar o email com todas as configurações e conteúdo que você definiu anteriormente no script.

            notificacoes(1, "Email enviado com sucesso! Confira o seu email.");

            header("location:form-recuperar-senha.php");

            // gravar as informações na tabela recuperar-senha
            date_default_timezone_set('America/Sao_Paulo'); //Esta linha define o fuso horário padrão para ‘America/Sao_Paulo’ (horário de Brasília). Isso é importante para garantir que todas as funções de data e hora utilizem o fuso horário correto.
            $data = new DateTime('now'); //Aqui, um novo objeto DateTime é criado com a data e hora atuais. O parâmetro 'now' indica que queremos a data e hora do momento em que o objeto é criado.
            $agora = $data->format('Y-m-d H:i:s'); //Esta linha formata o objeto DateTime criado anteriormente em uma string no formato ‘YYYY-MM-DD HH:MM:SS’. O método format permite que você especifique o formato desejado para a data e hora.

            //atribuir o comando de inserção no banco de dados na tabela recuperar_senha.
            $sql2 = "INSERT INTO recuperar_senha 
             (email, token, data_criacao, usado)
             VALUES ('" . $usuario['email'] . "', '$token', 
             '$agora', 0)";

            //executar o comando sql2 ($sql2) acima.
            excutarSQL($mysql, $sql2);
        } catch (Exception $e) { //Este bloco captura exceções que foram lançadas no bloco try correspondente. A palavra-chave Exception indica que estamos lidando com exceções gerais. A variável $e armazena a exceção capturada, permitindo que você acesse informações sobre o erro.
            echo "Não foi possível enviar o email. 
          Mailer Error: {$mail->ErrorInfo}"; //Esta é uma variável que contém informações detalhadas sobre o erro ocorrido durante a tentativa de envio do email. O uso de {$mail->ErrorInfo} dentro das chaves {} permite que o valor da variável seja inserido na string.
        }

        die();
    }

    //bin2hex(random_bytes(50)) é usado para gerar uma string hexadecimal de 100 caracteres, que representa 50 bytes de dados aleatórios.

    //random_bytes(50): Esta função gera uma string contendo 50 bytes de dados aleatórios criptograficamente seguros12. Esses bytes são selecionados de forma completamente aleatória, o que os torna adequados para usos como geração de chaves de criptografia.

    //bin2hex(): Esta função converte os dados binários (os bytes aleatórios gerados) em uma representação hexadecimal. Cada byte é representado por dois caracteres hexadecimais, resultando em uma string de 100 caracteres no total.

    //gerar um token unico
    $token = bin2hex(random_bytes(50));

    //incluir da biblioteca do PHPMailer os dados necessários.
    require_once 'PHPMailer/src/PHPMailer.php';
    require_once 'PHPMailer/src/SMTP.php';

    //incluir o arquivo de configurações do sistema.
    include '../config2.php';

    //Instanciação do Objeto PHPMailer:Cria uma nova instância da classe PHPMailer. Isso significa que você está criando um novo objeto $mail que pode ser usado para enviar emails.

    //Parâmetro true:O parâmetro true passado para o construtor da classe PHPMailer indica que exceções devem ser lançadas em caso de erro. Isso permite que você use blocos try...catch para capturar e tratar esses erros de forma mais controlada.
    $mail = new PHPMailer(true);

    //O comando try...catch em PHP é utilizado para tratar exceções, ou seja, erros que podem ocorrer durante a execução de um script. Aqui está uma explicação detalhada:

    //try: Este bloco contém o código que pode potencialmente lançar uma exceção. Se o código dentro do bloco try executa sem problemas, o bloco catch é ignorado.

    //catch: Este bloco é executado se uma exceção for lançada no bloco try. Ele captura a exceção e permite que você lide com o erro de uma maneira controlada, evitando que o script pare abruptamente.
    try {
        // configurações para o envio do email.
        $mail->CharSet = 'UTF-8'; // Define o conjunto de caracteres para UTF-8, garantindo que caracteres especiais sejam exibidos corretamente.
        $mail->Encoding = 'base64'; // Define a codificação do email para base64, que é adequada para conteúdo binário e texto.
        $mail->setLanguage('br'); // Define o idioma para mensagens de erro e outros textos gerados automaticamente para português do Brasil.
        $mail->SMTPDebug = SMTP::DEBUG_OFF;  //tira as mensagens
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER; //imprime as mensagens
        $mail->isSMTP();                       //envia o email usando SMTP
        $mail->Host = 'smtp.gmail.com';        // Define o servidor SMTP que será usado para enviar o email.
        $mail->SMTPAuth = true;                 // Habilita a autenticação SMTP.
        $mail->Username = $config['email'];    // Define o nome de usuário para autenticação SMTP, geralmente o endereço de email.
        $mail->Password = $config['senha_email']; // Define a senha para autenticação SMTP.
        //Enable implicit TLS encryption
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Habilita a criptografia TLS para a conexão SMTP.
        // TCP port to connect to; use 587 if you have set 
        //`SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS` 
        $mail->Port = 587; // Define a porta TCP para a conexão SMTP, 587 é a porta padrão para STARTTLS.
        $mail->SMTPOptions = array( //Esta linha define opções adicionais para a conexão SMTP, especificando que essas opções serão configuradas em um array.
            'ssl' => array( // Aqui, estamos configurando opções específicas para a camada SSL (Secure Sockets Layer), que é usada para criptografar a conexão.
                'verify_peer' => false, //Esta opção desativa a verificação do certificado SSL do servidor. Normalmente, essa verificação garante que o certificado do servidor seja válido e confiável. Definir como false pode ser útil em ambientes de desenvolvimento ou teste, mas não é recomendado para produção, pois pode comprometer a segurança. 
                'verify_peer_name' => false, //Esta opção desativa a verificação do nome do host no certificado SSL. Novamente, isso pode ser útil em ambientes de desenvolvimento, mas não é recomendado para produção.
                'allow_self_signed' => true //Esta opção permite o uso de certificados SSL autoassinados. Certificados autoassinados são aqueles que não são emitidos por uma autoridade certificadora confiável. Isso pode ser útil para testes locais, mas não é seguro para uso em produção. 
            )
        ); // Define opções adicionais para a conexão SSL, desabilitando a verificação de certificado.

        //Recipients
        $mail->setFrom($config['email'], 'Recuperação de senha'); // Define o endereço de email e o nome do remetente.
        $mail->addAddress($usuario['email'], $usuario['nome']);     //Este método adiciona um destinatário ao e-mail. Ele aceita dois parâmetros:
        //$usuario[‘email’]: O endereço de e-mail do destinatário.
        //$usuario[‘nome’]: O nome do destinatário.
        $mail->addReplyTo($config['email'], 'Recuperação de senha'); // Define um endereço de resposta.

        //Content
        $mail->isHTML(true);   // Define que o formato do email será HTML.
        $mail->Subject = 'Recuperação de Senha do Sistema'; // Define o assunto do email.
        $mail->Body = 'Olá!<br>
            Você solicitou a recuperação da sua conta no nosso sistema.
            Para isso, clique no link abaixo para realizar a troca de senha:<br>
            <a href="' . $_SERVER['SERVER_NAME'] . '/jeverson-tcc/recuperarSenha/nova_senha.php?email='
            . $usuario['email'] . '&token=' . $token .
            '">Clique aqui para recuperar o acesso à sua conta!</a><br>
            <br>
            Atenciosamente<br>
            Equipe do sistema...'; // Define o corpo do email em HTML.

        //O comando $_SERVER['SERVER_NAME'] em PHP é utilizado para obter o nome do host do servidor onde o script está sendo executado1. Este valor é definido na configuração do servidor web e pode ser útil em várias situações.

        $mail->send(); //é utilizado para enviar o email configurado anteriormente com a biblioteca PHPMailer. Quando você chama este método, ele tenta enviar o email com todas as configurações e conteúdo que você definiu anteriormente no script.
        notificacoes(1, "Email enviado com sucesso! Confira o seu email.");

        header("location:form-recuperar-senha.php");

        // gravar as informações na tabela recuperar-senha
        date_default_timezone_set('America/Sao_Paulo'); //Esta linha define o fuso horário padrão para ‘America/Sao_Paulo’ (horário de Brasília). Isso é importante para garantir que todas as funções de data e hora utilizem o fuso horário correto.
        $data = new DateTime('now'); //Aqui, um novo objeto DateTime é criado com a data e hora atuais. O parâmetro 'now' indica que queremos a data e hora do momento em que o objeto é criado.
        $agora = $data->format('Y-m-d H:i:s'); //Esta linha formata o objeto DateTime criado anteriormente em uma string no formato ‘YYYY-MM-DD HH:MM:SS’. O método format permite que você especifique o formato desejado para a data e hora.

        //atribuir o comando de inserção no banco de dados na tabela recuperar_senha.
        $sql2 = "INSERT INTO recuperar_senha 
             (email, token, data_criacao, usado)
             VALUES ('" . $usuario['email'] . "', '$token', 
             '$agora', 0)";

        //executar o comando sql2 ($sql2) acima.
        excutarSQL($mysql, $sql2);
    } catch (Exception $e) { //Este bloco captura exceções que foram lançadas no bloco try correspondente. A palavra-chave Exception indica que estamos lidando com exceções gerais. A variável $e armazena a exceção capturada, permitindo que você acesse informações sobre o erro.
        echo "Não foi possível enviar o email. 
          Mailer Error: {$mail->ErrorInfo}"; //Esta é uma variável que contém informações detalhadas sobre o erro ocorrido durante a tentativa de envio do email. O uso de {$mail->ErrorInfo} dentro das chaves {} permite que o valor da variável seja inserido na string.
    }
}
/*
$email = $_POST['email'];
$sql = "SELECT * FROM usuario WHERE email='$email'";
$resultado = executarSQL($conexao, $sql);

$usuario = mysqli_fetch_assoc($resultado);
if ($usuario == null) {
    echo "Email não cadastrado! Faça o cadastro e 
          em seguida realize o login.";
    die();
}
//gerar um token unico
$token = bin2hex(random_bytes(50));

require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';
require_once 'PHPMailer/src/Exception.php';
include 'config.php';


$mail = new PHPMailer(true);
try {
    // configurações
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';
    $mail->setLanguage('br');
    //$mail->SMTPDebug = SMTP::DEBUG_OFF;  //tira as mensagens
    $mail->SMTPDebug = SMTP::DEBUG_SERVER; //imprime as mensagens
    $mail->isSMTP();                       //envia o email usando SMTP
    $mail->Host = 'smtp.gmail.com';        //Set the SMTP server to send through
    $mail->SMTPAuth = true;                //Enable SMTP authentication
    $mail->Username = $config['email'];    //SMTP username
    $mail->Password = $config['senha_email']; //SMTP password
    //Enable implicit TLS encryption
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    // TCP port to connect to; use 587 if you have set 
    //`SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS` 
    $mail->Port = 587;
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    //Recipients
    $mail->setFrom($config['email'], 'Aula de Tópicos');
    $mail->addAddress($usuario['email'], $usuario['nome']);     //Add a recipient
    $mail->addReplyTo($config['email'], 'Aula de Tópicos');

    //Content
    $mail->isHTML(true);        //Set email format to HTML
    $mail->Subject = 'Recuperação de Senha do Sistema';
    $mail->Body = 'Olá!<br>
        Você solicitou a recuperação da sua conta no nosso sistema.
        Para isso, clique no link abaixo para realizar a troca de senha:<br>
        <a -href="' . $_SERVER['SERVER_NAME'] . '/recuperarsenha/nova-senha.php?email='
        . $usuario['email'] . '&token=' . $token .
        '">Clique aqui para recuperar o acesso à sua conta!</a><br>
        <br>
        Atenciosamente<br>
        Equipe do sistema...';

    $mail->send();
    echo 'Email enviado com sucesso!<br>Confira o seu email.';

    // gravar as informações na tabela recuperar-senha
    date_default_timezone_set('America/Sao_Paulo');
    $data = new DateTime('now');
    $agora = $data->format('Y-m-d H:i:s');

    $sql2 = "INSERT INTO `recuperar-senha` 
             (email, token, data_criacao, usado)
             VALUES ('" . $usuario['email'] . "', '$token', 
             '$agora', 0)";

    executarSQL($conexao, $sql2);
} catch (Exception $e) {
    echo "Não foi possível enviar o email. 
          Mailer Error: {$mail->ErrorInfo}";
}
*/
