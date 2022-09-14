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
    $this->setSessionAbility('delete', $this->getGetParams('c'));

    //能力更新のセッションの値を格納
    $H['delete'] = $this->getSessionAbility('delete');

    //能力更新のセッションの値を格納
    $H['update'] = $this->getSessionAbility('update');

    //能力コードがある場合は能力マスタからデータを取得し、値を格納する(削除)
    if (!empty($H['delete'])) {
      $H['register'] = $mst_ability->getData(['ability_cd' => $H['delete']], 'mst_ability');

      //データを取得できないと能力一覧画面に移動
      if (empty($H['register'])) {
        $this->redirect("index.php");
      }

      //能力登録用セッションに取得したデータを格納する
      $this->setSessionAbility('register', $H['register']);
    }

    //能力登録セッションに値がある場合はその値を表示する
    if ($this->getSessionAbility('register')) {
      $H['register'] = $this->getSessionAbility('register');
    }

    $this->buffer('../ability/view/conf_view.php',$H, '');
  }
}

//conf_controllerクラスのインスタンス化
$controller = new ConfController;
//conf_contorllerクラスのLoad関数を呼び出す
$controller->Load();

?>