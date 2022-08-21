<?php
require_once "../../controller/controller.php";
require_once "../../controller/ability/conf_controller.php";
$controller = new conf_controller;
$H = $controller->Load();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>能力登録確認</title>
</head>

<body>
  <div>
    <h1>能力登録確認</h1>
  </div>

  <div>
    能力コード

    能力名

    能力名カナ
  </div>

  <a href="index.php">戻る</a>
  <form method="POST">
    <input type="submit" value="登録" name="btn_comp">
  </form>
</body>