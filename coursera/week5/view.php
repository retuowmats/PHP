<?php
    require_once 'pdo.php';
    session_start();

        if( ! isset($_SESSION['email'])) {
            die('Not logged in');
        }

?>

<html>
    <head>
        <title>Wouter Stam - Auto Database View</title>
        <meta charset='utf-8'>
    </head>
    <body>
        <h1>Auto Database View</h1>

        <?php
                    if ( isset( $_SESSION['error'])) {
                        echo('<p style="color:red">'.$_SESSION['error'].'</p><br>');
                        unset($_SESSION['error']);
                    }
                    if ( isset( $_SESSION['success'])) {
                        echo ('<p style="color:green">'.$_SESSION['success'].'</p><br>');
                        unset($_SESSION['success']);
                    }
        ?>
        <table border='1px'>
            <thead>
                <tr>
                    <th>Make</th><th>Model</th><th>Year</th><th>Mileage</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $stmt = $pdo->query('SELECT make, model, year, mileage, auto_id FROM auto.autos ORDER BY auto_id ASC');
                    $total = 0;
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $total++;
                        echo('<tr><td>');
                        echo(htmlentities($row['make']));
                        echo('</td>');
                        echo('<td>');
                        echo(htmlentities($row['model']));
                        echo('</td>');
                        echo('<td>');
                        echo(htmlentities($row['year']));
                        echo('</td>');
                        echo('<td>');
                        echo(htmlentities($row['mileage']));
                        echo('</td><td>');
                        echo('<a href="edit.php?auto_id='.$row['auto_id'].'">Edit</a> / ');
                        echo('<a href="delete.php?auto_id='.$row['auto_id'].'">Delete</a>');
                        echo('<br></form><br>');
                        echo('</td></tr>');
                    }
                    if ($total == 0) {
                        echo'<p>No records found</p>';
                    }

                ?>
            </tbody>
        </table>
        <a href="add.php">Add New Entry</a>
        <p><a href='logout.php'>Logout</a></p>
    </body>
</html>