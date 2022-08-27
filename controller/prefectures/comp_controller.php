<?php
class comp_controller extends controller {

  public function Load() {
    //モデルの読み込み
    require_once "../../model/SQL.php";
    require_once "../../model/mst_prefectures.php";
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
?>