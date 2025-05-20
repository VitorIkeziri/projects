<?php
session_start(); // Inicia a sessão 

// Destroi todas as variáveis de sessão
session_unset();
// Destroi a sessão
session_destroy();

// Redireciona diretamente para a página de login
header("Location: ../Login/index.php");
exit();
?>
