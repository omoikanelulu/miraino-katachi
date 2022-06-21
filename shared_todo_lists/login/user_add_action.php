<?php
try {
    require_once('../class/db/Base.php');
    require_once('../class/db/Users.php');
    require_once('../class/util/Security.php');

    unset($_SESSION['err'], $_SESSION['success']);

    Security::session();

    var_dump($_SESSION['data']);
    // echo '<br>ここまで来ました';
    exit();

    // DBにユーザを登録する
    $userAdd = new Users;
    // $userAdd->dbUserAdd($_SESSION['data']);
    $result = $userAdd->dbUserAdd($_SESSION['data']);
    if ($result == true ? $_SESSION['success']['msg'] = '登録を完了しました' : '');
    header('Location:./user_add.php');
    exit();
} catch (Exception $e) {
    $_SESSION['err']['msg'] = 'DBへの登録が出来ませんでした';
    $_SESSION['err']['e'] = $e;

    header('Location:../error/error.php');
    exit();
}
