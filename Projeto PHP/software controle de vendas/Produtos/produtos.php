<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produto</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="cadastro-produto">
            <h1>Cadastro de Produto</h1>
            <form action="processar_cadastro.php" method="post">
                <div class="coluna">
                    <label for="nome">Nome:</label><br>
                    <input type="text" id="nome" name="nome" required><br><br>

                    <label for="valor">Valor:</label><br>
                    <input type="text" id="valor" name="valor" required><br><br>

                    <label for="ean">EAN:</label><br>
                    <input type="text" id="ean" name="ean"><br><br>
                </div>
                <div class="coluna">
                    <label for="codigo_interno">Código Interno:</label><br>
                    <input type="text" id="codigo_interno" name="codigo_interno"><br><br>

                    <label for="autorizado_venda">Autorizado para venda:</label><br>
                    <select id="autorizado_venda" name="autorizado_venda">
                        <option value="sim">Sim</option>
                        <option value="nao">Não</option>
                    </select><br><br>

                    <input type="submit" value="Cadastrar">
                </div>
            </form>
        </div>
    </div>
</body>
</html>
