<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css"  href="css\teste.css" />
    <title>Cadastro de Cliente</title>
</head>
<body>
    <div class="center">
        <h1>Cadastro Cliente</h1>
        <form>
            <div class="left">
                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" class="campo" maxlength="14" placeholder="Digite o CPF" oninput="formatarCPF(this)">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" class="campo" maxlength="40" placeholder="Digite o Nome">
                <label for="endereco">Endereço:</label>
                <input type="text" id="endereco" class="campo" maxlength="40" placeholder="Digite o Endereço">
            </div>
            <div class="right">
                <label for="contato">Contato:</label>
                <input type="text" id="contato" class="campo" maxlength="25" placeholder="Digite o Contato" oninput="formatarCONT(this)">
                <label for="residencia">Residência:</label>
                <input type="text" id="residencia" class="campo" maxlength="8" placeholder="Digite Residencia">

                
                <label for="temComplemento">Adicionar Complemento</label>
                <input class="alinha" type="checkbox" id="temComplemento">
                <input type="text" id="complemento" class="campo" maxlength="32" placeholder="Digite o Complemento">
            </div>
            <div class="botao">
                <input type="submit" value="Salvar">
                <input type="submit" value="Cancelar">
            </div>
        </form>
    </div>
</body>
</html>

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

        document.addEventListener("DOMContentLoaded", function() {
            const temComplementoCheckbox = document.getElementById("temComplemento");
            const complementoCampo = document.getElementById("complemento");

            temComplementoCheckbox.addEventListener("change", function() {
                if (temComplementoCheckbox.checked) {
                    complementoCampo.style.display = "block";
                } else {
                    complementoCampo.style.display = "none";
                }
            });
        });
</script>
