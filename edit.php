<?php

//ファイルの読み込み
require_once('config.php');
require_once('functions.php');

$dbh = connectDb();
$id = $_GET['id'];

// SQLの準備と実行
$sql = "select * from plans where id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(":id", $id);
$stmt->execute();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $title = $_POST['title'];
  $due_date = $_POST['due_date'];

  //errorが出なっかたら実行
  $errors = [];
  if ($title == '') {
    $errors['title'] =' ・  タスク名が変更されていません';
  }

  if ($due_date == '') {
    $errors['due_date'] = ' ・  日付が変更されていません';
  }

  if(empty($errors)) {
    
    //インサートするsql文
    $sql = "insert into plans (title, due_date, created_at, updated_at) values (:title, :due_date, now(), now())";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":due_date", $due_date);
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
  <title>タスクの編集</title>
</head>
<body>
  <h1>編集</h1>
  <p>
  <form action="" method="post">
      <label for="title"></label>
          <input type="text" name="title" id="">
      <label for="due_date">期限日: </label>
      <input type="date" name="due_date" value="due_date">
      <input type="submit" value="編集"><br>
      <span style="color:red"><?php echo h($errors['title']); ?></span><br>
      <span style="color:red"><?php echo h($errors['due_date']); ?></span>
    </p>

  </form>

  </p>
</body>
</html>