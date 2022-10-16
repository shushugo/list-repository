<?php
session_start();

//親クラスを読み込む
require_once '../library/controller.php';

class IndexController extends Controller {

  public function load() {
    //モデルの読み込み
    require_once '../library/SQL.php';
    require_once 'model/mst_ability.php';
    $mst_ability = new MstAbility;

    $H = [
      'search' => [
        'ability_cd' => '',
        'ability_name' => ''
      ]
    ];

    //ログイン用セッションに値がないときはログイン画面に飛ぶ
    if (empty($this->isSetSessionLogin())) {
      $this->redirect('../login/index.php');
    }

    //能力登録用のセッションを破棄する
    $this->clearSessionAbility('register');
    //更新用のセッションを破棄する
    $this->clearSessionAbility('update');
    //削除用のセッションを破棄する
    $this->clearSessionAbility('delete');

    //検索クリック時
    $H['search'] = $this->getPostParams($H['search']);

    //値が入力されている場合は能力検索用セッションに格納する
    $this->setSessionAbility('search', $H['search']);

    //現在のページ番号を取得して$_GETの値があったらそれを代入する
    $H['p'] = $this->getGetParams('p');

    if (empty($H['p'])) {
      $H['p'] = 1;
    }
    
    //検索用セッションに値がある場合は検索条件に含めて能力マスタを検索
    $H['data'] = $mst_ability->getList($H['search'], $H['p']);

    //能力マスタの総件数を取得
    $H['count'] = $mst_ability->getListCount($H['search']);

    $H['max_page'] = ceil($H['count'] / 10);
    $H['small_num'] = $this->getStartNum($H['p'], $H['count']);
    $H['max_num'] = $this->getLastNum($H['p'], $H['count']);

    //pageMenu関数でペーシ用のファイルを呼び出す
    $page_menu = $this->pageMenu($H['p'], $H['max_page']);

    $this->buffer('../ability/view/index_view.php',$H, $page_menu);
  }
}

//index_controllerクラスのインスタンス化
$controller = new IndexController;
//index_contorllerクラスのLoad関数を呼び出す
$controller->load();

?>