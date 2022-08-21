<?php
require_once "../../controller/controller.php";
require_once "../../controller/ability/edit_controller.php";
$controller = new edit_controller;
$H = $controller->Load();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>能力登録</title>
</head>

<body>
  <div>
    <h1>能力一覧</h1>
  </div>

  <?php if (!empty($H['err'])) { ?>
    エラーがあります
  <?php } ?>

  <form method="POST">
    <div>
      <div>
        能力コード
        <input type="text" name="ability_cd" value="<?= $H['register']['ability_cd'] ?>"><br>
        
        <?php if (!empty($H['err']['ability_cd'])) { 
          echo $H['err']['ability_cd'];
          } ?>
      </div>

      <div>
        能力名
        <input type="text" name="ability_name" value="<?= $H['register']['ability_name'] ?>"><br>

        <?php if (!empty($H['err']['ability_name'])) { 
          echo $H['err']['ability_name'];
          } ?>
      </div>

      <div>
        能力名カナ
        <input type="text" name="ability_name_kana" value="<?= $H['register']['ability_name_kana'] ?>"><br>

        <?php if (!empty($H['err']['ability_name_kana'])) { 
          echo $H['err']['ability_name_kana'];
          } ?>
      </div>
    </div>
    
    <a href="index.php">戻る</a>
    <input type="submit" value="確認" name="btn_conf">
  </form>

</body>