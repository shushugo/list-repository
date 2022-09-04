<?php
session_start();

//親クラスを読み込む
require_once "../library/controller.php";

class ConfController extends Controller {

  public function load() {
    //モデルの読み込み
    require_once "../library/SQL.php";
    require_once "model/mst_prefectures.php";
    $mst_prefectures = new MstPrefectures;

    $H = [
      'register' => [
        'prefecture_cd' => '',
        'prefecture_name' => '',
        'prefecture_name_kana' => ''
      ]
    ];

    $H['c'] = $this->getGetParams('c');
    $H['u'] = $this->getGetParams('u');

    //都道府県コードがある場合は都道府県マスタからデータを取得し、値を格納する(削除)
    if (isset($H['c'])) {
      $H['register'] = $mst_prefectures->getData(['prefecture_cd' => $H['c']], 'mst_prefecture');

      //データを取得できないと都道府県一覧画面に移動
      if (empty($H['register'])) {
        $this->redirect("index.php");
      }

      //都道府県登録用セッションに取得したデータを格納する
      $_SESSION['prefecture']['register'] = $H['register'];

      //戻るボタンの戻り先を能力一覧にする
    }

    //都道府県登録セッションに値がある場合はその値を表示する
    if (isset($_SESSION['prefecture']['register'])) {
      foreach ($H['register'] as $key => $value) {
        $H['register'][$key] = $_SESSION['prefecture']['register'][$key];
      }
    }

    return $this->arrayMapH($H);
  }
}

//conf_controllerクラスのインスタンス化
$controller = new ConfController;
//conf_contorllerクラスのLoad関数を呼び出す
$H = $controller->load();

//記録開始
ob_start();
//viewファイルを読み込む
require_once "view/conf_view.php";
//記録結果を$bufferに代入
$buffer = ob_get_contents();
//記録終了
ob_end_clean();
echo $buffer;

?>