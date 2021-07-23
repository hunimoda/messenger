<?php
    include_once('./connect_db.php');

    session_start();

    include_once('./function.php');
    if (!isset($_SESSION['userid']) && 
            $_SERVER['PHP_SELF'] != '/messenger/login.php')
        redirect('./login.php');
?>
