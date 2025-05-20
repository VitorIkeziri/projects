<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de CPF</title>
    <link rel="stylesheet" type="text/css" href="../css/Tabelas.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div>
        <div class="search-icon"></div>
        <form method="GET" action="">
            <input type="text" class="search-input" name="CPF" placeholder="Pesquisar CPF" maxlength="14" oninput="formatarCPF(this)">
            <button type="submit" class="search-button" name="pesquisa">Buscar</button>
        </form>
    </div>

    <?php
    //-----conexao com o banco de dados-----//
    require("../conecta.php");

    if (isset($_GET["pesquisa"]) && isset($_GET["CPF"])) {
        $CPF = $_GET["CPF"];

        // Exemplo de código para buscar os registros do CPF e atualizar a tabela:
        $query = $mysqli->query("SELECT * FROM Cliente WHERE CPF = '$CPF'");
        echo $mysqli->error;

        $registrosEncontrados = false;

        echo "<table border='1' align='center' style='background:white'>
                <tr>
                    <th>CPF</th>
                    <th>Nome</th>
                    <th>Endereco</th>
                    <th>Telefone</th>
                </tr>";

        while ($tabela = $query->fetch_assoc()) {
            $registrosEncontrados = true;

            echo "
            <tr>
                <td align='center'>$tabela[CPF]</td>
                <td align='center'>$tabela[Nome]</td>
                <td align='center'>$tabela[Endereco]</td>
                <td align='center'>$tabela[Telefone]</td>
            </tr>";
        }

        echo "</table>";

        if (!$registrosEncontrados) {
            echo "<p>Nenhum registro encontrado.</p>";
        }
    }
    ?>

    <script>
        function formatarCPF(campo) {
            var valor = campo.value;
            valor = valor.replace(/\D/g, ''); // Remove todos os caracteres não numéricos

            if (valor.length > 14) {
                valor = valor.substr(0, 14); // Limita o valor a 14 dígitos
            }
            if (valor.length > 3 && valor.length <= 6) {
                valor = valor.replace(/(\d{3})(\d{1,3})/, '$1.$2');
            } else if (valor.length > 6 && valor.length <= 9) {
                valor = valor.replace(/(\d{3})(\d{3})(\d{1,3})/, '$1.$2.$3');
            } else if (valor.length > 9) {
                valor = valor.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})/, '$1.$2.$3-$4');
            }

            campo.value = valor;
        }
    </script>
</body>
</html>
