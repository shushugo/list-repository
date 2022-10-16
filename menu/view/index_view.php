<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メニュー</title>
  </head>
  
  <body>
    <h1>メニュー</h1>

    <div>
      ログイン者名:<?php echo $H['login']['user_name']; ?>
    </div>

    <div>
       <input type="button" value="選手" name="btn_reset" onclick="location.href = '../player/index.php'">
    </div>

    <div>
       <input type="button" value="都道府県" name="btn_reset" onclick="location.href = '../prefecture/index.php'">
    </div>

    <div>
       <input type="button" value="能力" name="btn_reset" onclick="location.href = '../ability/index.php'">
    </div>

    <div>
       <input type="button" value="ログアウト" name="btn_reset" onclick="location.href = '../login/index.php'">
    </div>

  </body>
</html>