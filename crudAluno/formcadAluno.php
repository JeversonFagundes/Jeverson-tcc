<?php

//FORCADALUNO.PHP

//inicluir o arquivo que exibe as notificações do sistema.
require_once "../boasPraticas/notificacoes.php";

//conectar ao banco de dados jeverson-tcc.
require_once "../conecta.php";

//declarar a veriavél de conexão com o banco de dados jeverson-tcc. Essa veriavél vem do arquivo conecta.php.
$mysql = conectar();

//buscar pelos curso de exibi-los em ordem alfabética.
$sql = "SELECT id_curso, nome_curso FROM curso ORDER BY nome_curso ASC";

//atribuir a veriavél resultado ($resultado) o valor da excução do comando sql ($sql).
$resultado = excutarSQL($mysql, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="">
    <title>Tela de cadastro</title>

</head>

<body>

    <main>

        <h1>Formulário de cadastro</h1>

        <?php

        //chamar a função que exibe a notificação para o aluno.
        exibirNotificacoes();

        //limpar a notificação de dentro da sessão.
        limpaNotificacoes();
        ?>

        <form action="cadastrarAluno.php" method="post">

            <label for="nome">Nome: </label>
            <input type="text" name="nome" id="nome" required><br><br>


            <?php

            //buscar pelos curso de exibi-los em ordem alfabética.
            $sql = "SELECT id_curso, nome_curso FROM curso ORDER BY nome_curso ASC";

            //atribuir a veriavél resultado ($resultado) o valor da excução do comando sql ($sql).
            $resultado = excutarSQL($mysql, $sql);
            ?>

            <!--As tags selects e options são usadas para criar menus suspensos (dropdowns) ou listas de opções em formulários.-->
            <!--SELECT cria um menu suspenso que permite ao usuário escolher uma ou mais opções.-->
            <select name="curso" required>

                <!--OPTION define cada opção dentro do menu suspenso.-->
                <option selected disabled value="">Escolha um curso</option>

                <!--selected é usado para definir uma opção como pré-selecionada quando a página é carregada.-->
                <!--disabled é usado para tornar uma opção não selecionável.-->

                <?php

                //Dentro da tag select criamos uma estrutura de repetição que irá atribuir a veriavél dados ($dados) um array associativo com os resultado do comando sql ($sql) que repetirá enquanto houver valores.
                while ($dados = mysqli_fetch_assoc($resultado)) {

                ?>

                    <!--o while ($dados = mysqli_fetch_assoc($resultado) irá impremir options com os valores do array associativo.-->
                    <option value="<?php echo $dados['id_curso'] ?>">

                        <?php echo $dados['nome_curso'] ?>

                        <!--Um option que tem o valor do id_curso e tem em sua parte visivél o nome do curso.-->

                    </option>
                <?php
                }
                ?>

            </select><br><br>

            <label for="matricula">Matricula: </label>
            <input type="text" name="matricula" id="matricula" required><br><br>

            <label for="email"> Email: </label>
            <input type="email" name="email" id="email" required><br><br>

            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" required><br><br>

            <label for="senha2">Confirmar senha:</label>
            <input type="password" name="senha2" id="senha2" required><br><br>

            <input type="submit" value="Cadastrar"><br>

            <p><a href="../logout.php">Voltar</a></p>
        </form>
    </main>

    <!--Import jQuery before materialize.js-->
    <!--<script type="text/javascript" src="../js/materialize.min.js"></script>-->

    <?php

    /*

    Esse é o código sem estilização e o primeiro que eu criei.

     <h1>Formulário de cadastro</h1>

        <?php

        //aqui verificamos se uma notificação no sistema
        if (isset($_SESSION['notificacoes'])) {

        ?>

            <!--se houver criamos um paragrafo para imprimi-la-->
            <p><?php echo $_SESSION['notificacoes']; ?></p>

        <?php

            //unset() é usado para destruir variáveis específicas. Basicamente, ele remove a variável e a memória associada a ela. Funciona com variáveis normais, variáveis de sessão, e até elementos de arrays.
            //aqui limpamos da sessão notificações a notificação que foi gerada pelo sistema.
            unset($_SESSION['notificacoes']);
        }

        ?>
        <form action="cadastrarAluno.php" method="post">

            <label for="nome">Nome: </label>
            <input type="text" name="nome" id="nome" required><br><br>


            <?php

            //buscar pelos curso de exibi-los em ordem alfabética.
            $sql = "SELECT id_curso, nome_curso FROM curso ORDER BY nome_curso ASC";

            //atribuir a veriavél resultado ($resultado) o valor da excução do comando sql ($sql).
            $resultado = excutarSQL($mysql, $sql);
            ?>

            <!--As tags selects e options são usadas para criar menus suspensos (dropdowns) ou listas de opções em formulários.-->
            <!--SELECT cria um menu suspenso que permite ao usuário escolher uma ou mais opções.-->
            <select name="curso" required>

                <!--OPTION define cada opção dentro do menu suspenso.-->
                <option selected disabled value="">Escolha um curso</option>

                <!--selected é usado para definir uma opção como pré-selecionada quando a página é carregada.-->
                <!--disabled é usado para tornar uma opção não selecionável.-->

                <?php

                //Dentro da tag select criamos uma estrutura de repetição que irá atribuir a veriavél dados ($dados) um array associativo com os resultado do comando sql ($sql) que repetirá enquanto houver valores.
                while ($dados = mysqli_fetch_assoc($resultado)) {

                ?>

                    <!--o while ($dados = mysqli_fetch_assoc($resultado) irá impremir options com os valores do array associativo.-->
                    <option value="<?php echo $dados['id_curso'] ?>">

                        <?php echo $dados['nome_curso'] ?>

                        <!--Um option que tem o valor do id_curso e tem em sua parte visivél o nome do curso.-->

                    </option>
                <?php
                }
                ?>

            </select><br><br>

            <label for="matricula">Matricula: </label>
            <input type="text" name="matricula" id="matricula" required><br><br>

            <label for="email"> Email: </label>
            <input type="email" name="email" id="email" required><br><br>

            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" required><br><br>

            <label for="senha2">Repetir senha:</label>
            <input type="password" name="senha2" id="senha2" required><br><br>

            <input type="submit" value="Cadastrar"><br>

            <p><a href="../logout.php">Voltar</a></p>
        </form>
    
    */
    ?>
</body>

</html>