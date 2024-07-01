<?php
    /*
    * var $conn: db connection
    */
    require_once 'loginDB.php';

    if ((isset($_POST["login-reg"]) != null) & (isset($_POST["password-reg"]) != null)) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $login = $_POST["login-reg"];
        $password = $_POST["password-reg"];
        if (mb_strlen($login) < 5 || mb_strlen($login) > 25) {
            echo "Недопустимая длина логина";
            exit();
        } else if (mb_strlen($password) < 5 || mb_strlen($password) > 15) {
            echo "Недопустимая длина пароля";
            exit();
        }
        $query = "select * from users where login = '$login'";
        $result = $conn->query($query);
        $user = $result->fetch_assoc();
        if ((isset($user["login"]) != null) & (isset($user["password"]) != null)) {
            echo "Такой логин уже существует";
            $conn->close();
            exit();
        }
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $query = "insert into users (login, password, user_group) values('$login', '$hash', 'user')";
        $_SESSION['user_login'] = $login;
        setcookie('user_login', "true", time() + 3600 * 24, "/");
        $result = $conn->query($query);
    }

    $conn->close();
    header('Location: /mysite/');
?>