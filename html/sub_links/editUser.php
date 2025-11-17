<?php
session_start();
// O arquivo está em /html/sub_links/, então precisa subir dois níveis para a raiz do projeto.
include '../../server.php'; 

// 1. VERIFICAR AUTENTICAÇÃO E PERMISSÃO DE ADM
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['username'] !== 'soyADM') {
    header('Location: ../../index.php?error=access_denied');
    exit;
}

// 2. OBTER O ID DO USUÁRIO A SER EDITADO (e o número da página para redirecionar)
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Redireciona para a listagem se o ID não for fornecido
    header('Location: ../listagemAdm.php?error=no_id');
    exit;
}

$id_usuario_edicao = (int) $_GET['id']; 
// Captura o número da página atual da listagem (page=...) para redirecionar
$page_redirect = isset($_GET['page']) ? (int) $_GET['page'] : 1; 

// 3. CONSULTAR OS DADOS DO USUÁRIO NO BANCO
// Buscamos o usuário pelo ID, garantindo que pegamos o registro correto.
$query = "SELECT id, username, nome, sobrenome, email FROM tb_register WHERE id = '$id_usuario_edicao'";
$resultado = mysql_query($query);

if (!$resultado || mysql_num_rows($resultado) == 0) {
    // Redireciona se o usuário não for encontrado
    header('Location: ../listagemAdm.php?error=user_not_found');
    exit;
}

// $linha armazena os dados do usuário a ser editado
$linha = mysql_fetch_assoc($resultado); 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuário ID: <?php echo $linha['id']; ?></title>
    <link rel="icon" href="../../images/icon-site.png">
    <link rel="stylesheet" href="../../css/editUser1.css">
    </head>
<body>
    

    <div class="main">

    
      
    <div class="container-grid">
    <center>
      <h1 class="title">Editando Usuário: <?php echo htmlspecialchars($linha['username']); ?></h1>
    </center>

    <center>
      <p class="id">ID: <?php echo htmlspecialchars($linha['id']); ?></p>
    </center>
    <form name="form_edicao" method="POST" action="editUserUpdate.php"> 
          
          <input type="hidden" name="id" value="<?php echo htmlspecialchars($linha['id']); ?>">
          <input type="hidden" name="list_page" value="<?php echo htmlspecialchars($page_redirect); ?>">

          <label for="username">Username:</label>
          <input class="input-info" type="text" name="username" value="<?php echo htmlspecialchars($linha['username']); ?>" required><br><br>

          <label for="email">E-mail:</label>
          <input class="input-info" type="email" name="email" value="<?php echo htmlspecialchars($linha['email']); ?>" required><br><br>

          <label for="nome">Nome:</label>
          <input class="input-info" type="text" name="nome" value="<?php echo htmlspecialchars($linha['nome']); ?>" required><br><br>

          <label for="sobrenome">Sobrenome:</label>
          <input class="input-info" type="text" name="sobrenome" value="<?php echo htmlspecialchars($linha['sobrenome']); ?>" required><br><br>

          <div class="buttons-container">
            
            <a href="../listagemAdm.php?page=<?php echo htmlspecialchars($page_redirect); ?>">
              <button class="back-button" type="button">
                Voltar à Listagem
              </button>
            </a>  

            <button class="logout-button" type="submit" name="bt_incluir" value="UPDATE">
              Salvar Alterações
            </button>
          </div>
        </form>
      </div>
      <br>
    
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
        themeToggle.addEventListener('click', toggleTheme);
        
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