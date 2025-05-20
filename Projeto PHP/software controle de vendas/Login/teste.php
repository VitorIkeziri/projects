<?php
include("conecta.php");
$erro = ""; 
if (isset($_POST['usuario']) && isset($_POST['senha'])) {
  if (strlen($_POST['usuario']) == 0 || strlen($_POST['usuario']) == '') {
      $erro = "Por favor, verifique o usuário";
  } else if (strlen($_POST['senha']) == 0 || strlen($_POST['senha']) == '') {
      $erro = "Por favor, verifique a senha";
  } else {
      $trunfo = $mysqli->real_escape_string($_POST['usuario']);
      $trunco = $mysqli->real_escape_string($_POST['senha']);
      $consulta = "SELECT trunfo.id AS ID, trunco.id AS ID1, trunxo.id AS ID2 FROM trunfo JOIN trunco ON trunfo.id = trunco.id JOIN trunxo ON trunfo.id = trunxo.id";
      $sql_user = "SELECT * FROM trunfo WHERE usuario = '$trunfo'";
      $sql_pass = "SELECT * FROM trunco WHERE senha = '$trunco'";
      $sql_carg = "SELECT t.cargo FROM trunxo t JOIN trunco c ON t.id = c.id JOIN trunfo f ON c.id = f.id";

      $consulta_result = $mysqli->query($consulta) or die("Falha na consulta: " . $mysqli->error);
      $sql_user_result = $mysqli->query($sql_user) or die("Falha na consulta: " . $mysqli->error);
      $sql_pass_result = $mysqli->query($sql_pass) or die("Falha na consulta: " . $mysqli->error);
      $result = $mysqli->query($sql_carg);

      $return = $consulta_result->num_rows + $sql_user_result->num_rows + $sql_pass_result->num_rows;

      if ($return == 3) {
          if (!isset($_SESSION)) {
              session_start();

              $trunfo_data = $sql_user_result->fetch_assoc();
              $_SESSION['usuario'] = $trunfo;
              $_SESSION['senha'] = $trunco;

              $carg = $result->fetch_assoc();
              $cargo = $carg['cargo'];
              $_SESSION['cargo'] = $cargo;
          
              if (isset($_POST['alterna'])) {
                  header("location: ..\Mobile\index.php");
                  exit;
              } else {
                  header("location: ..\System\index.php");
                  exit;
              }
          }
      } else {
          $erro = "Falha no login";
      }
  }
}

?>

<!DOCTYPE html>
<html lang="pt-br" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Tela de login para acesso</title>
  <link rel="stylesheet" href="teste.css">
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
        Developer By: LTDA.IKEZIRI <a href="https://www.facebook.com/profile.php?id=100010056585991">Visualizar</a>
      </div>
    </form>
  </div>
</body>
</html>
