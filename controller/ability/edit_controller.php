<?php
class edit_controller extends controller {

  public function Load() {
    //モデルの読み込み
    require_once "../../model/mst_ability.php";
    $mst_ability = new mst_ability;

    session_start();

    $H = [
      'register' => [
        'ability_cd' => '',
        'ability_name' => '',
        'ability_name_kana' => ''
      ]
    ];

    $H['c'] = filter_input(INPUT_GET, 'c');

    //能力コードがある場合は能力マスタからデータを取得し、値を格納する
    if ($H['c']) {
      $H['register'] = $mst_ability->GetData(['ability_cd' => $H['c']]);

      //データを取得できないと能力一覧画面に移動
      if (empty($H['register'])) {
        header( "Location: index.php" );
	      exit;
      }
    }

    foreach ($H['register'] as $key =>$value)  {
      //能力登録セッションに値がある場合は値を格納する
      if (!empty($_SESSION['ability']['register'][$key])) {
        $H['register'][$key] = $_SESSION['ability']['register'][$key];
      }

      //入力チェック
      $data[$key] = filter_input(INPUT_POST, $key);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $H['err'] = $this->Validation($data);

      if (empty($H['err'])) {
        foreach ($H['register'] as $key =>$value)  {
          $_SESSION['ability']['register'][$key] = $data[$key];
        }

        if ($H['c']) {
          header( "Location: conf.php?u=1" );
          exit;
        } else {
          header( "Location: conf.php" );
          exit;
        }
          
      }
    }

    return $H;
  }

  public function Validation($data) {
    $err = [];

    //能力コード
    if ($this->IsRequired($data['ability_cd'])) {
      $err['ability_cd'] = $this->IsRequired($data['ability_cd']);
    } else if ($this->IsMaxLength($data['ability_cd'], 2)) {
      $err['ability_cd'] = $this->IsMaxLength($data['ability_cd'], 2);
    }

    //能力名
    if ($this->IsRequired($data['ability_name'])) {
      $err['ability_name'] = $this->IsRequired($data['ability_name']);
    } else if ($this->IsMaxLength($data['ability_name'], 20)) {
      $err['ability_name'] = $this->IsMaxLength($data['ability_name'], 20);
    }

    //能力名カナ
    if ($this->IsMaxLength($data['ability_name_kana'], 20)) {
      $err['ability_name_kana'] = $this->IsMaxLength($data['ability_name_kana'], 20);
    }

    return $err;
  }

}
?>