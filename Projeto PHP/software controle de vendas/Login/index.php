<?php
include("conecta.php");

session_start();
$erro = "";

// Limitar tentativas de login para evitar força bruta
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}
$max_attempts = 5;
$lockout_time = 15 * 60; // 15 minutos

// Checar se está bloqueado
if (isset($_SESSION['lockout']) && (time() - $_SESSION['lockout']) < $lockout_time) {
    die("Você excedeu o número de tentativas de login. Tente novamente em 15 minutos.");
}

// Certifique-se de que o formulário foi enviado e que ambos os campos estão presentes
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_SESSION['login_attempts'] >= $max_attempts) {
        $_SESSION['lockout'] = time();
        die("Você excedeu o número de tentativas de login. Tente novamente em 15 minutos.");
    }

    // Certifique-se de que os campos estão definidos
    $usuario = isset($_POST['usuario']) ? filter_var($_POST['usuario'], FILTER_SANITIZE_STRING) : '';
    $senha = isset($_POST['senha']) ? $_POST['senha'] : '';

    if (empty($usuario)) {
        $erro = "Por favor, verifique o usuário";
    } elseif (empty($senha)) {
        $erro = "Por favor, verifique a senha";
    } else {
        // Prevenção de SQL Injection e XSS
        $usuario_esc = $mysqli->real_escape_string($usuario);
        $senha_esc = $mysqli->real_escape_string($senha);

        // Verificar se o usuário existe
        $sql_user = "SELECT * FROM usuarios WHERE usuario = ?";
        $stmt_user = $mysqli->prepare($sql_user);
        $stmt_user->bind_param('s', $usuario_esc);
        $stmt_user->execute();
        $sql_user_result = $stmt_user->get_result();

        // Validação da senha usando password_hash e password_verify
        if ($sql_user_result->num_rows == 1) {
            $user_data = $sql_user_result->fetch_assoc();
            if (password_verify($senha_esc, $user_data['senha'])) {
                // Armazenar dados do usuário na sessão
                $_SESSION['usuario'] = $usuario;
                $_SESSION['senha'] = $senha;
                $_SESSION['cargo'] = $user_data['cargo'];

                // Redirecionamento após login bem-sucedido
                if (isset($_POST['alterna'])) {
                    header("Location: ../Mobile/index.php");
                } else {
                    header("Location: ../System/index.php");
                }
                exit;
            } else {
                $_SESSION['login_attempts']++;
                $erro = "Senha incorreta.";
            }
        } else {
            $_SESSION['login_attempts']++;
            $erro = "Usuário não encontrado.";
        }
    }
}

// Limpar tentativas de login após o sucesso
if (isset($_SESSION['usuario'])) {
    $_SESSION['login_attempts'] = 0;
}
?>


<!DOCTYPE html>
<html lang="pt-br" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Tela de login para acesso</title>
  <link rel="stylesheet" href="LoginEstilo.css">
</head>
<body>
  <div class="background-image"></div>
  <div class="center">
    <h1>Login</h1>
    <form method="post" action="index.php">
      <div class="set_texto">
        <input type="text" required name="usuario" placeholder="Usuário">
      </div>
      <div class="set_texto">
        <input type="password" required name="senha" placeholder="Senha">
      </div>
      <?php if (!empty($erro)) { ?>
        <div class="error-box"><?php echo $erro; ?></div>
      <?php } ?>
      </br>
      <input type="submit" value="Login">
      <div class="set_loga">
        <h4>Developer By: LTDA.IKEZIRI</h4> <a href="https://www.facebook.com/profile.php?id=100010056585991">Saiba Mais</a>
      </div>
    </form>
  </div>
</body>
</html>
