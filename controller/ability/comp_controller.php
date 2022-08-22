<?php
class comp_controller extends controller {

  public function Load() {
    //モデルの読み込み
    require_once "../../model/mst_ability.php";
    $mst_ability = new mst_ability;

    session_start();

    //能力登録用セッションに値がある場合
    if (isset($_SESSION['ability']['register'])) {

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