<?php

//conectar com o banco de dados.
include("conecta.php");

//Verificar se existe um formulário com os valores de email e senha.
if (isset($_POST['email']) and isset($_POST['senha'])) {

    //Verificar se os compos foram preenchidos corretamente.
    if (strlen($_POST['email']) == 0) {

        echo "Preencha corretamente com o seu email!";
    } else {

        if (strlen($_POST['senha']) == 0) {

            echo "Preencha corretamente com a sua senha!";
        } else {

            //Limpar os campos.
            $email = $mysql->real_escape_string($_POST['email']);

            $senha = $mysql->real_escape_string($_POST['senha']);

            //Selecionar os dados do aluno
            $sql = "SELECT * FROM aluno WHERE email = '$email' AND senha =  '$senha'";

            //Excutar o comando.
            $query = mysqli_query($mysql, $sql);

            //Caso dê erro.
            if ($mysql->error) {

                die("Falha no comando sql! " . $mysql->error);
            } else {

                $quantidade = $query->num_rows;

                if ($quantidade == 1) {

                    $aluno = $query->fetch_assoc();

                    if (!isset($_SESSION)) {

                        session_start();
                    }


                    $_SESSION['id_aluno'] = $aluno['id_aluno'];

                    //id_aluno vem do banco de dados.

                    $_SESSION['nome_aluno'] = $aluno['nome_aluno'];

                    $_SESSION['id_curso'] = $aluno['id_curso'];

                    header("location: inicialAluno.php");
                } else {

                    /*MEU PENSAMENTO:
                    
                    Estamos pegando os dados do aluno, por exemplo se o coordenador de curso entrar com os seus dados, e verificação de quantidade vai ser igual a 0 registros retornados e vai cair nesse die. Então ao invés de cair no die, agora e posso a verificar na tebela do coordenador de curso, vendo se o email ou senha são dele, se não eu faço o mesmo com o administrador. Então se todas as verificados de registros retornador for igual 0 nas três tabelas, o usuário não está cadastrado no sistema, entao exibe uma mensagem de que ele nao está cadastrado no sistema.
                    */

                    //listar as informações do coordenador de curos no sistema.
                    $sql2 = "SELECT * FROM coordenador_curso WHERE email = '$email' and senha = '$senha'";

                    //excutar o comando sql acima.
                    $query2 = mysqli_query($mysql, $sql2);

                    //caso dê algum erro.
                    if ($mysql->error) {

                        die("Falha ao listar coordenador de curso no sistema!" . $mysql->error);
                    } else {

                        $quantidade2 = $query2->num_rows;

                        if ($quantidade2 == 1) {

                            $coordenador = $query2->fetch_assoc();

                            if (!isset($_SESSION)) {

                                session_start();
                            }

                            $_SESSION['id_coordenador'] = $coordenador['id_coordenador'];

                            $_SESSION['nome_coordenador'] = $coordenador['nome_coordenador'];

                            $_SESSION['id_curso'] = $coordenador['id_curso'];

                            header("location: inicialCoordenador.php");
                        } else {

                            //listar os dados do administrador cadastrado no sistema.
                            $sql3 = "SELECT * FROM administrador WHERE email = '$email' and senha = '$senha'";

                            //excutar o comando sql acima.
                            $query3 = mysqli_query($mysql, $sql3);

                            //caso dê algum erro.
                            if ($mysql->error) {

                                die("Falha ao listar o administrado no sistema!" . $mysql->error);
                            } else {

                                $quantidade3 = $query3->num_rows;

                                if ($quantidade3 == 1) {

                                    $admin = $query3->fetch_assoc();

                                    if (!isset($_SESSION)) {

                                        session_start();
                                    }

                                    $_SESSION['id_administrador'] = $admin['id_administrador'];

                                    $_SESSION['email'] = $admin['email'];

                                    header("location: inicialAdmin.php");
                                } else {

                                    die("Você não está cadastrado no sistema! <p><a href = \"index.php\">Voltar</a></p>");
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
