<?php
class controller {

  public function Get_Start_Num($p, $count) {
    $rtn = $p * 10 - 10 + 1;
    if ($rtn > $count) {
      return $count;
    }
    return $rtn;
  }

  public function Get_Last_Num($p, $count) {
    $rtn = $p * 10 - 10 + 1;
    if ($p * 10 < $count) {
      return $p * 10;
    }
    return $count;
  }

}
?>