<?php

//conectar com o banco de dados.
require_once "../conecta.php";

//incluindo a proteção.
require_once "../protecao.php";

//variavel de conexxão.
$mysql = conectar();

//selecionar os dados das atividades complementares cadastradas no sistema.
$sql = "SELECT natureza, descricao, carga_horaria_maxima FROM atividade_complementar WHERE id_curso = " . $_SESSION['aluno'][2];

$resultado = excutarSQL($mysql, $sql);

echo '<h1>Formulário de entrega de atividades complementares.</h1>';

echo '<h3>Tabela de atividades complementares.</h3>';

//lista de itens.
echo '<table border=4;">
<tr>
<th>Natureza</th>
<th>Descrição</th>
<th>Carga horaria máxima</th>
</tr>';

while ($dados = mysqli_fetch_assoc($resultado)) {
    echo '<tr>';
    echo '<td>' . $dados['natureza'] . '</td>';
    echo '<td>' . $dados['descricao'] . '</td>';
    echo '<td>' . $dados['carga_horaria_maxima'] . '</td>';

    echo '</tr>';
}

echo '</table>' . '<br><br>';

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de entrega de atividade complementar</title>

</head>

<body>


    <form action="cadastrarEntrega.php" method="post" enctype="multipart/form-data">

        <?php

        $sql = "SELECT id_atividade_complementar, natureza FROM atividade_complementar WHERE id_curso = " . $_SESSION['aluno'][2];
        $resultado = excutarSQL($mysql, $sql);
        ?>

        <label for="select">Escolha a natureza do seu certificado:</label>
        <select id="select" required name="atividade_complementar">

            <option selected disabled value="">Natureza</option>

            <?php

            while ($dados = mysqli_fetch_assoc($resultado)) {

            ?>
                <option value="<?php echo $dados['id_atividade_complementar'] ?>">

                    <?php echo $dados['natureza'] ?>

                </option>
            <?php
            }
            ?>

        </select><br><br>


        <label for="titulo">Titulo do certificado:</label>
        <input type="text" id="titulo" name="titulo"><br><br>

        <label for="carga">Carga horaria do certificado:</label>
        <input type="number" id="carga" name="carga"><br><br>

        <input type="hidden" name="cargaDefe" value="0">

        <input type="hidden" name="status" value="Em análise">

        <label for="certi">Certificado:</label>
        <input type="file" id="certi" name="certificado"><br><br>

        <input type="submit" value="Enviar">

    </form>

    <a href="../inicialAluno.php">Voltar</a>

</body>

</html>