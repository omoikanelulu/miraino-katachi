<?php
try {
    require_once('../class/db/Base.php');
    require_once('../class/db/Users.php');
    require_once('../class/util/Security.php');

    Security::session();

    unset($_SESSION['err'], $_SESSION['success']);

    // DBの情報を編集する
    $userEdit = new Users;
    $result = $userEdit->userUpdate($_SESSION['data']);
    if ($result == true ? $_SESSION['success']['msg'] = "修正しました" : '');
    header('Location:./index.php');
    exit();
} catch (Exception $e) {
    $_SESSION['err']['msg'] = '修正出来ませんでした';
    $_SESSION['err']['e'] = $e;

    header('Location:../error/error.php');
    exit();
}
