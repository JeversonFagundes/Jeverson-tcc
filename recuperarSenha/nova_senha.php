<?php

//NOVA_SENHA.PHP

//incluir o arquivo de notificações do sistema.
require_once "../boasPraticas/notificacoes.php";

// verificar o email.
// verificar o token.
$email = $_GET['email'];
$token = $_GET['token'];

//conectar com o banco de dados jeverson-tcc.
require_once "../conecta.php";

//declarar variavél de conexão com o banco de dados jeverson-tcc.
$mysql = conectar();

//buscar por todos os dados da tabela recuperar_senha com a condição de ser onde o email e o token forem os que acabamos de receber.
$sql = "SELECT * FROM recuperar_senha WHERE email='$email' AND token='$token'";

//executar o comando sql ($sql).
$resultado = excutarSQL($mysql, $sql);

//atribuir a variavél recuperar ($recuperar) os valores retornados da execução do comando $sql.
$recuperar = mysqli_fetch_assoc($resultado);

//fazer a primeira verificação.
if ($recuperar == null) {

    echo "Email ou token incorreto. Tente fazer um novo pedido de recuperação de senha.";

    die();
} else {

    // verificar a validade do pedido (data_criacao).
    // verificar se o link já foi.

    date_default_timezone_set('America/Sao_Paulo'); //Esta função define o fuso horário padrão para todas as funções de data e hora no script. No caso, está configurando o fuso horário para "America/Sao_Paulo

    $agora = new DateTime('now'); //Cria uma nova instância da classe DateTime representando a data e hora atuais. A string 'now' indica que queremos a data e hora do momento da execução do código.

    $data_criacao = DateTime::createFromFormat('Y-m-d H:i:s', $recuperar['data_criacao']); //Cria uma instância de DateTime a partir de uma string de data e hora no formato 'Y-m-d H:i:s' (ano-mês-dia hora:minuto:segundo). A variável $recuperar['data_criacao'] deve conter essa string de data e hora.

    $umDia = DateInterval::createFromDateString('1 day'); //Cria um objeto DateInterval que representa um intervalo de tempo de 1 dia. Esse objeto pode ser usado para adicionar ou subtrair tempo de um objeto DateTime.

    $dataExpiracao = date_add($data_criacao, $umDia); //Adiciona o intervalo de 1 dia ($umDia) à data de criação ($data_criacao). O resultado é uma nova data e hora armazenada em $dataExpiracao, que representa a data de expiração.

    //fazer a segunda verificação.
    if ($agora > $dataExpiracao) {

        echo "Essa solicitação de recuperação de senha expirou! Faça um novo pedido de recuperação de senha.";

        die();
    }

    //fazer a terceira verificação.
    if ($recuperar['usado'] == 1) {

        echo "Esse pedido de recuperação de senha já foi utilizado anteriormente! Para recuperar a senha faça um novo pedido de recuperação de senha.<p><a href = \"../index.php\">Voltar</a></p>";

        die();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">

    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="../materialize/css/materialize.min.css" media="screen,projection" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Senha</title>

    <style>
        p{
            font-size: 20px;
        }
    </style>
</head>

<body>

    <!--conteudo principal-->
    <main class="container">

        <h1 class="center-align">Recuperação de senha</h1>

        <p>Seu email : <?php echo $email ?> </p>

        <div class="card-panel">
            <form action="salvar_nova_senha.php" method="post">

                <input type="hidden" name="email" value="<?= $email ?>">
                <input type="hidden" name="token" value="<?= $token ?>">

                <div class="input-field col s12 espacamento">
                    <i class="material-icons prefix">lock_outline</i>
                    <input id="senha" type="password" placeholder="Digite a seu senha" class="validate" name="senha" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$" required>
                    <label for="senha">Senha</label>
                    <span class="helper-text" data-error="Deve ter 8 caracteres, no mínimo e  conter pelo menos 1 letra maiuscula,1 letra minuscula, 1 número e 1 caracter especial;."> </span>
                </div>

                <br>

                <div class="input-field col s12 espacamento">
                    <i class="material-icons prefix">lock_outline</i>
                    <input id="repetirSenha" type="password" placeholder="Repita sua senha" class="validate" name="repetirSenha" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$" required>
                    <label for="repetirSenha">Repitir senha</label>
                    <span class="helper-text" data-error="Deve ter 8 caracteres, no mínimo e  conter pelo menos 1 letra maiuscula,1 letra minuscula, 1 número e 1 caracter especial;."> </span>
                </div>

                <div class="row">
                    <div class="col s12">
                        <p class="center-align">
                            <button class="btn waves-effect waves-light #00c853 green accent-4 lighten-3" type="submit" name="action">Recuperar senha
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