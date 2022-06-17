<?php
try {
    require_once('../class/db/Base.php');
    require_once('../class/db/Users.php');
    require_once('../class/db/TodoItems.php');
    require_once('../class/util/Security.php');
    require_once('../class/util/Validation.php');
    Security::session();
    Security::notLogin();
    $post = Security::sanitize($_POST);

    $userIns = new Users;
    $userInfo = $userIns->dbAllSelect();



    if (!Security::checkToken($_POST['token'])) {
        $_SESSION['err']['msg'] = 'ワンタイムトークンが一致しません';
        header('Location:../error/error.php');
        exit();
    }

    // $_POSTされた情報を$_SESSIONに保存する
    $_SESSION['post'] = $post;
    $_SESSION['post']['finished_date'] = !empty($post['finished_date']) ? $post['finished_date'] : null;

    unset($_SESSION['err'], $_SESSION['success']);




    // バリデーション処理のメソッドを呼び出す
    // エラーがあったかどうかのフラグ 初期値はfalse
    $hasErr = false; // エラーなし

    if (Validation::lengthLimit($post['item_name']) == true) {
        $hasErr = true;
        $_SESSION['err']['length'] = 'ToDo内容が正しくありません、文字数は100文字以下にしてください';
    }

    if (Validation::isSelectedRep($post['user_id']) == true) {
        $hasErr = true;
        $_SESSION['err']['noRep'] = '担当者を選択してください';
    }

    if (Validation::registeredCheck($userInfo, $post['user_id']) == true) {
        $hasErr = true;
        $_SESSION['err']['unRegRep'] = '登録されていない担当者です';
    }

    if (Validation::checkCorrectDate($post['expire_date']) == true) {
        $hasErr = true;
        $_SESSION['err']['date'] = '正しい日付ではありません';
    }

    // バリデーションの結果、エラーがあったらリダイレクト後に表示する
    if ($hasErr == true) {
        // $_SESSION['post']['item_id'] = $post['item_id'];
        header('Location:./edit.php');
        exit();
    }


    $todoIns = new TodoItems;
    $todoItem = $todoIns->dbUpdate($post);

    $_SESSION['success']['msg'] = '修正しました';
    header('Location:./index.php');
    exit();
} catch (Exception $e) {
    header('Location:../error/error.php');
    exit();
}
