<?php
class controller {

  public function h($data) {
    //var_dump($data);
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
  }

  //$_POST、$_GETの値を取得する
  public function Set_Post_Params($key) {
    $rtn = filter_input(INPUT_POST, $key);
    return $rtn;
  }

  public function Set_Get_Params($key) {
    $rtn = filter_input(INPUT_GET, $key);
    return $rtn;
  }

  //リダイレクト処理
  public function Redirect($url) {
    //var_dump("Location: $url");die;
    header( "Location: $url" );
	  exit;
  }

  //ページのカウント
  public function Get_Start_Num($p, $count) {
    $rtn = $p * 10 - 9;
    if ($rtn > $count) {
      return $count;
    }
    return $rtn;
  }

  public function Get_Last_Num($p, $count) {
    $rtn = $p * 10 + 1;
    if ($rtn > $count) {
      return $count;
    }
    return $rtn;
  }

  //入力チェック
  public function IsRequired($data) {
    if (empty($data)) {
      $rtn = '入力してください。';
      return $rtn;
    } else {
      return;
    }
  }

  public function IsMaxLength($data, $num) {
    if (mb_strlen($data) > $num) {
      $rtn = $num.'文字以下で入力してください';
      return $rtn;
    } else {
      return;
    }
  }

  public function IsHalfAlphanumeric($data) {
    if (!preg_match("/^[a-zA-Z0-9]+$/", $data)) {
      $rtn = '半角英数字で入力してください';
      return $rtn;
    } else {
      return;
    }
  }

  public function IsKana($data) {
    if (!preg_match("/\A[ァ-ヿ]+\z/u", $data)) {
      $rtn = '全角カタカナで入力してください';
      return $rtn;
    } else {
      return;
    }
  }
}
?>