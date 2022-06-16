<?php
class database
{
  public $que;
  private $servername = 'localhost';
  private $username = 'root';
  private $password = 'root';
  private $dbname = 'test1';
  private $result = array();
  private $mysqli = '';

  public function __construct()
  {
    $this->mysqli = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
  }

  // 挿入した時の挙動
  public function insert($table, $para = array())
  {
    $table_columns = implode(', ', array_keys($para));
    $table_value = implode("','", $para);

    // SQLのinsert文
    $sql = "INSERT INTO $table($table_columns) VALUES('$table_value')";

    // insertした結果の出力
    $result = $this->mysqli->query($sql);
  }

  // 更新をかけた時の挙動（update）
  public function update($table, $para = array(), $id)
  {
    $args = array();

    foreach ($para as $key => $value) {
      $args[] = "$key = '$value'";
    }

    // update文
    $sql = "UPDATE $table SET " . implode(',', $args);

    // 上記の$sqlにくっつく
    $sql .= " WHERE $id";

    $result = $this->mysqli->query($sql);
  }

  // 削除するときの挙動
  public function delete($table, $id)
  {
    $sql = "DELETE FROM $table";

    $sql .= " WHERE $id";

    $sql;

    $result = $this->mysqli->query($sql);
  }

  public $sql;

  // データ抽出時の挙動
  public function select($table, $rows = "*", $where = null)
  {
    // where句があるときとないときの条件分岐
    if ($where != null) {
      $sql = "SELECT $rows FROM $table WHERE $where";
    } else {
      // where句がない
      $sql = "SELECT $rows FROM $table";
    }

    $this->sql = $result = $this->mysqli->query($sql);
  }

  public function __destruct()
  {
    $this->mysqli->close();
  }
}
