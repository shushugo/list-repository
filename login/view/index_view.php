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
      選手ID又はパスワードが違います。
    <?php } ?>
    
    <form action="index.php" method="POST">
      <div>
        <div>
          選手ID
          <input type="text" name="player_id" value="">
        </div>

        <div>
          パスワード
          <input type="text" name="player_password" value="">
        </div>
      </div>

      <input type="submit" value="ログイン" name="btn_login">
      <input type="button" value="新規登録" name="btn_menu" onclick="location.href = '../login/edit.php'">
    </form>
  </body>
</html>