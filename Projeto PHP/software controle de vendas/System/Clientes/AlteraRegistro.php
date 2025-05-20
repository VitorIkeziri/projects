<?php
    require("../conecta.php");


	$Id_cliente="";
    $CPF="";
	$Nome="";
	$Endereco="";
	$Telefone="";
	$Residencia="";
	$erro = "";
	
	if (isset($_POST["Pesquisar"])) {
		$PesquisaCPF = htmlentities($_POST["PesquisaCPF"]);
	
		
		if (empty($PesquisaCPF)) {
			$erro = "CPF Vazio";
		}
		else {
			
					//SQL PARA VALIDACAO 
					$query 		= $mysqli->query("SELECT * FROM Cliente WHERE CPF = '$PesquisaCPF'");
					$tabela	    = $query->fetch_assoc();
					$Id_cliente = $tabela["Id_cliente"];
					$CPF 		= $tabela["CPF"];
					$Nome 		= $tabela["Nome"];
					$Endereco 	= $tabela["Endereco"];
					$Telefone 	= $tabela["Telefone"];
					$Residencia = $tabela["Residencia"];
				
					echo $mysqli->error;
					if ($mysqli->error == "") {
						$erro = "Cadastro Localizado";
					}else{
						$erro = "ERRO";
					}
				
					
		} 
	}
?>

<!DOCTYPE html>
<html>
	<link rel="stylesheet" type="text/css"  href="..\css\Alterarg.css" />
	<head>
		<meta charset="utf-8">
		<title>Altera Cadastro Cliente</title>

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


			function ValidarInput(texto) {
			var input = texto.value;

			// Verifica se o primeiro caractere é um espaço em branco e remove-o
			if (input.charAt(0) === ' ') {
				input = input.substr(1);
			}

			input = input.toLowerCase();
			input = input.replace(/\b\w/g, function(match) { return match.toUpperCase(); });
			input = input.replace(/\s\s+/g, ' ');
			input = input.replace(/[^a-zA-ZÀ-ÿ\s']/g, '');

			texto.value = input;
			}




			function formatarCONT(campo){
			var valor = campo.value;
			valor = valor.replace(/\D/g, ''); // Remove todos os caracteres não numéricos

			if (valor.length > 11) {
				valor = valor.substr(0, 11); // Limita o valor a 11 dígitos
			}
			if (valor.length > 2 && valor.length <= 6) {
				valor = valor.replace(/(\d{2})(\d{1,4})/, '($1)$2');
			} else if (valor.length > 6 && valor.length <= 10) {
				valor = valor.replace(/(\d{2})(\d{4})(\d{1,4})/, '($1)$2-$3');
			} else if (valor.length > 10) {
				valor = valor.replace(/(\d{2})(\d{5})(\d{4})/, '($1)$2-$3');
			}

			campo.value = valor;
			}
		</script>


	</head>
<body style="background-color:orange">
	<br /><br />
	<br /><br />
	<div class="center">
    <form method="POST" class="pform" action="AlteraRegistro.php" >
	<?php if (!empty($erro)) { ?>
      <div class="error-box"><?php echo $erro; ?></div>
    <?php } ?>
    
	<br /><br />
	<input type="hidden" name="Id_cliente" value="<?php echo $Id_cliente ?>"/>
	
	<h2 class="texto">Pesquisar por CPF: <input type="text" class="campoat" name="PesquisaCPF" maxlength="14" oninput="formatarCPF(this)" /></h2>
		<br /><br />
		
		<input type="submit" value="Pesquisar" name="Pesquisar" />

		<br /><br />

        <h2 class="texto">CPF:</h2><input type="text" name="CPF" class="campo" maxlength="14" oninput="formatarCPF(this)" value="<?php echo $CPF ?>" />
        <br /><br />
	

		<h2 class="texto">Nome:</h2>
		<input type="text" name="Nome" class="campo" oninput="ValidarInput(this)" value="<?php echo $Nome ?>" />
		<br /><br />
		

        <h2 class="texto">Endereco:</h2><input type="text" name="Endereco" class="campo" value="<?php echo $Endereco ?>" />
        <br /><br />
		

        <h2 class="texto">Telefone:</h2><input type="text" name="Telefone" class="campo"  value="<?php echo $Telefone ?>" oninput="formatarCONT(this)" />
        <br /><br />
		

		<h2 class="texto">Residência:</h2><input type="text" name="Residencia" class="campo" value="<?php echo $Residencia ?>" />
        <br /><br />
		</h2>
		<h2>
		<input type="submit" value="salvar" name="button"/>
		</h2>
		<br /><br />
    </form>


	<form class="conta">
	
    <a href="Cadastro.php" >
    <input type="botao" class="botao" value="Voltar" name="button1">
    </a>
	<br /><br />
	
    <a href="index.php" >
    <input type="botao" class="botao" value="Menu"  name="button2">
    </a>
	<br /><br />
	</form>

</body>
</html>
    <?php
	if(isset($_POST["button"])){
		$Id_cliente       	= htmlentities($_POST["Id_cliente"]);
		$CPF				= htmlentities($_POST["CPF"]);
		$Nome     			= htmlentities($_POST["Nome"]);
		$Endereco   		= htmlentities($_POST["Endereco"]);
		$Telefone			= htmlentities($_POST["Telefone"]);
		$Residencia 		= htmlentities($_POST["Residencia"]);  



		if(empty($CPF) || empty($Nome) || empty($Endereco) || empty($Telefone)|| empty($Residencia)){
		   $erro = "Por favor, preencha todos os campos.";
		} else {

		$mysqli->query("update Cliente set Id_cliente = '$Id_cliente' , CPF = '$CPF' , Nome ='$Nome' , Endereco ='$Endereco', Telefone ='$Telefone' , Residencia ='$Residencia' where Id_cliente = '$Id_cliente'  ");
		echo $mysqli->error;
		if ($mysqli->error == "") {
			$erro = "Cadastro Alterado.";
		}
		else{
			$erro = "ERRO";
		}
		}
	}
    ?>
