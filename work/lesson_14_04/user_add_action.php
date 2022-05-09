<?php
session_start();
session_regenerate_id(true);
require_once('./variables.php');
require_once('./class/db/Base.php');
require_once('./class/db/Users.php');
require_once('./class/util/Security.php');

if (!Security::checkToken($_SESSION['token'], $_POST['token'])) {
    $_SESSION['err']['msg'] = '不正な操作が行われました';
    header('Location:./user_add.php');
    exit();
}

$post = Security::sanitize($_POST);

// デバッグ用 //
// var_dump($post);
// exit();
////////////////

try {
    $db = new Users;

    // 重複チェック
    $rec = $db->dbDupMail($_POST['email']);

    // 重複していなければ
    if ($rec == false) {
        // 登録
        if ($db->dbAdd()) {
            unset($_SESSION['err']['msg'], $_SESSION['success']['msg']);
            $_SESSION['success']['msg'] = '登録完了しました';
            header('Location: ./user_add.php');
            exit();
        } else {
            $_SESSION['err']['msg'] = '登録できませんでした';
            header('Location: ./user_add.php');
            exit();
        }
    } else {
        $_SESSION['err']['msg'] = "{$_POST['email']}は既に存在します";
        header('Location: ./user_add.php');
        exit();
    }
} catch (Exception $e) {
    $_SESSION['err']['msg'] = '初心者「何もしてないけどおかしくなった」';
    header('Location: ./user_add.php');
    exit();
}
