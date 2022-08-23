<?php
class comp_controller extends controller {

  public function Load() {
    //モデルの読み込み
    require_once "../../model/mst_ability.php";
    $mst_ability = new mst_ability;

    session_start();

    $delete = filter_input(INPUT_GET, 'd');
    $update = filter_input(INPUT_GET, 'u');

    //能力登録用セッションに値がある場合
    if (isset($_SESSION['ability']['register'])) {
      if ($delete) {
        //データ削除
        $res = $mst_ability->Delete();
      } else if ($update) {
        //データ更新
        $res = $mst_ability->Delete();
      } else {
        //データ追加
        $res = $mst_ability->Insert();
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