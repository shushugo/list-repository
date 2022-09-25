<?php
session_start();

//親クラスを読み込む
require_once '../library/controller.php';

class IndexController extends Controller {

  public function load() {
    //モデルの読み込み
    require_once '../library/SQL.php';
    require_once 'model/mst_prefectures.php';
    $mst_prfectures = new MstPrefectures;

    $H = [
      'search' => [
        'prefecture_cd' => '',
        'prefecture_name' => ''
      ]
    ];

    //都道府県登録用のセッションを破棄する
    $this->clearSessionPrefecture('register');
    //更新用のセッションを破棄する
    $this->clearSessionPrefecture('update');
    //削除用のセッションを破棄する
    $this->clearSessionPrefecture('delete');

    //検索クリック時
    $H['search'] = $this->getPostParams($H['search']);

    //値が入力されている場合は都道府県検索用セッションに格納する
    $this->setSessionPrefecture('search', $H['search']);

    //現在のページ番号を取得して$_GETの値があったらそれを代入する
    $H['p'] = $this->getGetParams('p');

    if (empty($H['p'])) {
      $H['p'] = 1;
    }
    
    //検索用セッションに値がある場合は検索条件に含めて能力マスタを検索
    $H['data'] = $mst_prfectures->getList($H['search'], $H['p']);

    //能力マスタの総件数を取得
    $H['count'] = $mst_prfectures->getListCount($H['search']);

    $H['max_page'] = ceil($H['count'] / 10);
    $H['small_num'] = $this->getStartNum($H['p'], $H['count']);
    $H['max_num'] = $this->getLastNum($H['p'], $H['count']);

    //pageMenu関数でペーシ用のファイルを呼び出す
    $page_menu = $this->pageMenu($H['p'], $H['max_page']);

    $this->buffer('../prefecture/view/index_view.php',$H, $page_menu);
  }
}

//index_controllerクラスのインスタンス化
$controller = new IndexController;
//index_contorllerクラスのLoad関数を呼び出す
$controller->load();

?>