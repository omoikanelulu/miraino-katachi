<?php
class Base
{
    /**
     * データベースの情報
     * プロパティ
     */
    const DB_NAME = 'todo';
    const DB_HOST = 'localhost';
    const DB_USER = 'root';
    const DB_PASS = '0971790';

    protected $dbh;

    /**
     * データベースに接続するコンストラクタ
     */
    public function __construct()
    {
        $dsn = 'mysql:dbname=' . self::DB_NAME . ';host=' . self::DB_HOST . ';port=3306;charset=utf8';
        $this->dbh = new PDO($dsn, self::DB_USER, self::DB_PASS);
        // エラーモードの設定
        $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}
