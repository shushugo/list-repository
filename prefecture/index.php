<?php
session_start();

//親クラスを読み込む
require_once "../library/controller.php";

class IndexController extends Controller {

  public function load() {
    //モデルの読み込み
    require_once "../library/SQL.php";
    require_once "model/mst_prefectures.php";
    $mst_prefectures = new MstPrefectures;

    

    $H = [
      'search' => [
        'prefecture_cd' => '',
        'prefecture_name' => ''
      ]
    ];

    //都道府県登録用のセッションを破棄する
    unset($_SESSION['prefecture']['register']);

    //検索クリック時
    foreach ($H['search'] as $key => $value) {
      //値が入力されている場合は都道府県検索用セッションに格納する
      $_SESSION['prefecture']['search'][$key] = $this->getPostParams($key);
      
      //能力検索用セッションに検索条件がある場合は(1)能力コード、(2)能力名に値を格納する
      if (!empty($_SESSION['prefecture']['search'][$key])) {
        $H['search'][$key] = $_SESSION['prefecture']['search'][$key];
      }
    }

    //現在のページ番号を取得して$_GETの値があったらそれを代入する
    $H['p'] = $this->getGetParams('p');

    if (empty($H['p'])) {
      $H['p'] = 1;
    }

    //検索用セッションに値がある場合は検索条件に含めて都道府県マスタを検索
    $H['data'] = $mst_prefectures->getList($H['search'], $H['p'], 'mst_prefecture');

    //都道府県マスタの総件数を取得
    $H['count'] = $mst_prefectures->getListCount($H['search'], 'mst_prefecture');

    $H['maxpage'] = ceil($H['count'] / 10);
    $H['small_num'] = $this->getStartNum($H['p'], $H['count']);
    $H['max_num'] = $this->getLastNum($H['p'], $H['count']);

    return $this->arrayMapH($H);
  }

  public function pageLoad($p, $max_page) {
    //pageMenu関数でペーシ用のファイルを呼び出す
    return $this->pageMenu($p, $max_page);
  }

}

//index_controllerクラスのインスタンス化
$controller = new IndexController;
//index_contorllerクラスのLoad関数を呼び出す
$H = $controller->Load();

$pagemenu = $controller->pageLoad($H['p'], $H['maxpage']);


//記録開始
ob_start();
//viewファイルを読み込む
require_once "view/index_view.php";
//記録結果を$bufferに代入
$buffer = ob_get_contents();
//記録終了
ob_end_clean();
echo $buffer;

?>