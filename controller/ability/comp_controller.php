<?php
class comp_controller extends controller {

  public function Load() {
    //モデルの読み込み
    require_once "../../model/SQL.php";
    require_once "../../model/mst_ability.php";
    $mst_ability = new mst_ability;

    session_start();

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
      header( "Location: index.php" );
	    exit;
    }

    //能力登録用セッションを破棄する
    unset($_SESSION['ability']['register']);

    return $H;
  }

}
?>