<?php

require_once('config.php');
require_once('function.php');

$id = $_GET['id'];

$sql = "update plans set staus = 'done' where id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindParem(":id, $id");
$stmt->execute();

header('Location: index.php');
exit;