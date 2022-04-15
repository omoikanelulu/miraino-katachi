<?php
$title = 'lesson_11_04';

session_start();
session_regenerate_id(true);

if (isset($_SESSION['error'])) {
    unset($_SESSION['error']);
}

$id = $_POST['id'];
$is_completed = $_POST['is_completed'];
$delete = $_POST['delete'];
$input_date = $_POST['input_date'];

// try {
//     function input_date_check($i)
//     {
//         $i = explode('/', $i);
//         return checkdate($i['1'], $i['2'], $i['0']);
//     }

//     $result = input_date_check($input_date);

//     if ($result == 1) {
//         echo '<p>正常な日付です</p>';
//     } else {
//         throw new Exception('日付が正しくありません');
//     }
// } catch (Exception $e) {
//     $_SESSION['error']['msg'] = $e->getMessage();
//     $_SESSION['error']['date'] = $input_date();
//     exit();
// }









try {
    // DBへの接続
    $dsn = 'mysql:dbname=php_work;host=localhost;port=3306;charset=utf8';
    $user = 'root';
    $password = '0971790';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQLでDBエンジンに指示
    // 削除チェックが入っていた場合
    if (isset($delete) && $delete == '1') {
        $sql = 'DELETE FROM todo_items WHERE todo_items.id = :id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':id', "$id", PDO::PARAM_INT);
    } else {
        // 削除チェックがない場合はis_completedをUPDATEする
        $sql = 'UPDATE todo_items SET is_completed = :is_completed WHERE id = :id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':is_completed', "$is_completed", PDO::PARAM_INT);
        $stmt->bindValue(':id', "$id", PDO::PARAM_INT);
    }
    $stmt->execute();

    // DBから切断
    $dbh = null;
    header('Location: ./index.php');
    // header('Location: ./test.php');
    // throw new Exception('動いていません');
    // exit();
} catch (Exception $e) {
    echo $e;
    echo '<br><br>';
    echo '障害発生につきご迷惑をおかけしております<br>';
    echo '<br><br>';
    echo '<a href="./index.php">index.phpへ</a>';
    exit();
}
