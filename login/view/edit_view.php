<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー新規登録</title>
  </head>

  <body>
    <div>
      <h1>ユーザー新規登録</h1>
    </div>
    
    <?php if (!empty($H['err'])) { ?>
      エラーがあります
    <?php } ?>
    
    <form action="edit.php" method="POST">
      <div>
        <div>
          ユーザーID
          <input type="text" name="user_id" value="<?= $H['register']['user_id'] ?>">
          
          <?php if (!empty($H['err']['user_id'])) { 
            echo $H['err']['user_id'];
          } ?>
        </div>
        
        <div>
          ユーザー名
          <input type="text" name="user_name" value="<?= $H['register']['user_name'] ?>">
          
          <?php if (!empty($H['err']['user_name'])) { 
            echo $H['err']['user_name'];
          } ?>
        </div>

        <div>
          パスワード
          <input type="password" name="user_password" value="<?= $H['register']['user_password'] ?>">
          
          <?php if (!empty($H['err']['user_password'])) {
            echo $H['err']['user_password'];
          } ?>
        </div>
      </div>

      <input type="button" value="戻る" name="btn_back" onclick="location.href = 'index.php'">
      <input type="submit" value="確認" name="btn_conf">
    </form>
  </body>
</html>