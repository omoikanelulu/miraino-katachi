<?php
class Users extends Base
{
    /**
     * DBへ接続するコンストラクタ
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 一覧を取得しreturnする
     */
    public function dbAllSelect(): array
    {
        $sql = 'SELECT * FROM users ORDER BY id ASC';

        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * DBのuserに重複があるか確認
     * @param string $user
     * @return bool
     * true 重複あり false 重複なし
     */
    public function dbDupUser(string $user): bool
    {
        $sql = 'SELECT * FROM users WHERE user=:user';
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':user', $user, PDO::PARAM_STR);
        $stmt->execute();
        // DBに存在したレコードが入る
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($rec)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * DBのusersテーブルからuserを探す
     * @return $rec 該当したレコードが入る
     */
    public function dbFindUser($user)
    {
        $sql = 'SELECT * FROM users WHERE user=:user';
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':user', $user['user'], PDO::PARAM_STR);
        $stmt->execute();
        // 該当したレコードが入る
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
        // 見つからなかった時のメッセージ
        if (empty($rec)) {
            $_SESSION['err']['msg'] = 'ご登録されていないようです';

            // $_SESSION['loginFailure']++;
            header('Location:../login/index.php');
            exit();
        } else {
            // 本人確認
            $result = password_verify($user['pass'], $rec['pass']);
            if ($result) {
                $_SESSION['user'] = $rec;
                unset($_SESSION['err']['msg']);
                header('Location:../todo/index.php');
                exit();
            } else {
                $_SESSION['err']['msg'] = 'IDかパスワードが間違っています';

                // $_SESSION['loginFailure']++;

                header('Location:../login/index.php');
                exit();
            }
        }
    }

    /**
     * user情報を登録
     * @param array $post サニタイズ済みのデータ
     * @return bool true
     */
    public function dbAdd($post): bool
    {
        // passをハッシュ化する
        $post['pass'] = password_hash($post['pass'], PASSWORD_DEFAULT);

        $sql = 'INSERT INTO users (user, pass, name) VALUES(:user, :pass, :name)';

        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':user', $post['user'], PDO::PARAM_STR);
        $stmt->bindValue(':pass', $post['pass'], PDO::PARAM_STR);
        // $stmt->bindValue(':name', $post['name'], PDO::PARAM_STR);

        $stmt->execute();

        $_SESSION['success']['msg'] = '登録完了しました';

        return true;
    }

    /**
     * 会員情報削除
     */
    public function dbDelete()
    {
        $sql = 'DELETE FROM users WHERE(:name, :pass)';

        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':pass', $_POST['pass'], PDO::PARAM_STR);
        // $stmt->bindValue(':name', $_POST['name'], PDO::PARAM_STR);

        $stmt->execute();
    }
}