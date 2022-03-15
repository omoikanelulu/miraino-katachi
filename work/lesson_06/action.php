<?php

session_start();
session_regenerate_id(true);

$_SESSION['str1'] = $_POST['str1'];



?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrapの読み込み -->
    <link rel="stylesheet" href="./css/bootstrap.css">
    <!-- jqueryとbootstrapの読み込み -->
    <script src="./js/jquery-3.6.0.js"></script>
    <script src="./js/bootstrap.bundle.js"></script>

    <title>練習問題06</title>
</head>

<body>
    <!-- $str1が空だったら処理しない -->
    <div class="container">
        <?php if ($_SESSION['str1'] == '') : ?>
        <?php else : ?>
            <h3>設問01</h3><br>
            <table class="table">
                <thead>
                    <tr>
                        <th>文字を出力</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $_SESSION['str1'] ?></td>
                    </tr>
                </tbody>
            </table>
            <a href="./index.php">設問01用 戻る</a>
        <?php endif ?>

        <!-- $str3が空だったら処理しない -->
        <?php if ($str3 == '') : ?>
        <?php else : ?>
            <h3>設問03</h3><br>
            <table class="table">
                <thead>
                    <tr>
                        <th>文字数</th>
                        <th>最初の文字</th>
                        <th>最後の文字</th>
                    </tr>
                </thead>
                <tbody>
                    <h4><?= $str3 ?></h4>
                    <tr>
                        <td><?= mb_strlen($str3) ?></td>
                        <td><?= mb_substr($str3, 0, 1) ?></td>
                        <td><?= mb_substr($str3, -1, 1) ?></td>
                    </tr>
                </tbody>
            </table>
        <?php endif ?>

        <!-- $str4が空だったら処理しない -->
        <?php if ($str4 == '') : ?>
        <?php else : ?>
            <h3>設問04</h3><br>
            <table class="table">
                <thead>
                    <tr>
                        <th>文章</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $str4 ?></td>
                    </tr>
                </tbody>
            </table>
        <?php endif ?>

        <!-- $str5が空だったら処理しない -->
        <?php if ($str5 == '') : ?>
        <?php else : ?>
            <h3>設問05</h3><br>
            <table class="table">
                <thead>
                    <tr>
                        <th>「<?= $str5 ?>」を正規表現で判断します</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (preg_match('/^[0-9]+$/', $str5)) : ?>
                        <tr>
                            <td><?= 'これは数字のみです' ?></td>
                        </tr>
                    <?php else : ?>
                        <tr>
                            <td><?= 'これはその他です' ?></td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>

            <table class="table">
                <thead>
                    <tr>
                        <th>「<?= $str5 ?>」をis_numericで判断します</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (is_numeric($str5)) : ?>
                        <tr>
                            <td><?= 'これは数字のみです' ?></td>
                        </tr>
                    <?php else : ?>
                        <tr>
                            <td><?= 'これはその他です' ?></td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
        <?php endif ?>

        <!-- $str6が空だったら処理しない -->
        <?php if ($date6 == '') : ?>
        <?php else : ?>
            <h3>設問06</h3><br>
            <?php c_date($date6) ?>
        <?php endif ?>

        <!-- $str7が空だったら処理しない -->
        <?php if ($str7count == '') : ?>
        <?php else : ?>
            <h3>設問07</h3><br>
            <!-- きっちりと改行コードはカウントせずに文字数だけカウントしたかったが断念 -->
            <?php $str7count = str_replace('\n\r', '', $str7count) ?>
            <?php $mojisu = mb_strlen($str7count) ?>

            <table class="table">
                <thead>
                    <tr>
                        <th>文字数を判定します</th>
                    </tr>
                </thead>
                <h4>文字数「<?= $mojisu ?>」</h4>
                <p>文字列<br><?= $str7show ?></p>
                <tbody>
                    <?php if ($mojisu < 51) : ?>
                        <tr>
                            <td><?= '文字数は50文字未満です' ?></td>
                        </tr>
                    <?php else : ?>
                        <tr>
                            <td><?= '文字数は50文字を超えています' ?></td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
        <?php endif ?>







        <!-- 戻るボタン -->
        <br><br>
        <input type="button" onclick="history.back()" value="戻る">
    </div>

</body>

</html>