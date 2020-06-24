<?php
    session_start();
    require_once 'pdo.php';
    if ( ! isset($_SESSION['email'])) {
        die('Not Logged in');
    }
    if ( isset($_SESSION['success']) ) {
        echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p><br>");
        unset($_SESSION['success']);
    }

    if (isset($_POST['add'])) {
        header('Location:add.php');
        return;
    }
    elseif (isset($_POST['logout'])) {
        header('Location:logout.php');
        return;
    }
    else {
        echo '';
    }
?>

<html>
    <head>
        <title>Wouter Stam - Autos Database View</title>
        <meta charset='utf-8'>
    </head>

    <body>
        <h1>Autos Database View</h1>
        <table border='1'>
            <tr><td>Make </td><td>Year </td><td>Mileage</td><tr>
            <?php
                $stmt = $pdo->query('SELECT make, year, mileage FROM autos ORDER BY make ASC');
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<tr><td>';
                    echo (htmlentities($row['make']));
                    echo ('</td><td>');
                    echo (htmlentities($row['year']));
                    echo ('</td><td>');
                    echo (htmlentities($row['mileage']));
                    echo ('</td>');
                    echo ('</form>');
                    echo ('</tr>');
                }
            ?>
        </table>
        <form method ='post'>
            <p>
                <input type='submit' value='Add' name='add'>
                <input type='submit' value='Logout' name='logout'>
            </p>
        </form>
    </body>
</html>
