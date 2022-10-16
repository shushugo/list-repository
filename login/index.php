<?php
session_start();

//親クラスを読み込む
require_once '../library/controller.php';

class IndexController extends Controller {

  public function load() {
    //モデルの読み込み
    require_once '../library/SQL.php';
    require_once 'model/mst_user.php';
    $mst_user = new MstUser;

    $H = [
      'login' => [
        'user_id' => '',
        'user_password' => ''
      ]
    ];

    //全てのセッションを破棄する
    $this->clearSessionAll();

    if ($this->isPost()) {
      $H['login'] = $this->getPostParams($H['login']);

      if (!empty($H['login']['user_id']) && !empty($H['login']['user_password'])) {
        //ユーザーID、パスワードを元に選手マスタを検索する
        $H['data'] = $mst_user->getData($H['login']);

        if (!empty($H['data'])) {
          $this->setSessionLogin($H['data']);
          $this->redirect('../menu/index.php');
        } else {
          $H['err'] = 'ユーザID又はパスワードが違います';
        }

      } else {
        $H['err'] = 'ユーザーID又はパスワードを入力してください';
      }
    }

    $this->buffer('../login/view/index_view.php', $H, '');
  }
}

//index_controllerクラスのインスタンス化
$controller = new IndexController;
//index_contorllerクラスのLoad関数を呼び出す
$controller->load();

?>