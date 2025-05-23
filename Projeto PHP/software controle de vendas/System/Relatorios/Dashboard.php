<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Resumo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/Dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Biblioteca Chart.js -->
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center mb-4">Dashboard - Resumo de Operações</h1>
        
        <?php
        include("../verifica_sessao.php");

        $nrloja = isset($_SESSION['nrloja']) ? $_SESSION['nrloja'] : null;

        // Conexões com os bancos de dados
        require("../conecta.php"); // Conexão com o banco `erp`
        require("../conecta_2.php"); // Conexão com o banco `config`
        
        // Variáveis para armazenar os resumos
        $totalClientes = $totalVendas = $metodosPagamento = 0;
        $produtosEstoque = [];
        
        // Total de clientes cadastrados
        $queryClientes = "SELECT COUNT(*) AS total FROM erp.cliente";
        $stmt = $mysqli->prepare($queryClientes);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $totalClientes = $row['total'];
        }

        // Total de vendas realizadas (com estornado = 0)
        $queryVendas = "SELECT COUNT(*) AS total FROM erp.venda WHERE nrloja = ? AND estornado = 0";
        $stmt = $mysqli->prepare($queryVendas);
        $stmt->bind_param('i', $nrloja);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $totalVendas = $row['total'];
        }

        // Total de vendas estornadas (estornado = 1)
        $queryVendasEstornadas = "SELECT COUNT(*) AS total FROM erp.venda WHERE nrloja = ? AND estornado = 1";
        $stmt = $mysqli->prepare($queryVendasEstornadas);
        $stmt->bind_param('i', $nrloja);
        $stmt->execute();
        $result = $stmt->get_result();
        $totalVendasEstornadas = 0;
        if ($row = $result->fetch_assoc()) {
            $totalVendasEstornadas = $row['total'];
        }

        // Produtos com maior quantidade em estoque
        $queryEstoque = "SELECT P_Descricao, P_Estoque FROM config.produto WHERE P_NroLoja = ? ORDER BY P_Estoque DESC LIMIT 5";
        $stmt = $mysqli->prepare($queryEstoque);
        $stmt->bind_param('i', $nrloja);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $produtosEstoque[] = $row;
        }

        // Métodos de pagamento disponíveis
        $queryPagamento = "SELECT COUNT(*) AS total FROM config.fpagamento";
        $stmt = $mysqli->prepare($queryPagamento);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $metodosPagamento = $row['total'];
        }
        ?>
        
        <!-- Seção de Resumos (Quadrados) -->
        <div class="row text-center mb-4">
            <div class="col-md-3">
                <div class="card card-total-clientes">
                    <div class="card-body">
                        <h5>Clientes</h5>
                        <h3><?php echo $totalClientes; ?></h3>
                        <p class="details">Clientes registrados no sistema.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-total-vendas">
                    <div class="card-body">
                        <h5>Valor total de Vendas</h5>
                        <h3><?php echo $totalVendas; ?></h3>
                        <p class="details">Vendas realizadas até o momento.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-metodos-pagamento">
                    <div class="card-body">
                        <h5>Formas de Pagamento</h5>
                        <h3><?php echo $metodosPagamento; ?></h3>
                        <p class="details">Formas de pagamento disponíveis.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-top-produtos">
                    <div class="card-body">
                        <h5>Estoque de Produtos</h5>
                        <ul class="list-unstyled">
                            <?php foreach ($produtosEstoque as $produto): ?>
                                <li><?php echo $produto['P_Descricao'] . " (" . $produto['P_Estoque'] . ")"; ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <p class="details">Produtos mais estocados.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Seção de Gráficos -->
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <canvas id="graficoVendas" height="200"></canvas>
                    </div>
                    <div class="col-md-6">
                        <canvas id="graficoProdutos"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Gráfico de Vendas (Pizza)
        const ctxVendas = document.getElementById('graficoVendas').getContext('2d');
        new Chart(ctxVendas, {
            type: 'doughnut',
            data: {
                labels: ['Vendas Normais', 'Vendas Estornadas'],
                datasets: [{
                    label: 'Vendas',
                    data: [<?php echo $totalVendas; ?>, <?php echo $totalVendasEstornadas; ?>],
                    backgroundColor: ['#39912A', '#dc3545'], // Cores dos dados
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: '#ffffff', // Cor dos textos da legenda
                        }
                    },
                    tooltip: {
                        bodyColor: '#ffffff', // Cor do texto dos tooltips
                        titleColor: '#ffffff' // Cor do título dos tooltips
                    }
                },
                layout: {
                    padding: 10 // Ajuste do layout
                }
            }
        });

        // Gráfico de Produtos
        const ctxProdutos = document.getElementById('graficoProdutos').getContext('2d');
        const produtosLabels = <?php echo json_encode(array_column($produtosEstoque, 'P_Descricao')); ?>;
        const produtosData = <?php echo json_encode(array_column($produtosEstoque, 'P_Estoque')); ?>;

        new Chart(ctxProdutos, {
            type: 'bar',
            data: {
                labels: produtosLabels, // Rótulos das barras
                datasets: [{
                    label: 'Quantidade em Estoque',
                    data: produtosData,
                    backgroundColor: '#2FC3D3', // Cor das barras
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        ticks: {
                            color: '#ffffff' // Cor dos rótulos do eixo X
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.2)' // Cor das linhas de grade do eixo X
                        }
                    },
                    y: {
                        ticks: {
                            color: '#ffffff' // Cor dos rótulos do eixo Y
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.2)' // Cor das linhas de grade do eixo Y
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: '#ffffff' // Cor dos textos da legenda
                        }
                    },
                    tooltip: {
                        bodyColor: '#ffffff', // Cor do texto do tooltip
                        titleColor: '#ffffff' // Cor do título do tooltip
                    }
                }
            }
        });
    </script>
</body>
</html>
