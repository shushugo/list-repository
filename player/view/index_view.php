<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>選手一覧</title>
  </head>
  
  <body>
    <div>
      <h1>選手一覧</h1>
    </div>
    
    <form action="index.php" method="POST">
      <div>
        選手ID
        <input type="text" name="player_id" value="<?= !empty($H['search']['player_id']) ? $H['search']['player_id'] : ''; ?>">
        選手名
        <input type="text"name="player_name" value="<?= !empty($H['search']['player_name']) ? $H['search']['player_name'] : ''; ?>">
      </div>
      
      <div>
        <input type="submit" value="検索" name="btn_search">
        <input type="button" value="リセット" name="btn_reset" onclick="location.href = 'index.php'">
        <input type="button" value="追加" name="btn_insert" onclick="location.href = 'edit.php'">
      </div>
    </form>
    
    <?php if (!empty($H['data'])) { ?>
      <?= $H['count'] ?>件中<?= $H['small_num'] ?>～<?= $H['max_num'] ?>
      
      <div>
        <table border="1">
          <tr>
            <th>選手ID</th>
            <th>選手名</th>
            <th>性別</th>
            <th>年齢</th>
            <th>能力コード</th>
            <th>更新</th>
            <th>削除</th>
          </tr>
          
          <?php foreach($H['data'] as $key => $value) { ?>
            <tr>
              <th><?= $H['data'][$key]['player_id'] ?></th>
              <th><?= $H['data'][$key]['player_name'] ?></th>
              <th>
                <?php if ($H['data'][$key]['sex_div'] == 1) { ?>
                  <?= '男' ?>
                <?php } else if ($H['data'][$key]['sex_div'] == 2) { ?>
                  <?= '女' ?>
                <?php } ?>
              </th>
              <th><?= $H['data'][$key]['player_age'] ?></th>
              <th><?= $H['data'][$key]['ability_cd'] ?></th>
              <th><a href="edit.php?c=<?= $H['data'][$key]['player_id'] ?>">更新</a></th>
              <th><a href="conf.php?c=<?= $H['data'][$key]['player_id'] ?>">削除</a></th>
            </tr>
          <?php } ?>
        </table>
      </div>
      
      <?= $page_menu ?>

    <?php } else { ?>
      「データが存在しません」
    <?php } ?>
  </body>
</html>