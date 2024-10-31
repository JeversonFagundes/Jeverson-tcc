<?php

//INICIALALUNO.PHP

//conectar com o banco de dados jeverson-tcc
require_once "conecta.php";

//incluir o arquivo de notificações do sistema.
require_once "boasPraticas/notificacoes.php";

//criar a variavél de conexão com o banco de dados jeverson-tcc. Esta variavél vem do arquivo conecta.php.
$mysql = conectar();

//pasta de destino para onde vão os certificados.
$pasta = "certificados/";

//fazer uma verificação para definir a variavél que irá receber o total de horas do curso. Por exemplo "a carga horaria obrigatório do curso de informática é 60 horas".

if ($_SESSION['aluno'][2] == 9) {

    $total_curso = 60;
} else {

    if ($_SESSION['aluno'][2] == 11 or $_SESSION['aluno'][2] == 13) {

        $total_curso = 40;
    } else {

        if ($_SESSION['aluno'][2] == 12) {

            $total_curso = 50;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="materialize/css/materialize.min.css" media="screen,projection" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela inicial</title>

    <!--Estilização em formato de card para as informações que são exibidas para o aluno sobre as atividades que ele cadastrou no sistema.-->
    <style>
        .card {
            background-color: white;
            width: 40%;
            height: 450px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px rgba(0, 0, 0, 0.19);
        }
    </style>

</head>

<body>

    <!--Para que não seja necessário criar toda vez um header com uma nav em todas as telas dos usuários, então aqui incluimos a pasta onde esta o arquivo onde está criado o header e o nav.-->
    <?php require_once "boasPraticas/headerNav.php"; ?>

    <main>

        <!--Sessão com o valor do nome aluno.-->
        <h2><?php echo $_SESSION['aluno'][0]; ?></h2>

        <p><a href="crudEntrega/formcadEntrega.php">Entregar atividade complementar</a></p>

        <hr>

        <h1>Minhas atividade complementares de curso</h1>

        <?php

        //listar todas as atividades cadastradas pelo aluno que está logado no sistema. Para isso buscamos na tabela entrega_atividade unindo ela com a tabela atividade_complementar e aluno, para que seja possivél exibir as atividades cadastradas pelo aluno junto a com as informações da atividades complementar de curso que essa entrega está relacionada, como natureza, descricão etc.
        $sql = "SELECT 
        ac.descricao, 
        ac.natureza,
        ac.id_atividade_complementar,
        ea.id_entrega_atividade,
        ea.titulo_certificado, 
        ea.carga_horaria_certificado,
        ea.certificado, 
        ea.carga_horaria_aprovada, 
        ea.status,
        ea.caminho,
        ea.id_atividade_complementar,
        ea.observacoes
        FROM entrega_atividade ea 
        INNER JOIN atividade_complementar ac 
        ON ea.id_atividade_complementar = ac.id_atividade_complementar
        INNER JOIN aluno a 
        ON a.id_aluno = ea.id_aluno
        WHERE 
        a.id_aluno = " . $_SESSION['aluno'][1];

        //atribuir a variavél query ($query) a excução do comando sql ($sql).
        $query = excutarSQL($mysql, $sql);

        //atribuir á variavél quantidade ($quantidade) a quantidade de linhas que foram retornadas no comando sql ($sql).
        $quantidade = $query->num_rows;

        //com a quantidade de linhas em mãos, agora é possivél fazer verificações com relação a isso.
        if ($quantidade == 0) {

            echo "Você não entregou nenhuma atividade complementar no sistema ainda!";

            die();
        } else {

            //bem acima das atividades que foram entregues no sistema, fica a mecanica de exibir notificações do sistema, que nesse caso exibi as nofiticações de "entrega realizada com sucesso no sistema!" qunado necessário.

            //exibir a mensagem de emtrega de atividade no sistema bem sucessedida.
            exibirNotificacoes();

            //limpar as notificações do sistema.
            limpaNotificacoes();

            //definir a variavél que irá receber a soma total de horas das atividades aprovadas pelo coordenador de curso.
            $total = 0;

            //definir a estrutura de repetição que será responsável por pegar o valor das horas do banco de dados jeverson_tcc e soma-las.
            while ($entrega_atividades = mysqli_fetch_assoc($query)) {

                //aqui  ocorre a soma das horas que foram aprovadas pelo coordenador de curso.
                $total = $total +  $entrega_atividades['carga_horaria_aprovada'];

                //aqui eu faço uma verificação de que o aluno já concluiu as suas horas complementares de curso aprovadas
                if ($total > $total_curso) {
                    echo "Você completou as suas horas complementares de curso!";
                }
            }
            echo "Total de horas aprovadas: " . $total . " " . "/" . " " . $total_curso; // Imprimir o total após o while

            //para que o proximo while funcione corretamente, pricisamos redefinir o ponteiro de dados no resultado de uma consulta para uma linha específica
            mysqli_data_seek($query, 0); // Reseta o ponteiro de dados do query

            //mysqli_data_seek(); redefine o ponteiro de dados no resultado de uma consulta para uma linha específica

            //definir a estrutura de repetição que irá mostrar na tela do aluno, todas as atividades que ele entregou no sistema.
            while ($dados = mysqli_fetch_assoc($query)) {

                //dentro da repetição verificamos se o status e a observação são diferentes das configurações padrões do sistema. Se isso for verdadeiro, significa que o coordenador de curso adcionou uma correção a entrega do certificado, diante disso imprimimos as informações de status, observações que o coordenador de curso adicionou e a carga horária que foi aprovada.
                if ($dados['status'] != "Em análise" or $dados['observacoes'] != "Sem observações") {
        ?>

                    <div class="card">
                        <div class="card-body">

                            <h1 class="card-titla">Titulo do certificado: <?php echo $dados['titulo_certificado']; ?></h1>
                            <p class="card-text">Natureza do certificado: <?php echo $dados['natureza']; ?></p>
                            <p class="card-text">Descrição da natureza: <?php echo $dados['descricao']; ?></p>
                            <p class="card-text">O certificado: <a href="<?php echo $pasta . $dados['caminho']; ?>"><?php echo $dados['certificado']; ?></a></p>
                            <p class="card-text">Carga horária do certificado: <?php echo $dados['carga_horaria_certificado']; ?></p>
                            <p class="card-text">Carga horária deferida: <?php echo $dados['carga_horaria_aprovada']; ?></p>
                            <p class="card-text">Situação: <?php echo $dados['status']; ?></p>
                            <p class="card-text">Observações: <?php echo $dados['observacoes']; ?></p>
                            <button class="btnAlterar" value="<?php echo $dados['id_entrega_atividade']; ?>">Alterar</button>
                            <button class="btnExcluir" value="<?php echo $dados['id_entrega_atividade']; ?>">Excluir</button>
                        </div>
                    </div>

                <?php


                } else {

                ?>

                    <div class="card">
                        <div class="card-body">

                            <h1 class="card-titla">Titulo do certificado: <?php echo $dados['titulo_certificado']; ?></h1>
                            <p class="card-text">Natureza do certificado: <?php echo $dados['natureza']; ?></p>
                            <p class="card-text">Descrição da natureza: <?php echo $dados['descricao']; ?></p>
                            <p class="card-text">O certificado: <a href="<?php echo $pasta . $dados['caminho']; ?>"><?php echo $dados['certificado']; ?></a></p>
                            <p class="card-text">Carga horária do certificado: <?php echo $dados['carga_horaria_certificado']; ?></p>
                            <p class="card-text">Situação: <?php echo $dados['status']; ?></p>
                            <button class="btnAlterar" value="<?php echo $dados['id_entrega_atividade']; ?>">Alterar</button>
                            <button class="btnExcluir" value="<?php echo $dados['id_entrega_atividade']; ?>">Excluir</button>
                        </div>
                    </div>

        <?php


                }
            }
        }
        ?>

    </main>

    <?php

    /*
        ?>

            <<table class="table">
                <thead>
                    <tr>
                        <th scope="col">Titulo do certificado</th>
                        <th scope="col">Nome do arquivo</th>
                        <th scope="col">Descrição</th>
                        <th scope="col"colspan="3">Opções</th>
                        
                    </tr>
                </thead>
                <tbody>

            
                <?php

                while ($dados = mysqli_fetch_assoc($query)) {
                    
                    echo "<tr>"; 
                    echo "<td>" .$dados['titulo_certificado'] . "</td>";
                    echo "<td>" .$dados['certificado'] . "</td>";
                    echo "<td>" .$dados['descricao'] . "</td>";
                    echo '<td> <a> <img style = " width:30px;   heigth:20px;  " src = "icons/lapis.png"> </a> </td>';
                    echo '<td> <a> <img style = " width:30px;   heigth:20px;  " src = "icons/lixeira.png"> </a> </td>';
                    echo '<td> <a> <img style = " width:30px;   heigth:20px;  " src = "icons/visualizar.png"> </a> </td>';
                    echo "</tr>";
                }

                ?>
                </tbody>
            </table>

        <?php */
    ?>

    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="materialize/js/materialize.min.js"></script>

    <script>
        // Seleciona todos os botões com a classe 'btnExcluir'
        const botoesExcluir = document.querySelectorAll('.btnExcluir');
        //.btnExcluir
        //#btnExcluir

        //  <input id="btnexcluir">
        //const bExcluir = document.querySelectorAll('#btnexcluir');

        // bExcluir.addEventListener('click', function() {
        //bExcluir.foreach ( )



        //foreach ($botoesExcluir as $be)


        //$botoesExcluir.foreach ( )

        // Adiciona um evento de clique a cada botão
        botoesExcluir.forEach(botao => {

            botao.addEventListener('click', function() {
                // Captura o valor do botão
                const valorBotao = this.value;

                // Exibe a confirmação
                let primeiraConfirmacao = confirm("Deseja excluir esse item?");

                // Se o usuário confirmar, redireciona para a página de exclusão
                if (primeiraConfirmacao) {
                    window.location.href = 'crudEntrega/excluirEntrega.php?id=' + valorBotao;
                }
                // Se o usuário cancelar, não faz nada
            });

        });

        // Seleciona todos os botões com a classe 'btnAlterar'
        const botoesAlterar = document.querySelectorAll('.btnAlterar');

        // Adiciona um evento de clique a cada botão
        botoesAlterar.forEach(botao => {

            botao.addEventListener('click', function() {
                // Captura o valor do botão
                const valorBotaoAlterar = this.value;
                window.location.href = 'crudEntrega/formeditEntrega.php?id=' + valorBotaoAlterar;

            });

        });
    </script>
</body>

</html>