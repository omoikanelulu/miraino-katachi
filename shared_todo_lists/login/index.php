<?php
try {
    require_once('../class/db/Base.php');
    require_once('../class/db/Users.php');
    require_once('../class/util/Security.php');

    unset($_SESSION['data'], $_SESSION['err'], $_SESSION['success']);

    Security::session();
    // トークンを作成し$_SESSION['token']に保存する
    $p_token = Security::makeToken(); // POSTするトークンを代入

    // デバッグ用 //
    echo '<p>$_SESSIONの中身を表示</p>';
    var_dump($_SESSION);
    ////////////////

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
    <title>ログイン</title>
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-primary">
        <span class="navbar-brand">ログイン</span>
    </nav>

    <div class="container">
        <div class="row my-2">
            <?php if (!isset($_SESSION['user'])) : ?>
                <div class="col-sm-3"></div>
                <div class="col-sm-6 alert alert-info">
                    <h4>ログインして使用してください</h4>
                </div>
                <div class="col-sm-3"></div>
            <?php endif ?>
        </div>

        <!-- エラーメッセージの表示ブロック -->
        <div class="row my-2">
            <?php if (isset($_SESSION['err']['msg'])) : ?>
                <div class="col-sm-3"></div>
                <div class="col-sm-6 alert alert-danger alert-dismissble fade show">
                    <div class="float-end">
                        <div class="float-start nes-balloon from-right">
                            <p><?= $_SESSION['err']['msg'] ?></p>
                        </div>
                        <i class="nes-bulbasaur"></i>
                        <button class="close" data-dismiss="alert">&times;</button>
                    </div>
                </div>
                <div class="col-sm-3"></div>
            <?php endif ?>
        </div>
        <!-- エラーメッセージの表示ブロック ここまで -->

        <!-- ログイン情報の入力ブロック -->
        <div class="row my-2">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <form action="./login.php" method="post">
                    <input type="hidden" name="token" value="<?= $p_token ?>">
                    <div class="form-group">
                        <label for="user">ユーザー名</label>
                        <input type="text" class="form-control" id="user" name="user">
                    </div>
                    <div class="form-group">
                        <label for="pass">パスワード</label>
                        <input type="password" class="form-control" id="pass" name="pass">
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">ログイン</button>
                </form>
            </div>
            <div class="col-sm-3"></div>
        </div>

        <div class="row my-2">
            <div class="col-sm-3"></div>
            <div class="col-sm-6 alert alert-info">
                <h4>ユーザ登録はこちら</h4>
            </div>
            <div class="col-sm-3"></div>
        </div>

        <!-- ユーザ登録ブロック -->
        <div class="row my-2">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <form action="./user_add.php" method="post">
                    <input type="hidden" name="token" value="<?= $p_token ?>">
                    <button type="submit" class="btn btn-info">ユーザ登録</button>
                </form>
            </div>
            <div class="col-sm-3"></div>
        </div>
    </div>

    <!-- 必要なJavascriptを読み込む -->
    <!-- <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>

</body>

</html>