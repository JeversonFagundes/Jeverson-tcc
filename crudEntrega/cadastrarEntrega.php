<?php

//CADASTRARENTREGA.PHP

//conectar com o banco de dados jeverson-tcc.
require_once "../conecta.php";

//incluir o arquivo de notificações do sistema.
require_once "../boasPraticas/notificacoes.php";

//declarar a variável de conexão com o banco de dados jeverson-tcc.
$mysql = conectar();

//declarar uma variavél que recebe o valor do id do aluno que estpa logado no momento.
$id = $_SESSION['aluno'][1];

//receber os dados vindos do formulário que está no formcadentrega.php.
$atividade_complementar = $_POST['atividade_complementar'];
$titulo = $_POST['titulo'];
$carga = $_POST['carga'];
$carga_deferida = $_POST['cargaDefe'];
$status = $_POST['status'];
$certificado = $_FILES['certificado'];
$observacoes = "Sem observações";

/*

Se fossemos olhar para dentro da variavél "cartificado", esse seria o resultado.

C:\wamp64\www\Jeverson-tcc\crudEntrega\cadastrarEntrega.php:26:
array (size=5)
  'name' => string 'Motivação Vôlei.jpeg' (length=23)
  'type' => string 'image/jpeg' (length=10)
  'tmp_name' => string 'C:\wamp64\tmp\php6E30.tmp' (length=25)
  'error' => int 0 <<<<<---------
  'size' => int 68163

*/

//verificar se houve erro no recebimento do arquivo.
if ($certificado['error'] != 0) {

    notificacoes(2, "Falha ao receber o arquivo!");

    header("location:formcadEntrega.php");

    die ();
} else {

    //se não houve no recebimento do arquivo, devemos processeguir com o upload do arquivo.

    //pasta de destino.
    $pastaDestino = "../certificados/";

    /*

    C:\wamp64\www\Jeverson-tcc\crudEntrega\cadastrarEntrega.php:26:
    array (size=5)
        'name' => string 'Motivação Vôlei.jpeg' (length=23) <<<<<-----
        'type' => string 'image/jpeg' (length=10)
        'tmp_name' => string 'C:\wamp64\tmp\php6E30.tmp' (length=25)
        'error' => int 0 
        'size' => int 68163

    */

    //pegar o nome do arquivo.
    $nome_certificado = $certificado['name'];

    //"uniqid()" é utilizado para gerar um identificador único baseado no tempo atual em microssegundos. Isso é útil para criar IDs únicos para elementos como nomes de arquivos, identificadores de sessão, ou qualquer outra situação onde um identificador único é necessário.

    //gerar um novo identificar eleatório para o arquivo.
    $novo_nome_certificado = uniqid();

    //"strtolower()" é utilizado para converter todos os caracteres alfabéticos de uma string para minúsculas.

    //"pathinfo($nome_certificado, PATHINFO_EXTENSION)" é utilizado para obter a extensão de um arquivo a partir de seu caminho

    //buscar pela extenção do arquivo.
    $extencao = strtolower(pathinfo($nome_certificado, PATHINFO_EXTENSION));

    //verificar as extenções que são permitidas.
    if (
        $extencao != "png" and $extencao != "jpeg" and

        $extencao != "gif" and $extencao != "jfif" and

        $extencao != "svg" and $extencao != "pdf" and $extencao != "jpg"

    ) {

        notificacoes(2, "Esse tipo de extenção '.$extencao' não é aceito");

        header("location:formcadEntrega.php");
    
        die ();
    } else {

        //se a extenção do arquivo faz parte das permitidas, devamos agora move-lo para a pasta onde vai ficar armazenado.

        //move_uploaded_file() é utilizado para mover um arquivo que foi enviado via formulário HTML para um novo local.

        /*

        C:\wamp64\www\Jeverson-tcc\crudEntrega\cadastrarEntrega.php:26:
        array (size=5)
            'name' => string 'Motivação Vôlei.jpeg' (length=23) 
            'type' => string 'image/jpeg' (length=10)
            'tmp_name' => string 'C:\wamp64\tmp\php6E30.tmp' (length=25) <<<<<-----
            'error' => int 0 
            'size' => int 68163

        */

        // move_uploaded_file("nome temporário do arquivo", "onde o arquivo vai ser salvo" . "novo nome do arquivo" . "." . "extenção do arquivo");

        //mover o arquivo.
        $mover_certificado = move_uploaded_file($certificado['tmp_name'], $pastaDestino . $novo_nome_certificado . "." . $extencao);

        //verificar se deu certo mover o arquivo.
        if ($mover_certificado) {

            //criar o caminho que será armazenado no banco de dados.
            $caminho = $novo_nome_certificado . "." . $extencao;

            //atribuir a variavál sql ($sql) o comando de inserção no banco de dados.
            $sql = "INSERT INTO entrega_atividade (titulo_certificado, carga_horaria_certificado, certificado, caminho, carga_horaria_aprovada, status, observacoes, id_aluno,id_atividade_complementar)           
            VALUES ('$titulo', $carga, '$nome_certificado','$caminho', $carga_deferida, '$status', '$observacoes',$id, $atividade_complementar)";

            //atribuir a variavél query ($query) a execução do comando sql ($sql).
            $query = excutarSQL($mysql, $sql);

            //adicionar a mensagem de cadastro feito com sucesso.
            notificacoes(1, "Entrega de atividade realizda com sucesso!");

            //redirecionar o aluno para a sua tela inicial.
            header("location:../inicialAluno.php");
        }
    }
}
