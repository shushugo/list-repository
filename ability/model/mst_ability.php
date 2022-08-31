<?php 

class mst_ability extends SQL {

  public $H = [
    'item' => [
      'ability_cd' => '',
      'ability_name' => '',
      'ability_name_kana' => ''
    ]
  ];

  //更新の際のSET文を生成
  public function CreateSet($arr) {
    $set = ' SET';
    $params = [];
    
    if (!empty($arr['ability_name']) && !empty($arr['ability_name_kana'])) {
      $set .= ' ability_name = :ability_name, ability_name_kana = :ability_name_kana';
      $params += [':ability_name' => $arr['ability_name']];
      $params += [':ability_name_kana' => $arr['ability_name_kana']];
    } else if (!empty($arr['ability_name'])) {
      $set .= ' ability_name = :ability_name';
      $params += [':ability_name' => $arr['ability_name']];
    } else if (!empty($arr['ability_name_kana'])) {
      $set .= ' ability_name_kana = :ability_name_kana';
      $params += [':ability_name_kana' => $arr['ability_name_kana']];
    }
    
    return ['set' => $set, 'params' => $params];
  }

  //Value文の生成
  public function CreateValue($arr) {
    $value = ' ';
    $params = [];

    if (!empty($arr['ability_cd']) && !empty($arr['ability_name']) && !empty($arr['ability_name_kana'])) {
      $value = '(ability_cd, ability_name, ability_name_kana) VALUES (:ability_cd, :ability_name, , :ability_name_kana)';
      $params += [':ability_cd' => $arr['ability_cd']];
      $params += [':ability_name' => $arr['ability_name']];
      $params += [':ability_name_kana' => $arr['ability_name_kana']];
    } else if (!empty($arr['ability_cd']) && !empty($arr['ability_name'])) {
      $value = '(ability_cd, ability_name) VALUES (:ability_cd, :ability_name)';
      $params += [':ability_cd' => $arr['ability_cd']];
      $params += [':ability_name' => $arr['ability_name']];
    }

    return ['value' => $value, 'params' => $params];
  }

  //データ挿入
  public function Insert($arr) {
    try {
      $insert = 'INSERT INTO mst_ability';
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
      $update = 'UPDATE mst_ability';
      $set = $this->CreateSet($arr)['set'];
      $params = $this->CreateSet($arr)['params'];
      $where = ' WHERE ability_cd = '.$arr['ability_cd'];
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
      $delete = 'DELETE FROM mst_ability';
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