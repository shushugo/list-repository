<?php
require_once "../../controller/controller.php";
require_once "../../controller/prefectures/index_controller.php";
$controller = new index_controller;
$H = $controller->Load();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>都道府県一覧</title>
</head>

<body>
  <div>
    <h1>都道府県一覧</h1>
  </div>

  <form method="POST">
    <div>
      都道府県コード
      <input type="text" name="ability_cd" value="<?= !empty($H['search']['prefecture_cd']) ? $H['search']['prefecture_cd'] : ''; ?>">
      都道府県名
      <input type="text"name="prefecture_name" value="<?= !empty($H['search']['prefecture_name']) ? $H['search']['prefecture_name'] : ''; ?>">
    </div>
    
    <div>
      <input type="submit" value="検索" name="btn_search">
      <button type="submit" value="1" name="btn_reset">リセット</button>
      <a href="edit.php">追加</a>
    </div>
  </form>

  <?php if ($H['data']) { ?>
    <?= $H['count'] ?>件中<?= $H['small_num'] ?>～<?= $H['max_num'] ?>
    
    <div>
      <table border="1">
        <tr>
          <th>都道府県コード</th>
          <th>都道府県名</th>
          <th>更新</th>
          <th>削除</th>
        </tr>
        
        <?php foreach($H['data'] as $key => $value) { ?>
          <tr>
            <th><?= $H['data'][$key]['prefecture_cd'] ?></th>
            <th><?= $H['data'][$key]['prefecture_name'] ?></th>
            <th><a href="edit.php?c=<?= $H['data'][$key]['prefecture_cd'] ?>">更新</a></th>
            <th><a href="conf.php?c=<?= $H['data'][$key]['prefecture_cd'] ?>">削除</a></th>
          </tr>
        <?php } ?>
      </table>
    </div>
    
    <?php if ($H['p'] != 1) { ?>
      <a href="index.php?p=<?= $H['p'] -1?>">前のページ</a>
    <?php } ?>
    
    <?php if ($H['p'] != $H['maxpage']) { ?>
      <a href="index.php?p=<?= $H['p'] +1?>">次のページ</a>
    <?php } ?>
  <?php } else { ?>
    「データが存在しません」
  <?php } ?>
  
</body>