<?php
require_once 'pdo.php';
    if (isset($_GET['name'])) {
        echo '<h1>Tracking autos for '. $_GET[ 'name']. '</h1>';
    } else {
        die("Name parameter missing");
    }

    if (isset($_POST['logout'])) {
        header('Location: index.php');
    }
    elseif (isset($_POST['add'] ) && ((is_numeric($_POST['year']) == false) || is_numeric($_POST['mileage']) == false)) {
        echo '<p style="color:red"> Year and mileage must be numeric</p>';
    }
    elseif (isset($_POST['add'] ) && (empty($_POST['make']) == true) ) {
        echo '<p style="color:red">Make is required</p>';
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

    } else {
        echo '';
    }

?>

<html><head><title>Wouter Stam</title></head><body><form method='post'>
<p>Make: <input type='text' name='make' ></p>
<p>Year: <input name='year' min='1950' max='2020' placeholder='1950-2020'></p>
<p>Mileage: <input name='mileage' min='0' max='999999' placeholder='0-999999'></p>
<p><input type='submit' value='Add' name='add'/>
<input type='submit' value='Logout' name='logout'/>

</form>


</p>

<br>
<h1>Automobiles</h1><br>
<table border='1'>
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
} ?>
</table>
</body></html>
