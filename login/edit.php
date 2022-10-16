<?php
session_start();

//親クラスを読み込む
require_once '../library/controller.php';

class EditController extends Controller {

  public function load() {
    //モデルの読み込み
    require_once '../library/SQL.php';
    require_once 'model/mst_user.php';
    $mst_user = new MstUser;

    $H = [
      'register' => [
        'user_id' => '',
        'user_name' => '',
        'user_password' => ''
      ]
    ];

    $H['register'] = $this->getPostParams($H['register']);

    if ($this->isPost()) {
      $H['err'] = $this->validation($H['register'], $mst_user);

      if (empty($H['err'])) {
        $this->setSessionUser('register', $H['register']);
        $H['res'] = $mst_user->insert($H['register']);

        $this->redirect('../menu/index.php');
      }
    }

    $this->buffer('view/edit_view.php',$H, '');
  }

  private function validation($data, $mst_user) {
    $err = [];

    //pkを元にデータ取得
    $get_data = $mst_user->getDataByPk($data['user_id'], 'user_id');
    //ユーザーID
    if ($this->isRequired($data['user_id'])) {
      $err['user_id'] = $this->isRequired($data['user_id']);
    } else if ($get_data) {
      $err['user_id'] = 'その値は登録されています。';
    } else if ($this->isHalfAlphanumeric($data['user_id'])) {
      $err['user_id'] = $this->isHalfAlphanumeric($data['user_id']);
    } else if ($this->isMaxLength($data['user_id'], 20)) {
      $err['user_id'] = $this->isMaxLength($data['user_id'], 20);
    }

    //ユーザー名
    if ($this->isRequired($data['user_name'])) {
      $err['user_name'] = $this->isRequired($data['user_name']);
    } else if ($this->isMaxLength($data['user_name'], 50)) {
      $err['user_name'] = $this->isMaxLength($data['user_name'], 50);
    }

    //ユーザーパスワード
    if ($this->isRequired($data['user_password'])) {
      $err['user_password'] = $this->isRequired($data['user_password']);
    } else if ($this->isMaxLength($data['user_password'], 50)) {
      $err['user_password'] = $this->isMaxLength($data['user_password'], 50);
    }

    return $err;
  }

}

//edit_controllerクラスのインスタンス化
$controller = new EditController;
//edit_contorllerクラスのLoad関数を呼び出す
$controller->load();

?>