<?php
    require_once 'pdo.php';
    session_start();



    if ( isset ($_POST['email']) && isset ($_POST['pass'])) {
        unset($_SESSION['email']);

        if ( empty($_POST['email']) || empty($_POST['pass'])) {
            $_SESSION['error'] = "Email and password are required";
            header("Location:login.php");
            return;
        }
        if ( preg_match('/@/', $_POST['email'] ) < 1) {
            $_SESSION['error'] = "Email must have an at-sign (@)";
            header("Location: login.php");
            return;
        }

        if ( $_POST['pass'] == 'php123' && $_POST['email'] == 'umsi@umich.edu' ) {
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['success'] = 'Logged in';
            header('Location:view.php');
            return;
        }

        else {
            $_SESSION['error'] = 'Incorrect password';
            header('Location:login.php');
            return;
        }
    }
?>

<html>
    <head>
        <title>Wouter Stam - Auto Database Login</title>
    </head>
    <body>
        <h1>Please Login</h1>
        <?php
            if ( isset ($_SESSION['error'])) {
                echo('<p style="color:red">'.$_SESSION['error'].'</p><br>');
                unset($_SESSION['error']);
            }
            if ( isset ($_SESSION['success'])) {
                echo('<p style="color:green">'.$_SESSION['success'].'</p><br>');
                unset($_SESSION['success']);
            }
        ?>
        <form method='post'>
            <p>Account: <input type='text' name='email' ></p>
            <p>Password: <input type='text' name='pass' ></p>
            <p><input type='submit' value='Log In'>
            <a href='logout.php'>Logout</a>
            </p>
        </form>
    </body>
</html>
