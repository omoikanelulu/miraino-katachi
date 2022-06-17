<?php
try {
    require_once('../class/db/Base.php');
    require_once('../class/db/Users.php');
    require_once('../class/db/TodoItems.php');
    require_once('../class/util/Security.php');
    require_once('../class/util/Config.php');
    Security::session();
    $token = Security::makeToken();
    $datetime = Config::dateTime();
    $get = Security::sanitize($_GET);

    // デバッグ用 //
    echo '$_GETの中身<br>';
    var_dump($_GET);
    echo '<br>';
    ////////////////
    unset($_SESSION['post']);

    // /ログインされていない場合はログイン画面にリダイレクトする
    if (empty($_SESSION['user'])) {
        header('Location:../login/index.php');
    }

    // 検索窓に入力があった場合に検索用メソッドが動く
    // ページャーを付けた都合上このやり方では動かない
    if (!empty($get['search'])) {
        $searchIns = new TodoItems;
        $searchItems = $searchIns->dbSearch($get['search']);
        $showMode = 's'; // searchモードって事
        empty($searchItems) ? $_SESSION['err']['msg'] = '該当する検索結果はありません' : '';
    } else {
        // 検索窓が使用されていない場合登録されているToDoを全て取得する
        $todoIns = new TodoItems;
        $todoItems = $todoIns->dbAllSelect();
        $showMode = 'a'; // allモードって事
    }

    define('MAX', '4'); // 最大表示レコード数の設定defineでMAXという定数を作成し4を設定した
    $itemsCount = count($todoItems); // 取得したレコードのトータル件数
    $maxPage = ceil($itemsCount / MAX); // 最大ページ数(ceilは小数点切り捨て)

    if (!isset($_GET['page_num'])) { // $_GET['page_num'] はURLに渡された現在のページ数
        $now = 1; // 設定されてない場合は1ページ目にする
    } else {
        $now = $_GET['page_num']; // 既に$_GET['page_num']にページ数があるならそれを代入する
    }

    // デバッグ用 //
    echo '$nowの中身<br>';
    var_dump($now);
    echo '<br>';
    ////////////////

    $start_num = ($now - 1) * MAX; // 配列の何番目から取得すればよいか

    // array_sliceは、配列の何番目($start_num)から何番目(MAX)まで切り取る関数
    $dispData = array_slice($todoItems, $start_num, MAX, true);
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
    <!-- <link href="https://unpkg.com/nes.css@2.3.0/css/nes.min.css" rel="stylesheet" /> -->
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
    <title>作業一覧</title>
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
                <li class="nav-item active">
                    <a class="nav-link" href="./">作業一覧 <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./entry.php">作業登録</a>
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
                <!-- 今は使用できません、ToDo一覧の表示の仕方を変更する必要がある -->
                <input disabled class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search" maxlength="100">
                <button disabled class="btn btn-outline-light my-2 my-sm-0" type="submit">検索</button>
            </form>
        </div>
    </nav>
    <!-- ナビゲーション ここまで -->

    <!-- フシギダネの msg 表示 -->
    <!-- err msg ある場合 -->
    <div class="row my-2">
        <?php if (isset($_SESSION['err']['msg'])) : ?>
            <div class="col-sm-3"></div>
            <div class="col-sm-6 alert alert-danger alert-dismissble fade show">
                <button class="close" data-dismiss="alert">&times;</button>
                <!-- 吹き出し -->
                <div class="nes-balloon from-right">
                    <p><?= $_SESSION['err']['msg'] ?></p>
                </div>
                <i class="nes-bulbasaur"></i>
            </div>
            <div class="col-sm-3"></div>
        <?php endif ?>
    </div>
    <!-- success msg ある場合 -->
    <div class="row my-2">
        <?php if (isset($_SESSION['success']['msg'])) : ?>
            <div class="col-sm-3"></div>
            <div class="col-sm-6 alert alert-info alert-dismissble fade show">
                <button class="close" data-dismiss="alert">&times;</button>
                <!-- 吹き出し -->
                <div class="nes-balloon from-right">
                    <p><?= $_SESSION['success']['msg'] ?></p>
                </div>
                <i class="nes-bulbasaur"></i>
            </div>
            <div class="col-sm-3"></div>
        <?php endif ?>
    </div>
    <!-- フシギダネの msg 表示 ここまで -->

    <!-- ToDoを表示させるコンテナ -->
    <div class="container">
        <table class="table table-striped table-hover table-sm my-2">
            <thead>
                <tr>
                    <th scope="col">項目名</th>
                    <th scope="col">担当者</th>
                    <th scope="col">登録日</th>
                    <th scope="col">期限日</th>
                    <th scope="col">完了日</th>
                    <th scope="col">操作</th>
                </tr>
            </thead>

            <tbody>
                <!-- searchした時のToDo表示 -->
                <?php if ($showMode == 's') : ?>
                    <?php foreach ($searchItems as $searchItem => $v) : ?>
                        <tr class=<?= isset($v['finished_date']) ? 'del' : '' ?> <?= $v['expire_date'] <= $datetime ? 'text-danger' : '' ?>>
                            <td class="align-middle">
                                <?= $v['item_name'] ?>
                            </td>
                            <td class="align-middle">
                                <?= $v['family_name'] . $v['first_name'] ?> </td>
                            <td class="align-middle">
                                <?= $v['registration_date'] ?> </td>
                            <td class="align-middle">
                                <?= $v['expire_date'] ?> </td>
                            <td class="align-middle">
                                <?= $v['finished_date'] ?> </td>
                            <td class="align-middle button">
                                <form action="./complete.php" method="post" class="my-sm-1">
                                    <input type="hidden" name="item_id" value=<?= $v['id'] ?>>
                                    <input type="hidden" name="finished_date" value=<?= $datetime ?>>
                                    <button class="btn btn-primary my-0" type="submit">完了</button>
                                </form>
                                <form action="./edit.php" method="post" class="my-sm-1">
                                    <input type="hidden" name="item_id" value=<?= $v['id'] ?>>
                                    <input type="hidden" name="user_id" value=<?= $v['user_id'] ?>>
                                    <input type="hidden" name="finished_date" value=<?= $v['finished_date'] ?>>
                                    <input class="btn btn-success my-0" type="submit" value="修正">
                                </form>
                                <form action="./delete.php" method="post" class="my-sm-1">
                                    <input type="hidden" name="item_id" value=<?= $v['id'] ?>>
                                    <input class="btn btn-danger my-0" type="submit" value="削除">
                                </form>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php endif ?>

                <!-- ToDo通常表示 -->
                <?php if ($showMode == 'a') : ?>
                    <?php foreach ($dispData as $data => $v) : ?>
                        <tr class=<?= isset($v['finished_date']) ? 'del' : '' ?> <?= $v['expire_date'] <= $datetime ? 'text-danger' : '' ?>>
                            <td class="align-middle">
                                <?= $v['item_name'] ?>
                            </td>
                            <td class="align-middle">
                                <?= $v['family_name'] . $v['first_name'] ?> </td>
                            <td class="align-middle">
                                <?= $v['registration_date'] ?> </td>
                            <td class="align-middle">
                                <?= $v['expire_date'] ?> </td>
                            <td class="align-middle">
                                <?= $v['finished_date'] ?> </td>
                            <td class="align-middle button">
                                <form action="./complete.php" method="post" class="my-sm-1">
                                    <input type="hidden" name="item_id" value=<?= $v['id'] ?>>
                                    <input type="hidden" name="finished_date" value=<?= $datetime ?>>
                                    <button class="btn btn-primary my-0" type="submit">完了</button>
                                </form>
                                <form action="./edit.php" method="post" class="my-sm-1">
                                    <input type="hidden" name="item_id" value=<?= $v['id'] ?>>
                                    <input type="hidden" name="user_id" value=<?= $v['user_id'] ?>>
                                    <input type="hidden" name="finished_date" value=<?= $v['finished_date'] ?>>
                                    <input class="btn btn-success my-0" type="submit" value="修正">
                                </form>
                                <form action="./delete.php" method="post" class="my-sm-1">
                                    <input type="hidden" name="item_id" value=<?= $v['id'] ?>>
                                    <input class="btn btn-danger my-0" type="submit" value="削除">
                                </form>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php endif ?>
            </tbody>
        </table>
        <!-- ページャー -->
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class="page-item">
                    <?php if ($now == 1) : ?>
                        <span class="page-link text-secondary" aria-hidden="true">&laquo;</span>
                    <?php else : ?>
                        <a class="page-link" href="./index.php?page_num=<?= $now - 1 ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    <?php endif ?>
                </li>
                <!-- リンクを最大ページ数まで作成する -->
                <?php for ($i = 1; $i <= $maxPage; $i++) {
                    // echo使いたくないなぁ
                    echo "<li class='page-item'><a class='page-link' href='./index.php?page_num=$i'>{$i}</a></li>";
                }
                ?>
                <li class="page-item">
                    <?php if ($now >= $maxPage) : ?>
                        <span class="page-link text-secondary" aria-hidden="true">&raquo;</span>
                    <?php else : ?>
                        <a class="page-link" href="./index.php?page_num=<?= $now + 1 ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    <?php endif ?>
                </li>
            </ul>
        </nav>
    </div>
    <!-- ToDoを表示させるコンテナ ここまで -->

    <!-- 表示させたメッセージは最後に消しておく -->
    <?php unset($_SESSION['err'], $_SESSION['success']) ?>

    <!-- 必要なJavascriptを読み込む -->
    <!-- <script src="../js/jquery-3.4.1.min.js"></script> -->
    <!-- <script src="../js/bootstrap.bundle.min.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>

</body>

</html>