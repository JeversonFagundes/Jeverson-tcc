<?php

//FORMCADCOORDENADOR.PHP

//incluir o arquivo de notificações do sistema.
require_once "../boasPraticas/notificacoes.php";

//conectar com o banco de dados jeverosn-tcc.
require_once "../conecta.php";

//declarar a variavel de conexão com o banco de dados jeverson-tcc.
$mysql = conectar();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="../materialize/css/materialize.min.css" media="screen,projection" />

    <title>Cdastrar coordenador de curso</title>

    <style>
        .espacamento {
            margin-bottom: 30px;
        }
    </style>

    </style>
</head>

<body>

    <?php

    require_once "../boasPraticas/headerNav.php";
    ?>

    <!--conteudo principal-->
    <main class="container">

        <h1 class="center-align">Cadastrar coordenador de curso</h1>

        <?php

        exibirNotificacoes();

        limpaNotificacoes();

        ?>

        <div class="card-panel">

            <form action="cadastrarCoordenador.php" method="post">

                <div class="input-field col s12">
                    <i class="material-icons prefix">person_outline</i>
                    <input placeholder="Digite o nome do coordenador de curso" id="nome" name="nome" type="text" class="validate" pattern="^.+$" required>
                    <label for="nome">Nome do coordenador de curso : </label>
                    <span class="helper-text" data-error="Você deve preenchar esse campo"></span>
                </div>

                <?php

                //atribuir a variavél sql ($sql) a busca por todos os curso cadastrados no sistema e ordena-los em ordem alfabética.
                $sql = "SELECT id_curso, nome_curso FROM curso ORDER BY nome_curso ASC";

                //atribuir a veriavél resultado ($resultado) a execução do comando sql ($sql).
                $resultado = excutarSQL($mysql, $sql);
                ?>

                <label>Qual é o curso?</label>
                <!--As tags selects e options são usadas para criar menus suspensos (dropdowns) ou listas de opções em formulários.-->
                <!--SELECT cria um menu suspenso que permite ao usuário escolher uma ou mais opções.-->
                <select name="curso" class="browser-default ">
                    <!--OPTION define cada opção dentro do menu suspenso.-->
                    <option value="" disabled selected>Escolha o curso</option>

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

                <br>

                <div class="input-field col s12 espacamento">
                    <i class="material-icons prefix">mail_outline</i>
                    <input placeholder="Digite o seu email" id="email" name="email" type="text" class="validate" pattern="^.*@.*$" required>
                    <label for="email">Email</label>
                    <span class="helper-text" data-error="O campo deve conter o @, exemplo user@gmail.com"></span>
                </div>

                <div class="input-field col s12 espacamento">
                    <i class="material-icons prefix">lock_outline</i>
                    <input id="senha" type="password" placeholder="Digite a seu senha" class="validate" name="senha" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$" required>
                    <label for="senha">Senha</label>
                    <span class="helper-text" data-error="Deve ter 8 caracteres, no mínimo e  conter pelo menos 1 letra maiuscula,1 letra minuscula, 1 número e 1 caracter especial;."> </span>
                </div>

                <div class="input-field col s12">
                    <i class="material-icons prefix">lock_outline</i>
                    <input id="senha2" type="password" placeholder="Digite a seu senha" class="validate" name="senha2" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$" required>
                    <label for="senha2">Confirmar senha</label>
                    <span class="helper-text" data-error="Deve ter 8 caracteres, no mínimo e  conter pelo menos 1 letra maiuscula,1 letra minuscula, 1 número e 1 caracter especial;."> </span>
                </div>

                <div class="row">
                    <div class="col s12">
                        <p class="center-align">
                            <button class="btn waves-effect waves-light #2e7d32 green darken-3 lighten-3" type="submit" name="action">Cadastrar coordenador de curso
                                <i class="material-icons right">send</i> </button>
                        </p>
                    </div>
                </div>

            </form>

        </div>

    </main>

    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="../materialize/js/materialize.min.js"></script>
</body>

</html>