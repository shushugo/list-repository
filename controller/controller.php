<?php
class controller {

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

}
?>