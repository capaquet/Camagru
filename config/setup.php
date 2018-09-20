<?php
require('database.php');
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
try
{
    $pdo = new PDO($DB_INIT, $DB_USER, $DB_PASSWORD);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

catch(PDOException $e)
{
    die("ERROR: Could not connect. " . $e->getMessage());
}


// Attempt create database query execution
try
{
    $sql = "CREATE DATABASE IF NOT EXISTS $DB_NAME";
    $pdo->exec($sql);
    echo "Database created successfully <br />";
}


catch(PDOException $e)
{
    die("ERROR: Could not able to execute $sql. " . $e->getMessage());
}

try
{
    $sql = "CREATE TABLE IF NOT EXISTS $DB_NAME.$TABLE_USER
    (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
     login VARCHAR(30) UNIQUE NOT NULL COLLATE utf8_general_ci,
     password VARCHAR(30) NOT NULL COLLATE utf8_general_ci,
     email VARCHAR(50) UNIQUE NOT NULL COLLATE utf8_general_ci,
     confirmation BOOLEAN DEFAULT 0,
     notification BOOLEAN DEFAULT 1,
     admim_status BOOLEAN DEFAULT 0
    )";
    $pdo->exec($sql);
    echo "Table user created <br />";
}

catch(PDOException $e)
{
    die("ERROR: Could not able to execute $sql. " . $e->getMessage());
}

try
{
  $sql = "INSERT INTO $DB_NAME.$TABLE_USER (login, password, email, confirmation, notification, admim_status)
  VALUES('admin2', 'admin', 'admin2@gmail.com', 1, 1, 1);";
  $pdo->exec($sql);
  echo "Admin user created <br />";
}

catch(PDOException $e)
{
    print(/*"ERROR: Could not able to execute $sql. " . */$e->getMessage());
}


// Close connection
unset($pdo);
?>
