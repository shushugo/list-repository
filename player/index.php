<?php
session_start();

//親クラスを読み込む
require_once '../library/controller.php';

class IndexController extends Controller {

  public function load() {
    //モデルの読み込み
    require_once '../library/SQL.php';
    require_once 'model/mst_player.php';
    require_once '../prefecture/model/mst_prefectures.php';
    require_once '../ability/model/mst_ability.php';
    $mst_player = new MstPlayer;
    $mst_prefecture = new MstPrefectures;
    $mst_ability = new MstAbility;

    $H = [
      'search' => [
        'player_id' => '',
        'player_name' => '',
        'sex_div' => '',
        'prefecture_cd' => '',
        'ability_cd' => ''
      ]
    ];

    //プレイヤー登録用のセッションを破棄する
    $this->clearSessionPlayer('register');
    //更新用のセッションを破棄する
    $this->clearSessionPlayer('update');
    //削除用のセッションを破棄する
    $this->clearSessionPlayer('delete');

    //検索クリック時
    $H['search'] = $this->getPostParams($H['search']);

    //値が入力されている場合はプレイヤー検索用セッションに格納する
    $this->setSessionPlayer('search', $H['search']);

    //現在のページ番号を取得して$_GETの値があったらそれを代入する
    $H['p'] = $this->getGetParams('p');

    if (empty($H['p'])) {
      $H['p'] = 1;
    }
    
    //検索用セッションに値がある場合は検索条件に含めてプレイヤーマスタを検索
    $H['data'] = $mst_player->getList($H['search'], $H['p']);

    //プレイヤーマスタの総件数を取得
    $H['count'] = $mst_player->getListCount($H['search']);

    //都道府県のプルダウン用のデータを取得
    $H['prefecture_list'] = $mst_prefecture->getPullList();

    //能力のプルダウン用のデータを取得
    $H['ability_list'] = $mst_ability->getPullList();

    $H['max_page'] = ceil($H['count'] / 10);
    $H['small_num'] = $this->getStartNum($H['p'], $H['count']);
    $H['max_num'] = $this->getLastNum($H['p'], $H['count']);

    //pageMenu関数でペーシ用のファイルを呼び出す
    $page_menu = $this->pageMenu($H['p'], $H['max_page']);

    $this->buffer('../player/view/index_view.php',$H, $page_menu);
  }
}

//index_controllerクラスのインスタンス化
$controller = new IndexController;
//index_contorllerクラスのLoad関数を呼び出す
$controller->load();

?>