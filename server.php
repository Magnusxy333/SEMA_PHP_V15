<?php 
$servidor="127.0.0.1";
$usuario="root";
$senha="usbw";
$banco="sema";
$conecta_db=mysql_connect($servidor, $usuario, $senha) or die (mysql_error());

if (mysql_select_db($banco)) {
  echo "";
} else {
  die("Erro ao conectar");
}

//mysql_select_db($banco) or die("Erro ao conectar");
?>