<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>能力<?= (!empty($H['delete'])) ? '削除' : '登録'; ?>確認</title>
  </head>
  
  <body>
    <div>
      <h1>能力<?= (!empty($H['delete'])) ? '削除' : '登録'; ?>確認</h1>
    </div>
    
    <div>
      能力コード
      <?= $H['register']['ability_cd'] ?><br>
      
      能力名
      <?= $H['register']['ability_name'] ?><br>
      
      能力名カナ
      <?= $H['register']['ability_name_kana'] ?><br>
    </div>

    <?php if (!empty($H['delete'])) { ?>
      <input type="button" value="戻る" name="btn_back" onclick="location.href = 'index.php'">
    <?php } else { ?>
      <input type="button" value="戻る" name="btn_insert" onclick="location.href = 'edit.php'">
    <?php } ?>

    <?php if (!empty($H['delete'])) { ?>
      <input type="button" value="削除" name="btn_comp" onclick="location.href = 'comp.php'">
    <?php } else { ?>
      <input type="button" value="登録" name="btn_comp" onclick="location.href = 'comp.php'">
    <?php } ?>
  </body>
</html>