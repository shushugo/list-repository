<?php
session_start();

//親クラスを読み込む
require_once '../library/controller.php';

class EditController extends Controller {

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

    //更新用のセッションがない場合セットする
    $this->setSessionPlayer('update', $this->getGetParams('c'));

    //プレイヤー更新のセッションの値を格納(更新のセッションがない場合、NULLを代入される)
    $H['update'] = $this->getSessionPlayer('update');

    //プレイヤーIDがある場合はプレイヤーマスタからデータを取得し、値を格納する(更新の場合)
    if (!empty($H['update'])) {
      $H['register'] = $mst_player->getData(['player_id' => $H['update']]);

      //データを取得できないとプレイヤー一覧画面に移動
      if (empty($H['register'])) {
        $this->redirect("index.php");
      }
    }

    //都道府県のプルダウン用のデータを取得
    $H['prefecture_list'] = $mst_prefecture->getPullList();

    //能力のプルダウン用のデータを取得
    $H['ability_list'] = $mst_ability->getPullList();

    //プレイヤー登録セッションに値がある場合は値を格納する
    if ($this->isSetSessionPlayer('register')) {
      $H['register'] = $this->getSessionPlayer('register');
    }

    $H['register'] = $this->getPostParams($H['register']);

    if ($this->isPost()) {
      //第三引数は1度バリデーションでエラーが出ても更新ということを渡せるように(更新以外NULLが渡される)
      $H['err'] = $this->validation($H['register'], $mst_player, $H['update']);

      if (empty($H['err'])) {
        $this->setSessionPlayer('register', $H['register']);

        if (!empty($H['update'])) {
          //更新
          $this->redirect('conf.php?u=1');
        } else {
          //追加
          $this->redirect('conf.php');
        }
      }
    }

    $this->buffer('../player/view/edit_view.php',$H, '');
  }

  private function validation($data, $mst_player, $c) {
    $err = [];

    //pkを元にデータ取得
    $get_data = $mst_player->getDataByPk($data['player_id'], 'player_id');
    //プレイヤーID
    if ($this->isRequired($data['player_id'])) {
      $err['player_id'] = $this->isRequired($data['player_id']);
    } else if ($get_data && empty($c)) {
      //empty($c)は更新の際にあるhiddenの値を除くため
      $err['player_id'] = 'その値は登録されています。';
    } else if ($this->isHalfAlphanumeric($data['player_id'])) {
      $err['player_id'] = $this->isHalfAlphanumeric($data['player_id']);
    } else if ($this->isMaxLength($data['player_id'], 20)) {
      $err['player_id'] = $this->isMaxLength($data['player_id'], 20);
    }

    //プレイヤー名
    if ($this->isRequired($data['player_name'])) {
      $err['player_name'] = $this->isRequired($data['player_name']);
    } else if ($this->isMaxLength($data['player_name'], 50)) {
      $err['player_name'] = $this->isMaxLength($data['player_name'], 50);
    }

    //性別
    if ($this->isRequired($data['sex_div'])) {
      $err['sex_div'] = $this->isRequired($data['sex_div']);
    }

    return $err;
  }

}

//edit_controllerクラスのインスタンス化
$controller = new EditController;
//edit_contorllerクラスのLoad関数を呼び出す
$controller->load();

?>