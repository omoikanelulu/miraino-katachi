<?php
require_once('../class/db/Base.php');
require_once('../class/db/Users.php');
require_once('../class/db/TodoItems.php');
require_once('../class/util/Security.php');
Security::session();
Security::notLogin();

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
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search" value="花子">
                <button class="btn btn-outline-light my-2 my-sm-0" type="submit">検索</button>
            </form>
        </div>
    </nav>
    <!-- ナビゲーション ここまで -->

    <!-- コンテナ -->
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
                <tr class="text-danger">
                    <td class="align-middle">
                        テストの項目 </td>
                    <td class="align-middle">
                        テスト花子 </td>
                    <td class="align-middle">
                        2020-01-13 </td>
                    <td class="align-middle">
                        2020-02-12 </td>
                    <td class="align-middle">
                        未 </td>
                    <td class="align-middle button">
                        <form action="./complete.php" method="post" class="my-sm-1">
                            <input type="hidden" name="item_id" value="1">
                            <button class="btn btn-primary my-0" type="submit">完了</button>
                        </form>
                        <form action="edit.php" method="post" class="my-sm-1">
                            <input type="hidden" name="item_id" value="1">
                            <input class="btn btn-primary my-0" type="submit" value="修正">
                        </form>
                        <form action="delete.php" method="post" class="my-sm-1">
                            <input type="hidden" name="item_id" value="1">
                            <input class="btn btn-primary my-0" type="submit" value="削除">
                        </form>
                    </td>
                </tr>
                <tr>
                    <td class="align-middle">
                    </td>
                    <td class="align-middle">
                        テスト花子 </td>
                    <td class="align-middle">
                        2020-02-13 </td>
                    <td class="align-middle">
                        2020-02-24 </td>
                    <td class="align-middle">
                        未 </td>
                    <td class="align-middle button">
                        <form action="./complete.php" method="post" class="my-sm-1">
                            <input type="hidden" name="item_id" value="3">
                            <button class="btn btn-primary my-0" type="submit">完了</button>
                        </form>
                        <form action="edit.php" method="post" class="my-sm-1">
                            <input type="hidden" name="item_id" value="3">
                            <input class="btn btn-primary my-0" type="submit" value="修正">
                        </form>
                        <form action="delete.php" method="post" class="my-sm-1">
                            <input type="hidden" name="item_id" value="3">
                            <input class="btn btn-primary my-0" type="submit" value="削除">
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- 検索のとき、戻るボタンを表示する -->
        <div class="row">
            <div class="col">
                <form>
                    <div class="goback">
                        <input class="btn btn-primary my-0" type="button" value="戻る" onclick="location.href='./';">
                    </div>
                </form>
            </div>
        </div>

    </div>
    <!-- コンテナ ここまで -->

    <!-- 必要なJavascriptを読み込む -->
    <!-- <script src="../js/jquery-3.4.1.min.js"></script> -->
    <!-- <script src="../js/bootstrap.bundle.min.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>


</body>

</html>