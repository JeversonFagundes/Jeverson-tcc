<?php

//FORCADALUNO.PHP

//conectar ao banco de dados jeverson-tcc.
require_once "../conecta.php";

//inicluir com o arquivo das notificações do sistema.
require_once "../boasPraticas/notificacoes.php";

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
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="../css/materialize.min.css" media="screen,projection" />
    <title>Tela de cadastro</title>

</head>

<body>

    <main class="container">

        <h1 class="center-align">Formulário de cadastro</h1>

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

            <div class="card-panel">


                <!--<nome>-->
                <div class="row">

                    <div class="input-field col s12">
                        <input placeholder="Digite o seu nome" id="nome" name="nome" type="text" required>
                        <label for="nome">Digite o seu nome</label>
                    </div>
                </div>
                <!--</nome>-->


                <!--<select>-->
                <div class="input-field col s12">

                    <!--As tags selects e options são usadas para criar menus suspensos (dropdowns) ou listas de opções em formulários.-->
                    <!--SELECT cria um menu suspenso que permite ao usuário escolher uma ou mais opções.-->
                    <select name="curso" required>

                        <!--OPTION define cada opção dentro do menu suspenso.-->
                        <option value="" disabled selected>Escolha o seu curso</option>

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

                    </select>
                    <label>Qual é o seu curso?</label><br>
                </div>
                <!--</select>-->

                <!--<matricula>-->
                <div class="input-field col s12">
                    <input placeholder="Digite sua matricula" id="matricula" name="matricula" type="text" class="validate" pattern="^[0-9]{10}$" required>
                    <label for="mat">Digite a sua matricula</label>
                    <span class="helper-text" data-error="A sua matricula deve conter 10 caracteres númericos"></span>
                </div>
                <!--</matricula>-->


                <!--<email>-->
                <div class="row">

                    <div class="input-field col s12">
                        <input placeholder="Digite o seu email" id="email" name="email" type="email" class="validate" pattern=".*@.*" required>
                        <label for="email">Digite o seu email</label>
                        <span class="helper-text" data-error="O email precisa do caracter @, não pode haver espaços 'User @ gmail.com' e não pode haver mais de um ponto 'user@..gmail.com'"></span>
                    </div>
                </div>
                <!--</email>-->

                <!--<senha>-->
                <div class="input-field col s12">
                    <input id="senha" type="password" class="validate" name="senha" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$" required>
                    <label for="senha">Digite a sua senha</label>
                    <span class="helper-text" data-error="A sua senha deve ter no mínimo 8 caracteres, no mínimo e  conter pelo menos 1 letra maiuscula,1 letra minuscula, 1 número e 1 caracter especial;."> </span>
                </div>
                <!--</senha>-->

                <!--<confirmação de senha>-->
                <div class="input-field col s12">
                    <input id="senha2" type="password" class="validate" name="senha2" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$" required>
                    <label for="senha2">Repita a sua senha</label>
                    <span class="helper-text" data-error="A sua senha deve ter no mínimo 8 caracteres, no mínimo e  conter pelo menos 1 letra maiuscula,1 letra minuscula, 1 número e 1 caracter especial;."> </span>
                </div>
                <!--</confirmação de senha>-->

                <!--<botão de envio do formulário>-->
                <div class="row">
                    <div class="col s12">
                        <p class="center-align">
                            <button class="btn waves-effect waves-light brown  lighten-3" type="submit" name="action">Submit
                                <i class="material-icons right">send</i> </button>
                        </p>
                    </div>
                </div>
                <!--</botão de envio do formulário>-->
            </div>

            <p><a href="../logout.php">Voltar</a></p>
        </form>
    </main>

    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="../js/materialize.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('select');
            var instances = M.FormSelect.init(elems);
        });
    </script>

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