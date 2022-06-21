<?php
try {
    require_once('../class/db/Base.php');
    require_once('../class/db/Users.php');
    require_once('../class/util/Security.php');

    Security::session();
    if (!Security::checkToken($_POST['token'])) {
        $_SESSION['err']['msg'] = '不正なアクセスです なぜにここでアウト？';
        header('Location: ../error/error.php');
        exit();
    }

    $p_token = Security::makeToken();

    // パスワード不一致時のエラーメッセージを代入
    if (isset($_SESSION['err']['pass']) ? $errMsg = $_SESSION['err']['pass'] : $errMsg = '');

    // バリデーションNGで戻ってきた時は、あらかじめ入力項目を入力した状態にしておく
    if (isset($_SESSION['data']['user']) ? $user = $_SESSION['data']['user'] : $user = '');
    if (isset($_SESSION['data']['family_name']) ? $family_name = $_SESSION['data']['family_name'] : $family_name = '');
    if (isset($_SESSION['data']['first_name']) ? $first_name = $_SESSION['data']['first_name'] : $first_name = '');
    if (isset($_SESSION['data']['is_admin']) ? $is_admin = 'checked="checked"' : $is_admin = '');

    // デバッグ用 //
    // echo '<p>$_SESSIONの中身を表示</p>';
    // var_dump($_SESSION);
    // echo '<p>$_POSTの中身を表示</p>';
    // var_dump($_POST);
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
    <title>作業修正</title>
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-primary">
        <span class="navbar-brand">ユーザ登録</span>
    </nav>

    <!-- エラーメッセージの表示ブロック -->
    <div class="row my-2">
        <?php if (isset($_SESSION['err']['msg'])) : ?>
            <div class="col-sm-3"></div>
            <div class="col-sm-6 alert alert-danger alert-dismissble fade show">
                <div class="nes-balloon from-right">
                    <p><?= $_SESSION['err']['msg'] ?></p>
                </div>
                <i class="nes-bulbasaur"></i>
                <button class="close" data-dismiss="alert">&times;</button>
            </div>
            <div class="col-sm-3"></div>
        <?php endif ?>
    </div>
    <!-- エラーメッセージの表示ブロック ここまで -->

    <!-- サクセスメッセージの表示ブロック -->
    <div class="row my-2">
        <?php if (isset($_SESSION['success']['msg'])) : ?>
            <div class="col-sm-3"></div>
            <div class="col-sm-6 alert alert-info alert-dismissble fade show">
                <div class="nes-balloon from-right">
                    <p><?= $_SESSION['success']['msg'] ?></p>
                </div>
                <i class="nes-bulbasaur"></i>
                <button class="close" data-dismiss="alert">&times;</button>
            </div>
            <div class="col-sm-3"></div>
        <?php endif ?>
    </div>
    <!-- サクセスメッセージの表示ブロック ここまで -->

    <!-- ユーザ登録情報の入力ブロック -->
    <div class="row my-2">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <form action="./user_add_check.php" method="post">
                <input type="hidden" name="token" value="<?= $p_token ?>">
                <div class="form-group">
                    <label for="user">ユーザー名</label>
                    <input type="text" class="form-control" id="user" name="user" value="<?= $user ?>">
                </div>
                <div class="form-group">
                    <label for="pass">パスワード</label>
                    <input type="password" class="form-control" id="pass" name="pass">
                </div>
                <div class="form-group">
                    <label for="pass2">パスワード(再確認用)</label>
                    <input type="password" class="form-control" id="pass2" name="pass2" aria-describedby="passCheck">
                    <div id="passCheck" class="form-text text-danger"><?= $errMsg ?></div>
                </div>
                <div class="form-group">
                    <label for="family_name">性</label>
                    <input type="text" class="form-control" id="family_name" name="family_name" value="<?= $family_name ?>">
                </div>
                <div class="form-group">
                    <label for="first_name">名</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?= $first_name ?>">
                </div>
                <div class="form-group form-check">
                    <input type="hidden" value="0" id="is_admin" name="is_admin">
                    <input type="checkbox" value="1" <?= $is_admin ?> class="form-check-input" id="is_admin" name="is_admin">
                    <label for="is_admin">管理者権限を与える</label>
                </div>
                <br>
                <button type="submit" class="btn btn-primary">登録</button>
                <input type="button" value="キャンセル" class="btn btn-outline-primary" onclick="location.href='./';">
            </form>
        </div>
        <div class="col-sm-3"></div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
</body>

</html>