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

// メッセージを初期化しておく
unset($_SESSION['err'], $_SESSION['success']);

// アップロード成功時のメッセージ
$s_msg = '更新完了しました';

// エラーメッセージ
$e_msg = 'ファイルが存在しないか、エラーが発生しています';

$userdata = $_FILES['userdata'];

// アップロードが上手くいかなかった場合、エラーメッセージを$_SESSIONに保存する
if (!isset($userdata) || $userdata['error'] != 0) {
    $_SESSION['err']['msg'] = $e_msg;
    header('Location:./upload.php');
    exit();
}

$fp = fopen($userdata['tmp_name'], 'r');

// これは意味もなく一行読み込んでいるって動きになってしまう
// $line = fgetcsv($fp);

try {
    $db = new TodoItems();

    while (($line = fgetcsv($fp)) !== false) {
        $db->dbCsvUpdate($line[0], $line[1], mb_convert_encoding($line[2], 'UTF-8', 'SJIS-win'), $line[3]);
    }

    // 成功時のメッセージを代入
    $_SESSION['success']['msg'] = $s_msg;
    header('Location:./upload.php');
} catch (Exception $e) {
    // 失敗時のメッセージを代入
    $_SESSION['err']['msg'] = $e_msg;
    header('Location:./upload.php');
    exit();
}
