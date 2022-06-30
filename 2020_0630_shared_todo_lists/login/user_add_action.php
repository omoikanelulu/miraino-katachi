<?php
try {
    require_once('../class/db/Base.php');
    require_once('../class/db/Users.php');
    require_once('../class/util/Security.php');

    Security::session();

    unset($_SESSION['err'], $_SESSION['success']);

    // var_dump($_SESSION['data']);
    // echo '<br>ここまで来ました';
    // exit();

    // DBにユーザを登録する
    $userAdd = new Users;
    // $userAdd->dbUserAdd($_SESSION['data']); // いらんやろ
    $result = $userAdd->dbUserAdd($_SESSION['data']);
    if ($result == true ? $_SESSION['success']['msg'] = "{$_SESSION['data']['family_name']}{$_SESSION['data']['first_name']}さんを<br>登録しました" : '');
    header('Location:./index.php');
    exit();
} catch (Exception $e) {
    $_SESSION['err']['msg'] = 'DBへの登録が出来ませんでした';
    $_SESSION['err']['e'] = $e;

    header('Location:../error/error.php');
    exit();
}
