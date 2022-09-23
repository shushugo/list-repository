<?php
session_start();

//親クラスを読み込む
require_once '../library/controller.php';

class CompController extends Controller {

  public function load() {
    //モデルの読み込み
    require_once '../library/SQL.php';
    require_once 'model/mst_prefectures.php';
    $mst_prfectures = new MstPrefectures;

    $data = $this->getSessionPrefecture('register');

    //都道府県更新のセッションの値を格納
    $H['delete'] = $this->getSessionPrefecture('delete');

    //都道府県更新のセッションの値を格納
    $H['update'] = $this->getSessionPrefecture('update');

    //都道府県登録用セッションに値がある場合
    if ($data) {
      if ($H['delete']) {
        //データ削除
        $H['crud'] = '削除';
        $H['res'] = $mst_prfectures->delete($data);
      } else if ($H['update']) {
        //データ更新
        $H['crud'] = '更新';
        $H['res'] = $mst_prfectures->update($data, $data['prefecture_cd']);
      } else {
        //データ追加
        $H['crud'] = '追加';
        $H['res'] = $mst_prfectures->insert($data);
      }
    } else {
      $this->redirect("index.php");
    }

    //都道府県登録用のセッションを破棄する
    $this->clearSessionPrefecture('register');
    //更新用のセッションを破棄する
    $this->clearSessionPrefecture('update');
    //削除用のセッションを破棄する
    $this->clearSessionPrefecture('delete');

    $this->buffer('../prefecture/view/comp_view.php',$H, '');
  }

}

//comp_controllerクラスのインスタンス化
$controller = new CompController;
//comp_contorllerクラスのLoad関数を呼び出す
$controller->load();

?>