<?php
    require_once 'pdo.php';
    session_start();

    if ( ! isset( $_SESSION['email'])) {
        die('Not logged in');
    }

    if ( isset( $_POST['add'])) {
        if (empty($_POST['make']) || empty($_POST['model']) || empty($_POST['year']) || empty($_POST['mileage'])) {
            $_SESSION['error'] = "All fields are required";
            header("Location: edit.php?auto_id=".$_POST['auto_id']);
            return;
        }

        if (isset($_POST['add'] ) && ((is_numeric($_POST['year']) == false) || is_numeric($_POST['mileage']) == false)) {  
            $_SESSION['error'] = "Year and mileage must be numeric";
            header("Location: edit.php?auto_id=".$_POST['auto_id']);
            return;
        }    
        if (isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year']) && isset($_POST['mileage'] ) && isset($_POST['auto_id'])) {
            $sql = 'UPDATE auto.autos SET make = :make, model = :model, year = :year, mileage = :mileage
            WHERE auto_id = :auto_id';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':make' => $_POST['make'],
                ':model' => $_POST['model'],
                ':year' => $_POST['year'],
                ':mileage' => $_POST['mileage'],
                ':auto_id' => $_POST['auto_id']
            ));
            $_SESSION['success'] = 'added';
            header('location:view.php');
            return;
        }
    }
    $stmt = $pdo->prepare('SELECT * FROM auto.autos WHERE auto_id = :xyz');
    $stmt->execute(array(
        ':xyz' => $_GET['auto_id']
    ));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row === false) {
        $_SESSION['error'] = 'Not a valid ID';
        header('Location:view.php');
        return;
    } 

    $make = htmlentities($row['make']);
    $model = htmlentities($row['model']);
    $year = htmlentities($row['year']);
    $mileage = htmlentities($row['mileage']);
    $auto_id = $row['auto_id'];
?>

<html>
    <head>
        <title>Wouter Stam - Auto Database Edit</title>
        <meta charset='utf-8'>
    </head>
    <body>
        <h1>Edit Auto Database</h1>
        <?php
            if ( isset($_SESSION['error']) ) {
                echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p><br>");
                unset($_SESSION['error']);
            }
        ?>
        <form method='post'>
            <p>Make: 
            <input type='text' name='make' value='<?= $make ?>'></p>
            <p>Model: 
            <input type='text' name='model' value='<?= $model ?>'></p>
            <p>Year: 
            <input type='text' name='year' value='<?= $year ?>'></p>
            <p>Mileage: 
            <input type='text' name='mileage' value='<?= $mileage ?>'></p>
            <p>
            <input type='hidden' name='auto_id' value='<?= $auto_id ?>'></p>
            <p>
            <input type='submit' value='Save' name='add'>
            <a href='view.php'>Cancel</a></p>
        </form>  
    </body>
</html>
            