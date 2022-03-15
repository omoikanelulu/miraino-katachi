<?php
session_start();
session_regenerate_id(true);


$carts = $_SESSION['cart'];

// デバッグ用 //
var_dump($carts);
exit();
////////////////
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
        <div class="col-6 accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-heading444">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse444" aria-expanded="false" aria-controls="panelsStayOpen-collapse444">
                    <!-- ボタン -->
                    <h3>設問04 カートの中身</h3>
                </button>
            </h2>
            <div id="panelsStayOpen-collapse444" class="accordion-collapse" aria-labelledby="panelsStayOpen-heading444">
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
                                    <?php foreach ($carts as $cart) : ?>
                                        <tr>
                                            <td>
                                                <?= $cart['product_name'] ?>
                                            </td>
                                            <td>
                                                <?= $cart['price'] ?>円
                                            </td>
                                            <td>
                                                <?= $cart['num'] ?>個
                                            </td>
                                        </tr>
                                    <?php endforeach ?>

                                    <?php foreach ($carts as $cart => $val) : ?>
                                        <tr>
                                            <td>
                                                <?= $val['product_name'] ?>
                                            </td>
                                            <td>
                                                <?= $val['price'] ?>円
                                            </td>
                                            <td>
                                                <?= $val['num'] ?>個
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                            <a href="./cart_show.php">カートを見る</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>