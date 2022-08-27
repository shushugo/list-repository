<?php 

class mst_prefectures extends SQL {

  public $H = [
    'item' => [
      'prefecture_cd' => '',
      'prefecture_name' => '',
      'prefecture_name_kana' => ''
    ]
  ];

  //更新の際のSET文を生成
  public function CreateSet($arr) {
    $set = ' SET';
    $params = [];
    
    if (!empty($arr['prefecture_name']) && !empty($arr['prefecture_name_kana'])) {
      $set .= ' prefecture_name = :prefecture_name, prefecture_name_kana = :prefecture_name_kana';
      $params += [':prefecture_name' => $arr['prefecture_name']];
      $params += [':prefecture_name_kana' => $arr['prefecture_name_kana']];
    } else if (!empty($arr['prefecture_name'])) {
      $set .= ' prefecture_name = :prefecture_name';
      $params += [':prefecture_name' => $arr['prefecture_name']];
    } else if (!empty($arr['prefecture_name_kana'])) {
      $set .= ' prefecture_name_kana = :prefecture_name_kana';
      $params += [':prefecture_name_kana' => $arr['prefecture_name_kana']];
    }
    
    return ['set' => $set, 'params' => $params];
  }

  //Value文の生成
  public function CreateValue($arr) {
    $value = ' ';
    $params = [];

    if (!empty($arr['prefecture_cd']) && !empty($arr['prefecture_name']) && !empty($arr['prefecture_name_kana'])) {
      $value = '(prefecture_cd, prefecture_name, prefecture_name_kana) VALUES (:prefecture_cd, :prefecture_name, :prefecture_name_kana)';
      $params += [':prefecture_cd' => $arr['prefecture_cd']];
      $params += [':prefecture_name' => $arr['prefecture_name']];
      $params += [':prefecture_name_kana' => $arr['prefecture_name_kana']];
    } else if (!empty($arr['prefecture_cd']) && !empty($arr['prefecture_name'])) {
      $value = '(prefecture_cd, prefecture_name) VALUES (:prefecture_cd, :prefecture_name)';
      $params += [':prefecture_cd' => $arr['prefecture_cd']];
      $params += [':prefecture_name' => $arr['prefecture_name']];
    }

    return ['value' => $value, 'params' => $params];
  }

  //データ挿入
  public function Insert($arr) {
    try {
      $insert = 'INSERT INTO mst_prefecture';
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
  public function Update($arr) {
    try {
      $update = 'UPDATE mst_prefecture';
      $set = $this->CreateSet($arr)['set'];
      $params = $this->CreateSet($arr)['params'];
      $where = ' WHERE prefecture_cd = '.$arr['prefecture_cd'];
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
      echo 'エラーメッセージ:「データが存在しません」: ' . $e->getMessage();
    }
  }

  //データ削除
  public function Delete($arr) {
    try {
      $delete = 'DELETE FROM mst_prefecture';
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