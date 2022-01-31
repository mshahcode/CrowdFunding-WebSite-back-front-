<?php
    require('db.php');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    session_start();
    if (isset($_POST['email'])) {
        $email = $con -> real_escape_string($_REQUEST['email']);    
        $password = $con -> real_escape_string($_REQUEST['password']);
        // Check user is exist in the database
        $query = "SELECT * FROM `users` WHERE email='$email'
                     AND password='" . $password . "'";

        $result = $con->query($query) or die(); 
        $rows = $result->num_rows;
        if ($rows == 1) {
            $current_row = $result->fetch_assoc();
            $_SESSION['email'] = $email;
            $_SESSION['userid'] = $current_row['idUser'];
            $_SESSION['password'] = $current_row['password'];
            $_SESSION['firstname'] = $current_row['firstname'];
            // Redirect to homepage
            header("Location: homepage.php");
        } else {
            $_SESSION['Error'] = "Wrong Username/Password";
            header("Location: index.php");
        }
    }

?>