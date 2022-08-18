<?php 

class mst_ability {
  
  function __construct() {
    //定数
    define('DSN' , 'mysql:dbname=test;host=localhost;charset=utf8mb4');
    define('USER' , 'root');
    define('PASSWORD' , '');
  }

  //Where文の生成
  public function CreateWhere($arr) {
    if (!empty($arr['ability_cd'])) {
      $where = ' AND ability_cd LIKE :ability_cd';
    }
  }

  //データの数を取得
  public function GetDataCount() {
    try {
      $select = 'SELECT COUNT(*) FROM mst_ability';
      $dbh = new PDO(DSN, USER, PASSWORD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      ]);
      $sql = $select;
      $stmt = $dbh->prepare($sql);
      $stmt->execute();
      return $stmt->fetchColumn();
    } catch (PDOException $e) {
      echo 'エラーメッセージ:「データが存在しません」: ' . $e->getMessage();
    }
  }
  

  //データ取得
  public function GetData($arr) {
    try {
      $select = 'SELECT * FROM mst_ability';
      $where = $this->CreateWhere($arr);
      $limit = ' LIMIT 10';
      $dbh = new PDO(DSN, USER, PASSWORD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      ]);
      $sql = $select.$where.$limit;
      $stmt = $dbh->prepare($sql);
      $stmt->execute();
      return $stmt->fetchAll();
    } catch (PDOException $e) {
      echo 'エラーメッセージ:「データが存在しません」: ' . $e->getMessage();
    }
  }

  //データ挿入
  public function Insert() {
    try {
      $insert = 'INSERT INTO mst_ability';
      $dbh = new PDO(DSN, USER, PASSWORD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      ]);
      $sql = $insert.$where.$order;
      $stmt = $dbh->prepare($sql);
      $stmt->execute();
      return $stmt->fetchAll();
    } catch (PDOException $e) {
      echo 'エラーメッセージ:「データが存在しません」: ' . $e->getMessage();
    }
  }

  //データ更新
  public function Update() {
    try {
      $insert = 'UPDATE mst_ability';
      $dbh = new PDO(DSN, USER, PASSWORD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      ]);
      $sql = $insert.$where.$order;
      $stmt = $dbh->prepare($sql);
      $stmt->execute();
      return $stmt->fetchAll();
    } catch (PDOException $e) {
      echo 'エラーメッセージ:「データが存在しません」: ' . $e->getMessage();
    }
  }

}

?>