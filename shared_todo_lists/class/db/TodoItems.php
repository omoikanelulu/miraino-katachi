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
        $sql = 'INSERT INTO';
        $sql .= ' todo_items (user_id,registration_date,expire_date,item_name,finished_date)';
        $sql .= ' VALUES (:user_id,:registration_date,:expire_date,:item_name,:finished_date)';

        $stmt = $this->dbh->prepare($sql);

        // SQL文の該当箇所に、変数の値を割り当て（バインド）する
        $stmt->bindValue(':user_id', $post['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':registration_date', $post['registration_date'], PDO::PARAM_STR);
        $stmt->bindValue(':expire_date', $post['expire_date'], PDO::PARAM_STR);
        $stmt->bindValue(':item_name', $post['item_name'], PDO::PARAM_STR);
        $stmt->bindValue(':finished_date', $post['finished_date'], PDO::PARAM_STR);

        $stmt->execute();
    }

    /**
     * 一覧を取得しreturnする
     * 取得するテーブルはtodo_itemsとusersのふたつ
     * 削除フラグが1の物は除外する
     */
    public function dbAllSelect()
    {
        $sql = 'SELECT';
        $sql .= ' todo_items.id';
        $sql .= ',todo_items.user_id';
        $sql .= ',todo_items.item_name';
        $sql .= ',todo_items.registration_date';
        $sql .= ',todo_items.expire_date';
        $sql .= ',todo_items.finished_date';
        $sql .= ',todo_items.is_deleted';
        $sql .= ',users.family_name';
        $sql .= ',users.first_name';
        $sql .= ' FROM todo_items INNER JOIN users ON todo_items.user_id = users.id';
        $sql .= ' WHERE todo_items.is_deleted = 0';
        $sql .= ' ORDER BY todo_items.expire_date ASC, todo_items.finished_date ASC, todo_items.item_name ASC';

        $stmt = $this->dbh->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * searchに入力した文字列がitem_name内に存在するか
     * あいまい検索する
     */
    public function dbSearch($get)
    {
        $sql = 'SELECT';
        $sql .= ' todo_items.id';
        $sql .= ',todo_items.user_id';
        $sql .= ',todo_items.item_name';
        $sql .= ',todo_items.registration_date';
        $sql .= ',todo_items.expire_date';
        $sql .= ',todo_items.finished_date';
        $sql .= ',todo_items.is_deleted';
        $sql .= ',users.family_name';
        $sql .= ',users.first_name';
        $sql .= ' FROM todo_items INNER JOIN users ON todo_items.user_id = users.id';
        $sql .= ' WHERE todo_items.is_deleted = 0';
        $sql .= ' AND (todo_items.item_name LIKE :get OR users.family_name LIKE :get OR users.first_name LIKE :get)';
        $sql .= ' ORDER BY todo_items.expire_date ASC, todo_items.finished_date ASC, todo_items.item_name ASC';

        $stmt = $this->dbh->prepare($sql);
        // あいまい検索用の変数はここで括る
        $stmt->bindValue(':get', '%' . $get . '%', PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * 引数に入れた['item_id']のToDoを表示する（1レコードだけ）
     * @param int item_id
     */
    public function dbConfirmation($id)
    {
        $sql = 'SELECT';
        $sql .= ' todo_items.id';
        $sql .= ',todo_items.user_id';
        $sql .= ',todo_items.item_name';
        $sql .= ',todo_items.registration_date';
        $sql .= ',todo_items.expire_date';
        $sql .= ',todo_items.finished_date';
        $sql .= ',todo_items.is_deleted';
        $sql .= ',users.family_name';
        $sql .= ',users.first_name';
        $sql .= ' FROM todo_items INNER JOIN users ON todo_items.user_id = users.id';
        $sql .= ' WHERE todo_items.id=:id';
        $sql .= ' ORDER BY todo_items.expire_date ASC';

        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * 削除する（削除フラグを立てる）
     */
    public function dbDelete($is_deleted, $id)
    {
        $sql = 'UPDATE todo_items SET is_deleted=:is_deleted WHERE todo_items.id=:id';

        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':is_deleted', $is_deleted, PDO::PARAM_INT);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();
    }

    /**
     * 修正ボタンを押した
     */
    public function dbUpdate($post)
    {
        $sql = 'UPDATE todo_items';
        $sql .= ' SET';
        $sql .= ' item_name=:item_name';
        $sql .= ',user_id=:user_id';
        $sql .= ',expire_date=:expire_date';
        $sql .= ',finished_date=:finished_date';
        $sql .= ' WHERE todo_items.id =:id';

        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':item_name', $post['item_name'], PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $post['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':expire_date', $post['expire_date'], PDO::PARAM_STR);
        $stmt->bindValue(':finished_date', $post['finished_date'], PDO::PARAM_STR);
        $stmt->bindValue(':id', $post['item_id'], PDO::PARAM_INT);

        $stmt->execute();
    }

    /**
     * 完了ボタンを押した
     */
    public function dbIsComp($post)
    {
        $sql = 'UPDATE todo_items';
        $sql .= ' SET';
        $sql .= ' finished_date=:finished_date';
        $sql .= ' WHERE todo_items.id =:id';

        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':finished_date', $post['finished_date'], PDO::PARAM_STR);
        $stmt->bindValue(':id', $post['item_id'], PDO::PARAM_INT);

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
