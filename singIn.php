<?php
session_start();
include 'server.php';


$username = $_POST["txt_username"];
$password = $_POST["txt_password"];

$sql = mysql_query("SELECT id, username, profile_picture_url FROM tb_register WHERE username = '$username' and senha = '$password' ");

if ($sql && mysql_num_rows($sql) > 0) {
    $row = mysql_fetch_assoc($sql);
    
    // ✅ VERIFIQUE SE ESTÁ SALVANDO O user_id CORRETAMENTE
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $username;
    $_SESSION['user_id'] = $row['id']; // ✅ LINHA CRÍTICA - DEVE ESTAR PRESENTE
    
    $photo_db_path = '';
    if (isset($row['profile_picture_url'])) {
        $photo_db_path = $row['profile_picture_url'];
    }

    if (!empty($photo_db_path)) {
        $_SESSION['profile_picture_url'] = $photo_db_path;
    } else {
        $_SESSION['profile_picture_url'] = 'images/default-profile.png';
    }

    header('Location: index.php');
    exit;
} else {
    header('location:html/fail_pages/accessDenied.php');
}
?>