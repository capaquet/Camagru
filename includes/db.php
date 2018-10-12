<?php
    require('/app/config/database.php');
    $pdo = new PDO($db_config['init'], $db_config['user'], $db_config['pwd']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    echo("OK CONNEXION TO DB");
?>