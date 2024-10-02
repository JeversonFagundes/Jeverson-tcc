<?php

//PERFIL.PHP

//conectar com o banco de dados jeverson-tcc
require_once "../conecta.php";

//incluir o arquivo de onde é feita a proteção do sistema.
require_once "../protecao.php";

//declarar a variavel de conexão com o banco de dados jeverson-tcc.
$mysql = conectar();

//atribuir a variavél sql ($sql) a busca pelos dados do coordenador de curso.
$sql = "SELECT nome, email, id_curso, id_coordenador FROM coordenador_curso WHERE id_coordenador = " . $_SESSION['coordenador'][1];

//atribuir a veriavél ressultado ($resultado) a execução do comando sql ($sql).
$resultado = excutarSQL($mysql, $sql);

//atribuir a veriavél coordenador ($coordenador) os valores do array associativo gerado com a execução do comando sql.
$coordenador = mysqli_fetch_assoc($resultado);

?>

<!DOCTYPE html>
<html lang="pt_br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Editar sua conta</title>


</head>

<body>

    <h1>Informações da sua conta!</h1>

    <form action="editarContCo.php" method="post">

        <label for="nome">Nome: </label>
        <input type="text" value="<?php echo $coordenador['nome']; ?>" name="nome"><br><br>

        <label for="email">Email: </label>
        <input type="email" value="<?php echo $coordenador['email']; ?>" name="email"><br><br>

        <?php

        //buscar por todos os curso cadastrados no sistema e ordena-los em ordem alfabética.
        $sql2 = "SELECT id_curso, nome_curso FROM curso ORDER BY nome_curso ASC";

        //atribuir a veriavél resultado2 ($resultado2) a execução do comando sql.
        $resultado2 = excutarSQL($mysql, $sql2);

        ?>

        <label for="curso">Selecione o seu curso: </label>

        <!--declarar o campo de selecção.-->
        <select id="curso" name="curso" required>

            <?php

            //atribuir a veriavél dados ($dados) os valores gerados no array associativo pela execução do comando sql ($sql2) que será repetido enquanto houver dados.
            while ($dados = mysqli_fetch_assoc($resultado2)) {

            ?>
                <!--declarar as opções do compo de seleção. Os valores estão vendo da variavél dados ($dados).-->
                <option <?php

                        //aqui tendo em maões os valores vindos do coordenador de curso que esta logado nomomento e dos cursos cadastrados no sistema, verificamos qual é o curso do coordenador e exibimos com opção selecionada o curso dele. No caso essa condição sempre vai ser atendida porque o coordenador de curso, assim com o alno estão cadastrados no sistema e por possuem obrigratóriamente um curso em seu cadastro.
                        if ($coordenador['id_curso'] == $dados['id_curso']) {

                            echo "selected";
                        }
                        ?> value="<?php echo $dados['id_curso'] ?>">
                    <?php echo $dados['nome_curso'] ?>
                </option>
            <?php
            }
            ?>

        </select><br><br>

        <input type="hidden" value="<?php echo $coordenador['id_coordenador']; ?>" name="id">

        <input type="submit" value="Editar"><br><br>



    </form>

    <button><a href="excluirContCo.php">Excluir sua conta!</a></button><br><br>

    <p>Deseja <a href="../inicialCoordenador.php">Voltar!</a></p>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</body>

</html>