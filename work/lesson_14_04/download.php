<?php
require_once('./variables.php');
require_once('./class/db/Base.php');
require_once('./class/db/TodoItems.php');

session_start();
session_regenerate_id(true);

// ログインしていない場合は、login.phpへ飛ばす
if (empty($_SESSION['user'])) {
    header('Location:./login.php');
    exit();
}

// $datetime = new DateTime('now', new DateTimeZone('Asia/Tokyo'));
// $datetime = $datetime->format('Y-m-d');

try {
    $db = new TodoItems;

    $lists = $db->dbAllSelect();
} catch (Exception $e) {
    echo $e->getMessage();
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
