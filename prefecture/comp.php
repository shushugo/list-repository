<?php
session_start();

//親クラスを読み込む
require_once "../library/controller.php";

class CompController extends Controller {

  public function load() {
    //モデルの読み込み
    require_once "../library/SQL.php";
    require_once "model/mst_prefectures.php";
    $mst_prefectures = new MstPrefectures;

    $data = $_SESSION['prefecture']['register'];

    //都道府県登録用セッションに値がある場合
    if ($data) {
      if ($this->getGetParams('d')) {
        //データ削除
        $H['crud'] = '削除';
        $H['res'] = $mst_prefectures->delete($data, 'mst_prefecture');
      } else if ($this->getGetParams('u')) {
        //データ更新
        $H['crud'] = '更新';
        $H['res'] = $mst_prefectures->update($data, $data['prefecture_cd'], 'mst_prefecture');
      } else {
        //データ追加
        $H['crud'] = '追加';
        $H['res'] = $mst_prefectures->insert($data, 'mst_prefecture');
      }
    } else {
      $this->redirect("index.php");
    }

    //都道府県登録用セッションを破棄する
    unset($_SESSION['prefecture']['register']);

    return $this->arrayMapH($H);
  }

}

//comp_controllerクラスのインスタンス化
$controller = new CompController;
//comp_contorllerクラスのLoad関数を呼び出す
$H = $controller->load();

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