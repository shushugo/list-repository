<?php
session_start();

//親クラスを読み込む
require_once "../library/controller.php";

class EditController extends Controller {

  public function load() {
    //モデルの読み込み
    require_once "../library/SQL.php";
    require_once "model/mst_ability.php";
    $mst_ability = new MstAbility;

    $H = [
      'register' => [
        'ability_cd' => '',
        'ability_name' => '',
        'ability_name_kana' => ''
      ]
    ];

    $H['c'] = $this->getGetParams('c');

    //能力コードがある場合は能力マスタからデータを取得し、値を格納する(更新の場合)
    if (isset($H['c'])) {
      $H['register'] = $mst_ability->getData(['ability_cd' => $H['c']], 'mst_ability');

      //データを取得できないと能力一覧画面に移動
      if (empty($H['register'])) {
        $this->redirect("index.php");
      }
    }

    foreach ($H['register'] as $key =>$value)  {
      //能力登録セッションに値がある場合は値を格納する
      if (!empty($_SESSION['ability']['register'][$key])) {
        $H['register'][$key] = $_SESSION['ability']['register'][$key];
      }

      //入力したデータ
      $H['data'][$key] = $this->getPostParams($key);
    }
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $H['err'] = $this->validation($H['data']);

      if (empty($H['err'])) {
        foreach ($H['register'] as $key =>$value)  {
          $_SESSION['ability']['register'][$key] = $H['data'][$key];
        }

        if ($H['c']) {
          //更新
          $this->redirect("conf.php?u=1");
        } else {
          //追加
          $this->redirect("conf.php");
        }
          
      }
    }

    return $this->arrayMapH($H);
  }

  public function validation($data) {
    $err = [];

    //能力コード
    if ($this->isRequired($data['ability_cd'])) {
      $err['ability_cd'] = $this->isRequired($data['ability_cd']);
    } else if ($this->isHalfAlphanumeric($data['ability_cd'])) {
      $err['ability_cd'] = $this->isHalfAlphanumeric($data['ability_cd']);
    } else if ($this->isMaxLength($data['ability_cd'], 2)) {
      $err['ability_cd'] = $this->isMaxLength($data['ability_cd'], 2);
    }

    //能力名
    if ($this->isRequired($data['ability_name'])) {
      $err['ability_name'] = $this->isRequired($data['ability_name']);
    } else if ($this->isMaxLength($data['ability_name'], 20)) {
      $err['ability_name'] = $this->isMaxLength($data['ability_name'], 20);
    }

    //能力名カナ
    if (!empty($data['ability_name_kana'])) {
      if ($this->isMaxLength($data['ability_name_kana'], 20)) {
        $err['ability_name_kana'] = $this->isMaxLength($data['ability_name_kana'], 20);
      } else if ($this->isKana($data['ability_name_kana'])) {
        $err['ability_name_kana'] = $this->isKana($data['ability_name_kana']);
      }
    }

    return $err;
  }

}

//edit_controllerクラスのインスタンス化
$controller = new EditController;
//edit_contorllerクラスのLoad関数を呼び出す
$H = $controller->Load();

//記録開始
ob_start();
//viewファイルを読み込む
require_once "view/edit_view.php";
//記録結果を$bufferに代入
$buffer = ob_get_contents();
//記録終了
ob_end_clean();
echo $buffer;

?>