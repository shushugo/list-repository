<?php
class controller {

  public function arrayMapH($data) {
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

  public function h($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
  }

  //$_POST、$_GETの値を取得する
  public function getPostParams($key) {
    $rtn = filter_input(INPUT_POST, $key);
    return $rtn;
  }

  public function getGetParams($key) {
    $rtn = filter_input(INPUT_GET, $key);
    return $rtn;
  }

  //リダイレクト処理
  public function redirect($url) {
    //var_dump("Location: $url");die;
    header( "Location: $url" );
	  exit;
  }

  //ページのカウント
  public function getStartNum($p, $count) {
    $rtn = $p * 10 - 9;
    if ($rtn > $count) {
      return $count;
    }
    return $rtn;
  }

  public function getLastNum($p, $count) {
    $rtn = $p * 10;
    if ($rtn > $count) {
      return $count;
    }
    return $rtn;
  }

  //入力チェック
  public function isRequired($data) {
    if (empty($data)) {
      $rtn = '入力してください。';
      return $rtn;
    } else {
      return;
    }
  }

  public function isMaxLength($data, $num) {
    if (mb_strlen($data) > $num) {
      $rtn = $num.'文字以下で入力してください';
      return $rtn;
    } else {
      return;
    }
  }

  public function isHalfAlphanumeric($data) {
    if (!preg_match("/^[a-zA-Z0-9]+$/", $data)) {
      $rtn = '半角英数字で入力してください';
      return $rtn;
    } else {
      return;
    }
  }

  public function isKana($data) {
    if (!preg_match("/\A[ァ-ヿ]+\z/u", $data)) {
      $rtn = '全角カタカナで入力してください';
      return $rtn;
    } else {
      return;
    }
  }

  public function pageMenu($p, $max_page) {
    //記録開始
    ob_start();
    //ファイルを読み込む
    require_once "page.php";
    $page_menu = new page_menu;
    $page_menu->load($p, $max_page);
    //記録結果を$bufferに代入
    $buffer = ob_get_contents();
    //記録終了
    ob_end_clean();
    //var_dump($buffer);die;
    return $buffer;
  }
}
?>