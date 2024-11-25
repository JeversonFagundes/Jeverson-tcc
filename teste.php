<?php

//FORCADALUNO.PHP

//inicluir o arquivo que exibe as notificações do sistema.
require_once "boasPraticas/notificacoes.php";

//conectar ao banco de dados jeverson-tcc.
require_once "conecta.php";

//declarar a veriavél de conexão com o banco de dados jeverson-tcc. Essa veriavél vem do arquivo conecta.php.
$mysql = conectar();

$senha = "123";

$senha1 = password_hash($senha,  PASSWORD_ARGON2ID);

echo "$senha1";

//buscar pelos curso de exibi-los em ordem alfabética.
$sql = "SELECT id_curso, nome_curso FROM curso ORDER BY nome_curso ASC";

//atribuir a veriavél resultado ($resultado) o valor da excução do comando sql ($sql).
$resultado = excutarSQL($mysql, $sql);
?>




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


             //definir a estrutura de repetição que irá mostrar na tela do aluno, todas as atividades que ele entregou no sistema.
             while ($dados = mysqli_fetch_assoc($query)) {

                //dentro da repetição verificamos se o status e a observação são diferentes das configurações padrões do sistema. Se isso for verdadeiro, significa que o coordenador de curso adcionou uma correção a entrega do certificado, diante disso imprimimos as informações de status, observações que o coordenador de curso adicionou e a carga horária que foi aprovada.
                if ($dados['status'] != "Em análise" or $dados['observacoes'] != "Sem observações") {
            ?>

                    <div>
                        <h1 class="card-titla">Titulo do certificado: <?php echo $dados['titulo_certificado']; ?> </h1>
                        <p class="card-text">Natureza do certificado: <?php echo $dados['natureza']; ?></p>
                        <p class="card-text">Descrição da natureza: <?php echo $dados['descricao']; ?></p>
                        <p class="card-text">O certificado: <a href="<?php echo $pasta . $dados['caminho']; ?>"><?php echo $dados['certificado']; ?></a></p>
                        <p class="card-text">Carga horária do certificado: <?php echo $dados['carga_horaria_certificado']; ?></p>
                        <p class="card-text">Carga horária deferida: <?php echo $dados['carga_horaria_aprovada']; ?></p>
                        <p class="card-text">Situação: <?php echo $dados['status']; ?></p>
                        <p class="card-text">Observações: <?php echo $dados['observacoes']; ?></p>
                        <a href="#modal<?php echo $dados['id_entrega_atividade']; ?>" class="btn-floating btn-small waves-effect waves-light red modal-trigger"><i class="material-icons">delete</i></a>

                        <a href="crudEntrega/formeditEntrega.php?id=<?php echo $dados['id_entrega_atividade']; ?>" class="btn-floating btn-small waves-effect waves-light red modal-trigger"><i class="material-icons">create</i></a>

                        <!-- Modal Structure -->
                        <div id="modal<?php echo $dados['id_entrega_atividade']; ?>" class="modal">
                            <div class="modal-content">
                                <h2> Atenção! </h2>
                                <p>Você confirma a exclusão dessa atividade?: <?php echo $dados['titulo_certificado']; ?> </p>
                            </div>

                            <div class="modal-footer">
                                <form action="crudEntrega/excluirEntrega.php" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $dados['id_entrega_atividade']; ?>">

                                    <button type="submit" name="btn-deletar" class="modal-action modal-close waves-red btn red darken-1">
                                        Excluir </button>

                                    <button type="button" name="btn-cancelar" class="modal-action modal-close  btn waves-light green">
                                        Cancelar </button>
                            </div>

                        </div>
                    <?php


                } else {

                    ?>

                        <div>

                            <h1 class="card-titla">Titulo do certificado: <?php echo $dados['titulo_certificado']; ?></h1>
                            <p class="card-text">Natureza do certificado: <?php echo $dados['natureza']; ?></p>
                            <p class="card-text">Descrição da natureza: <?php echo $dados['descricao']; ?></p>
                            <p class="card-text">O certificado: <a href="<?php echo $pasta . $dados['caminho']; ?>"><?php echo $dados['certificado']; ?></a></p>
                            <p class="card-text">Carga horária do certificado: <?php echo $dados['carga_horaria_certificado']; ?></p>
                            <p class="card-text">Situação: <?php echo $dados['status']; ?></p>

                            <a href="#modal<?php echo $dados['id_entrega_atividade']; ?>" class="btn-floating btn-small waves-effect waves-light red modal-trigger"><i class="material-icons">delete</i></a>

                            <a href="crudEntrega/formeditEntrega.php?id=<?php echo $dados['id_entrega_atividade']; ?>" class="btn-floating btn-small waves-effect waves-light red modal-trigger"><i class="material-icons">create</i></a>

                            <!-- Modal Structure -->
                            <div id="modal<?php echo $dados['id_entrega_atividade']; ?>" class="modal">
                                <div class="modal-content">
                                    <h2> Atenção! </h2>
                                    <p>Você confirma a exclusão dessa atividade?: <?php echo $dados['titulo_certificado']; ?> </p>
                                </div>

                                <div class="modal-footer">
                                    <form action="crudEntrega/excluirEntrega.php" method="POST">
                                        <input type="hidden" name="id" value="<?php echo $dados['id_entrega_atividade']; ?>">

                                        <button type="submit" name="btn-deletar" class="modal-action modal-close waves-red btn red darken-1">
                                            Excluir </button>

                                        <button type="button" name="btn-cancelar" class="modal-action modal-close  btn waves-light green">
                                            Cancelar </button>
                                </div>

                    <?php


                }
            }


            ?>

            <form action="mudarSituacao.php" method="post">

                <div class="card-panel">

                    <div class="row">

                     <!--dados invisiveis.-->
                     <input type="hidden" name="id_atividade" value="<?php echo $dados['id_entrega_atividade']; ?>">
                        <input type="hidden" name="aluno" value="<?php echo $dados['id_aluno']; ?>">
                        <input type="hidden" name="nome" value="<?php echo $dados['nome']; ?>">
                        <input type="hidden" name="matricula" value="<?php echo $dados['matricula']; ?>">
                        <input type="hidden" name="email" value="<?php echo $dados['email']; ?>">
                        <input type="hidden" name="certificado" value="<?php echo $dados['titulo_certificado']; ?>">
                        <input type="hidden" name="descricao" value="<?php echo $dados['descricao']; ?>">

                        <div class="input-field col s12">
                            <input placeholder="Digite o seu email" id="email" name="email" type="text" class="validate" pattern="^.*@.*$" required>
                            <label for="email">Email</label>
                            <span class="helper-text" data-error="O campo deve conter o @, exemplo user@gmail.com"></span>
                        </div>

                        <div class="input-field col s12">
                            <input placeholder="Digite o seu email" id="email" name="email" type="text" class="validate" pattern="^.*@.*$" required>
                            <label for="email">Email</label>
                            <span class="helper-text" data-error="O campo deve conter o @, exemplo user@gmail.com"></span>
                        </div>

                        <div class="input-field col s12">
                            <input placeholder="Digite o seu email" id="email" name="email" type="text" class="validate" pattern="^.*@.*$" required>
                            <label for="email">Email</label>
                            <span class="helper-text" data-error="O campo deve conter o @, exemplo user@gmail.com"></span>
                        </div>

                        <div class="input-field col s12">
                            <input placeholder="Digite o seu email" id="email" name="email" type="text" class="validate" pattern="^.*@.*$" required>
                            <label for="email">Email</label>
                            <span class="helper-text" data-error="O campo deve conter o @, exemplo user@gmail.com"></span>
                        </div>

                        <div class="input-field col s12">
                            <input placeholder="Digite o seu email" id="email" name="email" type="text" class="validate" pattern="^.*@.*$" required>
                            <label for="email">Email</label>
                            <span class="helper-text" data-error="O campo deve conter o @, exemplo user@gmail.com"></span>
                        </div>

                    </div>

                </div>

            </form>

        <?php