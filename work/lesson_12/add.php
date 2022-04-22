<?php
require_once('./variables.php');
require_once('./class/db/Base.php');
require_once('./class/db/Todoitems.php');

session_start();
session_regenerate_id(true);

try {
    // DBに追加するデータを取得する
    $expiration_date = $_POST['expiration_date'];
    $todo_item = $_POST['todo_item'];

    // DBへの接続
    $db = new TodoItems;
    $db->dbAdd();
    // ここはconstructで済ませている
    // $dsn = 'mysql:dbname=php_work;host=localhost;port=3306;charset=utf8';
    // $user = 'root';
    // $password = '0971790';
    // $dbh = new PDO($dsn, $user, $password);
    // $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    ////////////////////////////////

    // Todoitems.phpのメソッドにした
    // $sql = 'INSERT INTO todo_items (expiration_date,todo_item) VALUES (:expiration_date,:todo_item)';
    // $stmt = $dbh->prepare($sql);
    // $stmt->bindValue(':expiration_date', $_POST['expiration_date'], PDO::PARAM_STR);
    // $stmt->bindValue(':todo_item', $_POST['todo_item'], PDO::PARAM_STR);
    // $stmt->execute();
    // $dbh = null;
    ///////////////////////////////

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
