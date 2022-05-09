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

        // 取得したレコードを連想配列として取得？
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * email重複チェック
     * true 重複あり
     * false 重複なし
     */
    public function dbDupMail(string $email): bool
    {
        $sql = 'SELECT * FROM users WHERE email=:email';
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        // DBに存在したレコードが入る
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($rec)) {
            return false;
        } else {
            return true;
            // throw new Exception('だめでしたー');
        }
    }

    /**
     * user存在チェック
     * true 見つけた
     * false 見つからない
     */
    public function dbFindUser(string $userId)
    {
        $sql = 'SELECT * FROM users WHERE email=:email';
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':email', $userId, PDO::PARAM_STR);
        $stmt->execute();
        // DBに存在したレコードが入る
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);

        // 名前が見つからなかった時のメッセージを出す
        if (empty($rec)) {
            $_SESSION['err']['msg'] = 'ご登録されていないようです';
            header('Location:./login.php');
            exit();
        } else {
            // 本人確認
            $result = password_verify($_POST['userPassWord'], $rec['password']);
            if ($result) {



                // $_SESSION['success']['msg'] = "{$rec['name']}様である事が確認出来ました";
                // header('Location:./login.php');
                // exit();
                $_SESSION['user'] = $rec;
                header('Location:./index.php');
                exit();



            } else {
                $_SESSION['err']['msg'] = "パスワードが間違っています...<br>付箋に書いてディスプレイに貼り付けておきましょうね";
                header('Location:./login.php');
                exit();
            }
        }
    }


    /**
     * 会員情報登録
     */
    public function dbAdd(): bool
    {
        // passwordをハッシュ化する
        $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $sql = 'INSERT INTO users (email, password, name) VALUES(:email, :password, :name)';

        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
        $stmt->bindValue(':password', $_POST['password'], PDO::PARAM_STR);
        $stmt->bindValue(':name', $_POST['name'], PDO::PARAM_STR);

        $stmt->execute();

        $_SESSION['success']['msg'] = '登録完了しました';

        return true;
    }

    /**
     * 会員情報削除
     */
    public function dbDelete()
    {
        $sql = 'DELETE FROM users WHERE(:name, :password)';

        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':password', $_POST['password'], PDO::PARAM_STR);
        $stmt->bindValue(':name', $_POST['name'], PDO::PARAM_STR);

        $stmt->execute();
    }
}
