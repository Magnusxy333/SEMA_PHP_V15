<?php
session_start();
include '../server.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  header('Location: login.php');
  exit;
}

// Buscar informações apenas do usuário logado
$username = $_SESSION['username'];
$sql = mysql_query("SELECT * FROM tb_register WHERE username = '$username'"); 

// Verificar se a query foi bem-sucedida
if ($sql === false) {
  die('Erro na consulta SQL: ' . mysql_error());
}

// Obter os dados do usuário
$linha = mysql_fetch_assoc($sql);

// Verificar se encontrou o usuário
if (!$linha) {
  die('Usuário não encontrado.');
}

// ----------------------------------------------------------------------
// ✅ BLOCO DE LÓGICA CORRIGIDA (Troca de Foto/Ícone)
// ----------------------------------------------------------------------

$db_photo_url = $linha['profile_picture_url'];
$profile_photo_url = null; // Variável de controle: é NULL se não tiver foto de usuário

// 1. Verifica se o campo do BD tem um caminho salvo E se é um caminho de upload real
if (isset($db_photo_url) && !empty($db_photo_url) && strpos($db_photo_url, 'uploads/') !== false) {
    
    // 2. Adiciona o "../" necessário para sair da pasta "html/" e acessar a raiz "uploads/"
    $image_path = '../' . $db_photo_url; 
    $profile_photo_url = $image_path; // Atribui o caminho da foto
} 
// Nota: Se $profile_photo_url for null, o bloco HTML usará a nova imagem padrão.

// 3. Define o estilo da imagem para o Header (Apenas o estilo, que será usado logo abaixo)
$img_style_header = "style='width: 38px; height: 38px; border-radius: 50%; object-fit: cover; margin-right: 2px; vertical-align: middle;'";

// ----------------------------------------------------------------------
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Meu Perfil - SEMA</title>
  <link rel="stylesheet" href="../css/profile.css">
  <link rel="icon" href="../images/icon-site.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    
  <div class="header">
    <div class="left">
      <a href="../index.php">
        <img class="icon" src="../images/sema.png" alt="icon">
      </a>
    </div>

    <div class="right">

      <button class="theme-toggle" id="themeToggle" aria-label="Alternar tema">
        <i class="fas fa-sun"></i>
        <i class="fas fa-moon"></i>
      </button>

      <a class="areas-text" href="../index.php">                    
        <i class="fas fa-house-user"></i>                   
        HOME                     
      </a>

      <a class="areas-text" href="location.php">
        <i class="fas fa-map-marker-alt"></i>
        LOCALIZAÇÃO
      </a>

      <a class="areas-text" href="orientations.php">
        <i class="fas fa-book-open"></i>
        ORIENTAÇÕES
      </a>

      <a class="areas-text" href="contacts.php">
        <i class="fas fa-phone-alt"></i>
        CONTATOS
      </a>

      <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
        <a class="areas-text" href="profile.php">
          <span id="header-profile-wrapper">
            <?php if ($profile_photo_url !== null): ?>
              <img 
                id="header-profile-display" 
                src="<?php echo htmlspecialchars($profile_photo_url); ?>" 
                alt="Foto de Perfil" 
                <?php echo $img_style_header; ?>
              >
            <?php else: ?>
              <i class="fas fa-user-circle" id="header-profile-display"></i>
            <?php endif; ?>
          </span>
          PERFIL
        </a> 
    </div>
    <?php else: ?>
      <a class="areas-text" href="login.php">
        <i class='fas fa-sign-in-alt' id="login-size"></i>
      </a>
    <?php endif; ?>
    </div>
  </div> 

  <div class="main">

    <div class="right-side">

      <div>
        <a class="sidebar-button-active" href="">
          <i class="fa-solid fa-caret-down"></i> IDIOMAS
        </a>      
      </div>

      <div>
        <a class="sidebar-button-active" href="">
          <i class="fa-solid fa-caret-down"></i> TEMAS
        </a>      
      </div>

      <div>
        <a class="sidebar-button-active" href="">
          <i class="fa-solid fa-caret-down"></i> MODOS
        </a>      
      </div>
    </div>

    <div class="container-grid">
      <div class="title-gear">
        <h1>Informações do usuário </h1>
        <a href="sub_links/changeInfo.php" title="Alterar informações">
          <img class="icon_gear" src="../images/icons/gray_gear.png" alt="">
        </a>
        
      </div>

      <div style="display: flex; flex-direction: row; align-items: center;">      
        <div>
          <div class="info-item">
          <span class="info-label">Usuário:</span>
          <span class="info-value"><?php echo htmlspecialchars($linha['username']); ?></span>
          </div>
        
          <div class="info-item">
          <span class="info-label">Email:</span>
          <span class="info-value"><?php echo htmlspecialchars($linha['email']); ?></span>
          </div>
        
          <div class="info-item">
          <span class="info-label">Nome completo:</span>
          <span class="info-value"><?php echo htmlspecialchars($linha['nome'] . ' ' . $linha['sobrenome']); ?></span>
          </div>
          
        <div class="info-item password-section">
            <div>
            <span class="info-label">
            Senha:
            </span>
            <span id="password-value" class="info-value">
            ••••••••
            </span>
            </div>
              
            <div style="margin-left: 20px; margin-top: 23px;">
              <a href="#" id="toggle-password" style="color: #007bff; text-decoration: none; cursor: pointer;">
              <i class="fas fa-eye"></i> Mostrar senha
              </a>
            </div>
          </div>
        </div>      
          
        <div class="image_profile">
          <div class="image_side">
              
            <div class="preview-container">
              <?php if ($profile_photo_url !== null): ?>
                  <img 
                    class="profile-picture" 
                    id="main-profile-display"
                    src="<?php echo htmlspecialchars($profile_photo_url); ?>" 
                    alt="Foto de Perfil"
                  >
              <?php else: ?>
                  <img 
                    class="icon_option" 
                    id="main-profile-display"
                    src="../images/icons/icon_button2.png" 
                    alt="Ícone Padrão"
                  > 
              <?php endif; ?>
            </div>
            
            <form action="../update.php" method="POST" enctype="multipart/form-data" class="upload-form" id="upload-form" style="margin-top: 15px;">
          
              <input type="file" name="foto_perfil" id="foto-input" accept="image/jpeg, image/png, image/jpg" required style="display: none;">
              
              <button type="button" class="custom-file-button" id="file-button" onclick="document.getElementById('foto-input').click();" style="display: block; margin: 5px auto;">
                  <i class="fas fa-camera"></i> Escolher nova foto
              </button>
              
              <button type="submit" class="custom-file-button" style="margin-top: 10px;" id="save-photo-button">
                  <i class="fas fa-upload"></i> Salvar Foto
              </button>

            </form>
            
            <div class="upload-instructions">
              Formatos suportados: JPG, PNG, GIF<br>
              Tamanho máximo: 2MB
            </div>
          </div>
        </div>     
      </div>          
              
      <div class="buttons-container">
        <a href="logout.php">
          <button class="delete-account-button">
            Sair da conta
          </button>
        </a>

        <a href="sub_links/deleteVerification.php">
          <button class="logout-button">
            Excluir conta
          </button>
        </a>
      </div>    
    </div>
  </div>

  <div class="footer">
            
      <div class="staff-information">
        <p class="staff-information2">Ainda não nos conhece?</p>
        <a class="central-link" href="sub_links/about_us.php">sobre nós</a>
      </div>

      <div class="social_midias">
        <p class="staff-information">Nossas redes sociais</p>

        <div class="icons">
          
          <a href="https://www.instagram.com/elobos.acolhe?igsh=ZDE5N2F5ODVoY2pj">
            <img id="images" src="../images/icons/INSTA.webp" alt="">
          </a>

          <a href="https://x.com/ellobos675443">
            <img id="images" src="../images/icons/xTWT.avif" alt="">
          </a>

          <a href="https://www.youtube.com/@ellobos-n8n">
            <img id="images2" src="../images/icons/YOUYOU2.png" alt="">      
          </a>
        </div>
    </div>

<script src="../js/location.js"></script>

<!-- SISTEMA DE DARK MODE -->
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

<script>
  // Lógica para pré-visualizar a imagem no perfil principal e no header
  document.getElementById('foto-input').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const newImageUrl = e.target.result;
            
            // 1. Atualizar Imagem Principal (Preview no Perfil Grande)
            let mainDisplay = document.getElementById('main-profile-display');
            
            // Se o elemento for o ícone padrão, substitua-o por uma tag <img>
            if (mainDisplay.tagName !== 'IMG' || mainDisplay.classList.contains('icon_option')) {
                const newImg = document.createElement('img');
                newImg.id = 'main-profile-display';
                newImg.className = 'profile-picture'; // Aplica o CSS de 160x160
                newImg.alt = 'Nova Foto de Perfil';
                mainDisplay.replaceWith(newImg);
                mainDisplay = newImg; // Atualiza a referência
            }
            mainDisplay.src = newImageUrl;
            
            // 2. Atualizar Imagem do Header (Icone Pequeno)
            const headerWrapper = document.getElementById('header-profile-wrapper');
            let headerDisplay = document.getElementById('header-profile-display');
            
            // Se o elemento for o <i> (ícone padrão do header), substitua-o por uma tag <img>
            if (headerDisplay.tagName !== 'IMG') {
                const newHeaderImg = document.createElement('img');
                newHeaderImg.id = 'header-profile-display';
                // Define o estilo inline para o tamanho pequeno do header (25x25)
                newHeaderImg.setAttribute('style', 'width: 25px; height: 25px; border-radius: 50%; object-fit: cover; margin-right: 5px; vertical-align: middle;');
                newHeaderImg.alt = 'Nova Foto de Perfil';
                headerDisplay.replaceWith(newHeaderImg);
                headerDisplay = newHeaderImg; // Atualiza a referência
            }
            headerDisplay.src = newImageUrl;
        };
        reader.readAsDataURL(file);
    }
  });

  // Lógica para Mostrar/Ocultar Senha (mantida)
  document.getElementById('toggle-password').addEventListener('click', function(e) {
    e.preventDefault();
    
    var passwordElement = document.getElementById('password-value');
    var toggleElement = document.getElementById('toggle-password');
    var iconElement = toggleElement.querySelector('i');
    
    if (passwordElement.textContent === '••••••••') {
      // Mostrar senha real (substitua pelo valor real da senha)
      passwordElement.textContent = '<?php echo htmlspecialchars($linha["senha"]); ?>';
      toggleElement.innerHTML = '<i class="fas fa-eye-slash"></i> Ocultar senha';
    } else {
      // Ocultar senha
      passwordElement.textContent = '••••••••';
      toggleElement.innerHTML = '<i class="fas fa-eye"></i> Mostrar senha';
    }
  });
</script>

</body>
</html>