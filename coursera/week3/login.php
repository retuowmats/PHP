<?php
    session_start();
    require_once 'pdo.php';

    $salt = 'XyZzy12*_';
    $stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1'; // pw = php123 user = ggg@umich.edu
    $failure = false;

    if (isset($_POST['email']) && isset($_POST['password'])) {
        unset ($_SESSION['email']);

        $sql = "SELECT name FROM users
        WHERE email = :em
        AND password = :pw";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':em' => $_POST['email'],
            ':pw' => $_POST['password']
        ));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ( empty($_POST['email']) || empty($_POST['password'])) {
            $_SESSION['error'] = "Email and password are required";
            header("Location: login.php");
            return;
        }
        if ( preg_match('/@/', $_POST['email'] ) < 1) {
            $_SESSION['error'] = "Email must have an at-sign (@)";
            header("Location: login.php");
            return;
        }
        if ( $row === FALSE) {
            error_log("Login fail ".$_POST['email']." ".$_POST['password']);
            echo '<p style="color:red;">Incorrect password</p>';
        }
        $check = hash('md5', $salt.$_POST['password']);
        if ( $check == $stored_hash ) {
			error_log("login.php, Login success ".$_POST['email']);
            // Redirect the browser to game.php
            header("Location: view.php?name=".urlencode($_POST['name']));
			return;
        }
        /*elseif ( $_POST['password'] == 'php123') {
            error_log('Login success '.$_POST['email']);
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['success'] = 'Logged in';
            header('Location:view.php' );
            return;
        } */
        else {
            $_SESSION['error'] = 'Incorrect password';
            header('Location:login.php' );
            return;
        }
    }
?>

<html>
    <head>
        <meta charset='utf-8'>
        <title>Wouter Stam - Autos Database</title>
    </head>

    <body>
        <h1>Please login</h1>
        <?php
            if (isset($_SESSION['error']) ) {
                echo('<p style="color:red">'.$_SESSION['error'].'</p><br>');
                unset($_SESSION['error']);
            }
            if ( isset($_SESSION['success'])) {
                echo('<p style="color:green">'.$_SESSION['success']).'</p><br>';
                unset($_SESSION['success']);
            }
        ?>

        <form method ='post'>
            <p>User name <input type='text' size ='30' name = 'email'></p>
            <p>Password <input type='text' size='30' name='password'></p>
            <p>
                <input type='submit' value='login'/>
                <a href='login.php'>Cancel</a>
            </p>
        </form>
    </body>
</html>