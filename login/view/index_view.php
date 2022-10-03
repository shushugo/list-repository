<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
  </head>

  <body>
    <div>
      <h1>ログイン</h1>
    </div>
    
    <?php if (!empty($H['err'])) { ?>
      エラーがあります
    <?php } ?>
    
    <form action="login.php" method="POST">
      <div>
        <div>
          選手ID
          <input type="text" name="player_id" value="">
          
          <?php if (!empty($H['err']['player_id'])) { 
            echo $H['err']['player_id'];
          } ?>
        </div>

        <div>
          パスワード
          <input type="text" name="player_password" value="">
          
          <?php if (!empty($H['err']['player_password'])) {
            echo $H['err']['player_password'];
          } ?>
        </div>
      </div>

      <input type="submit" value="ログイン" name="btn_login">
    </form>
  </body>
</html>