<!DOCTYPE html>
<html>
<link rel="stylesheet" type="text/css"  href="..\css\Adiciona.css" />
<head>
	<meta charset="utf-8">
</head>
<body>
<br>
<div class="center">
    <form method="POST" action="AdicionaCliente.php" class="pform" >
        <br>
        <h4 class="texto">CPF do Cliente: </h4><input type="text" class="campo" name="CPF" maxlength="30" placeholder="Digite o CPF" oninput="formatarCPF(this)" />
        <br /><br />
        <h4 class="texto" >Nome do Cliente: </h4><input type="text" class="campo" name="Nome" maxlength="40" placeholder="Digite o Nome"  />
        <br /><br />
        <h4 class="texto">Endereço do Cliente:</h4><input type="text" class="campo" name="Endereco" maxlength="40" placeholder="Digite o Endereço"  />
        <br /><br />
        <h4 class="texto">Contato do Cliente:</h4><input type="text" class="campo" name="Telefone" maxlength="25" placeholder="Digite o Contato" oninput="formatarCONT(this)"  />
        <br /><br />
        <h4 class="texto">Residencia do Cliente:</h4><input type="text" class="campo" name="Residencia" maxlength="8" placeholder="Digite Residencia"  />
        <br /><br>
        <div style="text-align: center;">
        <input type="submit" value="salvar" name="button"  />
        <br></br>
        </div>
    </form>
    <div style="text-align: center;">
    <a href="Cadastro.php" >
        <input type="submit" value="Voltar">
        </a>
</div>
    <br>
</body>
</html>
    <div style="color:black;" align="center">
        <h2>
                <?php
            if(isset($_POST["button"])){
                require("../conecta.php");

                $CPF=htmlentities($_POST["CPF"]);
                $Nome=htmlentities($_POST["Nome"]);
                $Endereco=htmlentities($_POST["Endereco"]);
                $Telefone=htmlentities($_POST["Telefone"]);
                $Residencia=htmlentities($_POST["Residencia"]);

                // Verifica se algum campo está vazio
                if(empty($CPF) || empty($Nome) || empty($Endereco) || empty($Telefone)|| empty($Residencia)){
                    echo "Por favor, preencha todos os campos.";
                } else {
                    $mysqli->query("INSERT INTO Cliente (CPF, Nome, Endereco, Telefone, data_cadastro,Residencia) VALUES ('$CPF', '$Nome', '$Endereco', '$Telefone', NOW(),$Residencia)");
                    echo $mysqli->error;

                    if($mysqli->error == ""){
                        echo "<br />Cliente adicionado com sucesso<br /></br />";
                    } else {
                        echo "<br />ERRO ao adicionar cliente<br /></br />";
                    }
                }
            }
        ?>
    </h2>
    <br>
    </div>
</div>
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