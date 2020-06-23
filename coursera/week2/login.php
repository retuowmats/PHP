<!DOCTYPE html>
<html>
    <head>
        <title>Wouter Stam</title>
        <meta charset='utf-8'>
    </head>

    <body>
        <h1>Please Login</h1>
        <?php
        session_start();
            require_once 'pdo.php';

            if ( isset($_POST['email']) && isset($_POST['password'])) {

                $sql = "SELECT name FROM users
                WHERE email = :em
                AND password = :pw";

                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(   // prepare, execute and placeholders
                    ':em' => $_POST['email'],
                    ':pw' => $_POST['password']
                ));
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                //var_dump($row);
                if ( empty($_POST['email']) || empty($_POST['password'])) {
                    echo '<p style="color:red;">Email and password required</p>';
                } elseif ( preg_match('/@/', $_POST['email'] ) < 1) {
                    echo '<p style="color:red;">Your email needs an @';
                } elseif ( $row === FALSE) {
                    error_log("Login fail ".$_POST['email']." ".$_POST['password']);
                    echo '<p style="color:red;">Incorrect password</p>';

                } else {

                    header("Location: autos.php?name=".urlencode($_POST['email']));
                    error_log("Login success ".$_POST['email']);

                }

            }

        ?>

        <form method='post'>
            <p>User Name <input type ='text' size = '30' name='email'></p>
            <p>Password <input type='text' size= '30' name='password'></p>
            <p><input type='submit' value='Login'/>
                <input type='reset' value='Cancel'/>
            </p>
        </form>
        <p>For a password hint, view source and find it in the comments.</p> <!-- gg@umich.edu pw = 456 -->
    </body>
</html>