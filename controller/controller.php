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

}
?>