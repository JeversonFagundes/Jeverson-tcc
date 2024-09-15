<?php

//EDITARENTREGA.PHP

//conectar com o banco de dados jeverson-tcc.
require_once "../conecta.php";

//declarra a variavel de conexão com o banco de dados jeverson-tcc.
$mysql = conectar();

//receber os dados vindos formulários que está no arquivo formeditentrega.php.
$atividade_complementar = $_POST['atividade_complementar'];
$titulo = $_POST['titulo'];
$carga = $_POST['carga'];
$caminho = $_POST['caminho'];
$certificado = $_FILES['certificado'];
$id = $_POST['id'];

//declarara a pasta de destino dos arquivos.
$pastaDestino = "../certificados/";

/*

    C:\wamp64\www\Jeverson-tcc\crudEntrega\cadastrarEntrega.php:26:
    array (size=5)
        'name' => string 'Motivação Vôlei.jpeg' (length=23) 
        'type' => string 'image/jpeg' (length=10)
        'tmp_name' => string 'C:\wamp64\tmp\php6E30.tmp' (length=25)
        'error' => int 0 
        'size' => int 68163 <<<<<-----

    */

//verificar o tamnho do arquivo, se o size é 0 não existe arquivo.
if ($certificado['size'] == 0) {

    //atribuir a variavél sql ($sql) o comando para alterar os valores no banco de dados.
    $sql = "UPDATE entrega_atividade SET id_atividade_complementar= $atividade_complementar, titulo_certificado = '$titulo', carga_horaria_certificado = $carga WHERE id_entrega_atividade = $id ";

    //excutar como sql ($sql).
    excutarSQL($mysql, $sql);

    //redirecionar o aluno para a sua tela inicial.
    header("location: ../inicialAluno.php");
} else {

    //se o size for maior do que 0, quer dizer que o aluno enviou um arquivo.

    /*

    C:\wamp64\www\Jeverson-tcc\crudEntrega\cadastrarEntrega.php:26:
    array (size=5)
        'name' => string 'Motivação Vôlei.jpeg' (length=23) 
        'type' => string 'image/jpeg' (length=10)
        'tmp_name' => string 'C:\wamp64\tmp\php6E30.tmp' (length=25)
        'error' => int 0 <<<<<-----
        'size' => int 68163 

    */

    //verificar se deu erro no recebimento do arquivo.
    if ($certificado['error']) {

        die("Falha ao receber o certificado enviado! <p><a href = \"formcadEntrega.php\">Tentar de novo?</a></p>");
    } else {

        //se nçao houve arro norecebimento do arquivo devemos processeguir com o uopload do arquivo e alterações no banco de dados.

        /*

        C:\wamp64\www\Jeverson-tcc\crudEntrega\cadastrarEntrega.php:26:
        array (size=5)
            'name' => string 'Motivação Vôlei.jpeg' (length=23) <<<<<-----
            'type' => string 'image/jpeg' (length=10)
            'tmp_name' => string 'C:\wamp64\tmp\php6E30.tmp' (length=25)
            'error' => int 0 
            'size' => int 68163 

        */

        //receber o nome do arquivo.
        $nome_certificado = $certificado['name'];

        //"uniqid()" é utilizado para gerar um identificador único baseado no tempo atual em microssegundos. Isso é útil para criar IDs únicos para elementos como nomes de arquivos, identificadores de sessão, ou qualquer outra situação onde um identificador único é necessário.

        //mudar o nome do arquivo, porque caso um usuário cadastrar um arquivo com o mesmo nome que outro arquivo já cadastrado no sistema, um dos arquivos vai acabar sendo substituido pelo novo.
        $novo_nome_certificado = uniqid();

        //strtolower(); as vezes podemos salvar um arquivo das seguintes maneiras JPG ou jpg, então por isso usamos strtolower para converter tudo para minúsculo.

        //pathinfo($nome_certificado, PATHINFO_EXTENSION): quando fazemos o upload de arquivos, o mesmo tem um caminho entao usamos esse código para pegar desse caminho, a extenção.

        //extrair a extenção do arquivo.
        $extencao = strtolower(pathinfo($nome_certificado, PATHINFO_EXTENSION));

        //delimitar os tipos de arquivos, por questões de segurança.
        if (
            $extencao != "png" and $extencao != "jpeg" and

            $extencao != "gif" and $extencao != "jfif" and

            $extencao != "svg" and $extencao != "pdf" and $extencao != "jpg"
        ) {

            die("Este tipo de arquivo nao é aceito. <p><a href = \"formeditEntrega.php\">Voltar</a></p>");
        } else {

            //declarar o caminho do arquivo.
            $caminho2 = $novo_nome_certificado . "." . $extencao;

            // o move_uploaded_file(); serve para mover um arquivo recebido para uma nova localização no projeto, no nosso caso é a pasta de certificado.

            //mover o arquivo para a pasta de destino.
            $deu_certo = move_uploaded_file($certificado['tmp_name'], $pastaDestino . $caminho2);

            //verificar se houve algum erro na hora de mover o arquivo.
            if ($deu_certo) {

                //se não houve erros até aqui, podemos atribuir a variavél sql ($ql) o comando de alterações no banco de dados.
                $sql = "UPDATE entrega_atividade SET id_atividade_complementar  = $atividade_complementar , titulo_certificado = '$titulo', carga_horaria_certificado = $carga, certificado = '$nome_certificado',caminho = '$caminho2' WHERE id_entrega_atividade = $id";

                //excutar o comando sql ($sql).
                excutarSQL($mysql, $sql);

                //"unlink()" é utilizado para deletar um arquivo do sistema de arquivos.

                //se o processo chegou até aqui, quer dizer que o aluno colocou outro arquivo no lugar do atual e por isso devemos depois de alterar no banco de dados, excluir da pasta de destino o arquivo antigo que recebemos porque ele agora não vai ter mais nenhuma utilidade.
                unlink($pastaDestino . $caminho);

                //redirecionar o aluno para a sua tela inicial.
                header("location: ../inicialAluno.php");
            }
        }
    }
}
