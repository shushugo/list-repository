<?php
class controller {

  // public function h($data) {
  //   if (is_array($data)) {
  //     var_dump($data);var_dump(11111);
  //     foreach ($data as $key => $value) {
  //       if (is_array($value)) {
  //         foreach ($value as $k => $v) {
  //           var_dump($v);var_dump(11111);
  //           htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
  //         }
  //       } else {
  //         var_dump($value);var_dump(11111);
  //         htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
  //       }
  //     }
  //   } else {
  //     htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
  //   }
  //   return $data;
  // }
  public function h($data) {
    
    if (is_array($data)) {
      foreach ($data as $key => $value) {
        if (is_array($value)) {
          return array_map("h", $value);
        } else {
          htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }
      }
    } else {
      htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }
    return $data;
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
    $rtn = $p * 10;
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

  public function pageMenu($p, $maxpage) {
    //記録開始
    ob_start();
    //ファイルを読み込む
    require_once "page.php";
    $pagemenu = new page_menu;
    $pagemenu->Load($p, $maxpage);
    //記録結果を$bufferに代入
    $buffer = ob_get_contents();
    //記録終了
    ob_end_clean();
    return $buffer;
  }
}
?>