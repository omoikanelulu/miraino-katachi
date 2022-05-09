<?php

class Security
{
    /**
     * CSRF（クロスサイトリクエストフォージェリ）対策
     * 送信側でトークンを作成しSESSIONに保存
     */
    static public function makeToken(): string
    {
        $token = bin2hex(openssl_random_pseudo_bytes(32));
        $_SESSION['token'] = $token;
        return $token;
    }

    /**
     * CSRF（クロスサイトリクエストフォージェリ）対策
     * 受信側では、$_SESSION['token']と$_POST['token']が同一であるかチェックする
     */
    static public function checkToken($s_token, $p_token): bool
    {
        if (!isset($s_token) || $s_token !== $p_token) {
            return false;
        }
        return true;
    }

    /**
     * XSS（クロスサイトスクリプティング）対策
     * 受け取ったデータをサニタイズする
     */
    // static public function sanitize($post)
    // type error になる
    // {
    //     htmlspecialchars($post, ENT_HTML5, 'UTF-8', true);
    //     return $post;
    // }

    // スクリプトが荒ぶる
    static public function sanitize($post)
    {
        foreach ($post as $key => $v) {
            $post[$key] = htmlspecialchars($v);
        }
        return $post;
    }
}
