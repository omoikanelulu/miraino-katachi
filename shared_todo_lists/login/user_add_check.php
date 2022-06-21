<?php
try {
    require_once('../class/db/Base.php');
    require_once('../class/db/Users.php');
    require_once('../class/util/Security.php');

    unset($_SESSION['err']['pass'], $_SESSION['err']['msg']);

    Security::session();
    if (!Security::checkToken($_POST['token'])) {
        $_SESSION['err']['msg'] = '不正なアクセスです';
        header('Location: ../error/error.php');
        exit();
    }

    // POSTされてきたデータをサニタイズして$postへ代入
    $post = Security::sanitize($_POST);
    // $postを$_SESSION['data']へ保存
    $_SESSION['data'] = $post;
    // 項目のチェック
    $hasErr = '';
    // パスワードの入力間違いチェック
    if ($post['pass'] != $post['pass2']) {
        $_SESSION['err']['pass'] = 'パスワードが一致しません';
        $hasErr = true;
    }
    // 値に空の物がないかチェック
    foreach ($post as $key => $v) {
        if ($key == 'token') {
            continue;
        } elseif (empty($v) == true) {
            $hasErr = true;
            $_SESSION['err']['msg'] = '未入力の項目があります';
            break;
        }
    }
    // 項目のチェック ここまで

    // 項目のチェックでNGだった場合、user_addにリダイレクト
    if ($hasErr == true) {
        header('location:./user_add.php');
        exit();
    }

    if (isset($_SESSION['data']['is_admin']) ? $is_admin = 'checked="checked"' : $is_admin = '');
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

    <!-- ユーザ登録情報の確認ブロック -->
    <div class="row my-2">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">

            <div class="alert alert-info">
                <h4>下記の情報を登録します</h4>
            </div>
            <!-- <form action="./user_add_action.php" method="post"> -->
            <div class="form-group">
                <label for="user">ユーザー名</label>
                <input disabled type="text" class="form-control" id="user" name="user" value="<?= $post['user'] ?>">
            </div>
            <div class="form-group">
                <label for="pass">パスワード</label>
                <input disabled type="password" class="form-control" id="pass" name="pass" value="<?= $post['pass'] ?>">
            </div>
            <div class="form-group">
                <label for="family_name">性</label>
                <input disabled type="text" class="form-control" id="family_name" name="family_name" value="<?= $post['family_name'] ?>">
            </div>
            <div class="form-group">
                <label for="first_name">名</label>
                <input disabled type="text" class="form-control" id="first_name" name="first_name" value="<?= $post['first_name'] ?>">
            </div>
            <div class="form-group form-check">
                <input disabled type="checkbox" <?= $is_admin ?> class="form-check-input" id="is_admin" name="is_admin">
                <label for="is_admin">管理者権限を与える</label>
            </div>
            <br>
            <button type="submit" class="btn btn-primary" onclick="location.href='./user_add_action.php'">登録</button>
            <input type="button" value="キャンセル" class="btn btn-outline-primary" onclick="location.href='./user_add.php';">

                <!-- <script type="text/javascript">
                    document.write('<input type="button" value=" 戻る " onClick="history.back()">');
                </script>
                <a href="～">サイトトップに戻る</a><br>
                <a href="～">カテゴリトップに戻る</a><br> -->

                <!-- </form> -->
        </div>
        <div class="col-sm-3"></div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
</body>

</html>