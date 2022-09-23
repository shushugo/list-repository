<?php
session_start();

//親クラスを読み込む
require_once '../library/controller.php';

class ConfController extends Controller {

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

    //削除用のセッションがない場合セットする
    $this->setSessionPrefecture('delete', $this->getGetParams('c'));

    //都道府県更新のセッションの値を格納
    $H['delete'] = $this->getSessionPrefecture('delete');

    //都道府県更新のセッションの値を格納
    $H['update'] = $this->getSessionPrefecture('update');

    //都道府県コードがある場合は都道府県マスタからデータを取得し、値を格納する(削除)
    if (!empty($H['delete'])) {
      $H['register'] = $mst_prfectures->getData(['prefecture_cd' => $H['delete']]);

      //データを取得できないと能力一覧画面に移動
      if (empty($H['register'])) {
        $this->redirect('index.php');
      }

      //都道府県登録用セッションに取得したデータを格納する
      $this->setSessionPrefecture('register', $H['register']);
    }

    //都道府県登録セッションに値がある場合はその値を表示する
    if ($this->isSetSessionPrefecture('register')) {
      $H['register'] = $this->getSessionPrefecture('register');
    }

    $this->buffer('../prefecture/view/conf_view.php',$H, '');
  }
}

//conf_controllerクラスのインスタンス化
$controller = new ConfController;
//conf_contorllerクラスのLoad関数を呼び出す
$controller->Load();

?>