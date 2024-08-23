<?php

//iniciar a sessão.
session_start();

//conectar com o banco de dados.
require_once "conecta.php";

//veriável de conexão.
$mysql = conectar();

if (isset($_POST['email']) and isset($_POST['senha'])) {

    if (strlen($_POST['email']) == 0) {

        echo "Preencha corretamente com o seu email!";
    } else {

        if (strlen($_POST['senha']) == 0) {

            echo "Preencha corretamente com a sua senha!";
        } else {

            //Limpar os campos.
            $email = $mysql->real_escape_string($_POST['email']);

            $senha = $mysql->real_escape_string($_POST['senha']);

            // Verifica se o e-mail existe na tabela de alunos.
            $consulta_alunos = excutarSQL($mysql, "SELECT COUNT(*) FROM aluno WHERE email = '$email'");
            $quantidade_alunos = mysqli_fetch_row($consulta_alunos)[0];

            // Verifica se o e-mail existe na tabela de coordenadores.
            $consulta_coordenadores = excutarSQL($mysql, "SELECT COUNT(*) FROM coordenador_curso WHERE email = '$email'");
            $quantidade_coordenadores = mysqli_fetch_row($consulta_coordenadores)[0];

            // Verifica se o e-mail existe na tabela de administradores.
            $consulta_administradores = excutarSQL($mysql, "SELECT COUNT(*) FROM administrador WHERE email = '$email'");
            $quantidade_administradores = mysqli_fetch_row($consulta_administradores)[0];

            var_dump($quantidade_administradores);
            var_dump($quantidade_alunos);
            var_dump($quantidade_coordenadores);

            if ($quantidade_alunos == 0 && $quantidade_coordenadores == 0 && $quantidade_administradores == 0) {
                echo "E-mail: " . " " . $email . " " . " não está cadastrado no sistema!<p><a href = \"index.php\">Voltar</a></p>";
            } else {

                if ($quantidade_alunos != 0) {

                    $sql = "SELECT a.nome, a.id_curso, a.id_aluno, a.senha FROM aluno a WHERE email = '$email'";

                    $query = excutarSQL($mysql, $sql);

                    $aluno = mysqli_fetch_assoc($query);

                    if (password_verify($senha, $aluno['senha'])) {

                        $_SESSION['aluno'][0] = $aluno['nome'];
                        $_SESSION['aluno'][1] = $aluno['id_aluno'];
                        $_SESSION['aluno'][2] = $aluno['id_curso'];

                        //echo "A senha  do aluno confere! <p><a href = \"logout.php\">Voltar</a></p>";

                        header("location: inicialAluno.php");

                    } else {

                        echo "A senha  do aluno não confere! <p><a href = \"logout.php\">Voltar</a></p>";
                    }
                } else {

                    if ($quantidade_coordenadores != 0) {

                        $sql2 = "SELECT cc.nome, cc.senha, cc.id_coordenador, cc.id_curso FROM coordenador_curso cc
                        WHERE email = '$email'";

                        $query2 = excutarSQL($mysql, $sql2);

                        $coordenador = mysqli_fetch_assoc($query2);

                        if (password_verify($senha, $coordenador['senha'])) {

                            $_SESSION['coordenador'][0] = $coordenador['nome'];
                            $_SESSION['coordenador'][1] = $coordenador['id_coordenador'];
                            $_SESSION['coordenador'][2] = $coordenador['id_curso'];

                            //echo "A senha do coordenador confere! <p><a href = \"logout.php\">Voltar</a></p>";

                            header("location: inicialCoordenador.php");
                        } else {
                            echo "A senha do coordenador não confere! <p><a href = \"logout.php\">Voltar</a></p>";
                        }
                    } else {

                        if ($quantidade_administradores != 0) {

                            $sql3 = "SELECT adm.email, adm.senha FROM administrador adm WHERE email = '$email'";

                            $query3 = excutarSQL($mysql, $sql3);

                            $administrador = mysqli_fetch_assoc($query3);

                            if (password_verify($senha, $administrador['senha'])) {
                                
                                $_SESSION['administrador'][0] = $administrador['email'];

                               header("location: inicialAdmin.php");
                            }else {
                                
                                echo "A senha do administrador não confere! <p><a href = \"logout.php\">Voltar</a></p>";
                            }
                        }
                    }
                }
            }
        }
    }
}
