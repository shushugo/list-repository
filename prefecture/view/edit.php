<?php
require_once "../../controller/controller.php";
require_once "../../controller/prefectures/edit_controller.php";
$controller = new edit_controller;
$H = $controller->Load();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>都道府県登録</title>
</head>

<body>
  <div>
    <h1>都道府県登録</h1>
  </div>

  <?php if (!empty($H['err'])) { ?>
    エラーがあります
  <?php } ?>

  <form method="POST">
    <div>
      <div>
        都道府県コード
        <?php if ($H['c']) { ?>
          <?= $H['register']['prefecture_cd'] ?>
          <input type="hidden" name="prefecture_cd" value="<?= $H['register']['prefecture_cd'] ?>">
        <?php } else { ?>
          <input type="text" name="prefecture_cd" value="<?= $H['register']['prefecture_cd'] ?>">
        <?php } ?>
        
        <?php if (!empty($H['err']['prefecture_cd'])) { 
          echo $H['err']['prefecture_cd'];
          } ?>
      </div>

      <div>
        都道府県名
        <input type="text" name="prefecture_name" value="<?= $H['register']['prefecture_name'] ?>">

        <?php if (!empty($H['err']['prefecture_name'])) { 
          echo $H['err']['prefecture_name'];
          } ?>
      </div>

      <div>
        都道府県名カナ
        <input type="text" name="prefecture_name_kana" value="<?= $H['register']['prefecture_name_kana'] ?>">

        <?php if (!empty($H['err']['prefecture_name_kana'])) { 
          echo $H['err']['prefecture_name_kana'];
          } ?>
      </div>
    </div>
    
    <a href="index.php">戻る</a>
    <input type="submit" value="確認" name="btn_conf">
  </form>

</body>