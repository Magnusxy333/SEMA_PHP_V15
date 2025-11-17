<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEMA - Contatos</title>
    <link rel="stylesheet" href="../css/contacts1.css">
    <link rel="icon" href="../images/icon-site.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  </head>
  <body>
    <?php
    session_start();
    include '../server.php';

    // Variáveis default
    $profile_photo_url = null; 
    $img_style_header = "style='width: 38px; height: 38px; border-radius: 50%; object-fit: cover; vertical-align: middle;'";

    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
      $username = $_SESSION['username'];
      $sql = mysql_query("SELECT profile_picture_url FROM tb_register WHERE username = '$username'"); 
      
      if ($sql && $linha = mysql_fetch_assoc($sql)) {
        $db_photo_url = $linha['profile_picture_url'];
        
        if (isset($db_photo_url) && !empty($db_photo_url) && strpos($db_photo_url, 'uploads/') !== false) {
          $profile_photo_url = '../' . $db_photo_url; 
        } 
      }
    }
  ?>
           
    <div class="header">
      <div class="left">
        <a href="../index.php">
          <img class="icon" src="../images/sema.png" alt="icon">
        </a>
      </div>

      <div class="right">
        <!-- Botão de alternância de tema -->
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
        <?php else: ?>
          <a class="areas-text" href="login.php">
            <i class='fas fa-sign-in-alt' id="login-size"></i>
          </a>
        <?php endif; ?>
      </div>
    </div>  

    <!---------------------------------->

    <div class="main-ctt">
      <div class="center">
        <div class="content-contacts"> 
          <div class="align-title">
            <h1 class="contact-text">
              CONTATOS DE EMERGÊNCIA 
              <i class="fas fa-phone-alt" style="font-size:32px;"> </i>
            </h1>
          </div>

          <p class="content-text-description">
            Ter a disposição contatos de emergência é de extrema importância 
            para uma resposta rápida e eficaz em uma situação de risco 
          </p>
          
          <!-- Barra de Pesquisa -->
          <div class="search-container">
            <input type="text" class="search-box" id="searchBox" placeholder="Buscar serviço de emergência... (ex: bombeiro, polícia, samu)">
          </div>
          
          <!-- Resultado da Pesquisa -->
          <div class="search-result" id="searchResult">
            <p class="result-service" id="resultService"></p>
            <p class="result-number" id="resultNumber"></p>
            <button id="modern-copy-btn" class="copy-result-btn">Copiar Número</button>
          </div>
          
          <p id="top-margin" class="content-text-description">
            <i>Clique ou pressione em cima do número desejado para copiar!</i>
          </p>

          <!-- CARDS DE EMERGÊNCIA ESTILIZADOS -->
          <div class="numbers-contact">
            <!-- Polícia -->
            <div class="emergency-card police" data-number="190">
              <div class="card-icon">
                <i class="fas fa-shield-alt"></i>
              </div>
              <div class="card-service">Polícia Militar</div>
              <div class="card-number">190</div>
              <button class="card-copy-btn">
                <i class="fas fa-copy"></i> Copiar Número
              </button>
            </div>

            <div class="emergency-card police" data-number="197">
              <div class="card-icon">
                <i class="fas fa-user-shield"></i>
              </div>
              <div class="card-service">Polícia Civil</div>
              <div class="card-number">197</div>
              <button class="card-copy-btn">
                <i class="fas fa-copy"></i> Copiar Número
              </button>
            </div>

            <div class="emergency-card police" data-number="191">
              <div class="card-icon">
                <i class="fas fa-car"></i>
              </div>
              <div class="card-service">Polícia Rodoviária Federal</div>
              <div class="card-number">191</div>
              <button class="card-copy-btn">
                <i class="fas fa-copy"></i> Copiar Número
              </button>
            </div>

            <div class="emergency-card police" data-number="194">
              <div class="card-icon">
                <i class="fas fa-passport"></i>
              </div>
              <div class="card-service">Polícia Federal</div>
              <div class="card-number">194</div>
              <button class="card-copy-btn">
                <i class="fas fa-copy"></i> Copiar Número
              </button>
            </div>

            <!-- Bombeiros -->
            <div class="emergency-card fire" data-number="193">
              <div class="card-icon">
                <i class="fas fa-fire-extinguisher"></i>
              </div>
              <div class="card-service">Corpo de Bombeiros</div>
              <div class="card-number">193</div>
              <button class="card-copy-btn">
                <i class="fas fa-copy"></i> Copiar Número
              </button>
            </div>

            <!-- Saúde -->
            <div class="emergency-card medical" data-number="192">
              <div class="card-icon">
                <i class="fas fa-ambulance"></i>
              </div>
              <div class="card-service">SAMU</div>
              <div class="card-number">192</div>
              <button class="card-copy-btn">
                <i class="fas fa-copy"></i> Copiar Número
              </button>
            </div>

            <div class="emergency-card medical" data-number="136">
              <div class="card-icon">
                <i class="fas fa-bug"></i>
              </div>
              <div class="card-service">Disque Dengue</div>
              <div class="card-number">136</div>
              <button class="card-copy-btn">
                <i class="fas fa-copy"></i> Copiar Número
              </button>
            </div>

            <!-- Defesa Civil -->
            <div class="emergency-card civil" data-number="199">
              <div class="card-icon">
                <i class="fas fa-house-flood"></i>
              </div>
              <div class="card-service">Defesa Civil</div>
              <div class="card-number">199</div>
              <button class="card-copy-btn">
                <i class="fas fa-copy"></i> Copiar Número
              </button>
            </div>

            <div class="emergency-card civil" data-number="153">
              <div class="card-icon">
                <i class="fas fa-user-police"></i>
              </div>
              <div class="card-service">Guarda Municipal</div>
              <div class="card-number">153</div>
              <button class="card-copy-btn">
                <i class="fas fa-copy"></i> Copiar Número
              </button>
            </div>

            <!-- Atendimento à Mulher -->
            <div class="emergency-card hotline" data-number="180">
              <div class="card-icon">
                <i class="fas fa-female"></i>
              </div>
              <div class="card-service">Central de Atendimento à Mulher</div>
              <div class="card-number">180</div>
              <button class="card-copy-btn">
                <i class="fas fa-copy"></i> Copiar Número
              </button>
            </div>

            <!-- Denúncias -->
            <div class="emergency-card hotline" data-number="181">
              <div class="card-icon">
                <i class="fas fa-phone-volume"></i>
              </div>
              <div class="card-service">Disque Denúncia</div>
              <div class="card-number">181</div>
              <button class="card-copy-btn">
                <i class="fas fa-copy"></i> Copiar Número
              </button>
            </div>

            <!-- Apoio Emocional -->
            <div class="emergency-card hotline" data-number="188">
              <div class="card-icon">
                <i class="fas fa-heart"></i>
              </div>
              <div class="card-service">CVV - Centro de Valorização da Vida</div>
              <div class="card-number">188</div>
              <button class="card-copy-btn">
                <i class="fas fa-copy"></i> Copiar Número
              </button>
            </div>

            <!-- Direitos Humanos -->
            <div class="emergency-card hotline" data-number="100">
              <div class="card-icon">
                <i class="fas fa-hands-helping"></i>
              </div>
              <div class="card-service">Disque Direitos Humanos</div>
              <div class="card-number">100</div>
              <button class="card-copy-btn">
                <i class="fas fa-copy"></i> Copiar Número
              </button>
            </div>

            <!-- Utilidades -->
            <div class="emergency-card utility" data-number="151">
              <div class="card-icon">
                <i class="fas fa-shopping-cart"></i>
              </div>
              <div class="card-service">Procon</div>
              <div class="card-number">151</div>
              <button class="card-copy-btn">
                <i class="fas fa-copy"></i> Copiar Número
              </button>
            </div>

            <div class="emergency-card utility" data-number="1332">
              <div class="card-icon">
                <i class="fas fa-satellite-dish"></i>
              </div>
              <div class="card-service">ANATEL</div>
              <div class="card-number">1332</div>
              <button class="card-copy-btn">
                <i class="fas fa-copy"></i> Copiar Número
              </button>
            </div>

            <!-- Emergência Internacional -->
            <div class="emergency-card utility" data-number="112">
              <div class="card-icon">
                <i class="fas fa-globe-americas"></i>
              </div>
              <div class="card-service">Emergência Internacional</div>
              <div class="card-number">112</div>
              <button class="card-copy-btn">
                <i class="fas fa-copy"></i> Copiar Número
              </button>
            </div>

            <!-- Números 0800 -->
            <div class="emergency-card utility" data-number="0800-722-6001">
              <div class="card-icon">
                <i class="fas fa-pills"></i>
              </div>
              <div class="card-service">Disque Intoxicação - ANVISA</div>
              <div class="card-number">0800-722-6001</div>
              <button class="card-copy-btn">
                <i class="fas fa-copy"></i> Copiar Número
              </button>
            </div>

            <div class="emergency-card utility" data-number="0800-728-2891">
              <div class="card-icon">
                <i class="fas fa-road"></i>
              </div>
              <div class="card-service">Emergência em Rodovias</div>
              <div class="card-number">0800-728-2891</div>
              <button class="card-copy-btn">
                <i class="fas fa-copy"></i> Copiar Número
              </button>
            </div>
          </div>

          <p style="margin-top: 30px;" class="content-text-description">
            Além desses contatos é recomendado sempre 
            a utilização de um número correspondente à 
            alguma pessoa de sua confiança para 
            eventuais contatações de urgência.
          </p>
        </div> 
        
        <div class="content-exemples">
          <ul>
            <b class="exemples-titles">Exemplos:</b>
            <div class="exemples">
              <li> Número de algum responsável (se de menor); </li>
              <li> Número de seu(sua) parceiro(a); </li>
              <li> Número de algum amigo próximo; </li>
              <li> Número de algum parente próximo. </li>
            </div>
          </ul>
        </div>
      </div>
    </div>

    <!---------------------------------->

    <div class="footer">
      <div class="staff-information">
        <p>Ainda não nos conhece?</p>
        <a class="central-link" href="sub_links/about_us.php">sobre nós</a>
      </div>

      <div class="social_midias">
        <p class="staff-information">Nossas redes sociais</p>

        <div class="icons">
          <a href="https://www.instagram.com/elobos.acolhe?igsh=ZDE5N2F5ODVoY2pj">
            <img id="images" src="../images/icons/INSTA.webp" alt="Instagram">
          </a>

          <a href="https://x.com/ellobos675443">
            <img id="images" src="../images/icons/xTWT.avif" alt="Twitter">
          </a>

          <a href="https://www.youtube.com/@ellobos-n8n">
            <img id="images2" src="../images/icons/YOUYOU2.png" alt="YouTube">      
          </a>
        </div>
      </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    <script>
      // ===== SISTEMA DE TEMA CLARO/ESCURO =====
      const themeToggle = document.getElementById('themeToggle');
      const body = document.body;
      
      function getThemePreference() {
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
          return savedTheme;
        }
        
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
          return 'dark';
        }
        
        return 'light';
      }
      
      function applyTheme(theme) {
        if (theme === 'dark') {
          body.setAttribute('data-theme', 'dark');
        } else {
          body.removeAttribute('data-theme');
        }
      }
      
      function toggleTheme() {
        const currentTheme = body.getAttribute('data-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        
        applyTheme(newTheme);
        localStorage.setItem('theme', newTheme);
      }
      
      function initTheme() {
        const theme = getThemePreference();
        applyTheme(theme);
        
        themeToggle.addEventListener('click', toggleTheme);
        
        if (window.matchMedia) {
          window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
            if (!localStorage.getItem('theme')) {
              applyTheme(e.matches ? 'dark' : 'light');
            }
          });
        }
      }
      
      // ===== SISTEMA DE BARRA DE PESQUISA =====
      const searchBox = document.getElementById('searchBox');
      const searchResult = document.getElementById('searchResult');
      const resultService = document.getElementById('resultService');
      const resultNumber = document.getElementById('resultNumber');
      const copyResultBtn = document.querySelector('.copy-result-btn');
      
      // Base de dados dos serviços de emergência (ATUALIZADA)
      const emergencyServices = [
        { name: 'Polícia Militar', number: '190', keywords: ['polícia militar', 'policia militar', 'pm', 'polícia', 'policia'] },
        { name: 'Polícia Civil', number: '197', keywords: ['polícia civil', 'policia civil', 'pc', 'civil'] },
        { name: 'Corpo de Bombeiros', number: '193', keywords: ['bombeiros', 'bombeiro', 'incêndio', 'incendio', 'fogo'] },
        { name: 'Defesa Civil', number: '199', keywords: ['defesa civil', 'desastre', 'enchente', 'alagamento'] },
        { name: 'Polícia Rodoviária Federal', number: '191', keywords: ['polícia rodoviária', 'policia rodoviaria', 'estrada', 'rodovia'] },
        { name: 'SAMU', number: '192', keywords: ['samu', 'ambulância', 'ambulancia', 'médico', 'medico', 'saúde', 'saude'] },
        { name: 'Central de Atendimento à Mulher', number: '180', keywords: ['mulher', 'violência', 'violencia', 'gênero', 'genero'] },
        { name: 'Disque Denúncia', number: '181', keywords: ['denúncia', 'denuncia', 'disque denúncia'] },
        { name: 'Centro de Valorização da Vida (CVV)', number: '188', keywords: ['cvv', 'suicídio', 'suicidio', 'depressão', 'depressao'] },
        { name: 'Polícia Federal', number: '194', keywords: ['polícia federal', 'policia federal', 'pf'] },
        { name: 'ANATEL', number: '1332', keywords: ['anatel', 'telecomunicações', 'telecomunicacoes'] },
        { name: 'Disque Intoxicação - ANVISA', number: '0800-722-6001', keywords: ['intoxicação', 'intoxicacao', 'anvisa', 'veneno'] },
        { name: 'Disque Direitos Humanos', number: '100', keywords: ['direitos humanos', 'violação', 'violacao'] },
        { name: 'Procon', number: '151', keywords: ['procon', 'consumidor', 'reclamação', 'reclamacao'] },
        { name: 'Emergência Internacional', number: '112', keywords: ['internacional', 'emergência internacional'] },
        { name: 'Guarda Municipal', number: '153', keywords: ['guarda municipal', 'gm'] },
        { name: 'Delegacia da Mulher', number: '180', keywords: ['delegacia mulher', 'violência doméstica'] },
        { name: 'Disque Meio Ambiente (IBAMA)', number: '0800-061-8080', keywords: ['ibama', 'meio ambiente', 'natureza'] },
        { name: 'Disque Dengue', number: '136', keywords: ['dengue', 'mosquito', 'aedes aegypti'] },
        { name: 'Serviço de Emergência em Rodovias', number: '0800-728-2891', keywords: ['rodovia', 'estrada', 'emergência rodoviária', 'autoestrada'] }
      ];
      
      // Função de busca
      function searchEmergencyService(query) {
        const normalizedQuery = query.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
        
        for (const service of emergencyServices) {
          for (const keyword of service.keywords) {
            if (normalizedQuery.includes(keyword)) {
              return service;
            }
          }
        }
        return null;
      }
      
      // Evento de input na barra de pesquisa
      searchBox.addEventListener('input', function() {
        const query = this.value.trim();
        
        if (query.length > 2) {
          const result = searchEmergencyService(query);
          
          if (result) {
            resultService.textContent = result.name;
            resultNumber.textContent = result.number;
            searchResult.classList.add('active');
            
            // Atualizar o botão de copiar com o número correto
            copyResultBtn.setAttribute('data-number', result.number);
          } else {
            searchResult.classList.remove('active');
          }
        } else {
          searchResult.classList.remove('active');
        }
      });
      
      // ===== SISTEMA DE COPIAR NÚMEROS =====
      async function copyToClipboard(text) {
        try {
          await navigator.clipboard.writeText(text);
          alert(`Número ${text} copiado com sucesso!`);
        } catch (err) {
          console.error("Falha ao copiar: ", err);
          // Fallback para navegadores mais antigos
          const textArea = document.createElement('textarea');
          textArea.value = text;
          document.body.appendChild(textArea);
          textArea.select();
          document.execCommand('copy');
          document.body.removeChild(textArea);
          alert(`Número ${text} copiado com sucesso!`);
        }
      }
      
      // Adicionar eventos de clique para todos os cards e botões de copiar
      document.querySelectorAll('.emergency-card').forEach(card => {
        card.addEventListener('click', function(e) {
          // Não copiar se o clique foi no botão de copiar (para evitar duplicação)
          if (!e.target.closest('.card-copy-btn')) {
            const number = this.getAttribute('data-number');
            copyToClipboard(number);
          }
        });
      });
      
      // Evento para os botões de copiar nos cards
      document.querySelectorAll('.card-copy-btn').forEach(button => {
        button.addEventListener('click', function(e) {
          e.stopPropagation(); // Impedir que o evento propague para o card
          const card = this.closest('.emergency-card');
          const number = card.getAttribute('data-number');
          copyToClipboard(number);
        });
      });
      
      // Evento para o botão de copiar no resultado da pesquisa
      copyResultBtn.addEventListener('click', function() {
        const number = this.getAttribute('data-number');
        if (number) {
          copyToClipboard(number);
        }
      });
      
      // Inicializar quando o DOM estiver carregado
      document.addEventListener('DOMContentLoaded', function() {
        initTheme();
      });
    </script>
  </body>
</html>