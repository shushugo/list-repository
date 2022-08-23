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
    $where = ' WHERE 1 = 1';
    $params = [];
    
    if (!empty($arr['ability_cd'])) {
      $where .= ' AND ability_cd LIKE :ability_cd';
      $params += [':ability_cd' => $arr['ability_cd']];
    }
    
    if (!empty($arr['ability_name'])) {
      $where .= ' AND ability_name LIKE :ability_name';
      $params += [':ability_name' => '%'.$arr['ability_name'].'%'];
    }

    return ['where' => $where, 'params' => $params];
  }

  //データの数を取得
  public function GetDataCount($arr) {
    try {
      $select = 'SELECT COUNT(*) FROM mst_ability';
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
  public function GetData($arr) {
    try {
      $select = 'SELECT * FROM mst_ability';
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
      return $stmt->fetch();
    } catch (PDOException $e) {
      echo 'エラーメッセージ:「データが存在しません」: ' . $e->getMessage();
    }
  }

  //データ取得
  public function GetList($arr) {
    try {
      $select = 'SELECT * FROM mst_ability';
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

  //データ削除
  public function Delete() {
    try {
      $delete = 'DELETE mst_ability';
      $dbh = new PDO(DSN, USER, PASSWORD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      ]);
      $sql = $delete.$where.$order;
      $stmt = $dbh->prepare($sql);
      $stmt->execute();
      return $stmt->fetchAll();
    } catch (PDOException $e) {
      echo 'エラーメッセージ:「データが存在しません」: ' . $e->getMessage();
    }
  }

}

?>