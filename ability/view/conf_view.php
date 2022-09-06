<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>能力<?= (!empty($_SESSION['delete'])) ? '削除' : '登録'; ?>確認</title>
  </head>
  
  <body>
    <div>
      <h1>能力<?= (!empty($_SESSION['delete'])) ? '削除' : '登録'; ?>確認</h1>
    </div>
    
    <div>
      能力コード
      <?= $H['register']['ability_cd'] ?><br>
      
      能力名
      <?= $H['register']['ability_name'] ?><br>
      
      能力名カナ
      <?= $H['register']['ability_name_kana'] ?><br>
    </div>

    <?php if (!empty($_SESSION['delete'])) { ?>
      <a href='index.php'>戻る</a>
    <?php } else if (!empty($_SESSION['update'])){ ?>
      <a href='edit.php?c=<?= $_SESSION['update'] ?>'>戻る</a>
    <?php } else { ?>
      <a href='edit.php'>戻る</a>
    <?php } ?>

    <?php if (!empty($_SESSION['delete'])) { ?>
      <a href='comp.php?d=1'>削除</a>
    <?php } else if (!empty($_SESSION['update'])){ ?>
      <a href='comp.php?u=1'>更新</a>
    <?php } else { ?>
      <a href='comp.php'>登録</a>
    <?php } ?>
  </body>
</html>