<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../../css/register3.css" />
    <link rel="icon" href="../../images/icon-site.png" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
    <title>SEMA - Cadastro</title>
  </head>
  <body>
    <?php
    // Inicie a sessão no início da página
    session_start();
    ?>

    <!-- Header Padronizado -->
    <div class="header">
      <div class="left">
        <a href="../../index.php">
          <img class="icon" src="../../images/sema.png" alt="icon" />
        </a>
      </div>

      <div class="right">
        <!-- Botão de alternância de tema -->
        <button class="theme-toggle" id="themeToggle" aria-label="Alternar tema">
          <i class="fas fa-sun"></i>
          <i class="fas fa-moon"></i>
        </button>

        <a class="areas-text" href="../../index.php">
          <i class="fas fa-house-user"></i>
          HOME
        </a>

        <a class="areas-text" href="../location.php">
          <i class="fas fa-map-marker-alt"> </i>
          LOCALIZAÇÃO
        </a>

        <a class="areas-text" href="../orientations.php">
          <i class="fas fa-book-open"> </i>
          ORIENTAÇÕES
        </a>

        <a class="areas-text" href="../contacts.php">
          <i class="fas fa-phone-alt"></i>
          CONTATOS
        </a>

        <a class="areas-text" href="../login.php">
          <i class="fas fa-sign-in-alt" id="login-size"></i>
        </a>
      </div>
    </div>

    <!-- Conteúdo Principal -->
    <div class="main">
      <form name="form1" method="post" class="register-form">
        <div class="register-container">
          <div class="register-header">
            <h1 class="register-main-title">
              <i class="fas fa-user-plus"></i>
              CADASTRO
            </h1>
            <p class="register-subtitle">Crie sua conta para acessar o SEMA</p>
          </div>

          <div class="form-content">
            <div class="form-group">
              <label for="username" class="form-label">
                <i class="fas fa-user"></i>
                Usuário
              </label>
              <input
                type="text"
                id="username"
                class="form-input"
                placeholder="Digite seu username"
                name="txt_username"
                required
              />
            </div>

            <div class="form-row">
              <div class="form-group">
                <label for="nome" class="form-label">
                  <i class="fas fa-signature"></i>
                  Nome
                </label>
                <input
                  type="text"
                  id="nome"
                  class="form-input"
                  placeholder="Digite o seu nome"
                  name="txt_nome"
                  required
                />
              </div>

              <div class="form-group">
                <label for="sobrenome" class="form-label">
                  <i class="fas fa-signature"></i>
                  Sobrenome
                </label>
                <input
                  type="text"
                  id="sobrenome"
                  class="form-input"
                  placeholder="Digite o seu sobrenome"
                  name="txt_sobrenome"
                  required
                />
              </div>
            </div>

            <div class="form-group">
              <label for="email" class="form-label">
                <i class="fas fa-envelope"></i>
                Email
              </label>
              <input
                type="email"
                id="email"
                class="form-input"
                placeholder="Digite o seu Email"
                name="txt_email"
                required
              />
            </div>

            <div class="form-row">
              <div class="form-group">
                <label for="password" class="form-label">
                  <i class="fas fa-lock"></i>
                  Senha
                </label>
                <div class="password-container">
                  <input
                    type="password"
                    id="password"
                    class="form-input"
                    placeholder="Digite a sua senha"
                    name="txt_password"
                    required
                  />
                  <button type="button" class="password-toggle" id="passwordToggle" aria-label="Mostrar senha">
                    <i class="fas fa-eye"></i>
                    <i class="fas fa-eye-slash"></i>
                  </button>
                </div>
              </div>

              <div class="form-group">
                <label for="confirmPassword" class="form-label">
                  <i class="fas fa-lock"></i>
                  Confirmar Senha
                </label>
                <div class="password-container">
                  <input
                    type="password"
                    id="confirmPassword"
                    class="form-input"
                    placeholder="Sua senha novamente"
                    name="txt_confirmPassword"
                    required
                  />
                  <button type="button" class="password-toggle" id="confirmPasswordToggle" aria-label="Mostrar senha">
                    <i class="fas fa-eye"></i>
                    <i class="fas fa-eye-slash"></i>
                  </button>
                </div>
              </div>
            </div>

            <div class="form-actions">
              <button type="button" class="btn-clean" onclick="clean();">
                <i class="fas fa-broom"></i>
                LIMPAR
              </button>

              <button type="submit" class="btn-submit" name="bt_incluir" value="CADASTRAR" onclick="document.form1.action='../../registration.php'">
                <i class="fas fa-paper-plane"></i>
                ENVIAR
              </button>
            </div>
          </div>

          <div class="login-redirect">
            <p>Já possui uma conta?</p>
            <a href="../login.php" class="login-link">
              <i class="fas fa-sign-in-alt"></i>
              Fazer login
            </a>
          </div>
        </div>
      </form>
    </div>

    <!-- Footer Padronizado -->
    <div class="footer">
      <div class="staff-information">
        <p>Ainda não nos conhece?</p>
        <a class="central-link" href="../sub_links/about_us.php">sobre nós</a>
      </div>

      <div class="social_midias">
        <p class="staff-information">Nossas redes sociais</p>

        <div class="icons">
          <a href="https://www.instagram.com/elobos.acolhe?igsh=ZDE5N2F5ODVoY2pj">
            <img id="images" src="../../images/icons/INSTA.webp" alt="Instagram">
          </a>

          <a href="https://x.com/ellobos675443">
            <img id="images" src="../../images/icons/xTWT.avif" alt="Twitter">
          </a>

          <a href="https://www.youtube.com/@ellobos-n8n">
            <img id="images2" src="../../images/icons/YOUYOU2.png" alt="YouTube">      
          </a>
        </div>
      </div>
    </div>

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

      // ===== SISTEMA DE MOSTRAR/OCULTAR SENHA =====
      function setupPasswordToggle(passwordInputId, toggleButtonId) {
        const passwordToggle = document.getElementById(toggleButtonId);
        const passwordInput = document.getElementById(passwordInputId);
        const eyeIcon = passwordToggle.querySelector('.fa-eye');
        const eyeSlashIcon = passwordToggle.querySelector('.fa-eye-slash');
        
        passwordToggle.addEventListener('click', function() {
          const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
          passwordInput.setAttribute('type', type);
          
          if (type === 'text') {
            eyeIcon.style.display = 'none';
            eyeSlashIcon.style.display = 'inline-block';
            passwordToggle.setAttribute('aria-label', 'Ocultar senha');
          } else {
            eyeIcon.style.display = 'inline-block';
            eyeSlashIcon.style.display = 'none';
            passwordToggle.setAttribute('aria-label', 'Mostrar senha');
          }
        });
        
        // Configurar ícones de senha inicialmente
        eyeIcon.style.display = 'inline-block';
        eyeSlashIcon.style.display = 'none';
      }
      
      // ===== FUNÇÃO LIMPAR FORMULÁRIO =====
      function clean() {
        document.querySelector('.register-form').reset();
      }
      
      // Inicializar quando o DOM estiver carregado
      document.addEventListener('DOMContentLoaded', function() {
        initTheme();
        setupPasswordToggle('password', 'passwordToggle');
        setupPasswordToggle('confirmPassword', 'confirmPasswordToggle');
      });
    </script>
  </body>
</html>