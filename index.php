<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEMA</title>
    <link rel="icon" href="images/icon-site.png">
    <link rel="stylesheet" href="styles/mobile-styles/mobile.css">
    <link rel="stylesheet" href="css/index4.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="fonts/Genova.otf" rel="stylesheet" type="text/css">
  </head>
  <body>
    <?php
      // Inicie a sessão no início da página
      session_start();
      // Inclua o arquivo de conexão
      include 'server.php'; 
      // REMOVA ESTA LINHA: $_SESSION['user_id'] = $row['id'];

      // ----------------------------------------------------------------------
      // ✅ NOVO BLOCO: LÓGICA DA FOTO DE PERFIL NO HEADER
      // ----------------------------------------------------------------------
      $profile_photo_url = null; 
      $img_style_header = "style='width: 38px; height: 38px; border-radius: 50%; object-fit: cover; margin-right: 5px; vertical-align: middle;'";

      if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
          $username = $_SESSION['username'];
          // Buscar apenas a coluna da foto
          $sql = mysql_query("SELECT profile_picture_url FROM tb_register WHERE username = '$username'"); 
          
          if ($sql && $linha = mysql_fetch_assoc($sql)) {
              $db_photo_url = $linha['profile_picture_url'];
              
              // Verifica se há um caminho válido
              if (isset($db_photo_url) && !empty($db_photo_url) && strpos($db_photo_url, 'uploads/') !== false) {
                  // No index.php, o caminho já é relativo à raiz
                  $profile_photo_url = $db_photo_url; 
              } 
          }
      }
      // ----------------------------------------------------------------------

      // ✅ ADICIONAR: Buscar resultados dos formulários
      $ultima_satisfacao = null;
      $ultimo_quiz = null;

      if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && isset($_SESSION['user_id'])) {
          $user_id = $_SESSION['user_id'];
          
          // Buscar último resultado do formulário de satisfação
          $sql_satisfacao = "SELECT * FROM tb_form_satisfacao 
                            WHERE user_id = '$user_id' 
                            ORDER BY data_preenchimento DESC 
                            LIMIT 1";
          $result_satisfacao = mysql_query($sql_satisfacao);
          if ($result_satisfacao && mysql_num_rows($result_satisfacao) > 0) {
              $ultima_satisfacao = mysql_fetch_assoc($result_satisfacao);
          }
          
          // Buscar último resultado do quiz de segurança
          $sql_quiz = "SELECT * FROM tb_quiz_seguranca 
                      WHERE user_id = '$user_id' 
                      ORDER BY data_realizacao DESC 
                      LIMIT 1";
          $result_quiz = mysql_query($sql_quiz);
          if ($result_quiz && mysql_num_rows($result_quiz) > 0) {
              $ultimo_quiz = mysql_fetch_assoc($result_quiz);
          }
      }
    ?>
           
    <div class="header">
      <div class="left">
        <a href="index.php">
          <img class="icon" src="images/sema.png" alt="icon">
        </a>
      </div>

      <div class="right">
        
      <!-- Botão de alternância de tema -->
        <button class="theme-toggle" id="themeToggle" aria-label="Alternar tema">
          <i class="fas fa-sun"></i>
          <i class="fas fa-moon"></i>
        </button>
      
        <a class="areas-text" href="index.php">                    
          <i class="fas fa-house-user"></i>                   
          HOME                     
        </a>

        <a class="areas-text" href="html/location.php">
          <i class="fas fa-map-marker-alt"></i>
          LOCALIZAÇÃO
        </a>

        <a class="areas-text" href="html/orientations.php">
          <i class="fas fa-book-open"></i>
          ORIENTAÇÕES
        </a>

        <a class="areas-text" href="html/contacts.php">
          <i class="fas fa-phone-alt"></i>
          CONTATOS
        </a>

        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
      <a class="areas-text" href="html/profile.php">
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
    <a class="areas-text" href="html/login.php">
        <i class='fas fa-sign-in-alt' id="login-size"></i>
    </a>
<?php endif; ?>
</div>
    </div> 
  
    <div class="main">

      <img  class="banner-test" src="images/banner-home.jpg" alt="banner">

      <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && isset($_SESSION['username']) && $_SESSION['username'] === 'soyADM'): ?>
      <a href="html/listagemAdm.php">
        <img class="btn-listagem-teste"  src="images/icons/planilha4.png"/>
      </a>
      <?php endif; ?>

      <div class="main-content-position">
        
        <h1 class="title-home">Nossos Objetivos</h1>

        <div class="text-main-div">
      
         <p class="text-main">
            Temos como missão fornecer assistências diversas
          </p>
          <p class="text-main">
            em situações de risco a integridade  de nossos usuários.
          </p>
          <p class="text-main">
            Buscando sempre a forma mais rápida e eficiente de
          </p>
          <p class="text-main">
            auxílio imediato através dos diversos meios que nossa
          </p>
          <p class="text-main">
            plataforma busca disponibilizar através de nossa plataforma web
          </p>
          <p class="text-main">
            e, futuramente, também por meio de um aplicativo para celulares
          </p>     
 
        </div>
      </div>

      <div class="formulario" style="overflow-x: hidden;">
        <h1 class="title-home">
          O que você acha dos serviços públicos <br>
          <center>de emergência de Mauá?</center>
        </h1>

          <div class="formulario-row" style="max-width: 100%; box-sizing: border-box;">

              <div class="card1" style="max-width: 100%; box-sizing: border-box;">

    <p class="text-form">
        O que você acha dos 
        serviços municípais?
    </p>

    <p class="text-form">
        responda esse formulário que aborda questões como:
    </p>

    <ul class="text-list" style="max-width: 100%; overflow-wrap: break-word;">
        <li>qualidade e pontualidade do transporte público.</li>
        <li>Iluminação pública.</li>
        <li>Manutenção e conservação das ruas e calçadas.</li>
        <li>Satisfação com os recursos públicos em Mauá (SUS, ônibus, etc.).</li>
    </ul>

    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
        <!-- Usuário LOGADO -->
        <a href="html/avaliantionForm.php">
            <button class="botao-formulario">
                <?php echo (isset($ultima_satisfacao) && $ultima_satisfacao) ? 'Refazer Pesquisa' : 'Responda aqui!'; ?>
            </button>
        </a>

        <?php if (isset($ultima_satisfacao) && $ultima_satisfacao): ?>
            <p class="text-form" style="margin-top: 20px; text-align: center; background: lightblue; padding: 8px; border-radius: 5px; max-width: 100%; overflow-wrap: break-word;">
                <strong><span style="color: black;">Último resultado:</span></strong><br>
                <span style="color: black;">Satisfação: <?php echo $ultima_satisfacao['satisfacao_geral']; ?></span>
            </p>
        <?php endif; ?>

    <?php else: ?>
        <!-- Usuário NÃO LOGADO -->
        <a href="html/login.php">
            <button class="botao-formulario">
                responda aqui!
            </button>
        </a>

        <p class="text-lock-form">
            ( 🔒 Faça login para responder este formulário )
        </p>
    <?php endif; ?>

      </div>

          <div class="card2" style="max-width: 100%; box-sizing: border-box;">

            <p class="text-form">
              Como você se sairia em uma situação de risco?
            </p>

            <p class="text-form">
              responda esse formulário que aborda questões como:
            </p>

            <ul class="text-list" style="max-width: 100%; overflow-wrap: break-word;">
              <li>Identificação de perigos iminentes.</li>
              <li>Primeiros socorros básicos.</li>
              <li>Rotas de fuga e pontos de encontro.</li>
              <li>Contato com serviços de emergência (SAMU, Bombeiros, Polícia).</li>
            </ul>

            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
              

              <a href="html/challengeForm.php">
                <button class="botao-formulario">
                  <?php echo (isset($ultimo_quiz) && $ultimo_quiz) ? 'Refazer Teste' : 'Realize o teste'; ?>
                </button>
              </a>

                <?php if (isset($ultimo_quiz) && $ultimo_quiz): ?>
                <p class="text-form" style="margin: 10px 0; text-align: center; background: lightgreen; padding: 8px; border-radius: 5px; max-width: 100%; overflow-wrap: break-word;">
                  <strong><span style="color: black;">Último resultado:</span></strong><br>
                  <span style="color: black;">Acertos: <?php echo $ultimo_quiz['pontuacao']; ?>/<?php echo $ultimo_quiz['total_questoes']; ?></span><br>
                  <span style="color: black;">Desempenho: <?php echo $ultimo_quiz['percentual']; ?>%</span>
                </p>
              <?php endif; ?>
            <?php else: ?>
              <a href="html/login.php">
                <button class="botao-formulario">
                  Realize o teste 
                </button>
              </a>

              <p class="text-lock-form">
                ( 🔒 Faça login para responder este formulário )
              </p>
            <?php endif; ?>
          </div>

        </div>
      </div>

        

      <div class="donation">
        <h1 class="title-doacao">
          Quer ajudar o SEMA a continuar ativo?
        </h1>
      
        <a href="html/sub_links/help.php" class="buton">
          <button class="meu-botao">
            Faça sua doação !
          </button>
        </a>
        <div class="faca-equipe">
          <a href="html/sub_links/join_the_team.php" class="buton">
            <button class="meu-botao">
              &#10084; Nos ajude a melhorar &#10084;
            </button>
          </a>
        </div>

        <h1 class="title-conteudos">
          Conteúdos rápidos
        </h1>
    
      </div>

    <section class="videos"> 
        <button class="pre-btn"><img class="b" src="images/arrow-png.png" alt=""></button>
        <button class="nxt-btn"><img class="b" src="images/arrow-png.png" alt=""></button>
        <div class="videos-container">

          <div class="video-card" data-category="socorros">
            <div class="video-container">
              <iframe 
                width="460" 
                height="315" 
                src="https://www.youtube.com/embed/5MgBikgcWnY?si=bsdtDlR-XPZbMJ-T" 
                title="YouTube video player" 
                frameborder="0" 
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                referrerpolicy="strict-origin-when-cross-origin" 
                allowfullscreen>
              </iframe>
            </div>
            <div class="video-info">
                <h3 class="video-title">Como Fazer Reanimação Cardiopulmonar</h3>
                <p class="video-description">Passo a passo para realizar RCP corretamente em emergências.</p>
            </div>
          </div>

          <div class="video-card" data-category="socorros">
              <div class="video-container">
              <iframe 
                width="460" 
                height="315" 
                src="https://www.youtube-nocookie.com/embed/XIH8v579xDo?si=3IaMhjKn2UsGP-g2" 
                title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                referrerpolicy="strict-origin-when-cross-origin" 
                allowfullscreen>
              </iframe>
              </div>
              <div class="video-info">
                  <h3 class="video-title">Controle de Hemorragia a nível de Primeiros Socorros | O que fazer? (Aula prática)</h3>
                  <p class="video-description">Passo a passo do que fazer em caso de uma hemorragia externa grave exsanguinante.</p>
              </div>
          </div>
          
          <div class="video-card" data-category="socorros">
              <div class="video-container">
              <iframe 
                width="460" 
                height="315" 
                src="https://www.youtube.com/embed/e2JIV58CppM?si=qX4nBEV-bdMqJ8DM" 
                title="YouTube video player" 
                frameborder="0" 
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                referrerpolicy="strict-origin-when-cross-origin" 
                allowfullscreen>
              </iframe>
              </div>
              <div class="video-info">
                  <h3 class="video-title">⚠️ DEFESA PESSOAL - Simples Defesas que todos deveriam saber! 👊 💥 ➡️ 🙅</h3>
                  <p class="video-description">Se alguém atacasse você ou sua família agora, você conseguiria defender?.</p>
              </div>
          </div>
          
          <div class="video-card" data-category="socorros">
              <div class="video-container">
              <iframe 
                width="460" 
                height="315" 
                src="https://www.youtube.com/embed/36P_5YtReAM?si=ZPXFHbrYQefvm_JR" 
                title="YouTube video player" 
                frameborder="0" 
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                referrerpolicy="strict-origin-when-cross-origin" 
                allowfullscreen>
              </iframe>
              </div>
              <div class="video-info">
                  <h3 class="video-title">5 TÉCNICAS QUE TODA MULHER DEVE SABER | MUSA DO JIU JITSU GHI ENSINA A SE DEFENDER!</h3>
                  <p class="video-description">Defesa pessoal feminida contra agressões.</p>
              </div>
          </div>
          
          <div class="video-card" data-category="socorros">
              <div class="video-container">
              <iframe 
                width="460" 
                height="315" 
                src="https://www.youtube.com/embed/ZtkwWQEiznY?si=oXgM7Rf6Q5r1hK2A" 
                title="YouTube video player" 
                frameborder="0" 
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                referrerpolicy="strict-origin-when-cross-origin" 
                allowfullscreen>
              </iframe>
              </div>
              <div class="video-info">
                  <h3 class="video-title">Queimadura grave | Primeiros socorros</h3>
                  <p class="video-description">PNeste vídeo, você vai conhecer os primeiros socorros a serem adotados em caso de uma queimadura grave.</p>
              </div>
          </div>
          
          <div class="video-card" data-category="socorros">
              <div class="video-container">
              <iframe 
                width="460"
                height="315" 
                src="https://www.youtube.com/embed/5kyyABzEy_k?si=9MmKK4uaLEZJN39V" 
                title="YouTube video player" 
                frameborder="0" 
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                referrerpolicy="strict-origin-when-cross-origin" 
                allowfullscreen>
              </iframe>
              </div>
              <div class="video-info">
                  <h3 class="video-title">Adulto engasgado | Primeiros socorros</h3>
                  <p class="video-description">Este vídeo explica o que fazer no caso de um adulto engasgado.</p>
              </div>
          </div>          

        </div>
    </section>

    </div>


    <div class="footer">
           
      <div class="staff-information">
        <p>Ainda não nos conhece?</p>
        <a class="central-link" href="html/sub_links/about_us.php">sobre nós</a>
      </div>

      <div class="social_midias">
        <p class="staff-information">Nossas redes sociais</p>

        <div class="icons">
          
          <a href="https://www.instagram.com/elobos.acolhe?igsh=ZDE5N2F5ODVoY2pj">
            <img id="images" src="images/icons/INSTA.webp" alt="">
          </a>

          <a href="https://x.com/ellobos675443">
            <img id="images" src="images/icons/xTWT.avif" alt="">
          </a>

          <a href="https://www.youtube.com/@ellobos-n8n">
            <img id="images2" src="images/icons/YOUYOU2.png" alt="">      
          </a>

          </div>
        </div>

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    <script src="js/index.js"></script>
    
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