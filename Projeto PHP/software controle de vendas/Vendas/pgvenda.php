<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/pgvenda.css">
    <script src="js/pgvenda.js"></script>
    <title>Gerenciador de Vendas</title>
</head>
<body>
    <header>
        <h1>Vendas</h1>
    </header>
    <div id="menu">
        <div id="menuback">
            <form action="pgvenda.php" method="post">
                <label for="cpf">CPF do Cliente:</label>
                <input type="text" id="cpf" name="cpf" required><br><br>

                <label for="produto">Produto:</label>
                <select id="produto" name="produto" required>
                    <?php
                    // Conexão com o banco de dados
                    require("conecta_2.php");

                    // Carregar produtos
                    $produtos_sql = "SELECT ID_produto, Descricao FROM produto";
                    $produtos_result = $mysqli->query($produtos_sql);

                    if ($produtos_result->num_rows > 0) {
                        while($row = $produtos_result->fetch_assoc()) {
                            echo "<option value='" . $row["ID_produto"] . "'>" . $row["Descricao"] . "</option>";
                        }
                    }
                    ?>
                </select><br><br>
                
                <label for="quantidade">Quantidade:</label>
                <input type="number" id="quantidade" name="quantidade" required><br><br>
                
                <label for="valor">Valor:</label>
                <input type="number" id="valor" name="valor" step="0.01" required><br><br>

                <label for="pagamento">Forma de Pagamento:</label>
                <select id="pagamento" name="pagamento" required>
                    <?php
                    // Carregar formas de pagamento
                    $pagamento_sql = "SELECT ID_Pagamento, Descricao FROM fpagamento";
                    $pagamento_result = $mysqli->query($pagamento_sql);

                    if ($pagamento_result->num_rows > 0) {
                        while($row = $pagamento_result->fetch_assoc()) {
                            echo "<option value='" . $row["ID_Pagamento"] . "'>" . $row["Descricao"] . "</option>";
                        }
                    }

                    // Fechar a conexão com o banco de dados
                    $mysqli->close();
                    ?>
                </select><br><br>
                
                <input type="submit" value="Adicionar">
            </form>
        </div>
    </div>
</body>
</html>
