<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['user_login'] = null;
    setcookie('user_login', '', time() - 3600 * 24, "/");
    header('Location: /mysite/');
?>