<?php 
class SQL {
  function __construct() {
    //定数
    define('DSN' , 'mysql:dbname=test;host=localhost;charset=utf8mb4');
    define('USER' , 'root');
    define('PASSWORD' , '');
  }

  //Where文の生成
  public function CreateWhere($arr) {
    $where = ' WHERE 1 = 1';
    $params = [];
    
    foreach ($this->H['item'] as $key => $value) {
      if (!empty($arr[$key])) {
        $where .= ' AND '.$key.' LIKE :'.$key;
        $params += [':'.$key => $arr[$key]];
      }
    }

    return ['where' => $where, 'params' => $params];
  }

  //データの数を取得
  public function GetListCount($arr, $mst) {
    try {
      $select = 'SELECT COUNT(*) FROM '.$mst;
      $where = $this->CreateWhere($arr)['where'];
      $params = $this->CreateWhere($arr)['params'];
      $dbh = new PDO(DSN, USER, PASSWORD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      ]);
      $sql = $select.$where;
      $stmt = $dbh->prepare($sql);
      foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
      }
      $stmt->execute();
      return $stmt->fetchColumn();
    } catch (PDOException $e) {
      echo 'エラーメッセージ:「データが存在しません」: ' . $e->getMessage();
    }
  }

  //データ取得
  public function GetData($arr, $mst) {
    try {
      $select = 'SELECT * FROM '.$mst;
      $where = $this->CreateWhere($arr)['where'];
      $limit = ' LIMIT 10';
      $params = $this->CreateWhere($arr)['params'];
      $dbh = new PDO(DSN, USER, PASSWORD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      ]);
      $sql = $select.$where.$limit;
      $stmt = $dbh->prepare($sql);
      foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
      }
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      echo 'エラーメッセージ:「データが存在しません」: ' . $e->getMessage();
    }
  }

  //データ取得
  public function GetList($arr, $p, $mst) {
    try {
      $select = 'SELECT * FROM '.$mst;
      $where = $this->CreateWhere($arr)['where'];
      $params = $this->CreateWhere($arr)['params'];
      $offset = 10 * ($p - 1);
      $limit = ' LIMIT '.$offset.' ,10';
      $dbh = new PDO(DSN, USER, PASSWORD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      ]);
      $sql = $select.$where.$limit;
      $stmt = $dbh->prepare($sql);
      foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
      }
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      echo 'エラーメッセージ:「データが存在しません」: ' . $e->getMessage();
    }
  }


}
?>