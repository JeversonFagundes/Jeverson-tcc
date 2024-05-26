<?php
//conectar com o banco de dados.
include ("../conecta.php");

include ("../protecao.php");

if (isset($_SESSION['id_aluno'])) {

    $id = $_SESSION['id_aluno'];
}

$natureza = $_POST['natureza'];
$titulo = $_POST['titulo'];
$carga = $_POST['carga'];
$carga_deferida = $_POST['cargaDefe'];
$status = $_POST['status'];
$certificado = $_FILES['certificado'];

if ($certificado['error']) {
    
    die ("Falha ao receber o certificado enviado! <p><a href = \"formcadEntrega.php\">Tentar de novo?</a></p>");

}else {
    
    //pasta onde o arquivo vai ser armazenado.
    $pasta = "../certificados/";

    //mudar o nome do arquivo, porque caso um usuário cadastrar um arquivo com o mesmo nome que outro arquivo já cadastrado no sistema, um dos arquivos vai acabar sendo substituido pelo novo.
    $nome_certificado = $certificado['name'];

    $novo_nome_certificado = uniqid();

    //extrair a extenção do arquivo.
    $extencao = strtolower(pathinfo($nome_certificado, PATHINFO_EXTENSION));

    //strtolower(); as vezes podemos salvar um arquivo das seguintes maneiras JPG ou jpg, então por isso usamos strtolower para converter tudo para minúsculo.

    //pathinfo($nome_certificado, PATHINFO_EXTENSION): quando fazemos o upload de arquivos, o mesmo tem um caminho entao usamos esse código para pegar desse caminho, a extenção.

    //delimitar os tipos de arquivos, por questões de segurança.
    if ($extencao != "jpg" and $extencao != "pdf") {
        
        die ("Este tipo de arquivo nao é aceito. <p><a href = \"formcadEntrega.php\">Voltar</a></p>");

    }else {
        
        $caminho = $pasta . $novo_nome_certificado . "." . $extencao;
        $deu_certo = move_uploaded_file($certificado['tmp_name'], $caminho);

        // o move_uploaded_file(); serve para mover um arquivo recebido para uma nova localização no projeto, no nosso caso é a pasta de certificado.

        if ($deu_certo) {
            
           //comando sql.
           $sql = "INSERT INTO entrega_atividade (natureza, titulo_certificado, carga_horaria_certificado, certificado, caminho, carga_horaria_aprovada, status, id_aluno)
           
           VALUES ('$natureza', '$titulo', $carga, '$nome_certificado','$caminho', $carga_deferida, '$status', $id)";

           //excutar o comando sql acima.
           mysqli_query($mysql, $sql);

           //caso dê erro.
           if ($mysql->error) {
            
            die ("Falha ao cadastrar sua atividade complemntar no sistema!" . $mysql->error);

           }else {
            
            header("location: ../inicialAluno.php");
           }
        }
    }

}
?>