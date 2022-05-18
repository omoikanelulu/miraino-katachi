<?php
class TodoItems extends Base
{
    /**
     * DBへ接続するコンストラクタ
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * ToDoを追加する
     * @param array $post
     * サニタイズした配列を入れる
     */
    public function dbAdd($post)
    {
        $sql = 'INSERT INTO todo_items (user_id,registration_date,expire_date,item_name) VALUES (:user_id,:registration_date,:expire_date,:item_name)';

        $stmt = $this->dbh->prepare($sql);

        // SQL文の該当箇所に、変数の値を割り当て（バインド）する
        $stmt->bindValue(':user_id', $post['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':registration_date', $post['registration_date'], PDO::PARAM_STR);
        $stmt->bindValue(':expire_date', $post['expire_date'], PDO::PARAM_STR);
        $stmt->bindValue(':item_name', $post['item_name'], PDO::PARAM_STR);

        $stmt->execute();
    }

    /**
     * 一覧を取得しreturnする
     * 取得するテーブルはtodo_itemsとusersのふたつ
     */
    public function dbAllSelect()
    {
        // 全部入りSELECT
        // $sql = 'SELECT * FROM todo_items INNER JOIN users ON todo_items.user_id = users.id ORDER BY todo_items.expire_date ASC';

        // 必要そうなの絞ったSELECT
        // $sql = 'SELECT todo_items.id, todo_items.user_id, todo_items.item_name, todo_items.registration_date, todo_items.expire_date, todo_items.finished_date, todo_items.is_deleted, users.id, users.family_name, users.first_name FROM todo_items INNER JOIN users ON todo_items.user_id = users.id ORDER BY todo_items.expire_date ASC';

        $sql = 'SELECT';
        $sql .= ' todo_items.id';// こいつと
        $sql .= ',todo_items.user_id';// これが一緒になっとる？
        $sql .= ',todo_items.item_name';
        $sql .= ',todo_items.registration_date';
        $sql .= ',todo_items.expire_date';
        $sql .= ',todo_items.finished_date';
        $sql .= ',todo_items.is_deleted';
        $sql .= ',users.id';// これが取れていない
        $sql .= ',users.family_name';
        $sql .= ',users.first_name';
        $sql .= ' FROM todo_items INNER JOIN users ON todo_items.user_id = users.id';
        $sql .= ' ORDER BY todo_items.expire_date ASC';

        $stmt = $this->dbh->prepare($sql);


        $stmt->execute();

        // 取得したレコードを連想配列として取得
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * 削除ボタンを押したToDoを表示する
     */
    public function dbDeleteConfirmation($id)
    {
        $sql = 'SELECT * FROM todo_items WHERE id=:id';

        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // 取得したレコードを連想配列として取得
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * 削除する
     */
    public function dbDelete($is_deleted, $id)
    {
        // $sql = 'DELETE FROM todo_items WHERE todo_items.id=:id';
        $sql = 'UPDATE todo_items SET is_deleted=:is_deleted WHERE todo_items.id=:id';

        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':is_deleted', $is_deleted, PDO::PARAM_INT);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * UPDATEする
     */
    public function dbUpdate()
    {
        $sql = 'UPDATE todo_items SET is_completed=:is_completed WHERE todo_items.id =:id';

        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':is_completed', $_POST['is_completed'], PDO::PARAM_INT);
        $stmt->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * csvファイルからUPDATEする
     */
    public function dbCsvUpdate(int $id, string $expire_date, string $item_name, int $is_completed)
    {
        $sql = 'UPDATE todo_items SET expire_date=:expire_date, item_name=:item_name, is_completed=:is_completed WHERE id=:id';

        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':expire_date', $expire_date, PDO::PARAM_STR);
        $stmt->bindValue(':item_name', $item_name, PDO::PARAM_STR);
        $stmt->bindValue(':is_completed', $is_completed, PDO::PARAM_INT);

        $stmt->execute();
    }
}
