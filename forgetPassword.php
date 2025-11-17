<?php
session_start();
include 'server.php'; // Inclui a conexão mysql_connect()

// Redireciona se não for um POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['email'])) {
    header('Location: html/forgot_email_form.php');
    exit;
}

$email = $_POST['email'];

// ✅ CORREÇÃO AQUI: Força para minúsculas e remove espaços em branco (trim)
$email_minusculo = strtolower(trim($email)); 

// Proteção básica para o email antes de usar na query
$email_seguro = mysql_real_escape_string($email_minusculo); 

// 1. Verificar se o email existe
$sql_check = mysql_query("SELECT id FROM tb_register WHERE email = '$email_seguro'");

// ----------------------------------------------------------------------
// BLOCO DE DEBUG (MANTIDO para diagnosticar erros fatais de SQL)
// ----------------------------------------------------------------------
if ($sql_check === FALSE) {
    // A consulta FALHOU. Exibe o erro do MySQL para diagnóstico.
    die("ERRO FATAL NA CONSULTA SQL: " . mysql_error());
}
// ----------------------------------------------------------------------


if (mysql_num_rows($sql_check) > 0) {
    // 2. Gerar Token Único e Data de Expiração (Ex: 1 hora)
    $token = bin2hex(openssl_random_pseudo_bytes(32)); 
    $expira = date("Y-m-d H:i:s", strtotime('+1 hour'));

    // 3. Salvar o token e a expiração no banco de dados
    $sql_update = "UPDATE tb_register 
                   SET reset_token = '$token', token_expiry = '$expira' 
                   WHERE email = '$email_seguro'"; // Usa a variável segura

    if (mysql_query($sql_update)) {
        
        // 4. CONSTRUÇÃO DO LINK DE REDEFINIÇÃO
        $reset_link = "http://" . $_SERVER['HTTP_HOST'] . "/html/reset_password.php?token=" . $token;

        // 5. SIMULAÇÃO DE ENVIO DE EMAIL (Apenas para teste)
        echo "<h1>SIMULAÇÃO: Email Enviado com Sucesso!</h1>";
        echo "<p>Na aplicação real, o link abaixo seria enviado para o email: **$email_minusculo**</p>";
        echo "<p>Clique aqui para redefinir a senha: <a href=\"$reset_link\">$reset_link</a></p>";
        echo "<p>⚠️ **LEMBRETE:** Este é um link de teste! Após testar, remova esta parte de 'echo' e descomente o 'header' abaixo para produção.</p>";
        
        // Descomente o bloco abaixo para o ambiente de produção (após testar):
        /*
        header('Location: html/forgot_email_form.php?status=success');
        exit;
        */

    } else {
        // Erro ao atualizar o banco
        header('Location: html/forgot_email_form.php?status=error');
        exit;
    }

} else {
    // Email não encontrado ou falha silenciosa na consulta.
    header('Location: html/forgot_email_form.php?status=error');
    exit;
}
?>