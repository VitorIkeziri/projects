<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="..\css\Tabelas.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="botaoe">
        <a href="AdicionaCliente.php" class="button-link">
            <button class="button" name="Botao">Cadastrar Cliente</button>
        </a>
        <a href="AlteraRegistro.php" class="button-link">
            <button class="button" name="Botao1">Altera Registro</button>
        </a>

        <a href="ExcluirRegistro.php" class="button-link">
            <button class="button" name="Botao2">Excluir Registro</button>
        </a>

        <a href="index.php" class="button-link">
            <button class="button" name="Voltar">Menu Principal</button>
        </a>
    </div>

    <div class="search-container">
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
        $registrosHtml = '';

        while ($tabela = $query->fetch_assoc()) {
            $registrosEncontrados = true;

            $registrosHtml .= "
            <tr>
                <td align='center'>$tabela[CPF]</td>
                <td align='center'>$tabela[Nome]</td>
                <td align='center'>$tabela[Endereco]</td>
                <td align='center'>$tabela[Telefone]</td>
                <td align='center'>$tabela[data_cadastro]</td>
            </tr>";
        }

        if ($registrosEncontrados) {
            $popupHtml = "
            <table border='1' align='center' style='background:white'>
                <tr>
                    <th>CPF</th>
                    <th>Nome</th>
                    <th>Endereco</th>
                    <th>Telefone</th>
                    <th>Data do cadastro</th>
                </tr>
                $registrosHtml
            </table>";
        
            // Exibe o resultado da pesquisa em um popup usando o SweetAlert2
            echo "<script>
                Swal.fire({
                    title: 'CPF Encontrado',
                    html: `$popupHtml`,
                    icon: 'success',
                    confirmButtonText: 'Voltar',
                    customClass: {
                        container: 'swal-vertical',
                        confirmButton: 'swal-button swal-button--black-border'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = window.location.href.split('?')[0];
                    }
                });
            </script>";
        } else {
            $popupHtml = "<p>Nenhum registro encontrado.</p>";
        
            // Exibe o resultado da pesquisa em um popup usando o SweetAlert2
            echo "<script>
                Swal.fire({
                    title: 'CPF Erro',
                    html: '$popupHtml',
                    icon: 'error',
                    confirmButtonText: 'Voltar',
                    customClass: {
                        confirmButton: 'swal-button swal-button--black-border'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = window.location.href.split('?')[0];
                    }
                });
            </script>";
        }
    }
    ?>

    <table border="1" width="1200" align="center" style="background:white">
        <tr>
            <th>Cliente</th>
            <th>CPF</th>
            <th>Nome</th>
            <th width="600">Endereco</th>
            <th>Telefone</th>
            <th>Data do cadastro</th>
        </tr>

        <?php
        //-----consulta registros da tabela-----//
        $query = $mysqli->query("SELECT * FROM Cliente");
        echo $mysqli->error;

        //-----carrega consulta de registros-----//
        while ($tabela = $query->fetch_assoc()) {
            echo "
            <tr>
                <td align='center'>$tabela[Id_cliente]</td>
                <td align='center'>$tabela[CPF]</td>
                <td align='center'>$tabela[Nome]</td>
                <td align='center'>$tabela[Endereco]</td>
                <td align='center'>$tabela[Telefone]</td>
                <td align='center'>$tabela[data_cadastro]</td>
            </tr>
            ";
        }
        ?>
</table>
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
