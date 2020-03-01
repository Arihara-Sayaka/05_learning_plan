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

$plans = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $title = $_POST['title'];
  $due_date = $_POST['due_date'];

  //errorが出なっかたら実行
  $errors = [];
  if ($title == '') {
    $errors['title'] ='タスク名が変更されていません';
  }

  if ($due_date == '') {
    $errors['due_date'] = '日付が変更されていません';
  }

  if(empty($errors)) {
    
    //インサートするsql文
    $sql = "update plans set title =:title, due_date = :due_date,  created_at = now(), updated_at = now() where id = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":due_date", $due_date);
    $stmt->bindParam(":id", $id);
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
      <label for="title">
        <input type="text" name="title" id="" value="<?php echo h($plans['title']); ?>">
      </label>

      <label for="due_date">期限日: 
        <input type="date" name="due_date" value="<?php echo h($plans['due_date']); ?>">
        <input type="submit" value="編集"><br>
      </label>

      <?php if (count($errors) > 0) : ?>
        <ul style="color:red;">
          <?php foreach ($errors as $key => $value) : ?>
            <li><?php echo h($value); ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>

    </form>
  </p>
</body>
</html>