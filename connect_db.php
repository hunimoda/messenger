<?php
    $sql_host = 'localhost';
    $sql_user = 'root';
    $sql_password = '1234';
    $sql_db = 'messenger';

    $conn = mysqli_connect(
        $sql_host, 
        $sql_user, 
        $sql_password, 
        $sql_db
    );
    if (!$conn) {
        echo "Connection error : ".mysqli_connect_error();
        exit;
    }
?>