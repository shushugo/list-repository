<?php 
class page_menu {
  public function load($p, $maxpage) {
    if ($p != 1) {
      echo "<a href=\"index.php?p=".$p - 1 ."\">前のページ</a>";
    }
    
    if ($p != $maxpage) {
      echo "<a href=\"index.php?p=".$p + 1 ."\">次のページ</a>";
    }
  }
}
?>