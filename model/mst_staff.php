<?php 

class mst_staff {
  
  //定数
  define('DSN' , 'mysql:dbname=test;host=mysql;charset=utf8mb4');
  define('USER' , 'test');
  define('PASSWORD' , 'test');

  //データ取得
  public function GetData {
    try {
      $select = 'SELECT * FROM mst_staff';
      $dbh = new PDO(DSN, USER, PASSWORD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      ]);
      $sql = $select.$where.$order;
      $stmt = $dbh->prepare($sql);
      $stmt->execute();
      return $stmt->fetchAll();
    } catch (PDOException $e) {
      echo 'エラーメッセージ:「データが存在しません」: ' . $e->getMessage();
    }
  }

  //データ挿入
  public function Insert {
    try {
      $insert = 'INSERT INTO mst_staff';
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
  public function Update {
    try {
      $insert = 'UPDATE mst_staff';
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