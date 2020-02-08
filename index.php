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

//新規タスクの追加
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $title = $_POST['title'];

  //インサートするsql文
  $sql = "insert into plans (title, due_date, created_at, update_at) values (:title, :due_date, now(), now())";
  $stmt = $dbh->prepare($sql);
  $stmt->bindParam(":title", $title, ":due_date", $due_date);
  $stmt->execute();

  //index.phpに戻る
  header('Location: index.php');
  exit;
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>学習管理アプリ</title>
</head>
<body>
  <h1>学習管理アプリ</h1>
<p>
  <form action="" method="post">
    <h4>学習内容: 
    <input type="text" name="title" id="">
    <br>期限日: 
    <input type="date">
    <input type="submit" value="追加">
    </h4>
  </form>
</p>



<h2>未達成</h2>
<ul>
  <?php foreach ($notyet_plans as $task) : ?>
  <li><?php echo h($task['title']); ?></li>
  <?php endforeach; ?>
</ul>

<hr>

<h2>達成済み</h2>



</body>
</html>