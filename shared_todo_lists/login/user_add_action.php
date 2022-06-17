<?php
try {
    require_once('../class/db/Base.php');
    require_once('../class/db/Users.php');
    require_once('../class/util/Security.php');

    Security::session();
    $post = Security::sanitize($_POST);
    if (!Security::checkToken($_POST['token'])) {
        $_SESSION['err']['msg'] = 'ワンタイムトークンが一致しません';
        header('Location:../error/error.php');
        exit();
    }
    
    // 来ないな…
    echo 'ここまで来ました！';
    exit();

    // DBにユーザを登録する
    $userAdd = new Users;
    $result = $userAdd->dbUserAdd($post);
    if ($result == true ? $_SESSION['success']['msg'] = '登録しました' : '');

    header('Location:./user_add.php');
    exit();
} catch (Exception $e) {
    header('Location:../error/error.php');
    exit();
}
