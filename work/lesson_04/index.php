<?php
$array = ['みかん', 'りんご', 'メロン', 'バナナ', 'パイナップル'];
$menus = ['Aランチ', 'Bランチ', 'Cランチ', '唐揚げ定食', 'とんかつ定食', 'エビフライ定食', 'オムライス', 'カレーライス', 'ごはん大', 'ごはん小', 'ビール', '烏龍茶'];

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

    <title>練習問題</title>
</head>

<body>
    <!-- アコーディオンメニューを使用 -->
    <div class="accordion" id="accordionPanelsStayOpenExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="false" aria-controls="panelsStayOpen-collapseOne">
                    <h3>設問01</h3><br>
                </button>
            </h2>
            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">
                <div class="accordion-body">
                    <h4>回答</h4><br>
                    <ul>果物のリスト
                        <?php
                        for ($i = 0; $i < 5; $i++) {
                            echo "<li>{$array[$i]}<br>";
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                    <h3>設問02</h3><br>
                </button>
            </h2>
            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                <div class="accordion-body">
                    <h4>回答</h4><br>
                    <table class="table">
                        <?php
                        foreach ($menus as $value) {
                            echo $value . ' ';
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                    <h3>設問03</h3><br>
                </button>
            </h2>
            <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
                <div class="accordion-body">
                    <h4>回答</h4><br>
                    <table class="table">メニュー<br>
                        <?php
                        foreach ($menus as $key => $value) {
                            echo $key . ' ', $value . '<br>';
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingfour">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapsefour" aria-expanded="false" aria-controls="panelsStayOpen-collapsefour">
                    <h3>設問04</h3><br>
                </button>
            </h2>
            <div id="panelsStayOpen-collapsefour" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingfour">
                <div class="accordion-body">
                    <h4>回答</h4>




                    <?php $i = 0 ?>
                    <form action="./action.php" method="post">
                        <?php foreach ($menus as $value) : ?>
                            <label><input type="checkbox" name="checkMenu" value="<?php $i ?>"><?php echo $value ?></label><br>
                            <?php $i++ ?>
                        <?php endforeach ?>
                        <br><br>
                        <input type="submit" value="送信" class="btn btn-outline-primary">
                    </form>




                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingfive">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapsefive" aria-expanded="false" aria-controls="panelsStayOpen-collapsefive">
                    <h3>設問</h3><br>
                </button>
            </h2>
            <div id="panelsStayOpen-collapsefive" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingfive">
                <div class="accordion-body">
                    <form action="./action.php" method="post">
                        <p>ループ回数を選択（奇数は飛ばします）</p>
                        <br>
                        <select name="kaisu">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                            <option value="25">25</option>
                        </select>
                        <br><br>
                        <input type="submit" value="送信" class="btn btn-outline-primary">
                    </form>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingsix">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapsesix" aria-expanded="false" aria-controls="panelsStayOpen-collapsesix">
                    <h3>設問</h3><br>
                </button>
            </h2>
            <div id="panelsStayOpen-collapsesix" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingsix">
                <div class="accordion-body">
                    <form action="./action.php" method="post">
                        <p>ループ回数を選択</p>
                        <br>
                        <select name="kaisu7">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                            <option value="25">25</option>
                        </select>
                        <br><br>
                        <input type="submit" value="送信" class="btn btn-outline-primary">
                    </form>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingseven">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseseven" aria-expanded="false" aria-controls="panelsStayOpen-collapseseven">
                    <h3>設問</h3><br>
                </button>
            </h2>
            <div id="panelsStayOpen-collapseseven" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingseven">
                <div class="accordion-body">
                    <h4><a href="./kuku3.php">for文を用いた九九の表</a></h4><br><br>
                    <h4><a href="./kuku_comp.php">解答例</a></h4><br><br>
                    <br><br>
                </div>
            </div>
        </div>
    </div>










</body>

</html>