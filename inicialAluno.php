<?php

//conectar com o banco de dados 
include("conecta.php");

//conectar na proteção.
include("protecao.php");

$pasta = "certificados/";

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela inicial</title>

    <style>
        .card {
            background-color: white;
            width: 40%;
            height: 380px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px rgba(0, 0, 0, 0.19);
        }
    </style>

</head>

<body>

    <header>
        <nav>
            <li><a href="crudAluno/perfil.php">Perfil</a></li>
            <li><a href="logout.php">Sair</a></li>
        </nav>
    </header>

    <main>
        <h2><?php echo $_SESSION['aluno'][0]; ?></h2>

        <p><a href="crudEntrega/formcadEntrega.php">Entregar atividade complementar</a></p>

        <hr>

        <h1>Minhas atividade complementares de curso</h1>

        <?php

        //listar as atividades cadastradas pelo a aluno no sistema.
        $sql = "SELECT 
        ac.descricao, 
        ea.natureza,
        ea.id_entrega_atividade,
        ea.titulo_certificado, 
        ea.carga_horaria_certificado,
        ea.certificado, 
        ea.carga_horaria_aprovada, 
        ea.status,
        ea.caminho
        FROM entrega_atividade ea 
        INNER JOIN atividade_complementar ac 
        ON ea.natureza = ac.natureza 
        INNER JOIN aluno a 
        ON a.id_aluno = ea.id_aluno
        WHERE 
        a.id_aluno = " . $_SESSION['aluno'][1];

        $query = mysqli_query($mysql, $sql);

        if ($mysql->error) {

            die("Falha ao listar" . $mysql->error);
        } else {

            //verificar a quantidade de linhas que foram retornadas
            $quantidade = $query->num_rows;

            if ($quantidade == 0) {

                echo "Você não cadastrou nenhuma atividade no sistema ainda!";

                die();
            } else {

                while ($dados = mysqli_fetch_assoc($query)) {

                    if ($dados['status'] != "Em análise") {

                        echo '<div class="card">';
                        echo '<div class="card-body">';
                        echo '<h1 class="card-title">' . 'Titulo do certificado:' . '' . $dados['titulo_certificado'] . '</h1>';
                        echo '<p class="card-text">' . 'Natureza do seu certificado: ' . '' . $dados['natureza'] . '</p>';
                        echo '<p class="card-text">' . 'Descrição da natureza: ' . '' . $dados['descricao'] . '</p>';
                        echo '<p class="card-title">' . 'O certificado:' . ' ' . '<a href="' .$pasta.$dados['caminho'] . '">' . $dados['certificado'] . '</a>' . '</p>';
                        echo '<p class="card-text">' . 'Carga horaria do seu certificado: ' . '' . $dados['carga_horaria_certificado'] . '</p>';
                        echo '<p class="card-text">' . 'Situação:' . ' ' . $dados['status'] . '</p>';
                        echo '<p class = "editar"> <a href="crudEntrega/formeditEntrega.php?id=' . $dados['id_entrega_atividade'] . '"> Alterar</a> </p>';
                        echo '<p class  = "excluir"> <a href="crudEntrega/excluirEntrega?id=' . $dados['id_entrega_atividade'] . '"> Excluir </a> </p>';
                        echo '</div>';
                        echo '</div>';
                    } else {

                        echo '<div class="card">';
                        echo '<div class="card-body">';
                        echo '<h1 class="card-title">' . 'Titulo do certificado:' . '' . $dados['titulo_certificado'] . '</h1>';
                        echo '<p class="card-text">' . 'Natureza do seu certificado: ' . '' . $dados['natureza'] . '</p>';
                        echo '<p class="card-text">' . 'Descrição da natureza: ' . '' . $dados['descricao'] . '</p>';
                        echo '<p class="card-title">' . 'O certificado:' . ' ' . '<a href="' .$pasta. $dados['caminho'] . '">' . $dados['certificado'] . '</a>' . '</p>';
                        echo '<p class="card-text">' . 'Carga horaria do seu certificado: ' . '' . $dados['carga_horaria_certificado'] . '</p>';
                        echo '<p class="card-text">' . 'Situação:' . ' ' . $dados['status'] . '</p>';
                        echo '<p class = "editar"> <a href="crudEntrega/formeditEntrega.php?id=' . $dados['id_entrega_atividade'] . '"> Alterar</a> </p>';
                        echo '<p class  = "excluir"> <a href="crudEntrega/excluirEntrega?id=' . $dados['id_entrega_atividade'] . '"> Excluir </a> </p>';
                        echo '</div>';
                        echo '</div>';
                    }
                }
            }
        }

        ?>

    </main>

</body>

</html>