<?php

//O PHPMailer é uma biblioteca escrita em PHP que facilita o envio de e-mails.
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Declarar a função que irá enviar o email para o aluno quando o coordenador de curso deferir ou indeferir a atividade que foi entregue pelo aluno no sistema.
function email($nome, $status, $email, $carga_horaria_aprovada, $descricao, $matricula, $certificado, $observacoes, $tipo)
{

    // Incluir da biblioteca do PHPMailer os dados necessários.
    require_once '../recuperarSenha/PHPMailer/src/PHPMailer.php';
    require_once '../recuperarSenha/PHPMailer/src/SMTP.php';

    // Incluir o arquivo de configurações do sistema.
    include '../config2.php';

    // Instanciação do Objeto PHPMailer
    $mail = new PHPMailer(true);  // Parâmetro true: O parâmetro true passado para o construtor da classe PHPMailer indica que exceções devem ser lançadas em caso de erro.

    // Verificar se temos que enviar um email sobre uma atividade que foi deferida ou indeferida.
    if ($tipo == 1) {  // Quer dizer que à atividade foi deferida.

        try {
            // Configurações para o envio do email.
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->setLanguage('br');
            $mail->SMTPDebug = SMTP::DEBUG_OFF;  // Tira as mensagens
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER; // Imprime as mensagens
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  // Define o servidor SMTP que será usado para enviar o email.
            $mail->SMTPAuth = true;  // Habilita a autenticação SMTP.
            $mail->Username = $config['email'];  // Define o nome de usuário para autenticação SMTP, geralmente o endereço de email.
            $mail->Password = $config['senha_email'];  // Define a senha para autenticação SMTP.
            // Enable implicit TLS encryption
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Habilita a criptografia TLS para a conexão SMTP.
            $mail->Port = 587;  // Define a porta TCP para a conexão SMTP, 587 é a porta padrão para STARTTLS.
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );  // Define opções adicionais para a conexão SSL, desabilitando a verificação de certificado.

            // Recipients
            $mail->setFrom($config['email'], 'Atividade deferida');  // Define o endereço de email e o nome do remetente.
            $mail->addAddress($email, $email);  // Adiciona um destinatário.
            $mail->addReplyTo($config['email'], 'Atividade deferida no sistema');  // Define um endereço de resposta.

            // Content
            $mail->isHTML(true);  // Define que o formato do email será HTML.
            $mail->Subject = 'Atividade deferida no sistema';  // Define o assunto do email.
            $mail->Body = 'Olá!<br>
                Informamos que a sua atividade <strong>' . $certificado . '</strong> foi deferida no sistema.<br><br>
                Informações:<br><br>
                <p>Nome do aluno: ' . $nome . '</p>
                <p>Matricula: ' . $matricula . '</p>
                <p>Email : ' . $email . '</p>
                <p>Atividade deferida: ' . $certificado . '</p>
                <p>Descrição: ' . $descricao . '</p>
                <p>Carga horária deferida: ' . $carga_horaria_aprovada . ' horas</p>
                <p>Status: ' . $status . '</p>
                <p>Observações: ' . $observacoes . '</p><br><br>
                Para acessar o sistema, clique no link abaixo:<br>
                <a href="http://' . $_SERVER['SERVER_NAME'] . '/jeverson-tcc/index.php">Clique aqui para acessar a sua conta!</a><br>
                <br>
                Atenciosamente,<br>
                Equipe do sistema...';  // Define o corpo do email em HTML.

            $mail->send();  // Envia o email configurado anteriormente com a biblioteca PHPMailer.
        } catch (Exception $e) {
            // Este bloco captura exceções que foram lançadas no bloco try correspondente.
            echo "O email não pôde ser enviado. Erro do Mailer: {$mail->ErrorInfo}";
        }
    } else {

        // Verificar se temos que enviar um email sobre uma atividade que foi deferida ou indeferida.
        if ($tipo == 2) {  // Quer dizer que à atividade foi indeferida.

            try {
                // Configurações para o envio do email.
                $mail->CharSet = 'UTF-8';
                $mail->Encoding = 'base64';
                $mail->setLanguage('br');
                $mail->SMTPDebug = SMTP::DEBUG_OFF;  // Tira as mensagens
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER; // Imprime as mensagens
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';  // Define o servidor SMTP que será usado para enviar o email.
                $mail->SMTPAuth = true;  // Habilita a autenticação SMTP.
                $mail->Username = $config['email'];  // Define o nome de usuário para autenticação SMTP, geralmente o endereço de email.
                $mail->Password = $config['senha_email'];  // Define a senha para autenticação SMTP.
                // Enable implicit TLS encryption
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Habilita a criptografia TLS para a conexão SMTP.
                $mail->Port = 587;  // Define a porta TCP para a conexão SMTP, 587 é a porta padrão para STARTTLS.
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );  // Define opções adicionais para a conexão SSL, desabilitando a verificação de certificado.

                // Recipients
                $mail->setFrom($config['email'], 'Atividade indeferida');  // Define o endereço de email e o nome do remetente.
                $mail->addAddress($email, $email);  // Adiciona um destinatário.
                $mail->addReplyTo($config['email'], 'Atividade indeferida no sistema');  // Define um endereço de resposta.

                // Content
                $mail->isHTML(true);  // Define que o formato do email será HTML.
                $mail->Subject = 'Atividade indeferida no sistema';  // Define o assunto do email.
                $mail->Body = 'Olá!<br>
                Informamos que a sua atividade <strong>"' . $certificado . '"</strong> foi indeferida no sistema.<br><br>
                Informações:<br><br>
                <p>Nome do aluno: ' . $nome . '</p>
                <p>Matricula: ' . $matricula . '</p>
                <p>Email : ' . $email . '</p>
                <p>Atividade indeferida: ' . $certificado . '</p>
                <p>Descrição: ' . $descricao . '</p>
                <p>Carga horária deferida: ' . $carga_horaria_aprovada . 'horas</p>
                <p>Status: ' . $status . '</p>
                <p>Observações: ' . $observacoes . '</p><br><br>
                Para acessar o sistema, clique no link abaixo:<br>
                <a href="http://' . $_SERVER['SERVER_NAME'] . '/jeverson-tcc/index.php">Clique aqui para acessar a sua conta!</a><br>
                <br>
                Atenciosamente,<br>
                Equipe do sistema...';  // Define o corpo do email em HTML.

                $mail->send();  // Envia o email configurado anteriormente com a biblioteca PHPMailer.
            } catch (Exception $e) {
                // Este bloco captura exceções que foram lançadas no bloco try correspondente.
                echo "O email não pôde ser enviado. Erro do Mailer: {$mail->ErrorInfo}";
            }
        }
    }
}
