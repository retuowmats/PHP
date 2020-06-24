<?php
    session_start();
    require_once 'pdo.php';
    if ( ! isset($_SESSION['email'])) {
        die ('Not logged in');
    }
    if ( isset($_SESSION['error']) ) {
        echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p><br>");
        unset($_SESSION['error']);
    }
    if (isset($_POST['logout'])) {
        header('Location: logout.php');
    }
    elseif (isset($_POST['add'] ) && ((is_numeric($_POST['year']) == false) || is_numeric($_POST['mileage']) == false)) {  
        $_SESSION['error'] = 'Year and mileage must be numeric';
        header("Location: add.php");
        return;
    }
    elseif (isset($_POST['add'] ) && (empty($_POST['make']) == true) ) {
        $_SESSION['error'] = 'Make is required';
        header("Location: add.php");
        return;
    }
    elseif ( isset ($_POST['make']) && isset ($_POST['year']) && isset ($_POST['mileage']) ) {
        $sql = 'INSERT INTO autos (make, year, mileage)
        VALUES (:make, :year, :mileage)';
        echo '<p style="color:green"> Row inserted </p>';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':make' => $_POST['make'],
            ':year' => $_POST[ 'year'],
            ':mileage' => $_POST['mileage']
        ));
        $_SESSION['success'] = "Record inserted";
        header("Location: view.php");
        return;
    } else {
        echo '';
    }
?>

<html>
    <head>
        <meta charset='utf-8'>
        <title>Wouter Stam - Autos Database Add</title>
    </head>

    <body>
        <form method='post'>
            <p>Make: <input type='text' name='make' ></p>
            <p>Year: <input type='text' name='year' min='1950' max='2020' placeholder='1950-2020'></p>
            <p>Mileage: <input type='text' name='mileage' min='0' max='999999' placeholder='0-999999'></p>
            <p>
                <input type='submit' value='Add' name='add'/>
                <input type='submit' value='Logout' name='logout'/>
            </p>
        </form>
    </body>
</html>


