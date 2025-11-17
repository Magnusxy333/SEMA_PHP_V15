<?php
session_start();
include 'server.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: html/login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Deleta o usuário do banco de dados
$sql = mysql_query("DELETE FROM tb_register WHERE id = '$user_id'");

if ($sql) {
    // Destrói a sessão e redireciona para página de confirmação
    session_destroy();
    header('Location: deletedAccount.php');
    exit;
} else {
    echo "Erro ao deletar a conta: " . mysql_error();
}
?>