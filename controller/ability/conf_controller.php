<?php
class conf_controller extends controller {

  public function Load() {
    //モデルの読み込み
    require_once "../../model/mst_ability.php";
    $mst_ability = new mst_ability;

    session_start();

    





    return $H;
  }


}
?>