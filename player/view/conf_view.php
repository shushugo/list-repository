<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>選手<?= (!empty($H['delete'])) ? '削除' : '登録'; ?>確認</title>
  </head>
  
  <body>
    <div>
      <h1>選手<?= (!empty($H['delete'])) ? '削除' : '登録'; ?>確認</h1>
    </div>
    
    <div>
      選手ID
      <?= $H['register']['player_id'] ?><br>
      
      選手名
      <?= $H['register']['player_name'] ?><br>
      
      選手名カナ
      <?= $H['register']['player_name_kana'] ?><br>

      性別
      <?php if ($H['register']['sex_div'] == 1) { ?>
        <?= '男' ?><br>
      <?php } else if ($H['register']['sex_div'] == 2) { ?>
        <?= '女' ?><br>
      <?php } ?>

      都道府県
      <?= $H['register']['prefecture_name'] ?><br>

      能力
      <?= $H['register']['ability_name'] ?><br>

      年齢
      <?= $H['register']['player_age'] ?><br>

      備考
      <?= $H['register']['player_note'] ?>
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