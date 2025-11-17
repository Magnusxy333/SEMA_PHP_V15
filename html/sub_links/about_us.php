<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SEMA</title>
  <link rel="icon" href="../../images/icon-site.png">
  <link rel="stylesheet" href="../../css/about_us1.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php
      session_start();
      // O caminho do include aponta para a raiz
      include '../../server.php'; 

      // Variáveis default
      $profile_photo_url = null; 
      $img_style_header = "style='width: 38px; height: 38px; border-radius: 50%; object-fit: cover; margin-right: 5px; vertical-align: middle;'";

      if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        $username = $_SESSION['username'];
        // Busca APENAS o caminho da foto, mais eficiente
        $sql = mysql_query("SELECT profile_picture_url FROM tb_register WHERE username = '$username'"); 
        
        if ($sql && $linha = mysql_fetch_assoc($sql)) {
          $db_photo_url = $linha['profile_picture_url'];
          
          // Verifica se há um caminho válido
          if (isset($db_photo_url) && !empty($db_photo_url) && strpos($db_photo_url, 'uploads/') !== false) {
            // Usa '../../' para ajustar o caminho do banco (uploads/...)
            $profile_photo_url = '../../' . $db_photo_url; 
          } 
        }
      }
    ?>

    <div class="header">
      <div class="left">
        <a href="../../index.php">
          <img class="icon" src="../../images/sema.png" alt="icon">
        </a>
      </div>

      <div class="right">

        <button class="theme-toggle" id="themeToggle" aria-label="Alternar tema">
          <i class="fas fa-sun"></i>
          <i class="fas fa-moon"></i>
        </button>

        <a class="areas-text" href="../../index.php">                    
          <i class="fas fa-house-user"></i>                   
          HOME                     
        </a>

        <a class="areas-text" href="../location.php">
          <i class="fas fa-map-marker-alt"></i>
          LOCALIZAÇÃO
        </a>

        <a class="areas-text" href="../orientations.php">
          <i class="fas fa-book-open"></i>
          ORIENTAÇÕES
        </a>

        <a class="areas-text" href="../contacts.php">
          <i class="fas fa-phone-alt"></i>
          CONTATOS
        </a>

        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
          <a class="areas-text" href="../profile.php">
            <?php if ($profile_photo_url !== null): ?>
              <img 
                src="<?php echo htmlspecialchars($profile_photo_url); ?>" 
                alt="Foto de Perfil" 
                <?php echo $img_style_header; ?>
              >
            <?php else: ?>
              <i class="fas fa-user-circle"></i>
            <?php endif; ?>
            PERFIL
          </a> 
        </div>
        <?php else: ?>
          <a class="areas-text" href="../login.php">
            <i class='fas fa-sign-in-alt' id="login-size"></i>
          </a>
        <?php endif; ?>
      </div>
    </div>  
  
    <!---------------------------------->

    <div class="main">

      <h1 class="title">
        Criadores do SEMA
      </h1>

      <div class="team-members">

        <div class="teams-margin-left">
          <img class="photo-team-size" src="../../images/team-photos/david.png" alt="">
          <h1>Davi Capelari</h1>
        </div>

        <div class="teams-margin-left">
          <img class="photo-team-size" src="../../images/team-photos/Giovanne.png" alt="">
          <h1>Giovane Girald</h1>
        </div>

        <div class="teams-margin-left">
          <img class="photo-team-size" src="../../images/team-photos/kauã.png" alt="">
          <h1>Kauã Carlos</h1>
        </div>

        <div class="teams-margin-left">
          <img class="photo-team-size" src="../../images/team-photos/tata.png" alt="">
          <h1>Thaisa Nascimento</h1>
        </div>

        <div class="teams-margin-left">
          <img class="photo-team-size" src="../../images/team-photos/cruz.png" alt="">
          <h1>Gabriel Cruz</h1>
        </div>

      </div>

      <h1 class="title">
        História do SEMA
      </h1>

      <P class="text-main">
        O SEMA é um projeto criado e desenvolvido por alunos da <a href="https://www.fatecmaua.com.br/">fatec de mauá</a>
      </P>

      <p class="text-main">
        com objetivo de criar uma plataforma de ajuda geral para os residentes do município de Mauá.
      </p>

      <p class="text-main">
        Através de uma plataforma web e mobile que forneça diversos tipos de assistências
      </p>

      <p class="text-main">
        Tais como localização de upas, delegacias e outros locais de assistências; orientações e contatos de emergências 
      </p>

    </div>
    
    <!---------------------------------->

    <div class="footer">
           
      <div class="staff-information">
        <p>Ainda não nos conhece?</p>
        <a class="central-link" href="about_us.php">sobre nós</a>
      </div>

      <div class="social_midias">
        <p class="staff-information">Nossas redes sociais</p>

        <div class="icons">
          
          <a href="https://www.instagram.com/elobos.acolhe?igsh=ZDE5N2F5ODVoY2pj">
            <img id="images" src="../../images/icons/INSTA.webp" alt="">
          </a>

          <a href="https://x.com/ellobos675443">
            <img id="images" src="../../images/icons/xTWT.avif" alt="">
          </a>

          <a href="https://www.youtube.com/@ellobos-n8n">
            <img id="images2" src="../../images/icons/YOUYOU2.png" alt="">      
          </a>

        </div>
      </div>

    </div>

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

</body>
</html>