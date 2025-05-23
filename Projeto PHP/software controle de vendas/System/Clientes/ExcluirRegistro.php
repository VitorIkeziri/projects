<?php
    require("../conecta.php");
	$Id_cliente = ""; 
	$erro = "";
	$mensagem = "";

	if (isset($_POST["Pesquisar"])) {
		$PesquisaCPF = htmlentities($_POST["PesquisaCPF"]);

		if (empty($PesquisaCPF)) {
			$erro = "CPF Vazio";
		} else {
			$query = $mysqli->query("SELECT * FROM Cliente WHERE CPF = '$PesquisaCPF'");
			$tabela = $query->fetch_assoc();

			if ($tabela) {
				$Id_cliente = $tabela["Id_cliente"];
				$CPF = $tabela["CPF"];
				$Nome = $tabela["Nome"];
				$erro = "Cadastro Localizado";
			} else {
				$erro = "CPF não encontrado";
			}
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Excluir Registro</title>
	<link rel="stylesheet" type="text/css" href="../css/Excluir.css" />
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
</head>
<body>
	<div class="central">
		<div>
			<?php if (empty($CPF) && empty($Nome)) : ?>
				<h2>CPF:</h2>
				<form method="POST" action="ExcluirRegistro.php">
					<input type="text" name="PesquisaCPF" maxlength="14" oninput="formatarCPF(this)" required>
					<br><br>
					<button type="submit" name="Pesquisar">Pesquisar</button>
				</form>
				<?php if (!empty($erro)) : ?>
					<div class="error-box"><?php echo $erro; ?></div>
				<?php endif; ?>
			<?php else : ?>
				<div class="error-box"><?php echo $erro; ?></div>
				<br>
				<h2 class="texto">CPF:</h2>
				<input type="text" name="CPF" class="campo" value="<?php echo $CPF; ?>" readonly/>
				<br /><br />
				<h2 class="texto">Nome:</h2>
				<input type="text" name="Nome" class="campo" value="<?php echo $Nome; ?>" readonly/>
				<br /><br />
			<?php endif; ?>
		</div>
		<div class="buttons">
			<a href="Cadastro.php">
				<button type="button" style="margin-right: 80px;">Voltar</button>
			</a>
			<form method="POST">
		<input type="hidden" name="excluir" value="<?php echo $Id_cliente; ?>">
		<button type="submit" style="margin-left: 80px;" id="btnExcluir">Excluir</button>
			</form>
			</div>
			<?php if (!empty($mensagem)) : ?>
				<div class="mensagem"><?php echo $mensagem; ?></div>
			<?php endif; ?>
			</div>
			</body>
			</html>

			<?php
			if (isset($_POST["excluir"])) {
				require("conecta.php");
				
				$Id_cliente = $_POST["excluir"];
				
				if (!empty($Id_cliente)) {
					$mysqli->query("DELETE FROM cliente WHERE Id_cliente = '$Id_cliente'");
				
					if ($mysqli->error == "") {
						$mensagem = "Registro excluído com sucesso.";
					} else {
						$mensagem = "Erro ao excluir o registro: " . $mysqli->error;
					}
				} else {
					$mensagem = "ID do cliente não fornecido.";
				}
			}
			?>
