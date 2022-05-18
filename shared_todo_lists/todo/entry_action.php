<?php
require_once('../class/db/Base.php');
require_once('../class/db/Users.php');
require_once('../class/db/TodoItems.php');
require_once('../class/util/Security.php');
Security::session();

$post = Security::sanitize($_POST);

if (empty($post['user_id'])) {
    $_SESSION['err']['msg'] = '担当者を選択してください';
    header('Location:./entry.php');
    exit();
}

$add = new TodoItems;
$add->dbAdd($post);

unset($_SESSION['err']['msg']);
header('Location:./index.php');
exit();
