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

  //Value文の生成
  public function CreateValue($arr) {
    $value = '';
    $values = '';
    $param = '';
    $params = [];
    $value_key = [];
    $param_key = [];

    foreach ($arr as $k => $v) {
      $value_key[] .= $k;
      $param_key[] .= ':'.$k;
      
      $params += [':'.$k => $v];
    }
    $values .= implode(", ", $value_key);
    $param .= implode(", ", $param_key);
    
    $value = '('.$values.') VALUES ('.$param.')';

    return ['value' => $value, 'params' => $params];
  }

  //更新の際のSET文を生成
  public function CreateSet($arr) {
    $set = ' SET ';
    $params = [];
    $value_key = [];
    $param_key = [];

    foreach ($arr as $key => $value) {
      if(!empty($value)) {
        $value_key[] .= $key.' = :'.$key;

        $params += [':'.$key => $arr[$key]];
      }
    }
    $set .= implode(", ", $value_key);
    
    return ['set' => $set, 'params' => $params];
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

  //データ挿入
  public function Insert($arr, $mst) {
    try {
      $insert = 'INSERT INTO '.$mst;
      $value = $this->CreateValue($arr)['value'];
      $params = $this->CreateValue($arr)['params'];
      $dbh = new PDO(DSN, USER, PASSWORD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      ]);
      $sql = $insert.$value;
      $stmt = $dbh->prepare($sql);
      foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
      } 
      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      echo 'エラーメッセージ:「データが存在しません」: ' . $e->getMessage();
    }
  }

  //データ更新
  public function Update($arr, $key, $mst) {
    try {
      $update = 'UPDATE '.$mst;
      $set = $this->CreateSet($arr)['set'];
      $params = $this->CreateSet($arr)['params'];
      $where = ' WHERE ability_cd = '.$key;
      $dbh = new PDO(DSN, USER, PASSWORD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      ]);
      $sql = $update.$set.$where;
      $stmt = $dbh->prepare($sql);
      foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
      }
      //var_dump($sql);die;
      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      echo 'エラーメッセージ:「データが存在しません」: ' . $e->getMessage();
    }
  }

  //データ削除
  public function Delete($arr, $mst) {
    try {
      $delete = 'DELETE FROM '.$mst;
      $where = $this->CreateWhere($arr)['where'];
      $params = $this->CreateWhere($arr)['params'];
      $dbh = new PDO(DSN, USER, PASSWORD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      ]);
      $sql = $delete.$where;
      $stmt = $dbh->prepare($sql);
      foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
      }
      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      echo 'エラーメッセージ:「データが存在しません」: ' . $e->getMessage();
    }
  }


}
?>