<?php
try {
    require_once('../class/db/Base.php');
    require_once('../class/db/Users.php');
    require_once('../class/db/TodoItems.php');
    require_once('../class/util/Security.php');
    Security::session();
    Security::notLogin();

    unset($_SESSION['err']['msg'], $_SESSION['success']['msg']);

    $todoIns = new TodoItems;
    $todoIns->dbDelete(1, $_POST['id']);

    $_SESSION['success']['msg'] = '削除しました';
    header('Location:./index.php');
    exit();
} catch (Exception $e) {
    header('Location:../error/error.php');
    exit();
}
