<?php

//INICIALALUNO.PHP

//conectar com o banco de dados jeverson-tcc
require_once "conecta.php";

//incluir o arquivo de proteção do sistema.
require_once "protecao.php";

//criar a variavél de conexão com o banco de dados jeverson-tcc. Esta variavél vem do arquivo conecta.php.
$mysql = conectar();

//pasta de destino para onde vão os certificados.
$pasta = "certificados/";

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <!--Import Google Icon Font-->
    <!--<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">-->
    <!--Import materialize.css-->
    <!--<link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela inicial</title>

    <!--Estilização em formato de card para as informações que são exibidas para o aluno sobre as atividades que ele cadastrou no sistema.-->
    <style>
        .card {
            background-color: white;
            width: 40%;
            height: 500px;
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

        //com a quantidade de linhas em mãos agora é possivél fazer verificações com relação a isso.
        if ($quantidade == 0) {

            echo "Você não entregou nenhuma atividade complementar no sistema ainda!";

            die();
        } else {

            //Se a quantidade for diferente de zero, atribuimos a variavél dados ($dados) um array associativo com os valores da excução query ($query) do comando sql ($sql) que será repetido enquanto houver dados. 
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
                            <button class="alterar" value="<?php echo $dados['id_entrega_atividade']; ?>">Alterar</button>
                            <button class="btnExcluir" value="<?php echo $dados['id_entrega_atividade']; ?>">Excluir</button>
                        </div>
                    </div>

                <?php

                    /*echo '<div class="card">';
                    echo '<div class="card-body">';
                    echo '<h1 class="card-title">' . 'Titulo do certificado:' . ' ' . $dados['titulo_certificado'] . '</h1>';
                    echo '<p class="card-text">' . 'Descrição da natureza: ' . '' . $dados['natureza'] . '</p>';
                    echo '<p class="card-text">' . 'Descrição da natureza: ' . '' . $dados['descricao'] . '</p>';

                    //aqui passamos um link para que o aluno possa var o arquivo que ele cadastrou no sistema
                    echo '<p class="card-title">' . 'O certificado:' . ' ' . '<a href="' . $pasta . $dados['caminho'] . '">' . $dados['certificado'] . '</a>' . '</p>';

                    echo '<p class="card-text">' . 'Carga horaria do seu certificado: ' . '' . $dados['carga_horaria_certificado'] . '</p>';
                    echo '<p class="card-text">' . 'Carga horaria deferida: ' . '' . $dados['carga_horaria_aprovada'] . '</p>';
                    echo '<p class="card-text">' . 'Situação:' . ' ' . $dados['status'] . '</p>';
                    echo '<p class="card-text">' . 'Observações:' . ' ' . $dados['observacoes'] . '</p>';
                    echo '<p class = "editar"> <a href="crudEntrega/formeditEntrega.php?id=' . $dados['id_entrega_atividade'] . '"> Alterar</a> </p>';
                    echo '<p class  = "excluir"> <a href="crudEntrega/excluirEntrega?id=' . $dados['id_entrega_atividade'] . '"> Excluir </a> </p>';
                    echo '</div>';
                    echo '</div>'; */
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
                            <button class="alterar" value="<?php echo $dados['id_entrega_atividade']; ?>">Alterar</button>
                            <button class="btnExcluir" value="<?php echo $dados['id_entrega_atividade']; ?>">Excluir</button>
                        </div>
                    </div>

        <?php

                    /*//Se não for verdadeiro as informações de observações e carga horária aprovada não precisam aparecer para o aluno.
                    echo '<div class="card">';
                    echo '<div class="card-body">';
                    echo '<h1 class="card-title">' . 'Titulo do certificado:' . ' ' . $dados['titulo_certificado'] . '</h1>';
                    echo '<p class="card-text">' . 'Natureza do certificado: ' . '' . $dados['natureza'] . '</p>';
                    echo '<p class="card-text">' . 'Descrição da natureza: ' . '' . $dados['descricao'] . '</p>';

                    //aqui passamos um link para que o aluno possa var o arquivo que ele cadastrou no sistema
                    echo '<p class="card-title">' . 'O certificado:' . ' ' . '<a href="' . $pasta . $dados['caminho'] . '">' . $dados['certificado'] . '</a>' . '</p>';

                    echo '<p class="card-text">' . 'Carga horaria do seu certificado: ' . '' . $dados['carga_horaria_certificado'] . '</p>';
                    echo '<p class="card-text">' . 'Situação:' . ' ' . $dados['status'] . '</p>';
                    echo '<p class = "editar"> <a href="crudEntrega/formeditEntrega.php?id=' . $dados['id_entrega_atividade'] . '"> Alterar</a> </p>';
                    echo '<p class  = "excluir"> <a href="crudEntrega/excluirEntrega?id=' . $dados['id_entrega_atividade'] . '"> Excluir </a> </p>';
                    echo '</div>';
                    echo '</div>'; */
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
    <!--<script type="text/javascript" src="js/materialize.min.js"></script>-->

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

        /*
        
        // Seleciona todos os botões com a classe 'btnExcluir'
const botoesExcluir = document.querySelectorAll('.btnExcluir');
Descrição: Esta linha seleciona todos os elementos do documento que possuem a classe btnExcluir e os armazena na constante botoesExcluir. querySelectorAll retorna uma lista de todos esses elementos.
JavaScript

// Adiciona um evento de clique a cada botão
botoesExcluir.forEach(botao => {
Descrição: Esta linha inicia um loop que percorre cada botão na lista botoesExcluir. Para cada botão, ele executa a função fornecida.
JavaScript

    botao.addEventListener('click', function() {
Descrição: Para cada botão, esta linha adiciona um “ouvinte” de evento de clique. Isso significa que quando o botão é clicado, a função fornecida será executada.
JavaScript

        // Captura o valor do botão
        const valorBotao = this.value;
Código gerado por IA. Examine e use com cuidado. Mais informações em perguntas frequentes.
Descrição: Dentro da função de clique, esta linha captura o valor do botão que foi clicado. this refere-se ao botão que foi clicado, e this.value obtém o valor desse botão.
JavaScript

        // Exibe a confirmação
        let primeiraConfirmacao = confirm("Fique ciente de que realizar essa ação irá excluir todos os dados da sua conta e também as atividades que você entregou no sistema. Deseja excluir sua conta?");
Código gerado por IA. Examine e use com cuidado. Mais informações em perguntas frequentes.
Descrição: Esta linha exibe uma caixa de diálogo de confirmação para o usuário com a mensagem especificada. A função confirm retorna true se o usuário clicar em “OK” e false se clicar em “Cancelar”.
JavaScript

        // Se o usuário confirmar, redireciona para a página de exclusão
        if (primeiraConfirmacao) {
            window.location.href = 'crudEntrega/excluirEntrega.php?id=' + valorBotao;
        }
Código gerado por IA. Examine e use com cuidado. Mais informações em perguntas frequentes.
Descrição: Se o usuário clicar em “OK” na caixa de confirmação, esta linha redireciona o navegador para a URL especificada, incluindo o valor do botão como um parâmetro de consulta (id). Isso geralmente é usado para passar informações para o servidor.
JavaScript

        // Se o usuário cancelar, não faz nada
    });
});
Código gerado por IA. Examine e use com cuidado. Mais informações em perguntas frequentes.
Descrição: Se o usuário clicar em “Cancelar” na caixa de confirmação, o código dentro do bloco if não será executado, e nada acontecerá.
        */
    </script>
</body>

</html>