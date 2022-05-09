<?php
session_start();
session_regenerate_id(true);
require_once('./variables.php');
require_once('./class/db/Base.php');
require_once('./class/db/Users.php');

try {
    $db = new Users;

    // userの存在チェック
    $rec = $db->dbFindUser($_POST['userId']);
} catch (Exception $e) {
    $_SESSION['err']['msg'] = '初心者「何もしてないけどおかしくなった」';
    header('Location: ./login.php');
    exit();
}
