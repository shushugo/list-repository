<?php
class index_controller extends controller {

  public function Load() {
    //モデルの読み込み
    require_once "../../model/SQL.php";
    require_once "../../model/mst_prefectures.php";
    $mst_prefectures = new mst_prefectures;

    session_start();

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
      $_SESSION['prefecture']['search'][$key] = $this->Set_Post_Params($key);
      
      //能力検索用セッションに検索条件がある場合は(1)能力コード、(2)能力名に値を格納する
      if (!empty($_SESSION['prefecture']['search'][$key])) {
        $H['search'][$key] = $_SESSION['prefecture']['search'][$key];
        $this->h($H['search'][$key]);
      }
    }

    //リセットクリック時、検索項目を初期化する
    if (isset($_POST['btn_reset'])) {
      foreach ($H['search'] as $key => $value) {
        unset($H['search'][$key]);
      }
    }

    //検索用セッションに値がある場合は検索条件に含めて都道府県マスタを検索
    $H['data'] = $mst_prefectures->GetList($H['search'], 'mst_prefecture');

    //都道府県マスタの総件数を取得
    $H['count'] = $mst_prefectures->GetListCount($H['search'], 'mst_prefecture');

    //現在のページ番号を取得して$_GETの値があったらそれを代入する
    $H['p'] = $this->Set_Get_Params('p');

    if (empty($H['p'])) {
      $H['p'] = 1;
    }

    $H['maxpage'] = ceil($H['count'] / 10);
    $H['small_num'] = $this->Get_Start_Num($H['p'], $H['count']);
    $H['max_num'] = $this->Get_Last_Num($H['p'], $H['count']);

    return $H;
  }

}
?>