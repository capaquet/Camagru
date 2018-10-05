<?php
class user
{
  function creation()
  {
    try{
      $sql = "INSERT INTO $DB_NAME.$TABLE_USER (login, password, email, confirmation, notification, admim_status)
      VALUES('admin2', 'admin', 'admin2@gmail.com', 1, 1, 1);";
      $pdo->exec($sql);
      echo "Admin user created <br />";
    } catch(PDOException $e){
        print(/*"ERROR: Could not able to execute $sql. " . */$e->getMessage());
    }
  }
}
?>
