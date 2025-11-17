<?php
include 'server.php';

$username = $_POST["txt_username"];

$nome = $_POST["txt_nome"];
$sobrenome = $_POST["txt_sobrenome"];

$email = $_POST["txt_email"];

$password = $_POST["txt_password"];
$confirmPassword = $_POST["txt_confirmPassword"];




$sql = mysql_query("SELECT * FROM tb_register
	WHERE username = '$username' or email = '$email' ");
if ($password !== $confirmPassword) {
	header('location:html/fail_pages/registerFail.php');
} elseif (mysql_num_rows($sql) > 0) {
	header('location:html/fail_pages/twoAccounts.php');
} elseif (empty($username) || empty($email) || empty($nome) || empty($sobrenome) || empty($password) || empty($confirmPassword)) {
	header('location:html/fail_pages/accessDenied.php');
} else {
	$sql = mysql_query("INSERT INTO tb_register (username, nome, sobrenome, email, senha) 
	VALUES ('$username', '$nome', '$sobrenome', '$email', '$password')");

	header('location:html/login.php');

	/*
  echo "<center>";
	echo "<hr>";
	echo "conta criada com sucesso";
	echo "<hr>";
	echo "<br>"; 
  */
}

//echo "<a href=\"listagem.php\"> LISTA DE CONTAS <\a>";
//header('location:listagem.php'); ABRIR DIRETAMENTE SEM O LINK (NÃO PRECISA CLICAR PARA FUNFAR)
