<?php
try {
    require_once('../class/db/Base.php');
    require_once('../class/db/Users.php');
    require_once('../class/db/TodoItems.php');
    require_once('../class/util/Security.php');
    require_once('../class/util/Config.php');
    Security::session();
    // $p_token = Security::makeToken();
    // $datetime = Config::dateTime();
    $get = Security::sanitize($_GET);

    unset($_SESSION['post']); // いらない気がする

    // /ログインされていない場合はログイン画面にリダイレクトする
    if (empty($_SESSION['user'])) {
        header('Location:./login/index.php');
        exit();
    }

    $post = Security::sanitize($_POST);
    $_SESSION['data'] = $post;
// デバッグ用 //
echo'<pre>';
var_dump($_SESSION['data']);
echo'</pre>';
////////////////
    // パスワード不一致時のエラーメッセージを代入
    // if (isset($_SESSION['err']['pass']) ? $errMsg = $_SESSION['err']['pass'] : $errMsg = '');

    // バリデーションNGで戻ってきた時は、あらかじめ入力項目を入力した状態にしておく

    // isset($_SESSION['data']['user']) ? $user = $_SESSION['data']['user'] : $user = '';
    // isset($_SESSION['data']['family_name']) ? $family_name = $_SESSION['data']['family_name'] : $family_name = '';
    // isset($_SESSION['data']['first_name']) ? $first_name = $_SESSION['data']['first_name'] : $first_name = '';
    isset($_SESSION['data']['is_admin']) && $_SESSION['data']['is_admin'] == 1 ? $is_admin = 'checked="checked"' : $is_admin = '';
    isset($_SESSION['data']['is_deleted']) && $_SESSION['data']['is_deleted'] == 1 ? $is_deleted = 'checked="checked"' : $is_deleted = '';
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
    <title>編集内容確認</title>
</head>

<body>
    <!-- ナビゲーション -->
    <nav class="navbar navbar-expand-md navbar-dark bg-primary">
        <span class="navbar-brand">ユーザ一覧</span>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="../todo/index.php">作業一覧 <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../todo/entry.php">作業登録</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?= $_SESSION['user']['family_name'] . $_SESSION['user']['first_name'] . 'さん' ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="./login/logout.php">ログアウト</a>
                        <a class="dropdown-item <?= $_SESSION['user']['is_admin'] != 1 ? 'collapse' : '' ?>" href="../login/user_edit.php">ユーザ管理</a>
                    </div>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0" action="./" method="get">
                <!-- 今は使用できません、検索結果一覧の表示ページを作成する必要がある -->
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
    <!-- フシギダネの msg 表示 ここまで -->

    <!-- 確認を促すメッセージ -->
    <div class="row my-2">
        <div class="col-sm-3"></div>
        <div class="col-sm-6 alert alert-info alert-dismissble fade show">
            <!-- <button class="close" data-dismiss="alert">&times;</button> -->
            <p>以下の内容で更新します</p>
        </div>
        <div class="col-sm-3"></div>
    </div>
    <!-- 確認を促すメッセージ ここまで -->

    <!-- ユーザ登録情報の入力ブロック -->
    <div class="row my-2">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <form action="./user_edit_action.php" method="post">
                <input type="hidden" name="token" value="<?= $p_token ?>">
                <div class="form-group">
                    <label for="user">ユーザー名</label>
                    <input disabled type="text" class="form-control" id="user" name="user" value="<?= $post['user'] ?>">
                </div>

                <!-- パスワードの変更は本人しか出来ないようにするべきではないか？ -->
                <!-- <div class="form-group">
                    <label for="pass">パスワード</label>
                    <input type="password" class="form-control" id="pass" name="pass">
                </div>
                <div class="form-group">
                    <label for="pass2">パスワード(再確認用)</label>
                    <input type="password" class="form-control" id="pass2" name="pass2" aria-describedby="passCheck">
                    <div id="passCheck" class="form-text text-danger"><= $errMsg ?></div>
                </div> -->

                <div class="form-group">
                    <label for="family_name">姓</label>
                    <input disabled type="text" class="form-control" id="family_name" name="family_name" value="<?= $post['family_name'] ?>">
                </div>
                <div class="form-group">
                    <label for="first_name">名</label>
                    <input disabled type="text" class="form-control" id="first_name" name="first_name" value="<?= $post['first_name'] ?>">
                </div>
                <div class="form-group form-check">
                    <!-- <input type="hidden" value="0" id="is_admin" name="is_admin"> -->
                    <input disabled type="checkbox" value="1" <?= $is_admin ?> class="form-check-input" id="is_admin" name="is_admin">
                    <label for="is_admin">管理者権限を与える</label>
                </div>
                <div class="form-group form-check">
                    <!-- <input type="hidden" value="0" id="is_deleted" name="is_deleted"> -->
                    <input disabled type="checkbox" value="1" <?= $is_deleted ?> class="form-check-input" id="is_deleted" name="is_deleted">
                    <label for="is_deleted">ユーザを削除する</label>
                </div>
                <br>
                <button type="submit" class="btn btn-primary">更新</button>
                <input type="button" value="キャンセル" class="btn btn-outline-primary" onclick="location.href='./user_edit.php';">
            </form>
        </div>
        <div class="col-sm-3"></div>
    </div>

    <!-- ユーザ登録情報の入力ブロック ここまで -->




    <!-- 表示させたメッセージは最後に消しておく -->
    <?php unset($_SESSION['err']) ?>

    <!-- 必要なJavascriptを読み込む -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>

</body>

</html>