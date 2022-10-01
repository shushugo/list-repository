<?php 
class Sql {
  function __construct() {
    require_once 'define.php';
  }

  //Where文の生成
  public function createWhere($arr) {
    $where = ' WHERE 1 = 1';
    $params = [];
    
    foreach ($arr as $key => $value) {
      if (array_key_exists($key, $this->columns)) {
        if (!empty($arr[$key])) {
          $where .= ' AND '.$key.' LIKE :'.$key;
          $params += [':'.$key => $arr[$key]];
        }
      }
    }

    return ['where' => $where, 'params' => $params];
  }

  //Value文の生成
  public function createValue($arr) {
    $value = '';
    $values = '';
    $param = '';
    $params = [];
    $value_key = [];
    $param_key = [];

    foreach ($arr as $k => $v) {
      if (array_key_exists($k, $this->columns)) {
        $value_key[] .= $k;
        $param_key[] .= ':'.$k;
      
        $params += [':'.$k => $v];
      }
    }
    $values .= implode(", ", $value_key);
    $param .= implode(", ", $param_key);
    
    $value = '('.$values.') VALUES ('.$param.')';

    return ['value' => $value, 'params' => $params];
  }

  //更新の際のSET文を生成
  public function createSet($arr) {
    $set = ' SET ';
    $params = [];
    $value_key = [];
    $param_key = [];

    foreach ($arr as $key => $value) {
      if (array_key_exists($key, $this->columns)) {
        if(!empty($value)) {
          $value_key[] .= $key.' = :'.$key;
  
          $params += [':'.$key => $arr[$key]];
        }
      }
    }
    $set .= implode(", ", $value_key);
    
    return ['set' => $set, 'params' => $params];
  }

  //データの数を取得
  public function getListCount($arr) {
    try {
      $select = 'SELECT COUNT(*) FROM '.$this->table;
      $where = $this->createWhere($arr)['where'];
      $params = $this->createWhere($arr)['params'];
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
      return 'エラーが発生しました: ' . $e->getMessage();
    }
  }

  //データ取得
  public function getData($arr) {
    try {
      $select = 'SELECT * FROM '.$this->table;
      $where = $this->createWhere($arr)['where'];
      $limit = ' LIMIT 10';
      $params = $this->createWhere($arr)['params'];
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
      return 'エラーが発生しました: ' . $e->getMessage();
    }
  }

  //pkを元にデータ取得
  public function getDataByPk($pk, $pk_name) {
    try {
      $select = 'SELECT * FROM '.$this->table;
      $where = ' WHERE '.$pk_name.' LIKE :'.$pk_name;
      $params = [':'.$pk_name => $pk];
      $dbh = new PDO(DSN, USER, PASSWORD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      ]);
      $sql = $select.$where;
      $stmt = $dbh->prepare($sql);
      foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
      }
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      return 'エラーが発生しました: ' . $e->getMessage();
    }
  }

  //データ取得
  public function getList($arr, $p) {
    try {
      $select = 'SELECT * FROM '.$this->table;
      $where = $this->createWhere($arr)['where'];
      $params = $this->createWhere($arr)['params'];
      $offset = 10 * ($p - 1);
      $limit = ' LIMIT '.$offset.' ,10';
      $dbh = new PDO(DSN, USER, PASSWORD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      ]);
      $sql = $select.$where.' ORDER BY 1 ASC'.$limit;
      $stmt = $dbh->prepare($sql);
      foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
      }
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      return 'エラーが発生しました: ' . $e->getMessage();
    }
  }

  //プルダウン用のデータを取得する
  public function getPullList() {
    try {
      $select = 'SELECT * FROM '.$this->table;
      $dbh = new PDO(DSN, USER, PASSWORD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      ]);
      $sql = $select;
      $stmt = $dbh->prepare($sql);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      return 'エラーが発生しました: ' . $e->getMessage();
    }
  }

  //データ挿入
  public function insert($arr) {
    try {
      $insert = 'INSERT INTO '.$this->table;
      $value = $this->createValue($arr)['value'];
      $params = $this->createValue($arr)['params'];
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
      return 'エラーが発生しました: ' . $e->getMessage();
    }
  }

  //データ更新
  public function update($arr, $key) {
    try {
      $update = 'UPDATE '.$this->table;
      $set = $this->createSet($arr)['set'];
      $params = $this->createSet($arr)['params'];
      $where = ' WHERE '.array_keys($arr)[0].' = '.$key;
      $dbh = new PDO(DSN, USER, PASSWORD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      ]);
      $sql = $update.$set.$where;
      $stmt = $dbh->prepare($sql);
      foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
      }
      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      return 'エラーが発生しました: ' . $e->getMessage();
    }
  }

  //データ削除
  public function delete($arr) {
    try {
      $delete = 'DELETE FROM '.$this->table;
      $where = $this->createWhere($arr)['where'];
      $params = $this->createWhere($arr)['params'];
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
      return 'エラーが発生しました: ' . $e->getMessage();
    }
  }


}
?>