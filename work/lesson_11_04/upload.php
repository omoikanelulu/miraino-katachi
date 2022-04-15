<?php
$title = 'lesson_11_04';

session_start();
session_regenerate_id(true);

$datetime = new DateTime('now', new DateTimeZone('Asia/Tokyo'));
$datetime = $datetime->format('Y-m-d');


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
            text-decoration-line: line-through;
        }
    </style>
    <title><?= $title ?></title>
</head>

<body>
    <header>
    </header>
    <div class="container-md mt-3">
        <div class="card">
            <div class="card-header">
                <div>
                    <h3><?= $title ?></h3>
                    <p>CSVファイルをアップロードする</p>
                    <i class="float-end nes-bulbasaur"></i>
                </div>
            </div>
            <div class="card-body">


                <?php if ($_SESSION['err']['msg']) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $_SESSION['err']['msg'] ?>
                    </div>
                <?php endif ?>

                
                <form action="./update.php" method="POST" enctype="multipart/form-data">
                    <div class="row m-2">
                        <div class="col-md">
                            <label for="userdata">アップロードするファイル</label>
                            <input type="file" name="userdata" id="userdata" class="w-75 nes-input">
                        </div>
                        <div class="col-md-1">
                            <input type="submit" value="送信" class="w-100 nes-btn is-primary">
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <button type="button" onclick="history.back()">戻る</button>
            </div>
        </div>
    </div>
</body>

</html>