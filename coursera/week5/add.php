<?php   
    require_once 'pdo.php';
    session_start();
        if ( ! isset($_SESSION['email'])) {
            die('Not logged in');
        }
        

        
        if ( isset( $_POST['add'])) {
            if (empty($_POST['make']) || empty($_POST['model']) || empty($_POST['year']) || empty($_POST['mileage'])) {
                $_SESSION['error'] = 'All fields are required';
                header("Location: add.php");
                return; 
            }

            if (isset($_POST['add'] ) && ((is_numeric($_POST['year']) == false) || is_numeric($_POST['mileage']) == false)) {
                $_SESSION['error'] = 'Year and mileage must be numeric';
                header("Location: add.php");
                return;
            }

            if ( isset($_POST[ 'make']) && isset($_POST['model'] ) && isset($_POST['year'])
            && isset($_POST['mileage'])) {
                $sql = 'INSERT INTO auto.autos (make, model, year, mileage)
                    VALUES (:make, :model, :year, :mileage)';
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(
                    ':make' => $_POST['make'],
                    ':model' => $_POST['model'],
                    ':year' => $_POST['year'],
                    ':mileage' => $_POST['mileage']
                ));
                $_SESSION['success'] = 'added';
                header('Location:view.php');
                return;
            } else {
                echo '';
            }
        }
?>

<html>
    <head>
        <meta charset='utf-8'>
        <title>Wouter Stam - Auto Database Add</title>
    </head>
    <body>
        <h1>Add New Auto</h1>
        <?php
        if ( isset($_SESSION['error']) ) {
            echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p><br>");
            unset($_SESSION['error']);
        }
        ?>
        <form method='post'>
            <p>Make: <input type='text' name='make'></p>
            <p>Model: <input type='text' name='model'></p>
            <p>Year: <input type='text' name='year'></p>
            <p>Mileage: <input type='text' name='mileage'></p>
            <p>
                <input type='submit' value='Add New Entry' name='add'>
                <a href='logout.php'>Logout</a>
            </p>
        </form>
    </body>
</html>