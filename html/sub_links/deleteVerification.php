<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Deletar conta</title>
  <link rel="stylesheet" href="../../css/deleteVerification.css">
  <link rel="icon" href="../../images/icon-site.png" />
</head>
<body>
<?php
  // Inicie a sessão no início da página
  session_start();  
?>

<div class="main">
  
  <div class="main-content">

    <h2 class="title-delete">Deletar Conta</h2>
      <p>Tem certeza que deseja deletar sua conta?</p>
      <p>Esta ação não pode ser desfeita.</p>
      <div class="delete-container-buttons">
        <a href="../profile.php">
          <button class="back-button">Não, voltar</button>
        </a>

        <form name="form2" method="POST" >
          <button 
          class="confirm-button" 
          type="submit" name="bt_incluir" 
          value="LOGAR" 
          onClick="document.form2.action='../../delete.php'
          ">Sim, prosseguir</button>
        </form>
      </div>
      
    </div>
  </div>
</div>
  
</body>
</html>