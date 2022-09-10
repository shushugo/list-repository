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

    //更新用のセッションがない場合セットする
    $this->setSessionAbilityUpdate($this->getGetParams('c'));

    //能力更新のセッションの値を格納
    $H['update'] = $this->getSessionAbilityUpdate();

    //能力コードがある場合は能力マスタからデータを取得し、値を格納する(更新の場合)
    if (!empty($H['update'])) {
      $H['register'] = $mst_ability->getData(['ability_cd' => $H['update']], 'mst_ability');

      //データを取得できないと能力一覧画面に移動
      if (empty($H['register'])) {
        $this->redirect("index.php");
      }
    }

    foreach ($H['register'] as $key =>$value)  {
      //能力登録セッションに値がある場合は値を格納する
      if ($this->getSessionAbilityRegister()) {
        $H['register'] = $this->getSessionAbilityRegister();
      }

      //入力したデータ
      $H['data'][$key] = $this->getPostParams($key);

      //バリデーションでエラー出た後でも、フォームに値が格納されるように
      if ($H['data'][$key]) {
        $H['register'][$key] = $H['data'][$key];
      }
      
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      //第三引数は1度バリデーションでエラーが出ても更新ということを渡せるように
      $H['err'] = $this->validation($H['data'], $mst_ability, $H['update']);

      if (empty($H['err'])) {
        foreach ($H['register'] as $key =>$value)  {
          $this->setSessionAbilityRegister($key, $H['data'][$key]);

        }

        if (!empty($H['update'])) {
          //更新
          $this->redirect("conf.php?u=1");
        } else {
          //追加
          $this->redirect("conf.php");
        }
          
      }
    }

    $this->buffer('../ability/view/edit_view.php',$H, '');
  }

  public function validation($data, $mst_ability, $c) {
    $err = [];

    //pkを元にデータ取得
    $get_data = $mst_ability->getDataByPk($data['ability_cd'], 'ability_cd', 'mst_ability');
    //能力コード
    if ($this->isRequired($data['ability_cd'])) {
      $err['ability_cd'] = $this->isRequired($data['ability_cd']);
    } else if ($get_data && empty($c)) {
      //empty($c)は更新の際にあるhiddenの値を除くため
      $err['ability_cd'] = 'その値は登録されています。';
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
$controller->load();

?>