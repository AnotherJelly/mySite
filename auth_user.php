<?php
    /*
    * var $conn: db connection
    */
    require_once 'loginDB.php';

    if ((isset($_POST["login-auth"]) != null) & (isset($_POST["password-auth"]) != null)) {

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $login = $_POST["login-auth"];
        $password = $_POST["password-auth"];

        $query = "select password from users where login = '$login'";
        $result = $conn->query($query);
        $user = $result->fetch_assoc();
        if ((isset($user["password"]) != null) & (password_verify($password, $user["password"]))) {
            $_SESSION["user_login"] = $login;
            setcookie('user_login', "true", time() + 3600 * 24, "/");
        } else {
            echo "Ошибка ввода";
        }
    }
    $conn->close();
    header('Location: /mysite/');
?>