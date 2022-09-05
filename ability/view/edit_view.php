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
      <h1>能力登録</h1>
    </div>
    
    <?php if (!empty($H['err'])) { ?>
      エラーがあります
    <?php } ?>
    
    <form action="<?= !empty($H['c']) ? 'edit.php?c=1' : 'edit.php'; ?>" method="POST">
      <div>
        <div>
          能力コード
          <?php if (!empty($H['c'])) { ?>
            <?= $H['register']['ability_cd'] ?>
            <input type="hidden" name="ability_cd" value="<?= $H['register']['ability_cd'] ?>">
          <?php } else { ?>
            <input type="text" name="ability_cd" value="<?= $H['register']['ability_cd'] ?>">
          <?php } ?>
          
          <?php if (!empty($H['err']['ability_cd'])) { 
            echo $H['err']['ability_cd'];
          } ?>
        </div>
        
        <div>
          能力名
          <input type="text" name="ability_name" value="<?= $H['register']['ability_name'] ?>">
          
          <?php if (!empty($H['err']['ability_name'])) { 
            echo $H['err']['ability_name'];
          } ?>
        </div>
        
        <div>
          能力名カナ
          <input type="text" name="ability_name_kana" value="<?= $H['register']['ability_name_kana'] ?>">
          
          <?php if (!empty($H['err']['ability_name_kana'])) {
            echo $H['err']['ability_name_kana'];
          } ?>
        </div>
      </div>
      
      <a href="index.php">戻る</a>
      <input type="submit" value="確認" name="btn_conf">
    </form>
  </body>
</html>