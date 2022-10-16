<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>選手登録</title>
  </head>

  <body>
    <div>
      <h1>選手登録</h1>
    </div>
    
    <?php if (!empty($H['err'])) { ?>
      エラーがあります
    <?php } ?>
    
    <form action="<?= !empty($H['update']) ? 'edit.php?c='.$H['update'] : 'edit.php'; ?>" method="POST">
      <div>
        <div>
          選手ID
          <?php if (!empty($H['update'])) { ?>
            <?= $H['register']['player_id'] ?>
            <input type="hidden" name="player_id" value="<?= $H['register']['player_id'] ?>">
          <?php } else { ?>
            <input type="text" name="player_id" value="<?= $H['register']['player_id'] ?>">
          <?php } ?>
          
          <?php if (!empty($H['err']['player_id'])) { 
            echo $H['err']['player_id'];
          } ?>
        </div>
        
        <div>
          選手名
          <input type="text" name="player_name" value="<?= $H['register']['player_name'] ?>">
          
          <?php if (!empty($H['err']['player_name'])) { 
            echo $H['err']['player_name'];
          } ?>
        </div>
        
        <div>
          選手名カナ
          <input type="text" name="player_name_kana" value="<?= $H['register']['player_name_kana'] ?>">
          
          <?php if (!empty($H['err']['player_name_kana'])) {
            echo $H['err']['player_name_kana'];
          } ?>
        </div>

        <div>
          性別
          <?php if ($H['register']['sex_div'] == 1) { ?>
            <input type="radio"name="sex_div" value="1" checked>男
          <?php } else { ?>
            <input type="radio"name="sex_div" value="1">男
          <?php } ?>
          
          <?php if ($H['register']['sex_div'] == 2) { ?>
            <input type="radio"name="sex_div" value="2" checked>女
          <?php } else { ?>
            <input type="radio"name="sex_div" value="2">女
          <?php } ?>
          
          <?php if (!empty($H['err']['sex_div'])) {
            echo $H['err']['sex_div'];
          } ?>
        </div>

        <div>
          都道府県
          <select name="prefecture_cd">
            <?php foreach ($H['prefecture_list'] as $key => $value) { ?>
              <?php if ($H['register']['prefecture_cd'] == $value['prefecture_cd']) { ?>
                <option value="<?php echo $value['prefecture_cd'] ?>" selected><?php echo $value['prefecture_name'] ?></option>
              <?php } else { ?>
                <option value="<?php echo $value['prefecture_cd'] ?>"><?php echo $value['prefecture_name'] ?></option>
              <?php } ?>
            <?php } ?>
          </select>
          
          <?php if (!empty($H['err']['prefecture_cd'])) {
            echo $H['err']['prefecture_cd'];
          } ?>
        </div>

        <div>
          能力
          <select name="ability_cd">
            <?php foreach ($H['ability_list'] as $key => $value) { ?>
              <?php if ($H['register']['ability_cd'] == $value['ability_cd']) { ?>
                <option value="<?php echo $value['ability_cd'] ?>" selected><?php echo $value['ability_name'] ?></option>
              <?php } else { ?>
                <option value="<?php echo $value['ability_cd'] ?>"><?php echo $value['ability_name'] ?></option>
              <?php } ?>
              <?php } ?>
          </select>
          
          <?php if (!empty($H['err']['prefecture_cd'])) {
            echo $H['err']['prefecture_cd'];
          } ?>
        </div>

        <div>
          年齢
          <input type="text" name="player_age" value="<?= $H['register']['player_age'] ?>">
          
          <?php if (!empty($H['err']['player_age'])) {
            echo $H['err']['player_age'];
          } ?>
        </div>

        <div>
          備考
          <input type="text" name="player_note" value="<?= $H['register']['player_note'] ?>">
          
          <?php if (!empty($H['err']['player_note'])) {
            echo $H['err']['player_note'];
          } ?>
        </div>
      </div>

      <input type="button" value="戻る" name="btn_back" onclick="location.href = 'index.php'">
      <input type="submit" value="確認" name="btn_conf">
    </form>
  </body>
</html>