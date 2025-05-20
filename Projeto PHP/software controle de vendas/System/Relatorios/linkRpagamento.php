<?php
require("../conecta.php"); // Conexão ao banco
include("../verifica_sessao.php");

require("vendor/autoload.php");

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$nrloja = isset($_SESSION['nrloja']) ? $_SESSION['nrloja'] : null;

// Variáveis para filtros e consulta de dados
$dataInicio = isset($_GET['dataInicio']) ? $_GET['dataInicio'] : null;
$dataFim = isset($_GET['dataFim']) ? $_GET['dataFim'] : null;
$formapagto = isset($_GET['formapagto']) ? $_GET['formapagto'] : 'todos';

// Verifica se a data de início e fim são do mesmo dia
if ($dataInicio && $dataFim && $dataInicio === $dataFim) {
    $dataFim = $dataFim . ' 23:59:59';
} else {
    if ($dataInicio) {
        $dataInicio .= ' 00:00:00';
    }
    if ($dataFim) {
        $dataFim .= ' 23:59:59';
    }
}

$query = "
    SELECT 
        DATE(fp.data_venda) AS data_venda, 
        fp.Forma_Pagamento, 
        SUM(fp.valor_pagamento) AS valor_pago,
        SUM(c.nr_itens) AS quantidade_itens,
        fpag.Descricao AS forma_pagamento_desc
    FROM formapagto fp
    LEFT JOIN config.fpagamento fpag ON fp.Forma_Pagamento = fpag.ID_Pagamento
    LEFT JOIN cupom c ON fp.cupom = c.cupom
    WHERE 1
";

// Filtros de data
if ($dataInicio && $dataFim) {
    $query .= " AND fp.data_venda BETWEEN '$dataInicio' AND '$dataFim'";
}

// Filtro de forma de pagamento
if ($formapagto != 'todos') {
    $query .= " AND fp.Forma_Pagamento = '$formapagto'";
}

// Filtro para nrloja com base na sessão
if ($nrloja) {
    $query .= " AND fp.nrloja = '$nrloja'";
}

$query .= " GROUP BY DATE(fp.data_venda), fp.Forma_Pagamento";

// Executa a consulta
$resultado = $mysqli->query($query);
if (!$resultado) {
    die("Erro na consulta SQL: " . $mysqli->error);
}

// Inicializa as variáveis de totais
$totalQuantidade = 0;
$totalValor = 0;
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vendas por Forma de Pgto</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/linkRpagamento.css?v=1.1">
</head>
<body>
<div class="container mt-5">
  <h2 class="text-center">Vendas por Forma de Pagamento</h2>

  <!-- Filtros -->
  <form class="row mb-4" action="linkRpagamento.php" method="GET" id="filtrosRelatorio">
    <div class="col-md-3">
      <label for="dataInicio">Data Início</label>
      <input type="date" class="form-control" id="dataInicio" name="dataInicio" 
             value="<?php echo isset($_GET['dataInicio']) ? $_GET['dataInicio'] : ''; ?>">
    </div>
    <div class="col-md-3">
      <label for="dataFim">Data Fim</label>
      <input type="date" class="form-control" id="dataFim" name="dataFim" 
             value="<?php echo isset($_GET['dataFim']) ? $_GET['dataFim'] : ''; ?>">
    </div>
    <div class="col-md-3">
      <label for="formapagto">Forma de Pagamento</label>
      <?php
      // Conectar ao banco de dados
      include("../conecta_2.php");

      // Definir a consulta para buscar as opções de forma de pagamento
      $query = "SELECT ID_Pagamento, Descricao FROM config.fpagamento";
      $result = $mysqli->query($query);

      // Capturar o valor de 'formapagto', se for passado pelo formulário
      $formapagto = isset($_POST['formapagto']) ? $_POST['formapagto'] : 'todos'; 
      ?>

      <select class="form-control" id="formapagto" name="formapagto">
          <option value="todos" <?php echo ($formapagto == 'todos') ? 'selected' : ''; ?>>Todas</option>

          <?php while ($row = $result->fetch_assoc()) { ?>
              <option value="<?php echo $row['ID_Pagamento']; ?>" <?php echo ($formapagto == $row['ID_Pagamento']) ? 'selected' : ''; ?>>
                  <?php echo $row['Descricao']; ?>
              </option>
          <?php } ?>
      </select>
    </div>
    <div class="col-md-3 d-flex align-items-end">
      <button type="submit" class="btn btn-primary w-100" id="btnBuscar">Buscar</button>
    </div>
  </form>

  <!-- Botões de Ação -->
  <div class="text-center mb-4">
    <button class="btn btn-success mr-2" id="btnToggleGrafico">Gerar Gráfico</button><br><br>
    <form method="post" action="">
      <button type="submit" class="btn btn-secondary" id="btnGerarExcel" name="gerarExcel">Gerar .xls</button>
  </form>
    <?php
    if (isset($_POST['gerarExcel'])) {
        // Cria a planilha
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
    
        // Cabeçalhos
        $sheet->setCellValue('A1', 'Data')
              ->setCellValue('B1', 'Quantidade de Produtos')
              ->setCellValue('C1', 'Valor Total')
              ->setCellValue('D1', 'Forma de Pagamento');
    
        // Preenche os dados
        $rowIndex = 2; // Começa na linha 2
        while ($row = $resultado->fetch_assoc()) {
            $sheet->setCellValue('A' . $rowIndex, date('d/m/Y', strtotime($row['data_venda'])))
                  ->setCellValue('B' . $rowIndex, $row['quantidade_itens'])
                  ->setCellValue('C' . $rowIndex, number_format($row['valor_pago'], 2, ',', '.'))
                  ->setCellValue('D' . $rowIndex, $row['forma_pagamento_desc']);
            $rowIndex++;
        }
    
        // Define o tipo do arquivo para download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Relatorio_Vendas.xlsx"');
    
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
      }
    ?>
  </div>

  <!-- Tabela de Vendas -->
  <div id="tabelaContainer">
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-sm" id="tabelaVendas">
        <thead>
          <tr>
            <th>Data</th>
            <th>Quantidade Produtos</th>
            <th>Valor Total</th>
            <th>Forma de Pagamento</th>
          </tr>
        </thead>
        <tbody>
          <?php while($row = $resultado->fetch_assoc()):
            $totalQuantidade += $row['quantidade_itens'];
            $totalValor += $row['valor_pago'];
          ?>
            <tr>
              <td><?php echo date('d/m/Y', strtotime($row['data_venda'])); ?></td>
              <td><?php echo $row['quantidade_itens']; ?></td>
              <td>R$ <?php echo number_format($row['valor_pago'], 2, ',', '.'); ?></td>
              <td><?php echo $row['forma_pagamento_desc']; ?></td>
            </tr>
          <?php endwhile; ?>
          <tr>
            <td><strong>Total</strong></td>
            <td><strong><?php echo $totalQuantidade; ?></strong></td>
            <td><strong>R$ <?php echo number_format($totalValor, 2, ',', '.'); ?></strong></td>
            <td></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Container do Gráfico -->
  <div id="graficoContainer" class="mt-5" style="display: none;">
    <canvas id="graficoVendas"></canvas>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<script>
// Função para alternar entre a tabela e o gráfico
function toggleTabelaGrafico() {
  const tabelaVisivel = $('#tabelaContainer').is(':visible');
  $('#tabelaContainer').toggle(!tabelaVisivel);
  $('#graficoContainer').toggle(tabelaVisivel);

  $('#btnToggleGrafico').text(tabelaVisivel ? 'Mostrar Tabela' : 'Gerar Gráfico');

  if (tabelaVisivel) {
    const ctx = document.getElementById('graficoVendas').getContext('2d');

    // Prepara os dados do gráfico agrupados por data e forma de pagamento
    const dadosPorDataFormaPagto = {};
    <?php
      $resultado->data_seek(0);
      while ($row = $resultado->fetch_assoc()) {
          $data = date('d/m/Y', strtotime($row['data_venda']));
          $formaPagamento = $row['forma_pagamento_desc'];
          echo "if (!dadosPorDataFormaPagto['$data']) dadosPorDataFormaPagto['$data'] = {};\n";
          echo "dadosPorDataFormaPagto['$data']['$formaPagamento'] = {valor: {$row['valor_pago']}, itens: {$row['quantidade_itens']}};\n";
      }
    ?>

    const labels = Object.keys(dadosPorDataFormaPagto);
    const formasPagamento = Array.from(new Set(labels.flatMap(data => Object.keys(dadosPorDataFormaPagto[data]))));

    // Define as cores para cada forma de pagamento
    const coresPorFormaPagamento = {
      'Cartão Débito': 'rgba(75, 192, 192, 0.5)',
      'Cartão Crédito': 'rgba(255, 99, 132, 0.5)',
      'Dinheiro': 'rgba(54, 162, 235, 0.5)',
      'Pix': 'rgba(255, 206, 86, 0.5)',
      'POS': 'rgba(153, 102, 255, 0.5)',
    };

    // Dados do gráfico, com barras para valores e linhas para quantidades de itens
    const dadosGrafico = {
      labels: labels,
      datasets: [
        ...formasPagamento.map(formaPagamento => ({
          label: `${formaPagamento} (Valor)`,
          backgroundColor: coresPorFormaPagamento[formaPagamento] || 'rgba(75, 192, 192, 0.5)', // Cor de fundo
          borderColor: coresPorFormaPagamento[formaPagamento] || 'rgba(75, 192, 192, 1)', // Cor da borda
          data: labels.map(data => dadosPorDataFormaPagto[data][formaPagamento]?.valor || 0),
          type: 'bar',
          yAxisID: 'y',
          datalabels: {
            display: true,
            color: 'white',
            font: { size: 16 },
            formatter: (value) => `R$ ${value.toFixed(2)}`
          }
        })),
        //...formasPagamento.map(formaPagamento => ({
          //label: `${formaPagamento} (Itens)`,
          //borderColor: coresPorFormaPagamento[formaPagamento] || 'rgba(75, 192, 192, 1)', // Cor da linha
         // backgroundColor: 'transparent', // Fundo transparente para a linha
         // data: labels.map(data => dadosPorDataFormaPagto[data][formaPagamento]?.itens || 0),
          //type: 'line',
          //yAxisID: 'y1',
         // datalabels: {
          //  display: true,
          //  color: 'white',
         //   font: { size: 16 },
          //  anchor: 'end',
         //   align: 'start',
        //    offset: 5,
         //   formatter: value => `${value}`
        //  }
        //}))
      ]
    };

    Chart.register(ChartDataLabels);  // Ativa o plugin

    new Chart(ctx, {
      type: 'bar',
      data: dadosGrafico,
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true,
            title: {
              display: true,
              text: 'Valor em R$',
              color: '#FFFFFF',
              font: { size: 16 }
            },
            ticks: {
              callback: value => 'R$ ' + value.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'),
              color: '#FFFFFF',
              font: { size: 14 }
            }
          },
          y1: {
            beginAtZero: true,
            position: 'right',
            title: {
              display: true,
              text: 'Quantidade de Itens',
              color: '#FFFFFF',
              font: { size: 16 }
            },
            ticks: {
              color: '#FFFFFF',
              font: { size: 14 }
            }
          },
          x: {
            title: { display: true, text: 'Data', color: '#FFFFFF' },
            ticks: { color: '#FFFFFF' }
          }
        },
        plugins: {
          legend: {
            labels: {
              color: '#FFFFFF',
              font: { size: 14 }
            }
          },
          datalabels: {
            display: true,
            color: '#FFFFFF',
            font: { size: 12 },
            formatter: (value, context) => {
              if (context.datasetIndex < formasPagamento.length) {
                // Formata valores monetários
                return 'R$ ' + value.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
              }
              // Exibe quantidade de itens
              return value;
            }
          }
        }
      }
    });
  }
}

// Evento do botão 'Gerar Gráfico' e 'Mostrar Tabela'
$('#btnToggleGrafico').on('click', toggleTabelaGrafico);

// Evento do botão 'Buscar' para sempre exibir a tabela ao aplicar novos filtros
$('#btnBuscar, #btnGerarExcel').on('click', function() {
  if (!$('#tabelaContainer').is(':visible')) {
    toggleTabelaGrafico();
  }
});
</script>
</body>
</html>

