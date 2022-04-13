<?php
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
    exit();
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

        .comp_line {
            text-decoration-line: line-through;
        }
    </style>
    <title>lesson_11_03</title>
</head>

<body>
    <header>
    </header>
    <div class="container-md mt-3">
        <div class="card">
            <div class="card-header">
                <div>
                    <h3>lesson_11_03</h3>
                    <i class="float-end nes-bulbasaur"></i>
                </div>
            </div>
            <div class="card-body">
                <form action="./add.php" method="POST">
                    <div class="row m-2">
                        <div class="col-md-4">
                            <label for="expiration_date">日付</label>
                            <input type="date" name="expiration_date" id="expiration_date" value="<?= $datetime ?>" class="w-75 nes-input">
                        </div>
                        <div class="col-md">
                            <label for="todo_item">内容</label>
                            <input type="text" name="todo_item" id="todo_item" placeholder="入力してください" class="w-75 nes-input">
                        </div>
                        <div class="col-md-1">
                            <input type="submit" value="追加" class="w-100 nes-btn is-primary">
                        </div>
                    </div>
                </form>
            </div>

            <?php if (0 < count($lists)) : ?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="col-md-4" scope="col">期限日</th>
                            <th scope="col">ToDo内容</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lists as $list) : ?>
                            <tr>
                                <td class="<?php if ($list['is_completed'] == 1) echo 'comp_line' ?>"><?= $list['expiration_date'] ?></td>
                                <td class="<?php if ($list['is_completed'] == 1) echo 'comp_line' ?>"><?= $list['todo_item'] ?></td>
                                <form action="./action.php" method="POST">
                                    <td><input type="hidden" name="id" value="<?= $list['id'] ?>"></td>
                                    <td><label><input type="radio" name="is_completed" value="0" <?php if ($list['is_completed'] == 0) echo 'checked' ?>>未完了</label></td>
                                    <td><label><input type="radio" name="is_completed" value="1" <?php if ($list['is_completed'] == 1) echo 'checked' ?>>完了</label></td>
                                    <td><label><input type="checkbox" name="delete" value="1">削除</label></td>
                                    <td><input type="submit" value="実行"></td>
                                </form>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p>ToDoは登録されていません</p>
            <?php endif ?>
            <button class="w-25 btn bg-warning">
                <a href="./csv.php">CSVファイルで出力</a>
            </button>
        </div>
    </div>
    <footer>
        <br><br>
        <div class="container-md">
            <a href="./test.php">テストページへ</a>
        </div>
    </footer>
</body>

</html>