<?php

define('DSN', 'mysql:host=mysql;dbname=learning_plan;charset=utf8;');
define('USER', 'admin_user');
define('PASSWORD', '1234');

try {
  $dbh = new PDO(DSN, USER, PASSWORD);
} catch (PDOException $e) {
  echo $e->getMessage();
  exit;
}

