<?php
require_once('info_db.php');

init_db($db_config);

function init_db($db_config)
{

//First connexion to mysql. DB not created yet.
try{
  $pdo = new PDO($db_config['init'], $db_config['user'], $db_config['pwd']);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch(PDOException $e) {
      die("ERROR: Could not connect. " . $e->getMessage());
  }

//Creation of database
try
{
  $sql = "CREATE DATABASE IF NOT EXISTS ".$db_config['db_name'];
  $pdo->exec($sql);
  echo "Database created successfully <br />";
  }
  catch(PDOException $e){
    die("ERROR: Could not able to execute $sql. " . $e->getMessage());
  }

//Creation of user table
try
{
  $sql = "CREATE TABLE IF NOT EXISTS ".$db_config['db_name'].".".$db_config['user_table']."
  (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
   username VARCHAR(30) UNIQUE NOT NULL COLLATE utf8_general_ci,
   password VARCHAR(60) NOT NULL COLLATE utf8_general_ci,
   email VARCHAR(50) UNIQUE NOT NULL COLLATE utf8_general_ci,
   confirmation_token VARCHAR(60),
   confirmation_date DATETIME DEFAULT NULL,
   reset_token VARCHAR(60) DEFAULT NULL,
   reset_date DATETIME,
   remember_token VARCHAR(250),
   notification BOOLEAN DEFAULT 1,
   admim_status BOOLEAN DEFAULT 0
  )";
  $pdo->exec($sql);
  echo "Table user created <br />";
  }catch(PDOException $e)
  {
    die("ERROR: Could not able to execute $sql. " . $e->getMessage());
  }
  $pdo = null;
}
?>
