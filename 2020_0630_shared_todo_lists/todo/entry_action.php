<?php
try {
    require_once('../class/db/Base.php');
    require_once('../class/db/Users.php');
    require_once('../class/db/TodoItems.php');
    require_once('../class/util/Security.php');
    require_once('../class/util/Validation.php');
    Security::session();
    Security::notLogin();

    unset($_SESSION['err'], $_SESSION['success']);

    // サニタイズで無害な文字列に変換
    $post = Security::sanitize($_POST);

    $userIns = new Users;
    $userInfo = $userIns->dbAllSelect();

    // バリデーションするメソッドを呼び出す
    // エラーがあったかどうかのフラグ 初期値はfalse
    $hasErr = false; // エラーなし

    if (Validation::lengthLimit($post['item_name']) == true) {
        $hasErr = true;
        $_SESSION['err']['length'] = 'ToDo内容が正しくありません、文字数は100文字以下にしてください';
    }

    if (Validation::checkCorrectDate($post['expire_date']) == true) {
        $hasErr = true;
        $_SESSION['err']['date'] = '正しい日付ではありません';
    }

    if (Validation::isSelectedRep($post['user_id']) == true) {
        $hasErr = true;
        $_SESSION['err']['noRep'] = '担当者を選択してください';
    }

    if (Validation::registeredCheck($userInfo, $post['user_id']) == true) {
        $hasErr = true;
        $_SESSION['err']['unRegRep'] = '登録されていない担当者です';
    }

    // バリデーションの結果、エラーがあったらリダイレクト後に表示する
    if ($hasErr == true) {
        header('Location:./entry.php');
        exit();
    }


    // ここから旧バリデーション_メソッド化する前

    // if (mb_strlen($post['item_name']) >= 100 || $post['item_name'] == '') {
    //     $_SESSION['err']['length'] = 'ToDoが入力されていません、もしくは文字数は100文字以下にしてください';
    //     $hasErr = true;
    // }

    /**
     * 正しい年月日かチェック
     * checkdate(int $month, int $day, int $year): bool
     */
    // list($year, $month, $day) = explode('-', $post['expire_date']);
    // if (!checkdate($month, $day, $year)) {
    //     $_SESSION['err']['date'] = '正しい日付ではありません';
    //     $hasErr = true;
    // }

    /**
     * 担当者を選択しているか
     */
    // if (empty($post['user_id'])) {
    //     $_SESSION['err']['noRep'] = '担当者を選択してください';
    //     $hasErr = true;
    // }

    /**
     * DBに登録されている担当者か確認する
     */
    // foreach ($userInfo as $info => $v) {
    //     if ($post['user_id'] != ($v['id'])) {
    //         $_SESSION['err']['unRegRep'] = '登録されていない担当者です';
    //         $hasErr = true;
    //     } else {
    //         $hasErr = false;
    //         break;
    //     }
    // }

    // ToDoの新規追加を行う
    $add = new TodoItems;
    $add->dbAdd($post);

    header('Location:./index.php');
    exit();
} catch (Exception $e) {
    header('Location:../error/error.php');
    exit();
}
