<?php
session_start();

// Verificar se o usuário está autenticado
if (!isset($_SESSION['usuario'])) {
    // Se não estiver autenticado, redirecione para a página de login
    header("Location: ../Login/index.php");
    exit;
}
?>
