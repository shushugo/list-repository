<?php
session_start();

//親クラスを読み込む
require_once '../library/controller.php';

class IndexController extends Controller {

  public function load() {

    //ログイン用セッションに値がないときはログイン画面に飛ぶ
    if (empty($this->isSetSessionLogin())) {
      $this->redirect('../login/login.php');
    }

    //ログイン用セッション以外の全てのセッションを破棄する
    $this->clearSession();

    //ログインした選手の情報を取得する
    $H['login'] = $this->getSessionLogin();

    $this->buffer('../menu/view/index_view.php', $H, '');
  }
}

//index_controllerクラスのインスタンス化
$controller = new IndexController;
//index_contorllerクラスのLoad関数を呼び出す
$controller->load();

?>