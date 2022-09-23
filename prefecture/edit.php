<?php
session_start();

//親クラスを読み込む
require_once '../library/controller.php';

class EditController extends Controller {

  public function load() {
    //モデルの読み込み
    require_once '../library/SQL.php';
    require_once 'model/mst_prefectures.php';
    $mst_prfectures = new MstPrefectures;
    
    $H = [
      'register' => [
        'prefecture_cd' => '',
        'prefecture_name' => '',
        'prefecture_name_kana' => ''
      ]
    ];

    //更新用のセッションがない場合セットする
    $this->setSessionPrefecture('update', $this->getGetParams('c'));

    //都道府県更新のセッションの値を格納(更新のセッションがない場合、NULLを代入される)
    $H['update'] = $this->getSessionPrefecture('update');

    //都道府県コードがある場合は都道府県マスタからデータを取得し、値を格納する(更新の場合)
    if (!empty($H['update'])) {
      $H['register'] = $mst_prfectures->getData(['prefecture_cd' => $H['update']]);

      //データを取得できないと都道府県一覧画面に移動
      if (empty($H['register'])) {
        $this->redirect("index.php");
      }
    }

    //都道府県登録セッションに値がある場合は値を格納する
    if ($this->isSetSessionPrefecture('register')) {
      $H['register'] = $this->getSessionPrefecture('register');
    }

    $H['register'] = $this->getPostParams($H['register']);

    if ($this->isPost()) {
      //第三引数は1度バリデーションでエラーが出ても更新ということを渡せるように(更新以外NULLが渡される)
      $H['err'] = $this->validation($H['register'], $mst_prfectures, $H['update']);

      if (empty($H['err'])) {
        $this->setSessionPrefecture('register', $H['register']);

        if (!empty($H['update'])) {
          //更新
          $this->redirect('conf.php?u=1');
        } else {
          //追加
          $this->redirect('conf.php');
        }
      }
    }

    $this->buffer('../prefecture/view/edit_view.php',$H, '');
  }

  private function validation($data, $mst_prfectures, $c) {
    $err = [];

    //pkを元にデータ取得
    $get_data = $mst_prfectures->getDataByPk($data['prefecture_cd'], 'prefecture_cd');
    //都道府県コード
    if ($this->isRequired($data['prefecture_cd'])) {
      $err['prefecture_cd'] = $this->isRequired($data['prefecture_cd']);
    } else if ($get_data && empty($c)) {
      //empty($c)は更新の際にあるhiddenの値を除くため
      $err['prefecture_cd'] = 'その値は登録されています。';
    } else if ($this->isHalfAlphanumeric($data['prefecture_cd'])) {
      $err['prefecture_cd'] = $this->isHalfAlphanumeric($data['prefecture_cd']);
    } else if ($this->isMaxLength($data['prefecture_cd'], 2)) {
      $err['prefecture_cd'] = $this->isMaxLength($data['prefecture_cd'], 2);
    }

    //都道府県名
    if ($this->isRequired($data['prefecture_name'])) {
      $err['prefecture_name'] = $this->isRequired($data['prefecture_name']);
    } else if ($this->isMaxLength($data['prefecture_name'], 5)) {
      $err['prefecture_name'] = $this->isMaxLength($data['prefecture_name'], 5);
    }

    //都道府県名カナ
    if (!empty($data['prefecture_name_kana'])) {
      if ($this->isMaxLength($data['prefecture_name_kana'], 10)) {
        $err['prefecture_name_kana'] = $this->isMaxLength($data['prefecture_name_kana'], 10);
      } else if ($this->isKana($data['prefecture_name_kana'])) {
        $err['prefecture_name_kana'] = $this->isKana($data['prefecture_name_kana']);
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