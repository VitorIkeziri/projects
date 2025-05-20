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
$tipoVenda = isset($_GET['tipoVenda']) ? $_GET['tipoVenda'] : 'todas';

// Verifica se a data de início e fim são do mesmo dia
if ($dataInicio && $dataFim && $dataInicio === $dataFim) {
    // Ajusta a dataFim para cobrir o dia inteiro (23:59:59)
    $dataFim = $dataFim . ' 23:59:59';
} else {
    // Caso contrário, formata as datas de início e fim para considerar o intervalo completo de dias
    if ($dataInicio) {
        $dataInicio .= ' 00:00:00';
    }
    if ($dataFim) {
        $dataFim .= ' 23:59:59';
    }
}

$query = "
    SELECT 
        DATE(data_venda) AS data_venda, 
        SUM(valor_total) AS valor_total,
        entrega 
    FROM cupom 
    WHERE 1
";

// Filtro de nrloja (apenas se existir)
if ($nrloja) {
    $query .= " AND nrloja = '$nrloja'";
}

// Filtros de data
if ($dataInicio && $dataFim) {
    $query .= " AND data_venda BETWEEN '$dataInicio' AND '$dataFim'";
}

// Filtro de tipo de venda
if ($tipoVenda === 'local') {
    $query .= " AND entrega = 0";
} elseif ($tipoVenda === 'entrega') {
    $query .= " AND entrega = 1";
}

$query .= " GROUP BY DATE(data_venda), entrega";

// Executa a consulta
$resultado = $mysqli->query($query);
if (!$resultado) {
    die("Erro na consulta SQL: " . $mysqli->error);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Relatório de Vendas</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/linkRVendas.css">
</head>
<body>
<div class="container mt-5">
  <h2 class="text-center">Relatório de Vendas</h2>

  <!-- Filtros -->
  <form class="row mb-4" action="linkRVendas.php" method="GET" id="filtrosRelatorio">
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
      <label for="tipoVenda">Tipo de Venda</label>
      <select class="form-control" id="tipoVenda" name="tipoVenda">
        <option value="todas" <?php echo (isset($_GET['tipoVenda']) && $_GET['tipoVenda'] == 'todas') ? 'selected' : ''; ?>>Todas</option>
        <option value="local" <?php echo (isset($_GET['tipoVenda']) && $_GET['tipoVenda'] == 'local') ? 'selected' : ''; ?>>Local</option>
        <option value="entrega" <?php echo (isset($_GET['tipoVenda']) && $_GET['tipoVenda'] == 'entrega') ? 'selected' : ''; ?>>Entrega</option>
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
    // Verifica se o botão 'Gerar Excel' foi pressionado
    if (isset($_POST['gerarExcel'])) {
        // Cria a planilha
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

            // Cabeçalhos
            $sheet->setCellValue('A1', 'Data')
                  ->setCellValue('B1', 'Valor Total')
                  ->setCellValue('C1', 'Entrega');

            // Preenche os dados
            $rowIndex = 2; // Começa na linha 2
            while ($row = $resultado->fetch_assoc()) {
                $sheet->setCellValue('A' . $rowIndex, date('d/m/Y', strtotime($row['data_venda'])))
                      ->setCellValue('B' . $rowIndex, number_format($row['valor_total'], 2, ',', '.'))
                      ->setCellValue('C' . $rowIndex, $row['entrega']);
                $rowIndex++;
            }
        

        // Define o tipo do arquivo para download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Relatorio_Cosistencia.xlsx"');

        // Salva o arquivo Excel e inicia o download
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
            <th>Valor Total</th>
            <th>Tipo</th>
          </tr>
        </thead>
        <tbody>
          <?php while($row = $resultado->fetch_assoc()): ?>
            <tr>
              <td><?php echo date('d/m/Y', strtotime($row['data_venda'])); ?></td>
              <td>R$ <?php echo number_format($row['valor_total'], 2, ',', '.'); ?></td>
              <td><?php echo $row['entrega'] ? 'Entrega' : 'Local'; ?></td>
            </tr>
          <?php endwhile; ?>
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
<script>
// Função para alternar entre a tabela e o gráfico
function toggleTabelaGrafico() {
  const tabelaVisivel = $('#tabelaContainer').is(':visible');
  $('#tabelaContainer').toggle(!tabelaVisivel);
  $('#graficoContainer').toggle(tabelaVisivel);

  // Atualiza o texto do botão
  $('#btnToggleGrafico').text(tabelaVisivel ? 'Mostrar Tabela' : 'Gerar Gráfico');

  if (tabelaVisivel) {
    const ctx = document.getElementById('graficoVendas').getContext('2d');

    // Dados do gráfico agrupados por data
    const dadosGrafico = {
      labels: [
        <?php
          $resultado->data_seek(0);
          while ($row = $resultado->fetch_assoc()) {
              echo '"' . date('d/m/Y', strtotime($row['data_venda'])) . '", ';
          }
        ?>
      ],
      datasets: [{
        label: 'Volume de Vendas',
        backgroundColor: 'rgba(54, 162, 235, 0.5)',
        borderColor: 'rgba(54, 162, 235, 1)',
        data: [
          <?php
            $resultado->data_seek(0);
            while ($row = $resultado->fetch_assoc()) {
                echo $row['valor_total'] . ', ';
            }
          ?>
        ]
      }]
    };

    // Renderiza o gráfico de barras
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
              color: '#FFFFFF' // Define a cor branca para os valores
            },
            ticks: {
              // Formata os valores com "R$" e ajusta a cor para branca
              callback: function(value) {
                return 'R$ ' + value.toFixed(2);
              },
              color: '#FFFFFF' // Define a cor branca para os valores
            }
          },
          x: {
            title: {
              display: true,
              text: 'Data',
              color: '#FFFFFF' // Define a cor branca para os valores
            },
            ticks: {
              color: '#FFFFFF' // Define a cor branca para os rótulos do eixo X
            }
          }
        },
        plugins: {
          legend: {
            labels: {
              color: '#FFFFFF' // Define a cor branca para o rótulo da legenda
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
