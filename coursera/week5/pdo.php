<?php
    $pdo = new PDO('mysql:host=localhost;port:3306;dbname=auto', 'umsi@umich.edu', 'php123');

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
