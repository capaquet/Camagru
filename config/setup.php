<?php
require('database.php');

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
   login VARCHAR(30) UNIQUE NOT NULL COLLATE utf8_general_ci,
   password VARCHAR(61) NOT NULL COLLATE utf8_general_ci,
   email VARCHAR(50) UNIQUE NOT NULL COLLATE utf8_general_ci,
   confirmation BOOLEAN DEFAULT 0,
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
