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

$sql = "select * from plans where status = 'done'";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$done_tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

//新規タスクの追加
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $title = $_POST['title'];
  $due_date = $_POST['due_date'];

  //errorが出なっかたら実行
  $errors = [];
  if ($title == '') {
    $errors['title'] =' ・  タスク名を入力して下さい';
  }

  if ($due_date == '') {
    $errors['due_date'] = ' ・  期限を入力して下さい';
  }

  if(empty($errors)) {
    
    //インサートするsql文
    $sql = "insert into plans (title, due_date, created_at, update_at) values (:title, :due_date, now(), now())";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(":title", $title);
    $ttmt->bindParam(":due_date", $due_date);
    $stmt->execute();
  
    //index.phpに戻る
    header('Location: index.php');
    exit;}
  }

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="style.css">
  <title>学習管理</title>
</head>
<body>
  <h1>学習管理アプリ</h1>
  <p>
  <form action="" method="post">
      <label for="title">学習内容: </label>
          <input type="text" name="title" id=""><br>
    <span style="color:red"><?php echo h($errors['title']); ?></span>
    </p>

    <p>
      <label for="due_date">期限日: </label>
      <input type="date" name="due_date" value="due_date">
      <span style="color:red"><?php echo h($errors['due_date']); ?></span>

      <input type="submit" value="追加"><br>
    </p>

  </form>


<h2>未達成</h2>

<ul>
  <?php foreach ($notyet_plans as $task) : ?>
  <li>
    <a href="done.php?id=<?php echo h($task['id']) ; ?>">[完了]</a>
    <a href="edit.php?id=<?php echo h($task['id']) ; ?>">[編集]</a>
    <?php echo h($task['title']); ?>
  </li>
  <?php endforeach; ?>
</ul>

<hr>

<h2>達成済み</h2>

<ul>
  <?php foreach ($done_tasks as $task) : ?>
    <li>
      <?php echo h($task['title']); ?>
    </li>
  <?php endforeach; ?>
</ul>

</body>
</html>