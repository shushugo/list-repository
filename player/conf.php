<?php
session_start();

//親クラスを読み込む
require_once '../library/controller.php';

class ConfController extends Controller {

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
      'register' => [
        'player_id' => '',
        'player_name' => '',
        'player_name_kana' => '',
        'sex_div' => '',
        'prefecture_cd' => '',
        'player_age' => '',
        'player_note' => '',
        'ability_cd' => ''
      ]
    ];


    //削除用のセッションがない場合セットする
    $this->setSessionPlayer('delete', $this->getGetParams('c'));

    //選手更新のセッションの値を格納
    $H['delete'] = $this->getSessionPlayer('delete');

    //選手更新のセッションの値を格納
    $H['update'] = $this->getSessionPlayer('update');

    //選手IDがある場合は選手マスタからデータを取得し、値を格納する(削除)
    if (!empty($H['delete'])) {
      $H['register'] = $mst_player->getData(['player_id' => $H['delete']]);

      //データを取得できないと選手一覧画面に移動
      if (empty($H['register'])) {
        $this->redirect('index.php');
      }

      //選手登録用セッションに取得したデータを格納する
      $this->setSessionPlayer('register', $H['register']);
    }

    //選手登録セッションに値がある場合はその値を表示する
    if ($this->isSetSessionPlayer('register')) {
      $H['register'] = $this->getSessionPlayer('register');
    }

    //都道府県コードから都道府県名を取得する
    $H['register']['prefecture_name'] = $mst_prefecture->getDataByPk($H['register']['prefecture_cd'], 'prefecture_cd')['prefecture_name'];

    //能力コードから能力名を取得す
    $H['register']['ability_name'] = $mst_ability->getDataByPk($H['register']['ability_cd'], 'ability_cd')['ability_name'];

    $this->buffer('../player/view/conf_view.php',$H, '');
  }
}

//conf_controllerクラスのインスタンス化
$controller = new ConfController;
//conf_contorllerクラスのLoad関数を呼び出す
$controller->Load();

?>