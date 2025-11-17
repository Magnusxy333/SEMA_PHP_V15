<?php
  // Verifique se o usuário está logado
  if (!isset($_SESSION['user_id'])) {
    // Redirecione para a página de login se não estiver logado
    header("Location: ../login.php");
    exit();
  }

  // Inclua o arquivo de conexão com o banco de dados
  require_once '../../config/db.php';

  // Obtenha o ID do usuário da sessão
  $userId = $_SESSION['user_id'];

  // Verifique se o formulário foi enviado
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Prepare a consulta SQL para deletar o usuário
      $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
      $stmt->bindParam(':id', $userId, PDO::PARAM_INT);

      // Execute a consulta
      if ($stmt->execute()) {
          // Destrua a sessão e redirecione para a página inicial após a exclusão
          session_destroy();
          header("Location: ../../index.php");
          exit();
      } else {
          echo "Erro ao deletar a conta. Por favor, tente novamente.";
      }
  }
?>



<div style="display: flex; flex-direction: column; align-items: center">
  <a class="areas-text" href="profile.php">
    <i class="fas fa-user-circle"></i>
    PERFIL
  </a>

  
  <div class="dropdown">
    <button class="button">
      <i class="fa-solid fa-bars"></i>
      MENU
    </button>
    <div class="content">
      <a href="">IDIOMAS</a>
      <a href="">TEMAS</a>
      <a class="bottom-menu" href="">MODOS</a>
    </div>
  </div>
</div>

<style>
.dropdown{
  display: inline-block;
}
.dropdown button{
  font-size: 25px;
  text-decoration: none;
  color: rgb(157, 178, 191);
  font-family: "Genova";
  background: none;
  border: none;
  cursor: pointer;
  border: 2px solid rgb(157, 178, 191);
  border-top-left-radius: 10px;
  border-top-right-radius: 10px;
  
  margin-left: 8px;
  margin-top: 5px;


  
}
.dropdown a{
  display: block;
  color: black;
  text-decoration: none;
  padding: 10px 15px;
}
.dropdown .content{
  display: none;
  position: absolute;
  background-color:  rgb(157, 178, 191);
  min-width: 90px;
  border-bottom-left-radius: 10px;
  border-bottom-right-radius: 10px;
  font-family: "Genova";

  margin-left: 8px;

  padding-left: 7px;
  padding-right: 10px;

  padding-top: 7px;
  padding-bottom: 7px;


}
.dropdown:hover .content{
  display: block;
  text-align: center;
}
.dropdown:hover button{
  opacity: 70%;
}
.dropdown a:hover{
  background-color: rgb(200, 210, 216);
}
.bottom-menu{
  border-bottom-left-radius: 10px;
  border-bottom-right-radius: 10px;

  text-align: center;
}
</style>

<form name="form2" method="POST">
    <div style="display: flex; flex-direction: row; align-items: center;">
        <div>
            <div class="info-item">
                <span class="info-label">Usuário:</span>
                <input class="info-input" type="text" value="<?php echo htmlspecialchars($linha['username']); ?>" name="username">
            </div>
            
            <div class="info-item">
                <span class="info-label">Email:</span>
                <input class="info-input" type="text" value="<?php echo htmlspecialchars($linha['email']); ?>" name="email">
            </div>
            
            <div class="info-item">
                <span class="info-label">Nome:</span>
                <input class="info-input" type="text" value="<?php echo htmlspecialchars($linha['nome']); ?>" name="nome">
            </div>
            
            <div class="info-item">
                <span class="info-label">Sobrenome:</span>
                <input class="info-input" type="text" value="<?php echo htmlspecialchars($linha['sobrenome']); ?>" name="sobrenome">
            </div>
            
        </div>
        </div>
    
    <div class="password-button">
        <div class="info-item">   
            <div>
                <span class="info-label">Senha:</span>             
                <input class="info-input" type="password" id="senha-input" value="" name="senha" placeholder="Deixe em branco para não alterar">
            </div>
        </div>
        </div>

    <button class="logout-button"
    type="submit" name="bt_incluir" 
    value="UPDATE" 
    onClick="document.form2.action='../../update.php'">
        Alterar informações
    </button>
</form>


<?php
session_start();
include '../../server.php'; // Este arquivo agora deve retornar o objeto de conexão $conn (MySQLi)

// ... Verificação de login ...

$username = $_SESSION['username'];

// Preparar a consulta (usando prepared statements, se $conn for o objeto mysqli)
// Nota: Se o seu server.php usar a função mysql_connect, você terá que reescrever TUDO.
// Vou assumir que $conn é um objeto mysqli válido.
$stmt = $conn->prepare("SELECT username, email, nome, sobrenome, senha FROM tb_register WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$sql = $stmt->get_result();

// Verificar se a query foi bem-sucedida
if ($sql === false) {
    die('Erro na consulta SQL: ' . $conn->error);
}

// Obter os dados do usuário
$linha = $sql->fetch_assoc();

// ... Verificação se encontrou o usuário ...
?>

<div class="card1">

<p class="text-form">
  O que  você acha dos 
  serviços municípais?
</p>

<p class="text-form">
  responda esse formulário que aborda questões como:
</p>

<ul class="text-list">
  <li>Identificação de perigos iminentes.</li>
  <li>Primeiros socorros básicos.</li>
  <li>Rotas de fuga e pontos de encontro.</li>
  <li>Contato com serviços de emergência (SAMU, Bombeiros, Polícia).</li>
</ul>

<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
  <!-- Usuário logado - mostrar formulário normal -->
  <a href="html/avaliantionForm.php">
    <button class="botao-formulario">
      responda aqui!
    </button>
  </a>
<?php else: ?>
  <!-- Usuário não logado - mostrar formulário bloqueado -->
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

<div class="card2">

<p class="text-form">
  Como você se sairia em uma situação de risco?
</p>

<p class="text-form">
  responda esse formulário que aborda questões como:
</p>

<ul class="text-list">
  <li>Identificação de perigos iminentes.</li>
  <li>Primeiros socorros básicos.</li>
  <li>Rotas de fuga e pontos de encontro.</li>
  <li>Contato com serviços de emergência (SAMU, Bombeiros, Polícia).</li>
</ul>

<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
  <!-- Usuário logado - mostrar formulário normal -->
  <a href="html/avaliantionForm.php">
    <button class="botao-formulario">
      Realize o teste
    </button>
  </a>
<?php else: ?>
  <!-- Usuário não logado - mostrar formulário bloqueado -->
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

