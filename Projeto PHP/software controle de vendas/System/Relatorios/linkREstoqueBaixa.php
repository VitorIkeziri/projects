<?php
require("../conecta.php"); // Conexão ao banco de dados
include("../verifica_sessao.php");

$nrloja = isset($_SESSION['nrloja']) ? $_SESSION['nrloja'] : null;

// Função para buscar os dados com filtros aplicados
// Função para buscar os dados com filtros aplicados
function fetchItems($mysqli, $startDate, $endDate, $includeEstornados, $nrloja, $produtoId) {
    $query = "SELECT i.Produto_id, 
                     p.P_Descricao, 
                     SUM(i.quantidade) AS total_quantidade, 
                     SUM(i.valor_produto * i.quantidade) AS total_valor
              FROM itens i
              JOIN config.produto p ON i.Produto_id = p.P_ID_Produto
              WHERE i.data_venda BETWEEN ? AND ?";

    // Filtrar por loja se $nrloja não for nulo
    if (!is_null($nrloja)) {
        $query .= " AND i.nrloja = ?";
    }

    // Adicionar condição para itens estornados se necessário
    if (!$includeEstornados) {
        $query .= " AND (i.estornado IS NULL OR i.estornado = 0)";
    }

    // Filtrar por Produto_id se informado
    if (!empty($produtoId)) {
        $query .= " AND i.Produto_id = ?";
    }

    $query .= " GROUP BY i.Produto_id, p.P_Descricao"; // Agrupar pelo Produto_id e P_Descricao

    $stmt = $mysqli->prepare($query);
    if (!$stmt) {
        die("Erro na preparação da consulta: " . $mysqli->error);
    }

    // Definir os parâmetros
    $params = [$startDate, $endDate];
    $types = 'ss';
    if (!is_null($nrloja)) {
        $params[] = $nrloja;
        $types .= 'i';
    }
    if (!empty($produtoId)) {
        $params[] = $produtoId;
        $types .= 'i';
    }

    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();

    $items = [];
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
    return $items;
}


// Valores padrão para os filtros
$startDate = $_POST['start_date'] ?? date('Y-m-01'); // Primeiro dia do mês atual
$endDate = $_POST['end_date'] ?? date('Y-m-d'); // Data atual
$includeEstornados = isset($_POST['include_estornados']) ? true : false;
$produtoId = $_POST['produto_id'] ?? null;

// Se a data final for fornecida, ajusta para o final do dia
if (isset($_POST['end_date']) && !empty($_POST['end_date'])) {
    $endDate = $_POST['end_date'] . ' 23:59:59'; // Final do dia
} else {
    $endDate = date('Y-m-d H:i:s'); // Data e hora atuais
}

// Obtém os dados do banco com filtros
$data = fetchItems($mysqli, $startDate, $endDate, $includeEstornados, $nrloja, $produtoId);

// Cálculo de total por produto, se filtrado
$totalQuantidade = 0;
$totalValor = 0;

foreach ($data as $item) {
    $totalQuantidade += $item['total_quantidade'];
    $totalValor += $item['total_valor'];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Saída de Itens</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/linkREstoqueBaixa.css?v=1.1">
</head>
<body>
<div class="container">
    <h2 class="text-center">Relatório de Saída de Itens</h2>

    <!-- Filtros -->
    <form method="POST" class="mb-4">
        <div class="row g-3">
            <div class="col-md-3">
                <label for="start_date" class="form-label">Data Inicial</label>
                <input type="date" id="start_date" name="start_date" class="form-control" value="<?= htmlspecialchars($startDate) ?>">
            </div>
            <div class="col-md-3">
                <label for="end_date" class="form-label">Data Final</label>
                <input type="date" id="end_date" name="end_date" class="form-control" value="<?= isset($_POST['end_date']) ? htmlspecialchars($_POST['end_date']) : date('Y-m-d') ?>">
            </div>
            <div class="col-md-3">
                <label for="produto_id" class="form-label">EAN Produto</label>
                <input type="text" id="produto_id" name="produto_id" class="form-control" value="<?= htmlspecialchars($produtoId) ?>">
            </div>
            <div class="col-md-3">
                <label for="include_estornados" class="form-label">Incluir Estornados</label>
                <div class="form-check">
                    <input type="checkbox" id="include_estornados" name="include_estornados" class="form-check-input" <?= $includeEstornados ? 'checked' : '' ?>>
                    <label class="form-check-label" for="include_estornados">Sim</label>
                </div>
            </div>
        </div>
        <div class="mt-3 d-flex justify-content-end">
            <button type="submit" class="btn btn-success">Aplicar Filtros</button>
        </div>
    </form>

    <!-- Exibir totais do produto -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="alert alert-black">
                <span class="strong">Quantidade Total Vendida:</span> <?= $totalQuantidade ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="alert alert-black">
                <span class="strong">Valor Total Vendido (R$):</span> R$ <?= number_format($totalValor, 2, ',', '.') ?>
            </div>
        </div>
    </div>

    <button id="toggleView" class="btn btn-custom mb-3">Exibir Gráfico</button>

    <!-- Relatório Analítico -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Valor Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['P_Descricao']) ?></td> <!-- Exibindo a descrição -->
                    <td><?= $item['total_quantidade'] ?></td>
                    <td>R$ <?= number_format($item['total_valor'], 2, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Relatório Gráfico -->
    <div id="grafico" style="display: none; display: flex; justify-content: space-between; align-items: flex-start; width: 100%;">
        <div style="flex: 1; padding: 10px;">
            <canvas id="chartValue"></canvas> <!-- Gráfico de Barras -->
        </div>
                    
        <div style="flex: 0 0 40%; padding: 10px;"> <!-- Ajuste a largura aqui -->
            <canvas id="chartQuantity"></canvas> <!-- Gráfico de Pizza -->
        </div>
    </div>

    <script>
    const data = <?= json_encode($data) ?>;

    const toggleButton = document.getElementById('toggleView');
    const graficoDiv = document.getElementById('grafico');
    const table = document.querySelector('.table'); // Referência à tabela

    toggleButton.addEventListener('click', () => {
        if (graficoDiv.style.display === 'none') {
            graficoDiv.style.display = 'flex';
            table.style.display = 'none'; // Ocultar a tabela
            toggleButton.textContent = 'Ocultar Gráfico';
            renderCharts(); // Renderiza ambos os gráficos
        } else {
            graficoDiv.style.display = 'none';
            table.style.display = 'table'; // Exibir a tabela novamente
            toggleButton.textContent = 'Exibir Gráfico';
        }
    });


    // Renderizar ambos os gráficos
    function renderCharts() {
        // Gráfico de pizza para quantidade
        const ctxPie = document.getElementById('chartQuantity').getContext('2d');
        const labels = data.map(item => item.P_Descricao); // Usar a descrição do produto
        const quantities = data.map(item => item.total_quantidade);

        new Chart(ctxPie, {
            type: 'pie',  // Gráfico de pizza
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Quantidade Vendida',
                        data: quantities, // Dados de quantidade
                        backgroundColor: ['#FF5733', '#33FF57', '#3357FF', '#FF33A1', '#FFD700'],
                        borderColor: ['#C70039', '#28B463', '#21618C', '#D5006A', '#F1C40F'],
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            color: 'white', // Cor dos textos da legenda
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw + ' unidades';
                            }
                        },
                        bodyColor: 'white', // Cor do texto no tooltip
                        titleColor: 'white', // Cor do título no tooltip
                    }
                }
            }
        });

        // Gráfico de barras para valor total vendido
        const ctxBar = document.getElementById('chartValue').getContext('2d');
        const values = data.map(item => item.total_valor);

        // Gerar um array de cores dinâmico
        const barColors = values.map((_, index) => {
            const colors = [
                '#FF5733', '#33FF57', '#3357FF', '#FF33A1', '#FFD700', 
                '#8E44AD', '#3498DB', '#E74C3C', '#1ABC9C', '#F39C12'
            ];
            return colors[index % colors.length]; // Reutilizar cores se o número de valores for maior que o número de cores
        });

        new Chart(ctxBar, {
            type: 'bar',  // Gráfico de barras
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Valor Total Vendido (R$)',
                        data: values, // Dados de valor total vendido
                        backgroundColor: barColors, // Usar cores diferentes para cada barra
                        borderColor: barColors.map(color => color.replace(/[^,]+(?=\))/, '1')), // Bordas com as mesmas cores
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            color: 'white', // Cor do texto
                            boxWidth: 0, // Tamanho da "caixa" ao lado do texto (remove o fundo colorido)
                            boxHeight: 0, // Remove a altura da caixa
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': R$ ' + tooltipItem.raw.toFixed(2);
                            }
                        },
                        bodyColor: 'white', // Cor do texto no tooltip
                        titleColor: 'white', // Cor do título no tooltip
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: 'white' // Cor dos textos no eixo X
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: 'white' // Cor dos textos no eixo Y
                        }
                    }
                }
            }
        });
    }
</script>
</body>
</html>
