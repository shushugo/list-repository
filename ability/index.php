<?php
session_start();

//親クラスを読み込む
require_once "../library/controller.php";

class index_controller extends controller {

  public function Load() {
    //モデルの読み込み
    require_once "../library/SQL.php";
    require_once "model/mst_ability.php";
    $mst_ability = new mst_ability;

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
      //値が入力されている場合は能力検索用セッションに格納する
      $_SESSION['ability']['search'][$key] = $this->Set_Post_Params($key);
      
      //能力検索用セッションに検索条件がある場合は(1)能力コード、(2)能力名に値を格納する
      if (!empty($_SESSION['ability']['search'][$key])) {
        $H['search'][$key] = $_SESSION['ability']['search'][$key];
        //$this->h($H['search'][$key]);
      }
    }
    
    //リセットクリック時、検索項目を初期化する
    if (isset($_POST['btn_reset'])) {
      foreach ($H['search'] as $key => $value) {
        unset($H['search'][$key]);
      }
    }

    //現在のページ番号を取得して$_GETの値があったらそれを代入する
    $H['p'] = $this->Set_Get_Params('p');

    if (empty($H['p'])) {
      $H['p'] = 1;
    }
    
    //検索用セッションに値がある場合は検索条件に含めて能力マスタを検索
    $H['data'] = $mst_ability->GetList($H['search'], $H['p'], 'mst_ability');

    //能力マスタの総件数を取得
    $H['count'] = $mst_ability->GetListCount($H['search'], 'mst_ability');

    $H['maxpage'] = ceil($H['count'] / 10);
    $H['small_num'] = $this->Get_Start_Num($H['p'], $H['count']);
    $H['max_num'] = $this->Get_Last_Num($H['p'], $H['count']);

    //pageMenu関数でペーシ用のファイルを呼び出す
    $H['pagemenu'] = $this->pageMenu($H['p'], $H['maxpage']);

    return $this->h($H);
  }
  
}

//index_controllerクラスのインスタンス化
$controller = new index_controller;
//index_contorllerクラスのLoad関数を呼び出す
$H = $controller->Load();

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