<?php
session_start();
session_regenerate_id(true);
require_once('./variables.php');
require_once('./class/db/Base.php');
require_once('./class/db/Users.php');
require_once('./class/util/Security.php');

$token = Security::makeToken();
// tokenデバッグ用 //
// var_dump($_SESSION['token']);
// echo '<br>';
// var_dump($token);
// exit();
////////////////


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
            /* 打ち消し線を入れる */
            text-decoration-line: line-through;
        }

        span {
            font-size: 3rem;
        }

        .box100 {
            /* 横幅を100%にする */
            width: 100%;
        }
    </style>
    <title><?= $title ?></title>
</head>

<body>
    <div class="container">
        <header>
        </header>
        <main>
            <div class="row">
                <div class="col-sm-1 col-md-3"></div>
                <div class="card col-sm-10 col-md-6 p-0">
                    <h5 class="card-header bg-info"><span>ユ</span>ーザ登録</h5>
                    <div class="card-body">



                        <!-- $_SESSIONのメッセージを表示させる -->
                        <?php if (isset($_SESSION['err']['msg'])) : ?>
                            <div class="alert alert-danger" role="alert">
                                <?= $_SESSION['err']['msg'] ?>
                            </div>
                        <?php elseif (isset($_SESSION['success']['msg'])) : ?>
                            <div class="alert alert-success" role="success">
                                <?= $_SESSION['success']['msg'] ?>
                            </div>
                        <?php endif ?>
                        <!-- $_SESSIONの内容を消す -->
                        <?php unset($_SESSION['err']['msg'], $_SESSION['success']['msg']); ?>




                        <form action="user_add_action.php" method="post">
                            <label class="d-block" for="email">
                                <p class="card-text" id="email"><span>メ</span>ールアドレス</p>
                                <input class="box100" type="text" name="email" id="email">
                            </label>
                            <label class="d-block" for="password">
                                <p class="card-text" id="password"><span>パ</span>スワード</p>
                                <input class="box100" type="password" name="password" id="password">
                            </label>
                            <label class="d-block" for="name">
                                <p class="card-text" id="name"><span>お</span>名前</p>
                                <input class="box100" type="text" name="name" id="name">
                            </label>
                            <br>
                            <input class="btn btn-primary" type="submit" value="登録">
                            <i class="float-end nes-bulbasaur"></i>
                            <input type="hidden" name="token" value="<?= $token ?>">
                        </form>
                    </div>
                </div>
                <div class="col-sm-1 col-md-3"></div>
            </div>
            <p><?= htmlspecialchars("<script>while(1){alert('test')}</script>") ?></p>
        </main>
        <footer>
        </footer>
    </div>
</body>

</html>