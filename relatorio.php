<?php

require_once "boasPraticas/notificacoes.php";

// Conectar com o banco de dados
require_once "conecta.php";

$mysql = conectar();

// Configurar o Dompdf
require 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Configurar opções do DOMPDF
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

function excutarSQL($mysql, $sql)
{
    return mysqli_query($mysql, $sql);
}

if (isset($_SESSION['aluno'])) {
    $sql = "SELECT 
        a.nome,
        a.matricula, 
        a.total_horas, 
        c.nome_curso, 
        c.carga_horaria, 
        ea.titulo_certificado, 
        ea.carga_horaria_certificado, 
        ea.carga_horaria_aprovada, 
        ea.status
    FROM aluno a 
    INNER JOIN curso c ON a.id_curso = c.id_curso 
    INNER JOIN entrega_atividade ea ON a.id_aluno = ea.id_aluno 
    WHERE c.id_curso = " . $_SESSION['aluno'][2] . "
    AND a.id_aluno = " . $_SESSION['aluno'][1];

    $query = excutarSQL($mysql, $sql);
    if (!$query) {
        echo "Erro ao executar a consulta SQL: " . mysqli_error($mysql);
        exit;
    }

    $sql2 = "SELECT nome FROM coordenador_curso WHERE id_coordenador = " . $_SESSION['aluno'][2];
    $query2 = excutarSQL($mysql, $sql2);
    if (!$query2) {
        echo "Erro ao executar a consulta SQL2: " . mysqli_error($mysql);
        exit;
    }

    $nome_coordenador = mysqli_fetch_assoc($query2);
    $todas_informacoes_relatoria_aluno = mysqli_fetch_assoc($query);

    $dados = '<!DOCTYPE html>
    <html lang="pt-br">
    
    <head>
        <meta charset="UTF-8">
        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="materialize/css/materialize.min.css" media="screen,projection" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Relatório do aluno</title>
    </head>
    
    <body>
        <main class="container">
            <img src="jeverson-tcc/IMG-20240822-WA0006.jpg" class="center-align">
            <h1>Relatório do aluno</h1>
            <p>Eu ' . $nome_coordenador["nome"] . ', como coordenador de curso responsável pelo ' . $todas_informacoes_relatoria_aluno["nome_curso"] . ', declaro que o aluno ' . $todas_informacoes_relatoria_aluno["nome"] . ', portador da matrícula ' . $todas_informacoes_relatoria_aluno["matricula"] . ', completou suas horas complementares de curso, no equivalente de ' . $todas_informacoes_relatoria_aluno["carga_horaria"] . ' horas.</p>
        </main>
        <!--Import jQuery before materialize.js-->
        <script type="text/javascript" src="materialize/js/materialize.min.js"></script>
    </body>
    
    </html>';
}

// Carrega o HTML no DOMPDF
$dompdf->loadHtml($dados);
// Define tamanho e orientação do papel
$dompdf->setPaper('A4', 'portrait');

// Renderizar o PDF
$dompdf->render();

// Enviar o PDF para o navegador
$dompdf->stream("relatorio.pdf", ["Attachment" => true]);
