<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEMA - Localização</title>
    <link rel="stylesheet" href="../css/location3.css">
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
          <span>HOME</span>                     
        </a>

        <a class="areas-text" href="location.php">
          <i class="fas fa-map-marker-alt"></i>
          <span>LOCALIZAÇÃO</span>
        </a>

        <a class="areas-text" href="orientations.php">
          <i class="fas fa-book-open"></i>
          <span>ORIENTAÇÕES</span>
        </a>

        <a class="areas-text" href="contacts.php">
          <i class="fas fa-phone-alt"></i>
          <span>CONTATOS</span>
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
            <span>PERFIL</span>
          </a> 
        <?php else: ?>
          <a class="areas-text" href="login.php">
            <i class='fas fa-sign-in-alt' id="login-size"></i>
          </a>
        <?php endif; ?>
      </div>
    </div>  
  
    <!---------------------------------->

    <div class="main">
      <div class="center">
        <div class="container">
          <header>
            <h1><i class="fas fa-map-marked-alt"></i> Localização e Navegação</h1>
            <p class="subtitle">Encontre sua localização atual e busque endereços com facilidade</p>
          </header>
            
          <div class="content">
            <!-- Seção de Localização Atual -->
            <div class="section">
              <h2><i class="fas fa-location-crosshairs"></i> Sua Localização Atual</h2>
              <p>Clique no botão abaixo para obter suas coordenadas geográficas atuais. Esta funcionalidade é essencial para situações de emergência.</p>
              
              <div class="location-controls">
                <button id="getLocation" class="btn">
                  <i class="fas fa-map-marker-alt"></i> Obter Minha Localização
                </button>
                
                <div id="locationStatus" class="status">
                  <i class="fas fa-info-circle"></i> Clique no botão para obter sua localização
                </div>
              </div>
              
              <div id="locationData" class="location-data" style="display: none;">
                <div class="data-grid">
                  <div class="data-item">
                    <div class="data-label">Latitude:</div>
                    <div id="latitude" class="data-value">-</div>
                  </div>
                  <div class="data-item">
                    <div class="data-label">Longitude:</div>
                    <div id="longitude" class="data-value">-</div>
                  </div>
                  <div class="data-item">
                    <div class="data-label">Precisão:</div>
                    <div id="accuracy" class="data-value">-</div>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Seção do Mapa -->
            <div class="section">
              <h2><i class="fas fa-map"></i> Visualização do Mapa</h2>
              <p>Visualize sua localização no mapa. Em situações de emergência, compartilhar estas coordenadas pode ser crucial.</p>
              <div id="map" class="map-container">
                <div class="map-placeholder">
                  <i class="fas fa-map-location-dot"></i>
                  <p>O mapa será exibido aqui após obter a localização</p>
                </div>
              </div>
            </div>
            
            <!-- Seção de Busca de Endereço -->
            <div class="section">
              <h2><i class="fas fa-search-location"></i> Buscar Endereço</h2>
              <p>Encontre a localização de qualquer endereço. Digite o endereço completo para obter as coordenadas.</p>
              
              <div class="search-container">
                <div class="search-box">
                  <input type="text" id="addressInput" placeholder="Digite um endereço completo (ex: Avenida Paulista, 1000 - São Paulo, SP)">
                  <button id="searchAddress" class="btn search-btn">
                    <i class="fas fa-search"></i> Buscar
                  </button>
                </div>
                
                <div id="addressData" class="location-data" style="display: none;">
                  <div class="data-grid">
                    <div class="data-item">
                      <div class="data-label">Endereço:</div>
                      <div id="formattedAddress" class="data-value">-</div>
                    </div>
                    <div class="data-item">
                      <div class="data-label">Coordenadas:</div>
                      <div id="searchedCoords" class="data-value">-</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
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
    <script src="scripts/script.js"></script>
    <script src="../js/location.js"></script>
    
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
          body.setAttribute('data-theme', 'light');
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
      
      // ===== SISTEMA DE LOCALIZAÇÃO =====
      const getLocationBtn = document.getElementById('getLocation');
      const locationStatus = document.getElementById('locationStatus');
      const locationData = document.getElementById('locationData');
      const latitudeElem = document.getElementById('latitude');
      const longitudeElem = document.getElementById('longitude');
      const accuracyElem = document.getElementById('accuracy');
      const mapContainer = document.getElementById('map');
      
      // Elementos de busca de endereço
      const addressInput = document.getElementById('addressInput');
      const searchAddressBtn = document.getElementById('searchAddress');
      const addressData = document.getElementById('addressData');
      const formattedAddressElem = document.getElementById('formattedAddress');
      const searchedCoordsElem = document.getElementById('searchedCoords');
      
      // Obter localização atual
      getLocationBtn.addEventListener('click', function() {
        locationStatus.textContent = 'Obtendo localização...';
        locationStatus.className = 'status';
        
        if (!navigator.geolocation) {
          locationStatus.textContent = 'Geolocalização não é suportada pelo seu navegador';
          locationStatus.className = 'status error';
          return;
        }
        
        navigator.geolocation.getCurrentPosition(
          function(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            const accuracy = position.coords.accuracy;
            
            // Atualizar elementos da interface
            latitudeElem.textContent = lat.toFixed(6);
            longitudeElem.textContent = lng.toFixed(6);
            accuracyElem.textContent = `${Math.round(accuracy)} metros`;
            
            locationData.style.display = 'block';
            locationStatus.textContent = 'Localização obtida com sucesso!';
            locationStatus.className = 'status success';
            
            // Atualizar mapa
            updateMap(lat, lng);
          },
          function(error) {
            let errorMessage = 'Erro ao obter localização: ';
            
            switch(error.code) {
              case error.PERMISSION_DENIED:
                errorMessage += 'Permissão negada pelo usuário.';
                break;
              case error.POSITION_UNAVAILABLE:
                errorMessage += 'Localização indisponível.';
                break;
              case error.TIMEOUT:
                errorMessage += 'Tempo de espera excedido.';
                break;
              default:
                errorMessage += 'Erro desconhecido.';
                break;
            }
            
            locationStatus.textContent = errorMessage;
            locationStatus.className = 'status error';
          },
          {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 60000
          }
        );
      });
      
      // Buscar endereço
      searchAddressBtn.addEventListener('click', function() {
        const address = addressInput.value.trim();
        
        if (!address) {
          alert('Por favor, digite um endereço para buscar.');
          return;
        }
        
        // Simulação de busca de endereço
        addressData.style.display = 'block';
        formattedAddressElem.textContent = address;
        searchedCoordsElem.textContent = '-23.550520, -46.633308';
        
        // Atualizar mapa com coordenadas simuladas
        updateMap(-23.550520, -46.633308);
      });
      
      // Função para atualizar o mapa
      function updateMap(lat, lng) {
        mapContainer.innerHTML = `
          <div class="map-active">
            <i class="fas fa-map-marked-alt"></i>
            <h3>Localização no Mapa</h3>
            <div class="map-coordinates">
              <p><strong>Latitude:</strong> ${lat.toFixed(6)}</p>
              <p><strong>Longitude:</strong> ${lng.toFixed(6)}</p>
            </div>
            <p class="map-note">Em uma implementação real, um mapa interativo seria exibido aqui</p>
          </div>
        `;
      }
      
      // Permitir busca com Enter
      addressInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
          searchAddressBtn.click();
        }
      });
      
      // Inicializar quando o DOM estiver carregado
      document.addEventListener('DOMContentLoaded', function() {
        initTheme();
      });
    </script>
  </body>
</html>