<?php
session_start();

//親クラスを読み込む
require_once '../library/controller.php';

class IndexController extends Controller {

  public function load() {

    //ログイン用セッションに値がないときはログイン画面に飛ぶ
    // if (!($this->isSetSessionLogin())) {
    //   $this->redirect('index.php');
    // }

    //ログイン用セッション以外の全てのセッションを破棄する
    $this->clearSession();

    $this->buffer('../menu/view/index_view.php', '', '');
  }
}

//index_controllerクラスのインスタンス化
$controller = new IndexController;
//index_contorllerクラスのLoad関数を呼び出す
$controller->load();

?>