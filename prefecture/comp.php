<?php

//親クラスを読み込む
require_once "../library/controller.php";

class comp_controller extends controller {

  public function Load() {
    //モデルの読み込み
    require_once "../library/SQL.php";
    require_once "model/mst_prefectures.php";
    $mst_prefectures = new mst_prefectures;

    session_start();

    $delete_flg = $this->Set_Get_Params('d');
    $update_flg = $this->Set_Get_Params('u');

    $data = $_SESSION['prefecture']['register'];

    //都道府県登録用セッションに値がある場合
    if ($data) {
      if ($delete_flg) {
        //データ削除
        $H['crud'] = '削除';
        $H['res'] = $mst_prefectures->Delete($data);
      } else if ($update_flg) {
        //データ更新
        $H['crud'] = '更新';
        $H['res'] = $mst_prefectures->Update($data);
      } else {
        //データ追加
        $H['crud'] = '追加';
        $H['res'] = $mst_prefectures->Insert($data);
      }
    } else {
      header( "Location: index.php" );
	    exit;
    }

    //都道府県登録用セッションを破棄する
    unset($_SESSION['prefecture']['register']);

    return $H;
  }

}

//comp_controllerクラスのインスタンス化
$controller = new comp_controller;
//comp_contorllerクラスのLoad関数を呼び出す
$H = $controller->Load();

//記録開始
ob_start();
//viewファイルを読み込む
require_once "view/comp_view.php";
//記録結果を$bufferに代入
$buffer = ob_get_contents();
//記録終了
ob_end_clean();
echo $buffer;

?>