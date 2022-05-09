<?php
require_once('./variables.php');
require_once('./class/db/Base.php');
require_once('./class/db/TodoItems.php');
require_once('./class/util/Security.php');

session_start();
session_regenerate_id(true);

// ログインしていない場合は、login.phpへ飛ばす
if (empty($_SESSION['user'])) {
    header('Location:./login.php');
    exit();
}

$this->checkToken();

try {
    // DBに追加するデータを取得する
    $expiration_date = $_POST['expiration_date'];
    $todo_item = $_POST['todo_item'];

    // DBへの接続
    $db = new TodoItems;
    $db->dbAdd();

    // 処理が完了したらトップページ（index.php）へリダイレクト
    header('Location: ./index.php');
    exit;
} catch (Exception $e) {
    var_dump($e->getMessage());
    echo '<br><br>';
    echo '障害発生につきご迷惑をおかけしております<br>';
    echo '<a href="./index.php">戻る</a>';
    exit();
}
