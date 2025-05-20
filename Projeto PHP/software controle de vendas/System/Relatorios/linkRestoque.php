<?php
require("../conecta.php"); // Conexão ao banco

include("../verifica_sessao.php");

// Recupera o número da loja da sessão
$nrloja = isset($_SESSION['nrloja']) ? $_SESSION['nrloja'] : null;


// Configuração inicial
$idProduto = isset($_POST['idProduto']) ? intval($_POST['idProduto']) : null;


$selectedProducts = isset($_POST['productFilter']) ? $_POST['productFilter'] : [];

// Consulta SQL inicial
$sql = "SELECT 
            e.nrloja AS 'Nrloja',
            e.Produto_id AS 'Produto_id',
            p.P_Descricao AS 'Descricao',
            e.quantidade AS 'Quantidade',
            e.valor_unit_compra AS 'ValorCompra',
            p.P_Valor AS 'Valorvenda',
            e.ultimo_pedido AS 'Ultimopedido',
            e.dth_inseri AS 'Dtinseri',
            e.dth_autaliza AS 'Dtatualiza'
        FROM 
            erp.estoque e
        INNER JOIN 
            config.produto p
        ON 
            e.Produto_id = p.P_ID_Produto AND e.nrloja = p.P_NroLoja";

// Se produtos foram selecionados, adiciona um filtro para eles
if (!empty($selectedProducts)) {
    $selectedProductsList = implode(',', array_map('intval', $selectedProducts));
    $sql .= " WHERE e.Produto_id IN ($selectedProductsList)";
}

// Se o nrloja estiver na sessão, filtra também por nrloja
if ($nrloja) {
    $sql .= empty($selectedProducts) ? " WHERE e.nrloja = $nrloja" : " AND e.nrloja = $nrloja";
}

// Ordena os resultados pela data de inserção e limita para os últimos 10 registros
$sql .= " ORDER BY e.dth_inseri DESC LIMIT 10"; // Últimos 10 registros

$result = $mysqli->query($sql);
if (!$result) {
    die("Erro na consulta SQL: " . $mysqli->error);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Estoque</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="css/linkRestoque.css?v=1.2">
</head>
<body>
<div class="container">
    <div class="center-container">
        <h1 class="titulo">Relatório de Estoque</h1>

        <!-- Formulário de Filtro -->
        <form method="POST" id="productFilterForm" onsubmit="filterChartData(event)">
            <div id="filterByInputSection">
                <label for="idProduto">Código EAN:</label>
                <input type="number" name="idProduto" id="idProduto" value="<?= htmlspecialchars($idProduto) ?>">    
                <button type="submit">Filtrar</button>
            </div>

            <div id="filterBySelectSection" style="display:none;">
                <label for="productFilter">Selecione os Produtos:</label>
                <select id="productFilter" name="productFilter[]" multiple style="width: 100%; height: 150px;">
                    <?php 
                    while($row = $result->fetch_assoc()): 
                    ?>
                        <option value="<?= htmlspecialchars($row['Produto_id']) ?>" 
                            <?= in_array($row['Produto_id'], $_POST['productFilter'] ?? []) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($row['Descricao']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                <br></br>
                <button type="submit">Filtrar</button>
            </div>
        </form>

        <button type="button" id="toggleFilterBtn">Alternar Filtro</button>

        <script>
            // Alternar entre os filtros
            document.getElementById('toggleFilterBtn').addEventListener('click', function() {
                const inputFilterSection = document.getElementById('filterByInputSection');
                const selectFilterSection = document.getElementById('filterBySelectSection');
                inputFilterSection.style.display = inputFilterSection.style.display === 'none' ? 'block' : 'none';
                selectFilterSection.style.display = selectFilterSection.style.display === 'none' ? 'block' : 'none';
            });
        </script>

        <div id="selectedItemsDisplay"></div>

        <div class="buttons">
            <button id="toggleButton" onclick="toggleView()">Exibir Gráfico</button>
        </div>
    </div>


<script>
// Função para atualizar a exibição dos itens selecionados
function updateSelectedItems() {
    var selectedOptions = document.getElementById('productFilter').selectedOptions;
    var selectedValues = [];
    for (var i = 0; i < selectedOptions.length; i++) {
        selectedValues.push(selectedOptions[i].text);
    }
    // Exibe os itens selecionados no campo de exibição
    document.getElementById('selectedItemsDisplay').innerHTML = "Selecionados: " + selectedValues.join(', ');
}
</script>
<?php
    $result = $mysqli->query($sql);
    if (!$result) {
        die("Erro na consulta SQL: " . $mysqli->error);
    }
?>
    <div id="analytical" style="display: block;">
        <div id="tabelaVendasContainer">
        <table id="tabelaVendas">
            <thead>
                <tr>
                    <th>Codigo EAN</th>
                    <th>Descrição</th>
                    <th>Quantidade</th>
                    <th>ValorCompra</th>
                    <th>Valorvenda</th>
                    <th>Ultimopedido</th>
                    <th>Dtinseri</th>
                    <th>Dtatualiza</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['Produto_id']) ?></td>
                        <td><?= htmlspecialchars($row['Descricao']) ?></td>
                        <td><?= htmlspecialchars($row['Quantidade']) ?></td>
                        <td><?= htmlspecialchars($row['ValorCompra']) ?></td>
                        <td><?= htmlspecialchars($row['Valorvenda']) ?></td>
                        <td><?= htmlspecialchars($row['Ultimopedido'] ?? 'Vazio') ?></td>
                        <td><?= htmlspecialchars($row['Dtinseri']) ?></td>
                        <td><?= htmlspecialchars($row['Dtatualiza']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    </div>

    <div id="chart" style="display: none; text-align: center;">
         <canvas id="stockChart" width="800" height="400"></canvas> <!-- Dimensões menores -->
    </div>
</div>
<?php

$result = $mysqli->query($sql);
if (!$result) {
    die("Erro na consulta SQL: " . $mysqli->error);
}
// Recupera os dados para o gráfico
$chartData = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Adiciona os dados ao gráfico
        $chartData[] = [
            "label" => $row['Descricao'],
            "value" => $row['Quantidade']
        ];
    }
}
?>
<script>
    const chartData = <?= json_encode($chartData) ?>;

    function toggleView() {
        const analytical = document.getElementById('analytical');
        const chart = document.getElementById('chart');
        const toggleButton = document.getElementById('toggleButton');

        if (analytical.style.display === 'block') {
            analytical.style.display = 'none';
            chart.style.display = 'block';
            toggleButton.innerText = 'Exibir Analítico';
            showChart();
        } else {
            analytical.style.display = 'block';
            chart.style.display = 'none';
            toggleButton.innerText = 'Exibir Gráfico';
        }
    }

    function showChart() {
    const ctx = document.getElementById('stockChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: chartData.map(data => data.label),
            datasets: [{
                label: 'Quantidade',
                data: chartData.map(data => data.value),
                backgroundColor: [
                    'rgba(255, 99, 132)',
                    'rgba(54, 162, 235)',
                    'rgba(255, 206, 86)',
                    'rgba(75, 192, 192)',
                    'rgba(153, 102, 255)',
                    'rgba(255, 159, 64)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    labels: {
                        color: 'white'  // Cor da legenda
                    }
                },
                tooltip: {
                    bodyColor: 'white'  // Cor do texto dentro do tooltip
                }
            },
            scales: {
                x: {
                    ticks: {
                        color: 'white'  // Cor dos rótulos do eixo X
                    }
                },
                y: {
                    ticks: {
                        color: 'white'  // Cor dos rótulos do eixo Y
                    }
                }
            },
            elements: {
                arc: {
                    borderColor: 'white'  // Cor das bordas dos arcos (se necessário)
                }
            }
        }
    });
}
</script>
</body>
</html>
