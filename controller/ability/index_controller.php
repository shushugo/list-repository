<?php
class index_controller extends controller {

  public function Load() {
    //モデルの読み込み
    require_once "../../model/mst_ability.php";
    $mst_ability = new mst_ability;

    session_start();

    $H = [
      'search' => [
        'ability_cd' => '',
        'ability_name' => ''
      ]
    ];

    //能力登録用のセッションを破棄する
    unset($_SESSION['ability']['register']);

    //検索クリック時
    foreach ($H['search'] as $key => $value) {
      $_SESSION['ability']['search'][$key] = filter_input(INPUT_POST, $key);
      
      //能力検索用セッションに検索条件がある場合は(1)能力コード、(2)能力名に値を格納する
      if (!empty($_SESSION['ability']['search'][$key])) {
        $H['search'][$key] = $_SESSION['ability']['search'][$key];
      }
    }

    //リセットクリック時、検索項目を初期化する
    if (isset($_POST['btn_reset'])) {
      foreach ($H['search'] as $key => $value) {
        unset($H['search'][$key]);
      }
    }

    //検索用セッションに値がある場合は検索条件に含めて能力マスタを検索
    $H['data'] = $mst_ability->GetData($H['search']);

    //能力マスタの総件数を取得
    $H['count'] = $mst_ability->GetDataCount($H['search']);

    //現在のページ番号を取得して$_GETの値があったらそれを代入する
    $H['page'] = filter_input(INPUT_GET, 'p');

    if (empty($H['page'])) {
      $H['page'] = 1;
    }

    $H['maxpage'] = ceil($H['count'] / 10);
    $H['small_num'] = $this->Get_Start_Num($H['page'], $H['count']);
    $H['max_num'] = $this->Get_Last_Num($H['page'], $H['count']);

    return $H;
  }

}
?>