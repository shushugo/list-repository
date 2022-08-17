<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>能力一覧</title>
</head>

<body>
  <div>
    <h1>能力一覧</h1>
  </div>

  <form method="POST">
    <div>
      能力コード
      <input type="text" name="ability_cd">
      能力名
      <input type="text"name="ability_name">
    </div>
    
    <div>
      <input type="submit" value="検索" name="btn_search">
      <input type="button" value="リセット" name="btn_reset">
      <input type="button" value="追加" name="btn_insert">
    </div>
  </form>

  何件なのか

  <div>
    <table border="1">
      <tr>
        <th>能力コード</th>
        <th>能力名</th>
        <th>更新</th>
        <th>削除</th>
      </tr>

      <?php foreach($data as $key => $value) { ?>
        <tr>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
        </tr>
      <?php } ?>
    </table>
  </div>

  <a>前のページ</a>
  <a>次のページ</a>

</body>