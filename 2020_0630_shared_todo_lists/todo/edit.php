<?php
try {
    require_once('../class/db/Base.php');
    require_once('../class/db/Users.php');
    require_once('../class/db/TodoItems.php');
    require_once('../class/util/Security.php');
    require_once('../class/util/Config.php');
    Security::session();
    Security::notLogin();
    $token = Security::makeToken();
    $datetime = Config::dateTime();

    // エラーメッセージを配列から変数に入れる(これいる？)
    if (isset($_SESSION['err'])) {
        foreach ($_SESSION['err'] as $key => $v) {
            $errMsg[] = $v;
        }
    }

    /**
     * DBからToDoのレコードを取得する取得する
     *
     * レコードのitem_idを$_POSTで受け取った値にするか
     * $_SESSIONに保存した値にするかの二択で条件分岐させている
     */
    $todoIns = new TodoItems;
    if (isset($_SESSION['post']['item_id'])) {
        $item_id = $_SESSION['post']['item_id'];
    } else {
        $item_id = $_POST['item_id'];
    }
    // 引数の中身を条件分岐で変える事で必要なレコードを取得している
    $todoItem = $todoIns->dbConfirmation($item_id);

    $userIns = new Users;
    $userInfos = $userIns->dbAllSelect();
} catch (Exception $e) {
    header('Location:../error/error.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- nes.cssの読み込み -->
    <link href="https://unpkg.com/nes.css@latest/css/nes.min.css" rel="stylesheet" />
    <!-- bootstrapの読み込み -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <!-- フォントの読み込み -->
    <!-- Nico Moji -->
    <link href="https://fonts.googleapis.com/earlyaccess/nicomoji.css" rel="stylesheet">
    <!-- RocknRoll One -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=RocknRoll+One&display=swap" rel="stylesheet">
    <!-- 自作cssの読み込み -->
    <link rel="stylesheet" href="../css/style.css">
    <title>作業修正</title>
</head>

<body>
    <!-- ナビゲーション -->
    <nav class="navbar navbar-expand-md navbar-dark bg-primary">
        <span class="navbar-brand">TODOリスト</span>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="./index.php">作業一覧</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./entry.php">作業登録 <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?= $_SESSION['user']['family_name'] . $_SESSION['user']['first_name'] . 'さん' ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="../login/logout.php">ログアウト</a>
                    </div>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0" action="./" method="get">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search" maxlength="100">
                <button class="btn btn-outline-light my-2 my-sm-0" type="submit">検索</button>
            </form>
        </div>
    </nav>
    <!-- ナビゲーション ここまで -->

    <!-- コンテナ -->
    <div class="container">
        <div class="row my-2">
            <div class="col-sm-3"></div>
            <div class="col-sm-6 alert alert-info">
                作業内容を修正してください
            </div>
            <div class="col-sm-3"></div>
        </div>

        <!-- エラーメッセージ -->
        <div class="row my-2">
            <?php if (isset($errMsg)) : ?>
                <div class="col-sm-3"></div>
                <div class="col-sm-6 alert alert-danger alert-dismissble fade show">
                    <p><?= (implode("<br>", $errMsg)) ?></p>
                    <button class="close" data-dismiss="alert">&times;</button>
                </div>
                <div class="col-sm-3"></div>
            <?php endif ?>
        </div>
        <!-- エラーメッセージ ここまで -->

        <!-- 入力フォーム -->
        <div class="row my-2">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <form action="./edit_action.php" method="post">
                    <div class="form-group">
                        <label for="item_name">項目名</label>
                        <input type="text" name="item_name" id="item_name" class="form-control" value=<?= isset($_SESSION['post']['item_name']) ? $_SESSION['post']['item_name'] : $todoItem['item_name'] ?>>
                    </div>
                    <div class="form-group">
                        <label for="user_id">担当者</label>
                        <select name="user_id" id="user_id" class="form-control">
                            <!-- ToDoに登録されている担当者を表示する -->
                            <option value=<?= $todoItem['user_id'] ?>><?= $todoItem['family_name'] . $todoItem['first_name'] ?></option>
                            <option value="">-- 登録されていない担当者 --</option>
                            <!-- DBに登録されているユーザを表示する -->
                            <?php foreach ($userInfos as $userInfo => $v) : ?>
                                <option value=<?= $v['id'] ?>><?= $v['family_name'] . $v['first_name'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="expire_date">期限</label>
                        <input type="date" class="form-control" id="expire_date" name="expire_date" value=<?= isset($_SESSION['post']['expire_date']) ? $_SESSION['post']['expire_date'] : $todoItem['expire_date'] ?>>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="finished_date" name="finished_date" value=<?= $datetime ?><?= !is_null($todoItem['finished_date']) ? " checked" : "" ?>>
                        <label for="finished_date">完了</label>
                    </div>
                    <input type="hidden" name="item_id" value="<?= $todoItem['id'] ?>">
                    <input type="hidden" name="token" value="<?= $token ?>">
                    <input type="submit" value="更新" class="btn btn-primary">
                    <input type="button" value="キャンセル" class="btn btn-outline-primary" onclick="location.href='./';">
                </form>
            </div>
            <div class="col-sm-3"></div>
        </div>
        <!-- 入力フォーム ここまで -->

    </div>
    <!-- コンテナ ここまで -->

    <!-- 必要なJavascriptを読み込む -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>


</body>

</html>