<?php
class index_controller {

  public function Load() {
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
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      foreach ($H['search'] as $key => $value) {
        $_SESSION['ability']['search'][$key] = filter_input(INPUT_POST, $key);
      }
    }

    //能力検索用セッションに検索条件がある場合は(1)能力コード、(2)能力名に値を格納する
    if (!empty($_SESSION['ability']['search'])) {
      foreach ($H['search'] as $key => $value) {
        $H['search'][$key] = $_SESSION['ability']['search'][$key];
      }
    }

    //能力マスタの総件数を取得
    $H['count'] = $mst_ability->GetDataCount();
var_dump($H['search']);
    //検索用セッションに値がある場合は検索条件に含めて能力マスタを検索
    if (!empty($_SESSION['ability']['search'])) {
      $H['data'] = $mst_ability->GetData($H['search']);
    }


    return $H;
  }

}
?>