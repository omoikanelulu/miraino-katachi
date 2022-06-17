<?php

class Security
{
    /**
     * セッションを開始する
     */
    public static function session()
    {
        session_start();
        session_regenerate_id(true);
    }

    /**
     * ログインされていない場合はindexにリダイレクトさせる
     * 同一ディレクトリのindexであるため注意
     */
    public static function notLogin()
    {
        if (empty($_SESSION['user'])) {
            header('Location:./index.php');
        }
    }

    /**
     * CSRF（クロスサイトリクエストフォージェリ）対策
     * $_SESSION['token']に保存
     */
    public static function makeToken(): string
    {
        $token = bin2hex(openssl_random_pseudo_bytes(32));
        $_SESSION['token'] = $token;
        return $token;
    }

    /**
     * CSRF（クロスサイトリクエストフォージェリ）対策
     * 受信側では、$_SESSION['token']と$_POST['token']が同一であるかチェックする
     * @param string $p_token ポストされてきたワンタイムトークン
     */
    public static function checkToken($p_token): bool
    {
        if (!isset($_SESSION['token']) || $_SESSION['token'] !== $p_token) {
            return false;
        }
        return true;
    }

    /**
     * XSS（クロスサイトスクリプティング）対策
     * 受け取ったデータをサニタイズする
     */
    public static function sanitize($post)
    {
        foreach ($post as $key => $v) {
            // $post[$key] = htmlspecialchars($v, ENT_HTML5, 'UTF-8', true);
            // オプションは無しでもいけるはず
            $post[$key] = htmlspecialchars($v);
        }
        return $post;
    }

}
