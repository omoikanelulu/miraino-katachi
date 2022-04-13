<?php
session_start();
session_regenerate_id(true);

try {
    // DBに追加するデータを取得する
    $expiration_date = $_POST['expiration_date'];
    $todo_item = $_POST['todo_item'];

    // DBへの接続
    $dsn = 'mysql:dbname=php_work;host=localhost;port=3306;charset=utf8';
    $user = 'root';
    $password = '0971790';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQLでDBエンジンに指示
    // POSTデータをデータベースにインサートする
    $sql = 'INSERT INTO todo_items (expiration_date,todo_item) VALUES (:expiration_date,:todo_item)';

    $stmt = $dbh->prepare($sql);

    // SQL文の該当箇所に、変数の値を割り当て（バインド）する
    $stmt->bindValue(':expiration_date', $_POST['expiration_date'], PDO::PARAM_STR);
    $stmt->bindValue(':todo_item', $_POST['todo_item'], PDO::PARAM_STR);

    // たぶんここでsql文を実行している
    $stmt->execute();

    // DBから切断
    $dbh = null;

    // 処理が完了したらトップページ（index.php）へリダイレクト
    header('Location: ./index.php');
    // header('Location: ./test.php');
    exit;
} catch (Exception $e) {
    var_dump($e->getMessage());
    echo '<br><br>';
    echo '障害発生につきご迷惑をおかけしております<br>';
    echo '<a href="./index.php">戻る</a>';
    exit();
}
