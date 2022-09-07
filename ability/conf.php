<?php
session_start();

//親クラスを読み込む
require_once "../library/controller.php";

class ConfController extends Controller {

  public function load() {
    //モデルの読み込み
    require_once "../library/SQL.php";
    require_once "model/mst_ability.php";
    $mst_ability = new MstAbility;

    $H = [
      'register' => [
        'ability_cd' => '',
        'ability_name' => '',
        'ability_name_kana' => ''
      ]
    ];

    //削除用のセッションがない場合セットする
    if ($this->getGetParams('c')) {
      $_SESSION['ability']['delete'] = $this->getGetParams('c');
    } else if (!isset($_SESSION['ability']['delete'])) {
      $_SESSION['ability']['delete'] = '';
    }

    //能力コードがある場合は能力マスタからデータを取得し、値を格納する(削除)
    if (!empty($_SESSION['ability']['delete'])) {
      $H['register'] = $mst_ability->getData(['ability_cd' => $_SESSION['ability']['delete']], 'mst_ability');

      //データを取得できないと能力一覧画面に移動
      if (empty($H['register'])) {
        $this->redirect("index.php");
      }

      //能力登録用セッションに取得したデータを格納する
      $_SESSION['ability']['register'] = $H['register'];

      //戻るボタンの戻り先を能力一覧にする
    }

    //能力登録セッションに値がある場合はその値を表示する
    if (isset($_SESSION['ability']['register'])) {
      foreach ($H['register'] as $key => $value) {
        $H['register'][$key] = $_SESSION['ability']['register'][$key];
      }
    }
    
    $this->buffer('../ability/view/conf_view.php',$H, '');
  }
}

//conf_controllerクラスのインスタンス化
$controller = new ConfController;
//conf_contorllerクラスのLoad関数を呼び出す
$controller->Load();

?>