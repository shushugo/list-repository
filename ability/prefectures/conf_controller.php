<?php
class conf_controller extends controller {

  public function Load() {
    //モデルの読み込み
    require_once "../../model/SQL.php";
    require_once "../../model/mst_prefectures.php";
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
    $H['u'] = $this->Set_Get_Params('u');

    //都道府県コードがある場合は都道府県マスタからデータを取得し、値を格納する(削除)
    if ($H['c']) {
      $H['register'] = $mst_prefectures->GetData(['prefecture_cd' => $H['c']], 'mst_prefecture');

      //データを取得できないと都道府県一覧画面に移動
      if (empty($H['register'])) {
        header( "Location: index.php" );
	      exit;
      }

      //都道府県登録用セッションに取得したデータを格納する
      $_SESSION['prefecture']['register'] = $H['register'];

      //戻るボタンの戻り先を能力一覧にする
    }

    //都道府県登録セッションに値がある場合はその値を表示する
    if (isset($_SESSION['prefecture']['register'])) {
      foreach ($H['register'] as $key => $value) {
        $H['register'][$key] = $_SESSION['prefecture']['register'][$key];
      }
    }

    return $H;
  }
}
?>