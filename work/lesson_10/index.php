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
    </style>
    <title>練習問題_10</title>
</head>

<body class="container m-3">
    <header>
        <h2>ファイルのアップロード</h2><br><br>
        <p>アップロードしたファイルは一時フォルダに保存される</p><br>
        <p>一時フォルダから保存したいフォルダへ移動させる必要がある</p><br>
        <p>一時フォルダに保存されたファイルはセッションが終了(プログラムが終了)すると削除されてしまう</p><br>
    </header>
    <main>
        <h4>アップロードするファイルを選択する</h4>
        <form action="./action.php" method="POST" enctype="multipart/form-data">
            <div class="card">
                <div class="card-body">
                    <input type="file" name="userfile">
                    <input type="submit" value="送信">
                </div>
            </div>
        </form>
    </main>
    <footer>
    </footer>
</body>

</html>