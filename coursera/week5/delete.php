<?php
    require_once 'pdo.php';
    session_start();
    if ( ! isset( $_SESSION['email'])) {
        die('Not logged in');
    }
    If (isset($_POST['delete']) && isset($_POST['auto_id'])) {
        $sql = 'DELETE FROM auto.autos WHERE auto_id = :zip';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':zip' => $_POST['auto_id']
        ));
        $_SESSION['success'] = 'Record Deleted';
        header('Location:view.php');
        return;
    }
    $stmt = $pdo->prepare('SELECT auto_id FROM auto.autos WHERE auto_id = :xyz');
    $stmt->execute(array(':xyz' => $_GET['auto_id']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ( $row === false ) {
        $_SESSION['error'] = 'Bad value for auto_id';
        header('Location:view.php');
        return;
    }
?>

<html>
    <head>
        <title>Wouter Stam - Auto Database Delete </title>
    </head>
    <body>
        <p>Confirm: Deleting <?= htmlentities($row['auto_id']) ?></p>
        <form method='post'><input type='hidden' name='auto_id' value='<?= $row["auto_id"] ?>'>
            <input type='submit' value='Delete' name='delete'>
            <a href='view.php'>Cancel</a>
        </form>
    </body>
</html>