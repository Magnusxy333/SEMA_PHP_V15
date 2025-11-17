<?php
session_start();
// O arquivo está em /html/sub_links/, então precisa subir dois níveis para a raiz do projeto.
include '../../server.php'; 

// 1. VERIFICAR AUTENTICAÇÃO E PERMISSÃO DE ADM
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['username'] !== 'soyADM') {
    header('Location: ../../index.php?error=access_denied');
    exit;
}

// 2. OBTER OS DADOS PARA CONFIRMAÇÃO
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: ../listagemAdm.php?error=no_id');
    exit;
}

$id_usuario_edicao = (int) $_GET['id']; 
$page_redirect = isset($_GET['page']) ? (int) $_GET['page'] : 1; 

// 3. CONSULTAR OS DADOS DO USUÁRIO NO BANCO
$query = "SELECT username FROM tb_register WHERE id = '$id_usuario_edicao'";
$resultado = mysql_query($query);

if (!$resultado || mysql_num_rows($resultado) == 0) {
    header('Location: ../listagemAdm.php?error=user_not_found');
    exit;
}

$linha = mysql_fetch_assoc($resultado); 
$username_a_excluir = htmlspecialchars($linha['username']);

// 4. IMPEDIR QUE O ADM EXCLUA A PRÓPRIA CONTA
if ($_SESSION['username'] === $username_a_excluir) {
    $error_message = urlencode("Você não pode excluir a sua própria conta de ADM!");
    header("Location: ../listagemAdm.php?error={$error_message}&page={$page_redirect}");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Confirmar Exclusão</title>
    <link rel="icon" href="../../images/icon-site.png">
    <link rel="stylesheet" href="../../css/deleteUserConfirm2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- BOTÃO DE TEMA ADICIONADO -->
    <button id="themeToggle" class="theme-toggle">
      <i class="fas fa-moon"></i>
      <i class="fas fa-sun"></i>
    </button>

    <div class="main">
      <div class="main-content">
        <h2 class="title-delete">ATENÇÃO: CONFIRMAR EXCLUSÃO</h2>
        <p>Você tem certeza que deseja <strong>EXCLUIR</strong> permanentemente a conta de usuário:</p>
        <h3><?php echo $username_a_excluir; ?> (ID: <?php echo $id_usuario_edicao; ?>)</h3>
        <p>Esta ação é irreversível.</p>
        
        <div class="delete-container-buttons">
          <a href="../listagemAdm.php?page=<?php echo $page_redirect; ?>">
            <button class="back-button" type="button">
              Não, Voltar 
            </button>
          </a>

          <a class="yes-button" href="deleteUser.php?id=<?php echo $id_usuario_edicao; ?>&page=<?php echo $page_redirect; ?>">
            <button class="back-button1">
              Sim, Excluir Definitivamente
            </button>             
          </a>
        </div>
        </div>
    </div>

    <script>
        // ===== SISTEMA DE TEMA CLARO/ESCURO =====
        
        // Elementos DOM
        const themeToggle = document.getElementById('themeToggle');
        const body = document.body;
        
        // Verificar preferência salva ou preferência do sistema
        function getThemePreference() {
            // Verificar se há uma preferência salva no localStorage
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme) {
                return savedTheme;
            }
            
            // Verificar preferência do sistema
            if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                return 'dark';
            }
            
            // Tema claro como padrão
            return 'light';
        }
        
        // Aplicar tema
        function applyTheme(theme) {
            if (theme === 'dark') {
                body.setAttribute('data-theme', 'dark');
            } else {
                body.removeAttribute('data-theme');
            }
        }
        
        // Alternar tema
        function toggleTheme() {
            const currentTheme = body.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            applyTheme(newTheme);
            localStorage.setItem('theme', newTheme);
        }
        
        // Inicializar tema
        function initTheme() {
            const theme = getThemePreference();
            applyTheme(theme);
            
            // Adicionar evento de clique no botão de alternância
            if (themeToggle) {
                themeToggle.addEventListener('click', toggleTheme);
            }
            
            // Ouvir mudanças na preferência do sistema
            if (window.matchMedia) {
                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                    // Só aplicar se o usuário não tiver uma preferência salva
                    if (!localStorage.getItem('theme')) {
                        applyTheme(e.matches ? 'dark' : 'light');
                    }
                });
            }
        }
        
        // Inicializar quando o DOM estiver carregado
        document.addEventListener('DOMContentLoaded', initTheme);
    </script>
</body>
</html>