<?php
session_start();

//親クラスを読み込む
require_once "../library/controller.php";

class comp_controller extends controller {

  public function Load() {
    //モデルの読み込み
    require_once "../library/SQL.php";
    require_once "model/mst_ability.php";
    $mst_ability = new mst_ability;

    $delete_flg = $this->Set_Get_Params('d');
    $update_flg = $this->Set_Get_Params('u');

    $data = $_SESSION['ability']['register'];

    //能力登録用セッションに値がある場合
    if ($data) {
      if ($delete_flg) {
        //データ削除
        $H['crud'] = '削除';
        $H['res'] = $mst_ability->Delete($data);
      } else if ($update_flg) {
        //データ更新
        $H['crud'] = '更新';
        $H['res'] = $mst_ability->Update($data);
      } else {
        //データ追加
        $H['crud'] = '追加';
        $H['res'] = $mst_ability->Insert($data);
      }
    } else {
      $this->Redirect("index.php");
    }

    //能力登録用セッションを破棄する
    unset($_SESSION['ability']['register']);

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