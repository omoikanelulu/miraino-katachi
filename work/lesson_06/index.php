<?php

session_start();
session_regenerate_id(true);

$str1 = $_SESSION['str1'];

$arrays = [['product_name' => 'みかん', 'price' => 300], ['product_name' => 'りんご', 'price' => 500], ['product_name' => 'バナナ', 'price' => 150]];





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

    <!-- アコーディオンメニューを使用 -->
    <div class="container baccordion" id="accordionPanelsStayOpenExample">
        <!-- アコーディオンアイテムのブロック -->
        <div class="col-6 accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-heading111">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse111" aria-expanded="false" aria-controls="panelsStayOpen-collapse111">
                    <!-- ボタン -->
                    <h3>設問01 SESSION変数に保存する</h3>
                </button>
            </h2>
            <div id="panelsStayOpen-collapse111" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-heading111">
                <div class="accordion-body">
                    <!-- 本体 -->
                    <form action="./action.php" method="post">
                        <div class="row">
                            <div class="col">
                                <input type="text" name="str1" value="<?= $str1 ?>" class="form-control" placeholder="文字入力" aria-label="文字入力">
                            </div>
                        </div>
                        <br>
                        <input class="btn btn-primary" type="submit" value="送信">
                    </form>
                </div>
            </div>
        </div>

        <!-- アコーディオンアイテムのブロック -->
        <div class="col-6 accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-heading222">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse222" aria-expanded="false" aria-controls="panelsStayOpen-collapse222">
                    <!-- ボタン -->
                    <h3>設問02 カウントを増やす</h3>
                </button>
            </h2>
            <div id="panelsStayOpen-collapse222" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-heading222">
                <div class="accordion-body">
                    <!-- 本体 -->
                    <div class="row">
                        <div class="col">
                            <?php
                            if (isset($_SESSION['count2']) && isset($_GET['reset'])) {
                                unset($_SESSION['count2']);
                            }

                            // if (isset($_SESSION['count2']) == null) {
                            //     $_SESSION['count2'] = 0;
                            // } else {
                            //     $_SESSION['count2']++;
                            // }

                            // if (!isset($_SESSION['count2'])) {
                            //     $_SESSION['count2'] = 0;
                            // } else {
                            //     $_SESSION['count2']++;
                            // }

                            if (isset($_SESSION['count2']) == false) {
                                $_SESSION['count2'] = 0;
                            } else {
                                $_SESSION['count2']++;
                            }

                            echo '現在のカウンタ:' . $_SESSION['count2'];

                            ?>
                            <br><br>
                            <a href="./">カウントを増やす</a>
                            <a href="./?reset">リセットする</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- アコーディオンアイテムのブロック -->
        <div class="col-6 accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-heading333">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse333" aria-expanded="false" aria-controls="panelsStayOpen-collapse333">
                    <!-- ボタン -->
                    <h3>設問03 04 カート</h3>
                </button>
            </h2>
            <div id="panelsStayOpen-collapse333" class="accordion-collapse" aria-labelledby="panelsStayOpen-heading333">
                <div class="accordion-body">
                    <!-- 本体 -->
                    <div class="row">
                        <div class="col">
                            <table>
                                <thead>
                                    <tr>
                                        <th>商品名</th>
                                        <th>価格</th>
                                        <th>注文数</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($arrays as $array) : ?>
                                        <form action="./cart_add.php" method="POST">
                                            <tr>
                                                <td>
                                                    <?= $array['product_name'] ?>
                                                    <input type="hidden" name="product_name" value="<?= $array['product_name'] ?>">
                                                </td>
                                                <td>
                                                    <?= $array['price'] ?>円
                                                    <input type="hidden" name="price" value="<?= $array['price'] ?>">
                                                </td>
                                                <td><input type="text" name="num" placeholder="注文数" style="width: 5rem; text-align: right;"></td>
                                                <td><input class="btn btn-primary" type="submit" value="カートに入れる"></td>
                                            </tr>
                                        </form>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                            <a href="./cart_show.php">カートを見る</a>
                        </div>
                    </div>
                    <br>
                    <input class="btn btn-primary" type="submit" value="送信">
                </div>
            </div>
        </div>

        <div class="col-6 accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-heading444">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse444" aria-expanded="false" aria-controls="panelsStayOpen-collapse444">
                    <!-- ボタン -->
                    <h3>設問04</h3>
                </button>
            </h2>
            <div id="panelsStayOpen-collapse444" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-heading444">
                <div class="accordion-body">
                    <!-- 本体 -->
                    <form action="./action.php" method="post">
                        <div class="row">
                            <div class="col">
                                <textarea name="str4" cols="40" rows="10" placeholder="改行を含めた文章を入力してください"></textarea>
                            </div>
                        </div>
                        <br>
                        <input class="btn btn-primary" type="submit" value="送信">
                    </form>
                </div>
            </div>
        </div>

        <div class="col-6 accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-heading555">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse555" aria-expanded="false" aria-controls="panelsStayOpen-collapse555">
                    <!-- ボタン -->
                    <h3>設問05</h3>
                </button>
            </h2>
            <div id="panelsStayOpen-collapse555" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-heading555">
                <div class="accordion-body">
                    <!-- 本体 -->
                    <form action="./action.php" method="post">
                        <div class="row">
                            <div class="col">
                                <input type="text" name="str5" placeholder="数字か文字列かを判断します">
                            </div>
                        </div>
                        <!-- 送信ボタン -->
                        <br>
                        <input class="btn btn-primary" type="submit" value="送信">
                    </form>
                </div>
            </div>
        </div>

        <div class="col-6 accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-heading666">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse666" aria-expanded="false" aria-controls="panelsStayOpen-collapse666">
                    <!-- ボタン -->
                    <h3>設問06</h3>
                </button>
            </h2>
            <div id="panelsStayOpen-collapse666" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-heading666">
                <div class="accordion-body">
                    <!-- 本体 -->
                    <form action="./action.php" method="post">
                        <div class="row">
                            <div class="col">
                                <input type="text" name="date6" maxlength="10" placeholder="日付を入力（yyyy/mm/dd）">
                            </div>
                        </div>
                        <!-- 送信ボタン -->
                        <br>
                        <input class="btn btn-primary" type="submit" value="送信">
                    </form>
                </div>
            </div>
        </div>

        <div class="col-6 accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-heading777">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse777" aria-expanded="false" aria-controls="panelsStayOpen-collapse777">
                    <!-- ボタン -->
                    <h3>設問07</h3>
                </button>
            </h2>
            <div id="panelsStayOpen-collapse777" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-heading777">
                <div class="accordion-body">
                    <!-- 本体 -->
                    <form action="./action.php" method="post">
                        <div class="row">
                            <div class="col">
                                <textarea placeholder="入力した文字数を出します" maxlength="100" name="str7" cols="40" rows="10"></textarea>
                            </div>
                        </div>
                        <!-- 送信ボタン -->
                        <br>
                        <input class="btn btn-primary" type="submit" value="送信">
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>