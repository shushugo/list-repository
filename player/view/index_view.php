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
      性別
        <input type="radio"name="sex_div" value="<?= !empty($H['search']['player_name']) ? $H['search']['player_name'] : ''; ?>">全て
        <input type="radio"name="sex_div" value="<?= !empty($H['search']['player_name']) ? $H['search']['player_name'] : ''; ?>">男
        <input type="radio"name="sex_div" value="<?= !empty($H['search']['player_name']) ? $H['search']['player_name'] : ''; ?>">女
        
        都道府県
        <select name="prefecture_cd">
          <?php foreach ($H['prefecture_list'] as $key => $value) { ?>
            <option value="<?php $value['prefecture_cd'] ?>"><?php echo $value['prefecture_name'] ?></option>
          <?php } ?>
        </select>

        能力
        <select name="ability_cd">
        <?php foreach ($H['ability_list'] as $key => $value) { ?>
            <option value="<?php $value['ability_cd'] ?>"><?php echo $value['ability_name'] ?></option>
          <?php } ?>
        </select>
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
            <!-- <th>能力</th> -->
            <th>更新</th>
            <th>削除</th>
          </tr>
          
          <?php foreach($H['data'] as $key => $value) { ?>
            <tr>
              <th><?= $H['data'][$key]['player_id'] ?></th>
              <th><?= $H['data'][$key]['player_name'] ?></th>
              <th><?= $H['data'][$key]['sex_div'] ?></th>
              <th><?= $H['data'][$key]['player_age'] ?></th>
              <!-- <th><?= $H['data'][$key]['ability_cd'] ?></th> -->
              <th><a href="edit.php?c=<?= $H['data'][$key]['prefecture_cd'] ?>">更新</a></th>
              <th><a href="conf.php?c=<?= $H['data'][$key]['prefecture_cd'] ?>">削除</a></th>
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