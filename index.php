<?php

define('DSN', 'mysql:host=mysql;dbname=learning_plan;charset=utf8;');
define('DB_USER', 'admin_user');
define('DB_PASSWORD', '1234');

function connectDb() {
  try {
    return new PDO(DSN, DB_USER, DB_PASSWORD);
  } catch (PDOException $e) {
    echo $e->getMessage();
    exit;
  }
}

