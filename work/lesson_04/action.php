<?php
$post = $_POST['checkMenu'];

// デバッグ用 //
// print_r($_POST['checkMenu']);
// exit();
////////////////

// デバッグ用 //
var_dump($_POST['checkMenu']);
exit();
////////////////

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>checkboxで選択</title>
</head>

<body>
    <h3>選択したメニューはこちらです</h3>


    <table>
        <?php foreach ($post as $value) : ?>
            <td><?php echo $value ?></td><br>
        <?php endforeach ?>
    </table>

</body>

</html>


<br><br>
<input type="button" onclick="history.back()" value="戻る">