<?php
session_start();

//親クラスを読み込む
require_once "../library/controller.php";

class EditController extends Controller {

  public function load() {
    //モデルの読み込み
    require_once "../library/SQL.php";
    require_once "model/mst_prefectures.php";
    $mst_prefectures = new MstPrefectures;

    $H = [
      'register' => [
        'prefecture_cd' => '',
        'prefecture_name' => '',
        'prefecture_name_kana' => ''
      ]
    ];

    $H['c'] = $this->getGetParams('c');

    //都道府県コードがある場合は都道府県マスタからデータを取得し、値を格納する(更新の場合)
    if (isset($H['c'])) {
      $H['register'] = $mst_prefectures->getData(['prefecture_cd' => $H['c']], 'mst_prefecture');

      //データを取得できないと都道府県一覧画面に移動
      if (empty($H['register'])) {
        $this->redirect("index.php");
      }
    }

    foreach ($H['register'] as $key =>$value)  {
      //都道府県登録セッションに値がある場合は値を格納する
      if (!empty($_SESSION['prefecture']['register'][$key])) {
        $H['register'][$key] = $_SESSION['prefecture']['register'][$key];
      }

      //入力したデータ
      $H['data'][$key] = $this->getPostParams($key);

      //バリデーションでエラー出た後でも、フォームに値が格納されるように
      if ($H['data'][$key]) {
        $H['register'][$key] = $H['data'][$key];
      }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $H['err'] = $this->Validation($H['data'], $mst_prefectures, $H['c']);

      if (empty($H['err'])) {
        foreach ($H['register'] as $key =>$value)  {
          $_SESSION['prefecture']['register'][$key] = $H['data'][$key];
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

  public function Validation($data, $mst_prefectures, $c) {
    $err = [];

    $get_data = $mst_prefectures->getData($data, 'mst_prefectures');
    //都道府県コード
    if ($this->IsRequired($data['prefecture_cd'])) {
      $err['prefecture_cd'] = $this->IsRequired($data['prefecture_cd']);
    } else if ($get_data && !$c) {
      $err['prefecture_cd'] = 'その値は登録されています。';
    } else if ($this->IsHalfAlphanumeric($data['prefecture_cd'])) {
      $err['prefecture_cd'] = $this->IsHalfAlphanumeric($data['prefecture_cd']);
    } else if ($this->IsMaxLength($data['prefecture_cd'], 2)) {
      $err['prefecture_cd'] = $this->IsMaxLength($data['prefecture_cd'], 2);
    }

    //都道府県名
    if ($this->IsRequired($data['prefecture_name'])) {
      $err['prefecture_name'] = $this->IsRequired($data['prefecture_name']);
    } else if ($this->IsMaxLength($data['prefecture_name'], 20)) {
      $err['prefecture_name'] = $this->IsMaxLength($data['prefecture_name'], 5);
    }

    //都道府県名カナ
    if (!empty($data['prefecture_name_kana'])) {
      if ($this->IsMaxLength($data['prefecture_name_kana'], 20)) {
        $err['prefecture_name_kana'] = $this->IsMaxLength($data['prefecture_name_kana'], 10);
      } else if ($this->IsKana($data['prefecture_name_kana'])) {
        $err['prefecture_name_kana'] = $this->IsKana($data['prefecture_name_kana']);
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