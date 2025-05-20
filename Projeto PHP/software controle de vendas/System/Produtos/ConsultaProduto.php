<?php
// Incluindo o arquivo de conexão
require("../conecta_2.php");

// Executando a consulta SQL para obter todos os campos
$sql = "SELECT `P_NroLoja`, `P_ID_Produto`, `P_Descricao`, `P_Valor`, `P_Classe`, `P_Quantidade`, `P_FlagPeso`, `P_Dimensoes`, `P_Categoria`, `P_Fornecedor`, `P_EANVALIDO`, `P_DataCadastro`, `P_Data_Criacao`, `P_Ultima_Atualizacao`, `P_Codigo_Interno`, `P_Validade`, `P_Estoque`, `P_Custo`, `P_Imagem`, `P_Marca`, `P_Modelo`, `P_Fabricante`, `P_Garantia` FROM `produto`";
$result = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Produtos</title>
    <link rel="stylesheet" href="ConsultaProduto.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> <!-- Link para a biblioteca de ícones -->
</head>
<body>

<h2>Lista de Produtos</h2>

<?php
if ($result->num_rows > 0) {
    // Início da tabela
    echo "<table>";
    echo "<tr>
    <th>Imagem</th>
    <th>Loja</th>
    <th>ID do Produto</th>
    <th>Descrição</th>
    <th>Valor</th>
    <th>Classe</th>
    <th>Quantidade</th>
    <th>Categoria</th>
    <th>Código EAN</th>
    <th>Código Interno</th>
    <th>Data de Cadastro</th>
    <th>Ultima Alteração</th>
    <th>Estoque</th>
    <th>Editar</th>
    </tr>";

    // Loop através dos resultados e exibição em uma tabela HTML

    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td><img src='" . htmlspecialchars($row["P_Imagem"]) . "' alt='Imagem' style='width: 50px; height: auto;'></td>";
        echo "<td>" . htmlspecialchars($row["P_NroLoja"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["P_ID_Produto"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["P_Descricao"]) . "</td>";
        echo "<td>" . number_format($row["P_Valor"], 2, ',', '.') . "</td>";
        echo "<td>" . htmlspecialchars($row["P_Classe"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["P_Quantidade"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["P_Categoria"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["P_EANVALIDO"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["P_Codigo_Interno"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["P_Data_Criacao"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["P_Ultima_Atualizacao"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["P_Estoque"]) . "</td>";
        echo "<td><a href='EditaProd.php?id=" . htmlspecialchars($row["P_ID_Produto"]) . "' class='edit-button'><i class='fas fa-edit'></i></a></td>";
        echo "</tr>";
    }
    // Fim da tabela
    echo "</table>";
} else {
    echo "<p>Nenhum produto encontrado.</p>";
}

// Fechando a conexão
$mysqli->close();
?>

</body>
</html>
