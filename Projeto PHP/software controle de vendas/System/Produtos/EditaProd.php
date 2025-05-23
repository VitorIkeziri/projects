<?php
// Incluindo o arquivo de conexão
require("../conecta_2.php");

// Verifica se o ID do produto foi passado na URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']); // Garante que o ID seja um número inteiro

    // Consulta para obter os dados do produto
    $sql = "SELECT `P_NroLoja`, `P_ID_Produto`, `P_Descricao`, `P_Valor`, `P_Classe`, `P_Quantidade`, `P_FlagPeso`, `P_Dimensoes`, `P_Categoria`, `P_Fornecedor`, `P_EANVALIDO`, `P_Data_Criacao`, `P_Ultima_Atualizacao`, `P_Codigo_Interno`, `P_Validade`, `P_Estoque`, `P_Custo`, `P_Imagem`, `P_Marca`, `P_Modelo`, `P_Fabricante`, `P_Garantia` FROM `produto` WHERE `P_ID_Produto` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica se o produto foi encontrado
    if ($result->num_rows > 0) {
        $produto = $result->fetch_assoc();
    } else {
        echo "Produto não encontrado.";
        exit();
    }
} else {
    echo "ID do produto não especificado ou inválido.";
    exit();
}

?>



<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
    <link rel="stylesheet" href="AdicionarProduto.css">
</head>
<body>
    <div class="container">
        <h1>Alterar Produto</h1>
        <form action="EditaProd.php?id=<?php echo $id; ?>" method="post">


        <script>

        </script>


            <div class="grid-container">
                <!-- Prima coluna -->
                <div class="grid-item">
                    <label for="nro_loja">Número da Loja:</label>
                    <input type="text" id="nro_loja" name="nro_loja" value="<?php echo $produto['P_NroLoja']; ?>" required>

                    <label for="descricao">Descrição:</label>
                    <input type="text" id="descricao" name="descricao" value="<?php echo $produto['P_Descricao']; ?>" required>

                    <label for="valor">Valor:</label>
                    <input type="text" id="valor" name="valor" value="<?php echo number_format($produto['P_Valor'], 2, ',', '.'); ?>" required>

                    <label for="quantidade">Quantidade:</label>
                    <input type="number" id="quantidade" name="quantidade" value="<?php echo $produto['P_Quantidade']; ?>" min="0" required>

                    <label for="peso">Peso (kg):</label>
                    <input type="text" id="peso" name="peso" value="<?php echo $produto['P_FlagPeso']; ?>">

                    <label for="estoque">Estoque:</label>
                    <input type="number" id="estoque" name="estoque" value="<?php echo $produto['P_Estoque']; ?>" min="0">

                    <label for="custo">Custo:</label>
                    <input type="text" id="custo" name="custo" value="<?php echo number_format($produto['P_Custo'], 3, ',', '.'); ?>">

                    <label for="classe">Classe:</label>
                    <select id="classe" name="classe" required>
                        <option value="1" <?php echo ($produto['P_Classe'] == 1) ? 'selected' : ''; ?>>Retirar</option>
                        <option value="2" <?php echo ($produto['P_Classe'] == 2) ? 'selected' : ''; ?>>Entrega</option>
                        <option value="3" <?php echo ($produto['P_Classe'] == 3) ? 'selected' : ''; ?>>E-commerce</option>
                    </select>

                    <label for="validade">Validade:</label>
                    <input type="date" id="validade" name="validade" value="<?php echo $produto['P_Validade']; ?>" disabled>

                </div>

                <!-- Segunda coluna -->
                <div class="grid-item">

                    <label for="categoria">Categoria:</label>
                    <input type="text" id="categoria" name="categoria" value="<?php echo $produto['P_Categoria']; ?>">

                    <label for="fornecedor">Fornecedor:</label>
                    <input type="text" id="fornecedor" name="fornecedor" value="<?php echo $produto['P_Fornecedor']; ?>">

                    <label for="P_EANVALIDO">Código EAN:</label>
                    <input type="text" id="P_EANVALIDO" name="P_EANVALIDO" value="<?php echo $produto['P_EANVALIDO']; ?>">

                    <label for="codigo_interno">Código Interno:</label>
                    <input type="text" id="codigo_interno" name="codigo_interno" value="<?php echo $produto['P_Codigo_Interno']; ?>">

                    <label for="imagem">Imagem:</label>
                    <input type="text" id="imagem" name="imagem" value="<?php echo $produto['P_Imagem']; ?>">

                    <label for="marca">Marca:</label>
                    <input type="text" id="marca" name="marca" value="<?php echo $produto['P_Marca']; ?>">

                    <label for="modelo">Modelo:</label>
                    <input type="text" id="modelo" name="modelo" value="<?php echo $produto['P_Modelo']; ?>">

                    <label for="fabricante">Fabricante:</label>
                    <input type="text" id="fabricante" name="fabricante" value="<?php echo $produto['P_Fabricante']; ?>">

                    <label for="garantia">Garantia (meses):</label>
                    <input type="number" id="garantia" name="garantia" value="<?php echo $produto['P_Garantia']; ?>" min="0">

                    <label for="dimensoes">Dimensões (LxAxP):</label>
                    <input type="text" id="dimensoes" name="dimensoes" value="<?php echo $produto['P_Dimensoes']; ?>">
                    
                </div>
            </div>
            <!-- Botões de ação -->
            <div class="button-container">
            <a href="ConsultaProduto.php" class="button">Voltar</a>
                <button type="submit">Alteração Produto</button>
            </div>
        </form>
    </div>
</body>
</html>


<?php
require_once('../conecta_2.php'); 

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coleta e sanitiza os dados do formulário
    $nro_loja = $mysqli->real_escape_string($_POST['nro_loja']);
    $descricao = $mysqli->real_escape_string($_POST['descricao']);
    $valor = str_replace(',', '.', $_POST['valor']);
    $classe = $mysqli->real_escape_string($_POST['classe']);
    $quantidade = intval($_POST['quantidade']);
    $flag_peso = $mysqli->real_escape_string($_POST['peso']);
    $dimensoes = $mysqli->real_escape_string($_POST['dimensoes']);
    $categoria = $mysqli->real_escape_string($_POST['categoria']);
    $fornecedor = $mysqli->real_escape_string($_POST['fornecedor']);
    $P_EANVALIDO = $mysqli->real_escape_string($_POST['P_EANVALIDO']);
    $codigo_interno = $mysqli->real_escape_string($_POST['codigo_interno']);
    $estoque = intval($_POST['estoque']);
    $custo = str_replace(',', '.', $_POST['custo']);
    $imagem = $mysqli->real_escape_string($_POST['imagem']);
    $marca = $mysqli->real_escape_string($_POST['marca']);
    $modelo = $mysqli->real_escape_string($_POST['modelo']);
    $fabricante = $mysqli->real_escape_string($_POST['fabricante']);
    $garantia = intval($_POST['garantia']);
    
    // Verifica se o produto possui validade
    $possui_validade = isset($_POST['possui_validade']);
    if (!empty($_POST['validade'])) { 
        $validade = $mysqli->real_escape_string($_POST['validade']);
    } else {
        $validade = null;
    }
    $sql_update = "UPDATE `produto` SET `P_NroLoja` = ?, `P_Descricao` = ?, `P_Valor` = ?, `P_Classe` = ?, `P_Quantidade` = ?, 
            `P_FlagPeso` = ?, `P_Dimensoes` = ?, `P_Categoria` = ?, `P_Fornecedor` = ?, `P_EANVALIDO` = ?, 
            `P_Codigo_Interno` = ?, `P_Validade` = ?, `P_Estoque` = ?, `P_Custo` = ?, 
            `P_Imagem` = ?, `P_Marca` = ?, `P_Modelo` = ?, `P_Fabricante` = ?, `P_Garantia` = ?, `P_Ultima_Atualizacao` = NOW() 
            WHERE `P_ID_Produto` = ?";
    $stmt_update = $mysqli->prepare($sql_update);
    $stmt_update->bind_param(
            "isssissssssssisssssi", 
            $nro_loja, $descricao, $valor, $classe, $quantidade, $flag_peso, $dimensoes, $categoria, 
            $fornecedor, $P_EANVALIDO, $codigo_interno, $validade, $estoque, $custo, 
            $imagem, $marca, $modelo, $fabricante, $garantia, $id 
        );
    


    if ($stmt_update->execute()) {
        echo "<p>Produto atualizado com sucesso!</p>";
    } else {
        echo "<p>Erro ao atualizar o produto: " . $stmt_update->error . "</p>";
    }

    $stmt_update->close();
}

$mysqli->close();
?>