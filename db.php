<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    //$con = new mysqli("localhost:3306","root","","crowdfundinghomwork");
    $con = new mysqli("mysql-mikayil.alwaysdata.net","mikayil","MikaMika123","mikayil_hwproject");

    // Check connection
    if ($con -> connect_errno) {
        echo "Failed to connect to MySQL: " . $con -> connect_error;
        exit();
    }

    // setting charset to utf 8
    $con -> set_charset("utf8");

?>
