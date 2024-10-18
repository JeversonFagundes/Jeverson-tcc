<?php

//FORCADALUNO.PHP

//inicluir o arquivo que exibe as notificações do sistema.
require_once "boasPraticas/notificacoes.php";

//conectar ao banco de dados jeverson-tcc.
require_once "conecta.php";

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
    <title>Tela de cadastro</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .main-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }

        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        .error {
            border-color: red !important;
        }

        .error-message {
            color: red;
            font-size: 0.9em;
        }
    </style>
</head>

<body>
    <div class="main-container">
        <div class="form-container">
            <h4 class="text-center">Formulário de cadastro</h4>
            <?php
            //chamar a função que exibe a notificação para o aluno.
            exibirNotificacoes();
            //limpar a notificação de dentro da sessão.
            limpaNotificações();
            ?>
            <form action="cadastrarAluno.php" method="post" onsubmit="return validateForm()">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome:</label>
                    <input type="text" name="nome" id="nome" class="form-control" pattern="[A-Za-zÀ-ÿ\s]+" title="O nome deve conter apenas letras." placeholder="Digite o seu nome completo" required>
                    <div id="nomeHelp" class="form-text">O nome deve conter apenas letras.</div>
                    <small class="error-message" id="nome-error"></small>
                </div>
                <div class="mb-3">
                    <?php
                    //buscar pelos curso de exibi-los em ordem alfabética.
                    $sql = "SELECT id_curso, nome_curso FROM curso ORDER BY nome_curso ASC";
                    //atribuir a variável resultado ($resultado) o valor da execução do comando sql ($sql).
                    $resultado = excutarSQL($mysql, $sql);
                    ?>
                    <label for="curso" class="form-label">Curso:</label>
                    <select name="curso" id="curso" class="form-control" required>
                        <option selected disabled value="">Escolha um curso</option>
                        <?php
                        //Dentro da tag select criamos uma estrutura de repetição que irá atribuir a variável dados ($dados) um array associativo com os resultado do comando sql ($sql) que repetirá enquanto houver valores.
                        while ($dados = mysqli_fetch_assoc($resultado)) {
                        ?>
                            <option value="<?php echo $dados['id_curso'] ?>">
                                <?php echo $dados['nome_curso'] ?>
                            </option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="matricula" class="form-label">Matricula:</label>
                    <input type="text" name="matricula" id="matricula" class="form-control" pattern="[0-9]{8}" title="A matrícula deve conter 8 números." required>
                    <div id="matriculaHelp" class="form-text">A matrícula deve conter 8 números.</div>
                    <small class="error-message" id="matricula-error"></small>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" name="email" id="email" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Informe um email válido." required>
                    <div id="emailHelp" class="form-text">Informe um email válido.</div>
                    <small class="error-message" id="email-error"></small>
                </div>
                <div class="mb-3">
                    <label for="senha" class="form-label">Senha:</label>
                    <input type="password" name="senha" id="senha" class="form-control" pattern=".{6,}" title="A senha deve conter pelo menos 6 caracteres." required>
                    <div id="senhaHelp" class="form-text">A senha deve conter pelo menos 6 caracteres.</div>
                    <small class="error-message" id="senha-error"></small>
                </div>
                <div class="mb-3">
                    <label for="senha2" class="form-label">Confirmar senha:</label>
                    <input type="password" name="senha2" id="senha2" class="form-control" pattern=".{6,}" title="A senha deve conter pelo menos 6 caracteres." required>
                    <div id="senha2Help" class="form-text">A senha deve conter pelo menos 6 caracteres.</div>
                    <small class="error-message" id="senha2-error"></small>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Cadastrar</button>
                <p class="center-align"><a href="../logout.php">Voltar</a></p>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
   


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



                
            //definir a variavél que irá armazenar o total de horas aprovadas do aluno.
            $total = 0;

            // Percorre todas as linhas do resultado da consulta sql do banco de dados jeverson_tcc. No caso esses valores são referentes ao que o aluno entregou no banco de dados e esse while apenas faz a soma total da carga horaria aprovada.
            while ($entrega_atividades = mysqli_fetch_assoc($query)) {

                //soma da carga horaria total aprovada.
                $total = $total + $entrega_atividades['carga_horaria_aprovada'];

                if ($total > $total_curso) {

                    echo "Você completou as suas horas complementares de curso!";
                }
            }
</body>

</html>