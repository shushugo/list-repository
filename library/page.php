<?php 
class page_menu {
  public function load($p, $maxpage) {
      if ($p != 1) { 
?>
        <a href="index.php?p=<?= $p - 1 ?>">前のページ</a>
<?php }

      if ($p != $maxpage) { 
?>
         <a href="index.php?p=<?= $p + 1 ?>">次のページ</a>
<?php }
  }
} ?>