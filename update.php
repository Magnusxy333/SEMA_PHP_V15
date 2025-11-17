<?php
session_start();
// O caminho do include deve ser ajustado para onde o server.php está em relação ao update.php
include 'server.php';

// 1. VERIFICAÇÃO DE LOGIN
// Verifica se o usuário está logado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['username'])) {
    // Redireciona para a página de login se não estiver logado
    header('Location: html/login.php');
    exit;
}

// Obter o username atual (para saber qual registro atualizar)
$username_atual = $_SESSION['username'];
$action_performed = false; // Flag para rastrear se alguma ação de atualização foi feita

// -------------------------------------------------------------------
// ✅ LÓGICA 1: ATUALIZAÇÃO DA FOTO DE PERFIL (Formulário de upload)
// -------------------------------------------------------------------
if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {

    $file_tmp = $_FILES['foto_perfil']['tmp_name'];
    $file_name = basename($_FILES['foto_perfil']['name']);

    // CUIDADO: Cria um nome de arquivo ÚNICO para evitar sobrescrever fotos de outros usuários!
    $ext = pathinfo($file_name, PATHINFO_EXTENSION);
    $new_file_name = $username_atual . '_' . time() . '.' . $ext;

    // Pasta de destino: 'uploads' está na raiz (mesmo nível de update.php)
    $upload_dir = 'uploads/';
    $destination = $upload_dir . $new_file_name;

    if (move_uploaded_file($file_tmp, $destination)) {
        // Sucesso no upload. O caminho salvo no banco deve ser relativo à raiz.
        $photo_path_db = mysql_real_escape_string($destination);

        // Query de atualização simplificada para APENAS a foto
        $sql_update_photo = "UPDATE tb_register 
                             SET profile_picture_url = '$photo_path_db' 
                             WHERE username = '$username_atual'";

        if (mysql_query($sql_update_photo)) {
            $action_performed = true;
            // Redireciona para o perfil com sucesso
            header('Location: html/profile.php?upload=success');
            exit;
        } else {
            // Se falhar a query, redireciona com erro
            die("Erro ao atualizar a foto no banco de dados: " . mysql_error());
        }
    } else {
        // Se falhar o movimento do arquivo, redireciona com erro
        die("Erro ao mover o arquivo de foto para o destino.");
    }
}


// -------------------------------------------------------------------
// ✅ LÓGICA 2: ATUALIZAÇÃO DE INFORMAÇÕES GERAIS (Formulário bt_incluir)
// -------------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bt_incluir'])) {

    // COLETAR E SANITIZAR OS DADOS DO POST (essencial para que a query funcione)
    $novo_username  = mysql_real_escape_string($_POST['username']);
    $novo_email     = mysql_real_escape_string($_POST['email']);
    $novo_nome      = mysql_real_escape_string($_POST['nome']);
    $novo_sobrenome = mysql_real_escape_string($_POST['sobrenome']);
    $nova_senha     = mysql_real_escape_string($_POST['senha']);

    // INÍCIO DA QUERY
    $sql_update = "UPDATE tb_register SET 
                   username = '$novo_username', 
                   email = '$novo_email', 
                   nome = '$novo_nome', 
                   sobrenome = '$novo_sobrenome'";

    // TRATAMENTO DA SENHA (SÓ ATUALIZA SE FOI PREENCHIDA)
    if (!empty($nova_senha)) {
        // ✅ REMOVIDO: Criptografia usando MD5
        // ✅ AGORA: Salva a senha em texto puro (sem hash)
        $sql_update .= ", senha = '$nova_senha'";
    }

    // CONDIÇÃO PARA SABER QUEM ATUALIZAR
    $sql_update .= " WHERE username = '$username_atual'";

    // EXECUTAR A QUERY DE ATUALIZAÇÃO
    if (mysql_query($sql_update)) {
        $action_performed = true;

        // Se o usuário mudou o username, atualize a sessão
        if ($novo_username !== $username_atual) {
            $_SESSION['username'] = $novo_username;
        }

        // Redireciona para o perfil com mensagem de sucesso
        header('Location: html/profile.php?update=success');
        exit;
    } else {
        // Se falhar
        die("Erro ao atualizar dados: " . mysql_error());
    }
}

// 3. TRATAMENTO FINAL (Se a página foi acessada sem POST ou com POST irrelevante)
if (!$action_performed) {
    // Redireciona se a página foi acessada diretamente sem formulário
    header('Location: html/sub_links/changeInfo.php');
    exit;
}