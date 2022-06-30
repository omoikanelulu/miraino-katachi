<?php
require_once('../class/util/Security.php');
Security::session();

unset($_SESSION['user'], $_SESSION['err'], $_SESSION['success'], $_SESSION['post'], $_SESSION['data']);
header('Location:./index.php');
exit();

// 絶対パスでトップ画面にリダイレクトさせたい時
// header("Location: http://" . $_SERVER["HTTP_HOST"] ."/shared_todo_lists/login/index.php");