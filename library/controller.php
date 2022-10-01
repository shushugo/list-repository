<?php
class Controller {

  protected function arrayMapH($data) {
    if (is_array($data)) {
      $arr = [];
      foreach ($data as $key => $value) {
        $arr[$this->h($key)] = $value;
      }
      return array_map(['controller', 'arrayMapH'], $arr);
    } else {
       return $this->h($data);
    }
  }

  protected function h($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
  }

  //POSTかどうか判定を行う
  protected function isPost() {
    $rtn = false;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $rtn = true;
    }
    return $rtn;
  }

  //$_POST、$_GETの値を取得する
  protected function getPostParams($arr) {
    $rtn = filter_input_array(INPUT_POST, $arr);
    if (is_null($rtn)) {
      return $arr;
    }
    return $rtn;
  }

  protected function getGetParams($key) {
    $rtn = filter_input(INPUT_GET, $key);
    return $rtn;
  }

  //リダイレクト処理
  protected function redirect($url) {
    header( "Location: $url" );
	  exit;
  }

  //ページのカウント
  protected function getStartNum($p, $count) {
    $rtn = $p * 10 - 9;
    if ($rtn > $count) {
      return $count;
    }
    return $rtn;
  }

  protected function getLastNum($p, $count) {
    $rtn = $p * 10;
    if ($rtn > $count) {
      return $count;
    }
    return $rtn;
  }

  //入力チェック

  protected function isRequired($data) {
    if (empty($data)) {
      $rtn = '入力してください。';
      return $rtn;
    } else {
      return;
    }
  }

  protected function isMaxLength($data, $num) {
    if (mb_strlen($data) > $num) {
      $rtn = $num.'文字以下で入力してください';
      return $rtn;
    } else {
      return;
    }
  }

  protected function isHalfAlphanumeric($data) {
    if (!preg_match("/^[a-zA-Z0-9]+$/", $data)) {
      $rtn = '半角英数字で入力してください';
      return $rtn;
    } else {
      return;
    }
  }

  protected function isKana($data) {
    if (!preg_match("/\A[ァ-ヿ]+\z/u", $data)) {
      $rtn = '全角カタカナで入力してください';
      return $rtn;
    } else {
      return;
    }
  }

  protected function pageMenu($p, $max_page) {
    //記録開始
    ob_start();
    //ファイルを読み込む
    require_once "page.php";
    $page_menu = new PageMenu;
    $page_menu->load($p, $max_page);
    //記録結果を$bufferに代入
    $buffer = ob_get_contents();
    //記録終了
    ob_end_clean();
    return $buffer;
  }

  protected function buffer($file, $H, $page_menu) {
    //エスケープ処理
    $H = $this->arrayMapH($H);
    //記録開始
    ob_start();
    //viewファイルを読み込む
    require_once $file;
    //記録結果を$bufferに代入
    $buffer = ob_get_contents();
    //記録終了
    ob_end_clean();
    
    echo $buffer;
  }

  //sessionに関する関数

  //能力に関するセッションを破棄する
  protected function clearSessionAbility($key) {
    unset($_SESSION['ability'][$key]);
  }

  //都道府県に関するセッションを破棄する
  protected function clearSessionPrefecture($key) {
    unset($_SESSION['prefecture'][$key]);
  }

  //プレイヤーに関するセッションを破棄する
  protected function clearSessionPlayer($key) {
    unset($_SESSION['player'][$key]);
  }

  //能力に関するセッションをセットする
  protected function setSessionAbility($key, $arr) {
    if (!empty($arr)) {
      $_SESSION['ability'][$key] = $arr;
    }
  }

  //都道府県に関するセッションをセットする
  protected function setSessionPrefecture($key, $arr) {
    if (!empty($arr)) {
      $_SESSION['prefecture'][$key] = $arr;
    }
  }

  //プレイヤーに関するセッションをセットする
  protected function setSessionPlayer($key, $arr) {
    if (!empty($arr)) {
      $_SESSION['player'][$key] = $arr;
    }
  }

  //能力に関するセッションをセットされてるかどうか
  protected function isSetSessionAbility($key) {
    if (isset($_SESSION['ability'][$key])) {
      return 1;
    } 
  }

  //都道府県に関するセッションをセットされてるかどうか
  protected function isSetSessionPrefecture($key) {
    if (isset($_SESSION['prefecture'][$key])) {
      return 1;
    } 
  }

  //プレイヤーに関するセッションをセットされてるかどうか
  protected function isSetSessionPlayer($key) {
    if (isset($_SESSION['player'][$key])) {
      return 1;
    } 
  }

  //能力に関するセッションをゲットする
  protected function getSessionAbility($key) {
    if (!empty($_SESSION['ability'][$key])) {
      return $_SESSION['ability'][$key];
    }
  }

  //都道府県に関するセッションをゲットする
  protected function getSessionPrefecture($key) {
    if (!empty($_SESSION['prefecture'][$key])) {
      return $_SESSION['prefecture'][$key];
    }
  }

  //プレイヤーに関するセッションをゲットする
  protected function getSessionPlayer($key) {
    if (!empty($_SESSION['player'][$key])) {
      return $_SESSION['player'][$key];
    }
  }

}
?>