<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>能力登録完了</title>
  </head>
  
  <body>
    <?php if ($H['res'] != 1) { ?>
      <?= $H['res'] ?><br>
    <?php } ?>

    能力の<?= $H['crud'] ?>が<?= ($H['res'] == 1) ? '完了' : '失敗' ?>しました。<br>
    
    <input type="button" value="戻る" name="btn_back" onclick="location.href = 'index.php'">
  </body>
</html>