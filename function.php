<?php
    function redirect($url) {
        echo "<script>location.replace('$url');</script>";
        exit;
    }

    function error_handling($message, $url) {
        echo "<script>alert('$message');</script>";
        redirect($url);
    }

    function alert_and_redirect($message, $url) {
        echo "<script>alert('$message');</script>";
        redirect($url);
    }
?>