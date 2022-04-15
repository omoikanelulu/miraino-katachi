<?php
$title = 'lesson_11_04';

session_start();
session_regenerate_id(true);

$datetime = new DateTime('now', new DateTimeZone('Asia/Tokyo'));
// formatした状態で変数に入れておかないと情報が多すぎて思い通りにならない
// っていうか日付は「-」で区切るとか...はぁあん！？
$datetime = $datetime->format('Y-m-d');

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
$fp = fopen('./todolist.csv', 'w');
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
    $msg = 'csvへ書き出し完了';
} else {
    $msg = '書き出し失敗';
}


?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- nes.cssの読み込み -->
    <link href="https://unpkg.com/nes.css@latest/css/nes.min.css" rel="stylesheet" />
    <!-- bootstrapの読み込み -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- フォントの読み込み -->
    <!-- Nico Moji -->
    <link href="https://fonts.googleapis.com/earlyaccess/nicomoji.css" rel="stylesheet">
    <!-- RocknRoll One -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=RocknRoll+One&display=swap" rel="stylesheet">
    <!-- 自作cssの読み込み -->
    <link rel="stylesheet" href="./css/style.css">
    <style>
        * {
            font-family: "Nico Moji", 'RocknRoll One', sans-serif;
        }
    </style>
    <title><?= $title ?></title>
</head>

<body class="container m-3-md">
    <header>
    </header>
    <main>
        <div class="row m-2">
            <p><?= $msg ?></p>
        </div>
    </main>
    <footer>
        <br>
        <a href="./index.php">index.phpへ</a>
    </footer>
</body>

</html>