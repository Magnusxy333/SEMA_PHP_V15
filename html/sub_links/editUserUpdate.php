<?php
session_start();
// O arquivo está em /html/sub_links/, então precisa subir dois níveis para a raiz do projeto.
include '../../server.php'; 

// 1. VERIFICAR AUTENTICAÇÃO E PERMISSÃO DE ADM
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['username'] !== 'soyADM') {
    header('Location: ../../index.php?error=access_denied');
    exit;
}

// 2. LÓGICA DE ATUALIZAÇÃO POR ADM
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bt_incluir'])) {
    
    // a. VERIFICA SE OS CAMPOS ESSENCIAIS FORAM RECEBIDOS
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        die("ID do usuário a ser atualizado não foi fornecido.");
    }
    
    // b. CAPTURA DOS DADOS (ID é a chave, list_page é para redirecionamento)
    $id_usuario_edicao  = (int) $_POST['id']; 
    // Captura o número da página para redirecionamento para voltar à listagem
    $page_to_redirect   = isset($_POST['list_page']) ? (int) $_POST['list_page'] : 1;
    
    // c. COLETAR E SANITIZAR OS DADOS DO POST
    $novo_username  = mysql_real_escape_string($_POST['username']);
    $novo_email     = mysql_real_escape_string($_POST['email']);
    $novo_nome      = mysql_real_escape_string($_POST['nome']);
    $novo_sobrenome = mysql_real_escape_string($_POST['sobrenome']);
    $nova_senha     = $_POST['senha']; 

    // d. CONSTRUÇÃO DA QUERY
    $sql_update = "UPDATE tb_register SET 
                       username = '$novo_username', 
                       email = '$novo_email', 
                       nome = '$novo_nome', 
                       sobrenome = '$novo_sobrenome'";

    // TRATAMENTO DA SENHA (SÓ ATUALIZA SE FOI PREENCHIDA)
    if (!empty($nova_senha)) {
        $hashed_senha = md5($nova_senha);
        $sql_update .= ", senha = '$hashed_senha'";
    }

    // A CONDIÇÃO WHERE USA O ID DO FORMULÁRIO. ISSO IMPEDE A TROCA DE SESSÃO.
    $sql_update .= " WHERE id = '$id_usuario_edicao'";

    // e. EXECUTAR A QUERY DE ATUALIZAÇÃO
    if (mysql_query($sql_update)) {

        // 3. REDIRECIONAMENTO DE SUCESSO
        // Volta para a listagem na página em que o ADM estava.
        header("Location: ../listagemAdm.php?update=success&id={$id_usuario_edicao}&page={$page_to_redirect}");
        exit;
    } else {
        // Se falhar
        // Redireciona com erro, mas ainda volta para a listagem na página correta.
        $error_message = urlencode("Erro ao atualizar dados: " . mysql_error());
        header("Location: ../listagemAdm.php?update=failed&message={$error_message}&page={$page_to_redirect}");
        exit;
    }
}

// 4. TRATAMENTO FINAL (Redireciona se a página foi acessada diretamente sem POST)
// Redireciona para a listagem (página 1)
header('Location: ../listagemAdm.php?error=invalid_access&page=1');
exit;
?>