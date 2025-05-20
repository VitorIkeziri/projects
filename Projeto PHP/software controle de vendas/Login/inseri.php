<?php
// Inclua a conexão com o banco de dados
include("conecta.php");

$erro = "";
$sucesso = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Captura os dados do formulário
    $usuario = isset($_POST['usuario']) ? filter_var($_POST['usuario'], FILTER_SANITIZE_STRING) : '';
    $senha = isset($_POST['senha']) ? $_POST['senha'] : '';

    // Verifica se o usuário e senha foram informados
    if (empty($usuario)) {
        $erro = "Por favor, informe um nome de usuário.";
    } elseif (empty($senha)) {
        $erro = "Por favor, informe uma senha.";
    } else {
        // Criptografa a senha
        $senha_criptografada = password_hash($senha, PASSWORD_DEFAULT);

        // Insere o usuário no banco de dados
        $sql = "INSERT INTO usuarios (usuario, senha) VALUES (?, ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('ss', $usuario, $senha_criptografada);

        if ($stmt->execute()) {
            $sucesso = "Usuário cadastrado com sucesso!";
        } else {
            $erro = "Falha ao cadastrar usuário: " . $mysqli->error;
        }

        // Fecha a declaração
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #161750;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        input[type="submit"]:hover {
            background-color: #130e4b;
        }
        .message {
            margin: 10px 0;
            font-size: 14px;
            color: green;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Cadastro de Usuário</h2>
        <form method="post" action="">
            <input type="text" name="usuario" placeholder="Usuário" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <input type="submit" value="Cadastrar">
        </form>

        <?php if (!empty($erro)) { ?>
            <div class="message error"><?php echo $erro; ?></div>
        <?php } elseif (!empty($sucesso)) { ?>
            <div class="message"><?php echo $sucesso; ?></div>
        <?php } ?>
    </div>
</body>
</html>
