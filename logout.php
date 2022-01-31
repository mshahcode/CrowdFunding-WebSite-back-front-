<?php
    session_start();
    // Destroy session
    if(session_destroy()) {
        // Redirecting To Login
        header("Location: index.php");
    }
?>
