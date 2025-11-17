<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Área Administrativa - Usuários</title>
  <link rel="icon" href="../images/icon-site.png">
  <link rel="stylesheet" href="styles/mobile-styles/mobile2.css">
  <link rel="stylesheet" href="../css/listagem2.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="fonts/Genova.otf" rel="stylesheet" type="text/css">
  <style>
    .profile-icon {
      width: 48px; 
      height: 48px; 
      border-radius: 50%; 
      object-fit: cover; 
      vertical-align: middle;
      margin-right: 5px;
    }
    .profile-icon-table {
      width: 40px; 
      height: 40px; 
      border-radius: 50%; 
      object-fit: cover; 
    }
    .icon_option {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
    }
  </style>
</head>
<body>
  <?php
  session_start();
  include '../server.php';

  // --- Lógica do Header (Foto de Perfil) ---
  $profile_photo_url = null;

  // Rejeitar acesso se não for ADM
  if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['username'] !== 'soyADM') {
    header('Location: ../index.php');
    exit;
  }

  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    $username = $_SESSION['username'];
    $sql_header = mysql_query("SELECT profile_picture_url FROM tb_register WHERE username = '$username'"); 
    
    if ($sql_header && $linha_header = mysql_fetch_assoc($sql_header)) {
      $db_photo_url = $linha_header['profile_picture_url'];
      
      // CORREÇÃO: Verificar se a foto existe e não está vazia
      if (!empty($db_photo_url) && file_exists('../' . $db_photo_url)) {
        $profile_photo_url = '../' . $db_photo_url; 
      } else {
        // Se não tem foto válida, usa a imagem padrão
        $profile_photo_url = '../images/icons/default_user.png';
      }
    } else {
      // Se não encontrou dados do usuário, usa imagem padrão
      $profile_photo_url = '../images/icons/default_user.png';
    }
  }
  
  // --- Lógica da Listagem e Paginação ---
  date_default_timezone_set('America/Sao_Paulo');

  // 1. DEFINIÇÃO DA PAGINAÇÃO
  $limit = 10;
  $page = isset($_GET['page']) ? intval($_GET['page']) : 1; 
  $page_interval = 2;
  $offset = ($page - 1) * $limit;

  // Sanitiza e obtém o termo de busca
  $termo_busca = isset($_POST['busca_nome']) ? mysql_real_escape_string($_POST['busca_nome']) : '';

  // 2. CONTAGEM TOTAL DE REGISTROS
  $sql_count = "SELECT COUNT(*) AS c FROM tb_register";

  if (!empty($termo_busca)) {
    $sql_count .= " WHERE username LIKE '{$termo_busca}%' OR nome LIKE '{$termo_busca}%'";
  }

  $sql_count_exec = mysql_query($sql_count) or die(mysql_error());
  $row_count = mysql_fetch_assoc($sql_count_exec);
  $registers_total = $row_count['c'];

  // 3. CÁLCULO DO NÚMERO DE PÁGINAS
  $page_numbers = ceil($registers_total / $limit);

  // 4. CONSULTA DOS DADOS
  $sql_query = "SELECT id, username, nome, sobrenome, email, profile_picture_url FROM tb_register";

  if (!empty($termo_busca)) {
    $sql_query .= " WHERE username LIKE '{$termo_busca}%' OR nome LIKE '{$termo_busca}%'";
  }

  $sql_query .= " ORDER BY id ASC LIMIT $limit OFFSET $offset";
  $sql = mysql_query($sql_query);
  ?>
         
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
          <?php if ($profile_photo_url !== null): ?>
            <img 
              src="<?php echo htmlspecialchars($profile_photo_url); ?>" 
              alt="Foto de Perfil" 
              class="profile-icon"
              onerror="this.src='../images/icons/default_user.png'"
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
  
  <div class="main">

    <h1>Área Administrativa: Listagem de Usuários</h1>

    <center style="margin-top: 20px;">
      <form name="form1" method="POST" action="listagemAdm.php">
        <label>Busca por usuário (Username ou Nome):</label>
        <input class="input-search" type="text" name="busca_nome" value="<?php echo htmlspecialchars($termo_busca); ?>">
        <input class="search-button" type="submit" value="FILTRAR">
      </form>
    </center>
    
    <table class="table-listagem" border="1" align="center">
      <tr>
        <th colspan="8">LISTAGEM DE USUÁRIOS CADASTRADOS</th>
      </tr>
      <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Nome</th>
        <th>Sobrenome</th>
        <th>Email</th>
        <th>Foto do Perfil</th>
        <th>EDITAR</th>
        <th>APAGAR</th>
      </tr>
      <?php 
      if ($sql && mysql_num_rows($sql) > 0) {
        while($linha = mysql_fetch_assoc($sql)){
          // CORREÇÃO COMPLETA: Tratamento robusto para fotos de perfil
          $user_profile_picture = isset($linha['profile_picture_url']) ? trim($linha['profile_picture_url']) : '';
          $photo_path = '../images/icons/default_user.png'; // Valor padrão
          
          // Verifica se tem foto definida no banco e se o arquivo existe
          if (!empty($user_profile_picture)) {
            $full_path = '../' . $user_profile_picture;
            if (file_exists($full_path)) {
              $photo_path = $full_path;
            }
          }
      ?>
        <tr>
          <td><center><?php echo $linha['id']; ?></center></td>
          <td><center><?php echo htmlspecialchars($linha['username']); ?></center></td>
          <td><center><?php echo htmlspecialchars($linha['nome']); ?></center></td>
          <td><center><?php echo htmlspecialchars($linha['sobrenome']); ?></center></td>
          <td><center><?php echo htmlspecialchars($linha['email']); ?></center></td>
          <td>
            <center>
              <img 
                class="profile-icon-table" 
                src="<?php echo htmlspecialchars($photo_path); ?>" 
                alt="Foto de Perfil"
                onerror="this.src='../images/icons/icon_button2.png'"
              >
            </center>
          </td>
          <td>
            <center> 
              <a href="sub_links/editUser.php?id=<?php echo $linha['id']; ?>">
                <button class="edit-button" type="submit" title="Editar">
                  <i class='fa-solid fa-pen-to-square'></i>
                </button>
              </a>        
            </center>
          </td>
          <td>
            <center>
              <form action="sub_links/deleteUserConfirm.php" method="GET" style="display: inline;">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($linha['id']); ?>">
                <input type="hidden" name="page" value="<?php echo htmlspecialchars($page); ?>">
                <button class="delete-button" type="submit" title="Excluir Usuário">
                  <i class='fa-solid fa-trash'></i>
                </button> 
              </form>
            </center>
          </td>
        </tr>
      <?php
        }
      } else {
        echo "<tr><td colspan='8'><center>Nenhum usuário encontrado" . (!empty($termo_busca) ? " com o termo '{$termo_busca}'" : "") . ".</center></td></tr>";
      }
      ?>
    </table>

    <center style="margin-top: 20px;">
      <p>
        <?php 
          echo "Página atual: {$page} de {$page_numbers}";
        ?>
      </p>
    </center>

    <center style="margin-top: 20px;">
      <p>
        <a class="link" href="?page=1&busca_nome=<?php echo urlencode($termo_busca); ?>">
          <button class="first-button" style="cursor: pointer;"><<</button>
        </a>
        
        <a class="link" href="?page=<?php echo max(1, $page - 1); ?>&busca_nome=<?php echo urlencode($termo_busca); ?>">
          <button class="left-button" style="cursor: pointer;"><</button>
        </a>
        
        <?php 
        $first_page = max($page - $page_interval, 1);
        $last_page = min($page_numbers, $page + $page_interval);
        
        for ($i = $first_page; $i <= $last_page; $i++) {
          if ($i == $page) {
            echo "<button style=\"cursor: pointer;\" class='current-page'><strong>{$i}</strong></button>";
          } else {
            echo "<a href='?page={$i}&busca_nome=" . urlencode($termo_busca) . "'><button class='page-button' style=\"cursor: pointer;\">{$i}</button></a> ";
          }
        }
        ?>
        
        <a class="link" href="?page=<?php echo min($page_numbers, $page + 1); ?>&busca_nome=<?php echo urlencode($termo_busca); ?>">
          <button class="right-button" style="cursor: pointer;">></button>
        </a>
        
        <a class="link" href="?page=<?php echo $page_numbers; ?>&busca_nome=<?php echo urlencode($termo_busca); ?>">
          <button class="last_button" style="cursor: pointer;">>></button>
        </a>
      </p>
    </center>

    <br>
    <center>
      <a href="../index.php">RETORNAR À PÁGINA INICIAL</a>
    </center>
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