<?php

//conectar com o banco de dados.
require_once "../conecta.php";

//variavel de conexão.
$mysql = conectar();

//receber os dados.
$atividade_complementar = $_POST['atividade_complementar'];
$titulo = $_POST['titulo'];
$carga = $_POST['carga'];
$caminho = $_POST['caminho'];
$certificado = $_FILES['certificado'];
$id = $_POST['id'];

//pasta de destino.
$pastaDestino = "../certificados/";

//verificar o tamnho do arquivo, se o size é 0 não existe arquivo.
if ($certificado['size'] == 0) {

    //comando sql.
    $sql = "UPDATE entrega_atividade SET id_atividade_complementar= $atividade_complementar, titulo_certificado = '$titulo', carga_horaria_certificado = $carga WHERE id_entrega_atividade = $id ";

    //excutar como sql.
    excutarSQL($mysql, $sql);

    header("location: ../inicialAluno.php");
} else {

    if ($certificado['error']) {

        die("Falha ao receber o certificado enviado! <p><a href = \"formcadEntrega.php\">Tentar de novo?</a></p>");
    } else {

        //mudar o nome do arquivo, porque caso um usuário cadastrar um arquivo com o mesmo nome que outro arquivo já cadastrado no sistema, um dos arquivos vai acabar sendo substituido pelo novo.
        $nome_certificado = $certificado['name'];

        $novo_nome_certificado = uniqid();

        //extrair a extenção do arquivo.
        $extencao = strtolower(pathinfo($nome_certificado, PATHINFO_EXTENSION));

        //strtolower(); as vezes podemos salvar um arquivo das seguintes maneiras JPG ou jpg, então por isso usamos strtolower para converter tudo para minúsculo.

        //pathinfo($nome_certificado, PATHINFO_EXTENSION): quando fazemos o upload de arquivos, o mesmo tem um caminho entao usamos esse código para pegar desse caminho, a extenção.

        //delimitar os tipos de arquivos, por questões de segurança.
        if (
            $extencao != "png" and $extencao != "jpeg" and

            $extencao != "gif" and $extencao != "jfif" and

            $extencao != "svg" and $extencao != "pdf" and $extencao != "jpg"
        ) {

            die("Este tipo de arquivo nao é aceito. <p><a href = \"formeditEntrega.php\">Voltar</a></p>");
        } else {

            $caminho2 = $novo_nome_certificado . "." . $extencao;
            $deu_certo = move_uploaded_file($certificado['tmp_name'], $pastaDestino . $caminho2);

            // o move_uploaded_file(); serve para mover um arquivo recebido para uma nova localização no projeto, no nosso caso é a pasta de certificado.

            if ($deu_certo) {

                //comando sql.
                $sql = "UPDATE entrega_atividade SET id_atividade_complementar  = $atividade_complementar , titulo_certificado = '$titulo', carga_horaria_certificado = $carga, certificado = '$nome_certificado',caminho = '$caminho2' WHERE id_entrega_atividade = $id";

                //excutar o comando sql acima.
                excutarSQL($mysql, $sql);

                unlink($pastaDestino . $caminho);

                header("location: ../inicialAluno.php");
            }
        }
    }
}
