<?php

//ファイルの読み込み
require_once('config.php');
require_once('function.php');

$dbh = connectDb();

//レコードの取得
$sql = "select * from plans where status = 'not yet'";
$stmt =$dbh->prepare($sql);
$stmt->execute();
$notyet_plans = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>タスクの編集</title>
</head>
<body>
  <h1>編集</h1>
  <p>
  <form action="" method="post">
      <label for="title"></label>
          <input type="text" name="title" id="">
    <span style="color:red"><?php echo h($errors['title']); ?></span>
      <label for="due_date">期限日: </label>
      <input type="date" name="due_date" value="due_date">
      <span style="color:red"><?php echo h($errors['due_date']); ?></span>

      <input type="submit" value="追加"><br>
    </p>

  </form>

  </p>
</body>
</html>