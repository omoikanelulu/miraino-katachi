<?php
class TodoItems extends Base
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 追加する
     */
    public function dbAdd()
    {
        $sql = 'INSERT INTO todo_items (expiration_date,todo_item) VALUES (:expiration_date,:todo_item)';

        $stmt = $this->dbh->prepare($sql);

        // SQL文の該当箇所に、変数の値を割り当て（バインド）する
        $stmt->bindValue(':expiration_date', $_POST['expiration_date'], PDO::PARAM_STR);
        $stmt->bindValue(':todo_item', $_POST['todo_item'], PDO::PARAM_STR);

        $stmt->execute();

        $this->dbh = null;
    }

    /**
     * 一覧を取得しreturnする
     */
    public function dbAllSelect()
    {
        $sql = 'SELECT * FROM todo_items ORDER BY expiration_date ASC';

        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();

        $this->dbh = null;

        // 取得したレコードを連想配列として取得？
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * 削除する
     */
    public function dbDelete()
    {
        $sql = 'DELETE FROM todo_items WHERE todo_items.id=:id';

        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
        $stmt->execute();

        $this->dbh = null;
    }

    /**
     * UPDATEする
     */
    public function dbUpdate()
    {
        $sql = 'UPDATE todo_items SET is_completed=:is_completed WHERE id =:id';

        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':is_completed', $_POST['is_completed'], PDO::PARAM_INT);
        $stmt->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
        $stmt->execute();

        $this->dbh = null;
    }

    /**
     * csvファイルからUPDATEする
     */
    public function dbCsvUpdate(int $id, string $expiration_date, string $todo_item, int $is_completed)
    {
        $sql = 'UPDATE todo_items SET expiration_date=:expiration_date, todo_item=:todo_item, is_completed=:is_completed WHERE id=:id';
        // $sql = 'UPDATE todo_items SET expiration_date=:expiration_date, todo_item=:todo_item, is_completed=:is_completed';
        // $sql .= 'WHERE id = :id';

        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':expiration_date', $expiration_date, PDO::PARAM_STR);
        $stmt->bindValue(':todo_item', $todo_item, PDO::PARAM_STR);
        $stmt->bindValue(':is_completed', $is_completed, PDO::PARAM_INT);

        $stmt->execute();

        $this->dbh = null;
    }
}
