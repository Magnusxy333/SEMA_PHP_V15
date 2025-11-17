<?php
session_start();
// O arquivo está em /html/sub_links/, então precisa subir dois níveis para a raiz do projeto.
include '../../server.php'; 

// 1. VERIFICAR AUTENTICAÇÃO E PERMISSÃO DE ADM
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['username'] !== 'soyADM') {
    header('Location: ../../index.php?error=access_denied');
    exit;
}

// 2. OBTER DADOS ESSENCIAIS (ID e PÁGINA)
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: ../listagemAdm.php?error=no_id');
    exit;
}

$id_usuario_edicao = (int) $_GET['id']; 
$page_to_redirect = isset($_GET['page']) ? (int) $_GET['page'] : 1; 

// 3. CONSULTAR USERNAME PARA IMPEDIR AUTO-EXCLUSÃO E TRATAR ERRO
$query_check = "SELECT username FROM tb_register WHERE id = '$id_usuario_edicao'";
$result_check = mysql_query($query_check);

if (!$result_check || mysql_num_rows($result_check) == 0) {
    header("Location: ../listagemAdm.php?delete=failed&message=" . urlencode("Usuário não encontrado.") . "&page={$page_to_redirect}");
    exit;
}
$user_info = mysql_fetch_assoc($result_check);

// 4. IMPEDIR QUE O ADM EXCLUA A PRÓPRIA CONTA
if ($_SESSION['username'] === $user_info['username']) {
    $error_message = urlencode("Você não pode excluir a sua própria conta de ADM!");
    header("Location: ../listagemAdm.php?delete=failed&message={$error_message}&page={$page_to_redirect}");
    exit;
}

// 5. EXECUTAR A QUERY DE EXCLUSÃO (DELETE)
$sql_delete = "DELETE FROM tb_register WHERE id = '$id_usuario_edicao'";

if (mysql_query($sql_delete)) {
    // 6. REDIRECIONAMENTO DE SUCESSO
    header("Location: ../listagemAdm.php?delete=success&id={$id_usuario_edicao}&page={$page_to_redirect}");
    exit;
} else {
    // 7. REDIRECIONAMENTO DE FALHA
    $error_message = urlencode("Erro ao excluir dados: " . mysql_error());
    header("Location: ../listagemAdm.php?delete=failed&message={$error_message}&page={$page_to_redirect}");
    exit;
}
?>