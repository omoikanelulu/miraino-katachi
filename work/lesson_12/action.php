<?php
require_once('./variables.php');
require_once('./class/db/Base.php');
require_once('./class/db/TodoItems.php');

session_start();
session_regenerate_id(true);

if (isset($_SESSION['error'])) {
    unset($_SESSION['error']);
}

try {
    // DBへの接続
    $db = new TodoItems;
    
    // 削除チェックが入っていた場合
    if (isset($_POST['delete']) && $_POST['delete'] == '1') {
        $db->dbDelete();
    } else {
        // 削除チェックがない場合はis_completedをUPDATEする
        $db->dbUpdate();
    }
    header('Location: ./index.php');
    // throw new Exception('動いていません');
    // exit();
} catch (Exception $e) {
    var_dump($e);
    echo '<br><br>';
    echo '障害発生につきご迷惑をおかけしております<br>';
    echo '<br><br>';
    echo '<a href="./index.php">index.phpへ</a>';
    exit();
}
