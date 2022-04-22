<?php
require_once('./variables.php');
require_once('./class/db/Base.php');
require_once('./class/db/Todoitems.php');

session_start();
session_regenerate_id(true);

if (isset($_SESSION['error'])) {
    unset($_SESSION['error']);
}

// $id = $_POST['id'];
// $is_completed = $_POST['is_completed'];
// $delete = $_POST['delete'];
// $input_date = $_POST['input_date'];

try {
    // DBへの接続
    $db = new TodoItems;
    

    // SQLでDBエンジンに指示
    // 削除チェックが入っていた場合
    // if (isset($_POST['delete']) && $_POST['delete'] == '1') {
        $this->db->dbDelete();
    // } else {
        // 削除チェックがない場合はis_completedをUPDATEする
        $this->db->dbUpdate();
    // }
    // $stmt->execute();

    // DBから切断
    // $dbh = null;
    header('Location: ./index.php');
    // header('Location: ./test.php');
    // throw new Exception('動いていません');
    // exit();
} catch (Exception $e) {
    var_dump($e);
    echo '<br><br>';
    echo '障害発生につきご迷惑をおかけしております<br>';
    echo '<br><br>';
    echo '<a href="./index.php">index.phpへ</a>';
    exit();
}
