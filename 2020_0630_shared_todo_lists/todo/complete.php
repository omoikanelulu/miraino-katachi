<?php
try {
    require_once('../class/db/Base.php');
    require_once('../class/db/Users.php');
    require_once('../class/db/TodoItems.php');
    require_once('../class/util/Security.php');
    Security::session();
    Security::notLogin();

    $post = Security::sanitize($_POST);

    unset($_SESSION['err']['msg'], $_SESSION['success']['msg']);

    $todoIns = new TodoItems;
    $todoItem = $todoIns->dbIsComp($post);

    // $_SESSION['success']['msg'] = 'こんぐらっちゅれーしょん！';
    header('Location:./index.php');
    exit();
} catch (Exception $e) {
    header('Location:../error/error.php');
    exit();
}
