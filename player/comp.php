<?php
session_start();

//親クラスを読み込む
require_once '../library/controller.php';

class CompController extends Controller {

  public function load() {
    //モデルの読み込み
    require_once '../library/SQL.php';
    require_once 'model/mst_player.php';
    $mst_player = new MstPlayer;

    $data = $this->getSessionPlayer('register');

    //選手更新のセッションの値を格納
    $H['delete'] = $this->getSessionPlayer('delete');

    //選手更新のセッションの値を格納
    $H['update'] = $this->getSessionPlayer('update');

    //選手登録用セッションに値がある場合
    if ($data) {
      if ($H['delete']) {
        //データ削除
        $H['crud'] = '削除';
        $H['res'] = $mst_player->delete($data);
      } else if ($H['update']) {
        //データ更新
        $H['crud'] = '更新';
        $H['res'] = $mst_player->update($data, $data['player_id']);
      } else {
        //データ追加
        $H['crud'] = '追加';
        $H['res'] = $mst_player->insert($data);
      }
    } else {
      $this->redirect("index.php");
    }

    //選手登録用のセッションを破棄する
    $this->clearSessionPlayer('register');
    //更新用のセッションを破棄する
    $this->clearSessionPlayer('update');
    //削除用のセッションを破棄する
    $this->clearSessionPlayer('delete');

    $this->buffer('../player/view/comp_view.php',$H, '');
  }

}

//comp_controllerクラスのインスタンス化
$controller = new CompController;
//comp_contorllerクラスのLoad関数を呼び出す
$controller->load();

?>