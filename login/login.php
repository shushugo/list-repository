<?php
session_start();

//親クラスを読み込む
require_once '../library/controller.php';

class IndexController extends Controller {

  public function load() {
    //モデルの読み込み
    require_once '../library/SQL.php';
    require_once '../player/model/mst_player.php';
    $mst_player = new MstPlayer;

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

      if (!empty($H['login']['player_id']) && !empty($H['login']['player_password'])) {
        //選手ID、パスワードを元に選手マスタを検索する
        $H['data'] = $mst_player->getData($H['login']);

        if (!empty($H['data'])) {
          $this->setSessionLogin($H['data']);
          $this->redirect('../menu/index.php');
        } else {
          $H['err'] = 1;
        }

      } else {
        $H['err'] = 1;
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