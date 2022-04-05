<?php

// デバッグ用 //
var_dump($_FILES['userfile']['tmp_name']);
echo '<br>';
var_dump(__DIR__ . '/img/' . $_FILES['userfile']['name']);
exit();
////////////////



// 保存したい保存先を変数に入れるつまり、移動先のpath
$path = __DIR__ . '/img/' . $_FILES['userfile']['name'];
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $path)) {
    echo '成功しました';
} else {
    echo '失敗しました';
}


?>


<br><br>
<a href="./index.php">index.phpへ</a>
