<?php
session_start();

//親クラスを読み込む
require_once '../library/controller.php';

class IndexController extends Controller {

  public function load() {

    $H = [
      'login' => [
        'player_id' => '',
        'player_password' => ''
      ]
    ];

    //全てのセッションを破棄する
    $this->clearSessionAll();

    if ($this->isPost()) {
      $H['login'] = $this->getPostParams($H['login']);

      //選手ID、パスワードを元に選手マスタを検索する
      
    }

    $this->buffer('../login/view/index_view.php', '', '');
  }
}

//index_controllerクラスのインスタンス化
$controller = new IndexController;
//index_contorllerクラスのLoad関数を呼び出す
$controller->load();

?>