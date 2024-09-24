<?php

//LOGIN.PHP

//iniciar as variaveis de sessão.
session_start();

//conectar com o banco de dados jeverson-tcc.
require_once "conecta.php";

//declarar a veriável de conexão com o banco de dados jeverson-tcc. Esta variavélç vem do arquivo conecta.php.
$mysql = conectar();

//verificar se os campos de email e senha foram preenchidos corretamente.
if (isset($_POST['email']) and isset($_POST['senha'])) {

    if (strlen($_POST['email']) == 0) {

        echo "Preencha corretamente com o seu email! <p><a href = \"index.php\">Voltar para a tela de login</a></p>";
    } else {

        if (strlen($_POST['senha']) == 0) {

            echo "Preencha corretamente com a sua senha! <p><a href = \"index.php\">Voltar para a tela de login</a></p>";
        } else {

            //Limpar os dados que foram colocados nos campos de email e senha.
            //O real_escape_string() é usado para escapar caracteres especiais em uma string, tornando-a segura para ser usada em uma consulta SQL, evitando que caracteres especiais quebrem a excução do comando sql.
            $email = $mysql->real_escape_string($_POST['email']);

            $senha = $mysql->real_escape_string($_POST['senha']);

            //O comando COUNT(*) é usado para contar o número total de registros (linhas) em uma tabela sem retornar o valor dos registros.
            //O comando sql mysqli_fetch_row() é usado para obter uma linha de dados de um conjunto de resultados e retorná-la como um array enumerado

            // Verifica se o e-mail informado existe na tabela de alunos.
            $consulta_alunos = excutarSQL($mysql, "SELECT COUNT(*) FROM aluno WHERE email = '$email'");
            $quantidade_alunos = mysqli_fetch_row($consulta_alunos)[0];

            // Verifica se o e-mail informado existe na tabela de coordenadores.
            $consulta_coordenadores = excutarSQL($mysql, "SELECT COUNT(*) FROM coordenador_curso WHERE email = '$email'");
            $quantidade_coordenadores = mysqli_fetch_row($consulta_coordenadores)[0];

            // Verifica se o e-mail informado existe na tabela de administradores.
            $consulta_administradores = excutarSQL($mysql, "SELECT COUNT(*) FROM administrador WHERE email = '$email'");
            $quantidade_administradores = mysqli_fetch_row($consulta_administradores)[0];

            var_dump($quantidade_administradores);
            var_dump($quantidade_alunos);
            var_dump($quantidade_coordenadores);

            //com a quantidade de cada uma das buscas nas tabelas podemos agora fazer as devidas verificações refentes a essas variaveis de quantidade.
            if ($quantidade_alunos == 0 && $quantidade_coordenadores == 0 && $quantidade_administradores == 0) {
                echo "E-mail: " . " " . $email . " " . " não está cadastrado no sistema!<p><a href = \"index.php\">Voltar</a></p>";
            } else {

                //se uma das variaveis de quantidade for diferente de zero, quer dizer o email digitado existe em alguma tabela dentro do banco de dados e por devemos agora verificar de qual tabela é esse email informado e quem é esse usuário. 

                //Depois achar a tabela e o usuário do email informado, devemos declarar um comendo sql que retorne as informações necessários do usuario como seu nome, id_curso, id_usuario e sua senha. Com isso em mãoes, agora para finalizar o validação do usuário, devemos verificar se a senha informada na tela de login confere com a senha que venho do banco de dados, se a senha não confere quer dizer que o usuário errou sua senha, se a senha confere, nós temos a informação da tebela onde está este usuário e consequentemente sabemos o nivél de acesso desse usuário, com isso podemos redirecionar ele para as respectivas páginas que ele tem acesso.

                if ($quantidade_alunos != 0) {

                    $sql = "SELECT a.nome, a.id_curso, a.id_aluno, a.senha FROM aluno a WHERE email = '$email'";

                    $query = excutarSQL($mysql, $sql);

                    $aluno = mysqli_fetch_assoc($query);

                    //password_verify() é utilizado para verificar se uma senha fornecida corresponde a um hash previamente gerado.

                    //password_verify("senha que recebemos do formulário de loigin", "senha vinda do banco de dados")

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
                            } else {

                                echo "A senha do administrador não confere! <p><a href = \"logout.php\">Voltar</a></p>";
                            }
                        }
                    }
                }
            }
        }
    }
}
