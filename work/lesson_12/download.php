<?php
require_once('./variables.php');
// session_start();
// session_regenerate_id(true);

// $datetime = new DateTime('now', new DateTimeZone('Asia/Tokyo'));
// $datetime = $datetime->format('Y-m-d');

try {
    // DBへの接続
    $dsn = 'mysql:dbname=php_work;host=localhost;port=3306;charset=utf8';
    $user = 'root';
    $password = '0971790';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQLでDBエンジンに指示
    $sql = 'SELECT * FROM todo_items ORDER BY expiration_date ASC';
    $stmt = $dbh->prepare($sql);

    $stmt->execute();

    // DBから切断
    $dbh = null;

    // 取得したレコードを連想配列として変数に代入する
    $lists = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    var_dump($e->getMessage());
    echo '<br><br>';
    echo '障害発生につきご迷惑をおかけしております<br>';
    echo '<a href="./index.php">index.phpへ</a>';
    exit();
}

// csvファイル作成
$fp = fopen('./todolist.csv', 'w');
chmod('./todolist.csv', 0666);
$result = true;

foreach ($lists as $list) {
    foreach ($list as $k => $v) {
        if ($k == 'todo_item') {
            $list[$k] = mb_convert_encoding($v, 'SJIS-win', 'UTF-8');
        }
    }
    if (fputcsv($fp, $list) === false) {
        $result = false;
        break;
    }
}

fclose($fp);

if ($result) {
    // csvを出力します
    // header('Content-Type: application/csv');
    header('Content-Type: text/csv');

    // downloaded.csv という名前で保存させます
    header('Content-Disposition: attachment; filename="downloaded.csv"');

    // もとのソース
    readfile('todolist.csv');
} else {
    $msg = '書き出し失敗';
}
