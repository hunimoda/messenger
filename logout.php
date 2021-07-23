<?php
    session_start();
    session_unset();
    session_destroy();

    include_once('./function.php');
    if (!isset($_SESSION['userid']))
        error_handling('로그아웃 되었습니다.', './login.php');
?>