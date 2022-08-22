<?php
class conf_controller extends controller {

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
      ],
      'item' => [
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
      
      //能力登録用セッションに取得したデータを格納する
      $_SESSION['ability']['register'] = $H['register'];

      //戻るボタンの戻り先を能力一覧にする
    }

    //能力登録セッションに値がある場合はその値を表示する
    if (isset($_SESSION['ability']['register'])) {
      foreach ($H['item'] as $key => $value) {
        $H['register'][$key] = $_SESSION['ability']['register'][$key];
      }
    }

    return $H;
  }


}
?>