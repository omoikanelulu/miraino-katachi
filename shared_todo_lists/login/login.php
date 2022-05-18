<?php
require_once('../class/db/Base.php');
require_once('../class/db/Users.php');
require_once('../class/util/Security.php');
Security::session();

if (!Security::checkToken($_POST['token'])) {
    $_SESSION['err']['msg'] = 'ワンタイムトークンが一致しません';
    header('Location:./index.php');
    exit();
}

$post = Security::sanitize($_POST);

$ins = new Users;
$ins->dbFindUser($post);
