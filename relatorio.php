<?php
require_once "conecta.php";
$mysql = conectar();
require_once "boasPraticas/notificacoes.php";
require 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Configurar opções do DOMPDF
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

if (isset($_SESSION['aluno'])) {

    $sql_total_horas = "SELECT SUM(ea.carga_horaria_aprovada) FROM entrega_atividade ea WHERE ea.id_aluno =" . $_SESSION['aluno'][1] . " AND ea.status = 'Deferido'";

    $execucao_total_horas = excutarSQL($mysql, $sql_total_horas);

    //definir a variável que irá armazenar o total de horas aprovadas do aluno.
    $total_horas_aprovadas = mysqli_fetch_assoc($execucao_total_horas);

    $sql_coordenador_curso = "SELECT nome FROM coordenador_curso WHERE id_curso = " . $_SESSION['aluno'][2];
    $query_coordenador = excutarSQL($mysql, $sql_coordenador_curso);
    $coordenador_curso = mysqli_fetch_assoc($query_coordenador);

    $sql = "SELECT 
                ea.titulo_certificado, 
                ea.carga_horaria_certificado, 
                ea.carga_horaria_aprovada, 
                ea.status,
                a.nome, 
                a.matricula, 
                c.nome_curso, 
                c.carga_horaria 
            FROM 
                entrega_atividade ea 
            INNER JOIN 
                aluno a ON ea.id_aluno = a.id_aluno
            INNER JOIN 
                curso c ON a.id_curso = c.id_curso
            WHERE 
                ea.id_aluno = " . $_SESSION['aluno'][1];

    $query = excutarSQL($mysql, $sql);
    $todas_atividades_aluno = mysqli_fetch_all($query, MYSQLI_ASSOC);
} else {

    if ($_SESSION['coordenador']) {

        $id_aluno = $_GET['id'];

        $sql_total_horas = "SELECT SUM(ea.carga_horaria_aprovada) FROM entrega_atividade ea WHERE ea.id_aluno = $id_aluno AND ea.status = 'Deferido'";

        $execucao_total_horas = excutarSQL($mysql, $sql_total_horas);

        //definir a variável que irá armazenar o total de horas aprovadas do aluno.
        $total_horas_aprovadas = mysqli_fetch_assoc($execucao_total_horas);

        $sql_coordenador_curso = "SELECT nome FROM coordenador_curso WHERE id_coordenador = " . $_SESSION['coordenador'][1];
        $query_coordenador = excutarSQL($mysql, $sql_coordenador_curso);
        $coordenador_curso = mysqli_fetch_assoc($query_coordenador);

        $sql = "SELECT 
                    ea.titulo_certificado, 
                    ea.carga_horaria_certificado, 
                    ea.carga_horaria_aprovada, 
                    ea.status,
                    a.nome, 
                    a.matricula, 
                    c.nome_curso, 
                    c.carga_horaria 
                FROM 
                    entrega_atividade ea 
                INNER JOIN 
                    aluno a ON ea.id_aluno = a.id_aluno
                INNER JOIN 
                    curso c ON a.id_curso = c.id_curso
                WHERE 
                    ea.id_aluno = $id_aluno";

        $query = excutarSQL($mysql, $sql);
        $todas_atividades_aluno = mysqli_fetch_all($query, MYSQLI_ASSOC);
    }
}

// HTML inicial
$dados = '
<html>
<head>
 <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="materialize/css/materialize.min.css" media="screen,projection" />
<link rel="StyleSheet" type="Text/css" href="estilo.css">

<style>
body { font-family: Arial, sans-serif; 
}
h1 { color:#a1887f; 
}
table { border-collapse: collapse; width: 100%; 
}
td, th { text-align: left; padding: 10px; 
}
tr:nth-child(even) { background-color: #f2f2f2; 
}
thead { background-color: #a1887f; color: white; 
}

</style>

</head>

<body>
';

$dados .= "<main class=\"container\">";

$dados .= "<h2 style='text-align: center;'><img src='http://localhost/jeverson-tcc/iffar.jpg' height='80' width='65%'> </h2>" . "<br><br>";

$dados .= "<h1 style='text-align: center;text-decoration: underline;'> Relatório das horas aprovadas</h1>" . "<br><br>";

$dados .= "Eu " . $coordenador_curso['nome'] . ", como coordenador de curso do " . $todas_atividades_aluno[0]['nome_curso'] . ", declaro que o aluno " . $todas_atividades_aluno[0]['nome'] . " com a matrícula " . $todas_atividades_aluno[0]['matricula'] . " concluiu todas as suas horas complementares de curso." . "<br><br>";

$dados .= "<table>
        <thead>
          <tr>
          <th>Titulo do certificado</th>
          <th>Carga horária entregue</th>
          <th>Carga horária aprovada</th>         
          <th>Situação</th>         
          </tr>
        </thead>
        <tbody>";

foreach ($todas_atividades_aluno as $dados_table) {
    $dados .= "<tr>";
    $dados .= "<td> " . $dados_table['titulo_certificado'] . "</td>";
    $dados .= "<td> " . $dados_table['carga_horaria_certificado'] . "</td>";
    $dados .= "<td> " . $dados_table['carga_horaria_aprovada'] . "</td>";
    $dados .= "<td> " . $dados_table['status'] . "</td>";
    $dados .= "</tr>";
}
$dados .= "</tbody>";
$dados .= "</table>" . "<br>";

$dados .= "<p style='text-align: center;'><strong>Total de horas aprovadas: " . $total_horas_aprovadas['SUM(ea.carga_horaria_aprovada)'] . " / " . $todas_atividades_aluno[0]['carga_horaria'] . "</strong></p><br>";

$dados .= "<p style='text-align: center;'> <strong>" . $coordenador_curso['nome'] . " </strong><br> Assinatura do coordenador de curso: <br><br> <strong>" . $todas_atividades_aluno[0]['nome'] . "</strong> <br> Assinatura do aluno:</p>";

echo "</main>";

$dados .= " <!--Import jQuery before materialize.js-->
    <script type=\"text/javascript\" src=\"materialize/js/materialize.min.js\"></script>";

$dados .= "</body></html>";

// Carrega o HTML no DOMPDF
$dompdf->loadHtml($dados);
// Define tamanho e orientação do papel
$dompdf->setPaper('A4', 'portrait');

// Renderizar o PDF
$dompdf->render();

// Enviar o PDF para o navegador
$dompdf->stream("relatorio.pdf", ["Attachment" => true]);
