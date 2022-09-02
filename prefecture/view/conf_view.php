<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>都道府県<?= (isset($H['c'])) ? '削除' : '登録'; ?>確認</title>
</head>

<body>
  <div>
    <h1>都道府県<?= (isset($H['c'])) ? '削除' : '登録'; ?>確認</h1>
  </div>

  <div>
    都道府県コード
    <?= $H['register']['prefecture_cd'] ?><br>

    都道府県名
    <?= $H['register']['prefecture_name'] ?><br>

    都道府県名カナ
    <?= $H['register']['prefecture_name_kana'] ?><br>
  </div>

    <a href= <?= (isset($H['c'])) ? 'index.php' : 'edit.php'; ?>>戻る</a>

    <?php if (isset($H['c'])) { ?>
      <a href='comp.php?d=1'>削除</a>
    <?php } else if (isset($H['u'])){ ?>
      <a href='comp.php?u=1'>登録</a>
    <?php } else { ?>
      <a href='comp.php'>登録</a>
    <?php } ?>
</body>