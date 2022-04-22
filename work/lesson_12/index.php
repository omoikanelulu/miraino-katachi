<?php
require_once('./variables.php');
require_once('./class/db/Base.php');
require_once('./class/db/Todoitems.php');

session_start();
session_regenerate_id(true);

// エラーメッセージを初期化しておく
unset($_SESSION['err'], $_SESSION['success']);

$datetime = new DateTime('now', new DateTimeZone('Asia/Tokyo'));
$datetime = $datetime->format('Y-m-d');

try {
    $db = new TodoItems;
    $lists = $db->dbAllSelect();

    // $sql = 'SELECT * FROM todo_items ORDER BY expiration_date ASC';
    // $stmt = $dbh->prepare($sql);
    // $stmt->execute();
    // $dbh = null;

    // $lists = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title><?= $title ?></title>
</head>

<body>
    <header>
    </header>
    <div class="container-md mt-3">
        <div class="card">
            <div class="card-header">
                <div>
                    <h3><?= $title ?></h3>
                    <i class="float-end nes-bulbasaur"></i>
                </div>
            </div>
            <!-- 新規入力ブロック -->
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

            <!-- 入力済みブロック -->
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

            <div class="float-start">
                <a href="./csv.php"><button type="button" class="w-25 m-3 btn btn-secondary">CSVファイルを出力</button></a>
                <a href="./upload.php"><button type="button" class="w-25 m-3 btn btn-secondary">CSVから読み込む</button></a>
                <a href="./download.php"><button type="button" class="w-25 m-3 btn btn-info">CSVをDOWNLOADする</button></a>
            </div>

        </div>
    </div>
    <footer>
    </footer>
</body>

</html>