<?php
require("../conecta_2.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $P_NroLoja = $_POST['P_NroLoja'];
    $P_ID_Produto = $_POST['P_ID_Produto'];
    $P_Descricao = $_POST['P_Descricao'];
    $P_Valor = $_POST['P_Valor'];
    $P_Classe = $_POST['P_Classe'];
    $P_Quantidade = $_POST['P_Quantidade'];
    $P_FlagPeso = $_POST['P_FlagPeso'];
    $P_Dimensoes = $_POST['P_Dimensoes'];
    $P_Categoria = $_POST['P_Categoria'];
    $P_Fornecedor = $_POST['P_Fornecedor'];
    $P_EANVALIDO = $_POST['P_EANVALIDO'];
    $P_Validade = $_POST['P_Validade'];
    $P_Estoque = $_POST['P_Estoque'];
    $P_Custo = $_POST['P_Custo'];
    $P_Imagem = $_POST['P_Imagem'];
    $P_Marca = $_POST['P_Marca'];
    $P_Modelo = $_POST['P_Modelo'];
    $P_Fabricante = $_POST['P_Fabricante'];
    $P_Garantia = $_POST['P_Garantia'];

    $sql = "INSERT INTO produto 
        (P_NroLoja, P_ID_Produto, P_Descricao, P_Valor, P_Classe, P_Quantidade, P_FlagPeso, P_Dimensoes, P_Categoria, P_Fornecedor, P_EANVALIDO, P_Validade, P_Estoque, P_Custo, P_Imagem, P_Marca, P_Modelo, P_Fabricante, P_Garantia) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('iisdiiisssssssssiii', $P_NroLoja, $P_ID_Produto, $P_Descricao, $P_Valor, $P_Classe, $P_Quantidade, $P_FlagPeso, $P_Dimensoes, $P_Categoria, $P_Fornecedor, $P_EANVALIDO, $P_Validade, $P_Estoque, $P_Custo, $P_Imagem, $P_Marca, $P_Modelo, $P_Fabricante, $P_Garantia);

    if ($stmt->execute()) {
        echo "Produto adicionado com sucesso!";
    } else {
        echo "Erro ao adicionar produto: " . $stmt->error;
    }

    $stmt->close();
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Produto</title>
    <link rel="stylesheet" href="AdicionarProduto.css">
</head>
<body>
    <div class="container">
        <h1>Adicionar Produto</h1>
        <form action="adicionar_produto.php" method="post">
            <div class="grid-container">
                <div class="grid-item">
                    
                    <label for="P_NroLoja">Número da Loja:</label>
                    <input type="number" name="P_NroLoja" id="P_NroLoja">

                    <label for="P_ID_Produto">ID do Produto:</label>
                    <input type="number" name="P_ID_Produto" id="P_ID_Produto" required>

                    <label for="P_Valor">Valor:</label>
                    <input type="text" name="P_Valor" id="P_Valor">

                    <label for="P_Classe">Classe:</label>
                    <input type="number" name="P_Classe" id="P_Classe" required>

                    <label for="P_Quantidade">Quantidade:</label>
                    <input type="number" name="P_Quantidade" id="P_Quantidade" required>

                    <label for="P_FlagPeso">Flag Peso:</label>
                    <input type="text" name="P_FlagPeso" id="P_FlagPeso">

                    <label for="P_Dimensoes">Dimensões:</label>
                    <input type="text" name="P_Dimensoes" id="P_Dimensoes">

                    <label for="P_Categoria">Categoria:</label>
                    <input type="text" name="P_Categoria" id="P_Categoria">

                    <label for="P_Descricao">Descrição:</label>
                    <textarea name="P_Descricao" id="P_Descricao" required></textarea>

                </div>

                <div class="grid-item">

                    <label for="P_Fornecedor">Fornecedor:</label>
                    <input type="text" name="P_Fornecedor" id="P_Fornecedor">

                    <label for="P_EANVALIDO">EAN Válido:</label>
                    <input type="text" name="P_EANVALIDO" id="P_EANVALIDO">

                    <label for="P_Validade">Validade:</label>
                    <input type="date" name="P_Validade" id="P_Validade">

                    <label for="P_Estoque">Estoque:</label>
                    <input type="number" name="P_Estoque" id="P_Estoque">

                    <label for="P_Custo">Custo:</label>
                    <input type="text" name="P_Custo" id="P_Custo">

                    <label for="P_Imagem">Imagem:</label>
                    <input type="text" name="P_Imagem" id="P_Imagem">

                    <label for="P_Marca">Marca:</label>
                    <input type="text" name="P_Marca" id="P_Marca">

                    <label for="P_Modelo">Modelo:</label>
                    <input type="text" name="P_Modelo" id="P_Modelo">

                    <label for="P_Fabricante">Fabricante:</label>
                    <input type="text" name="P_Fabricante" id="P_Fabricante">

                    <label for="P_Garantia">Garantia (meses):</label>
                    <input type="number" name="P_Garantia" id="P_Garantia">
                </div>
            </div>
            <div class="button-container">
            <a href="ConsultaProduto.php" class="button">Voltar</a>
                <button type="submit">Salvar Produto</button>
            </div>
        </form>
    </div>
</body>
</html>
