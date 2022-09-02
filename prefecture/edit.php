<?php

//親クラスを読み込む
require_once "../library/controller.php";

class edit_controller extends controller {

  public function Load() {
    //モデルの読み込み
    require_once "../library/SQL.php";
    require_once "model/mst_prefectures.php";
    $mst_prefectures = new mst_prefectures;

    session_start();

    $H = [
      'register' => [
        'prefecture_cd' => '',
        'prefecture_name' => '',
        'prefecture_name_kana' => ''
      ]
    ];

    $H['c'] = $this->Set_Get_Params('c');

    //都道府県コードがある場合は都道府県マスタからデータを取得し、値を格納する(更新の場合)
    if ($H['c']) {
      $H['register'] = $mst_prefectures->GetData(['prefecture_cd' => $H['c']], 'mst_prefecture');

      //データを取得できないと都道府県一覧画面に移動
      if (empty($H['register'])) {
        header( "Location: index.php" );
	      exit;
      }
    }

    foreach ($H['register'] as $key =>$value)  {
      //都道府県登録セッションに値がある場合は値を格納する
      if (!empty($_SESSION['prefecture']['register'][$key])) {
        $H['register'][$key] = $_SESSION['prefecture']['register'][$key];
      }

      //入力したデータ
      $H['data'][$key] = $this->Set_Post_Params($key);
      $this->h($H['data'][$key]);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $H['err'] = $this->Validation($H['data']);

      if (empty($H['err'])) {
        foreach ($H['register'] as $key =>$value)  {
          $_SESSION['prefecture']['register'][$key] = $H['data'][$key];
        }

        if ($H['c']) {
          //更新
          header( "Location: conf.php?u=1" );
          exit;
        } else {
          //追加
          header( "Location: conf.php" );
          exit;
        }
          
      }
    }

    return $H;
  }

  public function Validation($data) {
    $err = [];

    //都道府県コード
    if ($this->IsRequired($data['prefecture_cd'])) {
      $err['prefecture_cd'] = $this->IsRequired($data['prefecture_cd']);
    } else if ($this->IsHalfAlphanumeric($data['prefecture_cd'])) {
      $err['prefecture_cd'] = $this->IsHalfAlphanumeric($data['prefecture_cd']);
    } else if ($this->IsMaxLength($data['prefecture_cd'], 2)) {
      $err['prefecture_cd'] = $this->IsMaxLength($data['prefecture_cd'], 2);
    }

    //都道府県名
    if ($this->IsRequired($data['prefecture_name'])) {
      $err['prefecture_name'] = $this->IsRequired($data['prefecture_name']);
    } else if ($this->IsMaxLength($data['prefecture_name'], 20)) {
      $err['prefecture_name'] = $this->IsMaxLength($data['prefecture_name'], 5);
    }

    //都道府県名カナ
    if (!empty($data['prefecture_name_kana'])) {
      if ($this->IsMaxLength($data['prefecture_name_kana'], 20)) {
        $err['prefecture_name_kana'] = $this->IsMaxLength($data['prefecture_name_kana'], 10);
      } else if ($this->IsKana($data['prefecture_name_kana'])) {
        $err['prefecture_name_kana'] = $this->IsKana($data['prefecture_name_kana']);
      }
    }

    return $err;
  }

}

//edit_controllerクラスのインスタンス化
$controller = new edit_controller;
//edit_contorllerクラスのLoad関数を呼び出す
$H = $controller->Load();

//記録開始
ob_start();
//viewファイルを読み込む
require_once "view/edit_view.php";
//記録結果を$bufferに代入
$buffer = ob_get_contents();
//記録終了
ob_end_clean();
echo $buffer;

?>