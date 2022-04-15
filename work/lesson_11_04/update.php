<?php
$title = 'lesson_11_04';

session_start();
session_regenerate_id(true);

$datetime = new DateTime('now', new DateTimeZone('Asia/Tokyo'));
$datetime = $datetime->format('Y-m-d');

// エラーメッセージを初期化しておく
unset($_SESSION['err']);

// エラーメッセージ
$e_msg = 'ファイルが存在しないか、エラーが発生しています';
$userdata = $_FILES['userdata'];

// アップロードが上手くいかなかった場合、エラーメッセージを$_SESSIONに保存する
if (!isset($userdata) || $userdata['error'] != 0) {
    $_SESSION['err']['msg'] = $e_msg;
}

$fp = fopen($userdata['tmp_name'], 'r');

try {
    // UPDATE SET WHERE
    // DBへの接続
    $dsn = 'mysql:dbname=php_work;host=localhost;port=3306;charset=utf8';
    $user = 'root';
    $password = '0971790';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQLでDBエンジンに指示
    // $sql文でデータベースに指令を出す
    $sql = 'UPDATE todo_items SET expiration_date=:expiration_date, todo_item=:todo_item, is_completed=:is_completed WHERE id=:id';

    $stmt = $dbh->prepare($sql);

    while (($line = fgetcsv($fp)) !== false) {
        $stmt->bindValue(':id', $line[0], PDO::PARAM_INT);
        $stmt->bindValue(':expiration_date', $line[1], PDO::PARAM_STR);
        $stmt->bindValue(':todo_item', mb_convert_encoding($line[2], 'UTF-8', 'SJIS-win'), PDO::PARAM_STR);
        $stmt->bindValue(':is_completed', $line[3], PDO::PARAM_INT);
    }

    $stmt->execute();

    echo '更新が完了しました';
    echo '<a href="index.php">index.phpへ</a>';

    // DBから切断
    $dbh = null;
} catch (Exception $e) {
    $_SESSION['err']['msg'] = $e_msg;
    header('Location:./index.php');
    exit();
}
