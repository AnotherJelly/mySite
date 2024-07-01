<?php if (session_status() == PHP_SESSION_NONE) {
    session_start();
} ?>
<header class="header">
    <div class="header-about"><a style="color: #dec28e;" href="/mysite/about.php">О сайте</a></div>
    <div class="header-tabs">
        <?php if(isset($_SESSION["user_login"]) != null) { 
            /*
            * var $conn: db connection
            */
            require_once 'loginDB.php';
            $login_header = $_SESSION["user_login"];
            $query = "select * from users where login = '$login_header'";
            $result = $conn->query($query);
            $user = $result->fetch_assoc();
            if ($user['user_group'] == 'admin') {?>
                <div><a style="color: #dec28e;" href="/mysite/admin/">Коллекция</a></div>
            <?php } ?>
        <?php } ?>    

        <div><a style="color: #dec28e;" href="/mysite/">Главная</a></div>
        <div><a style="color: #dec28e;" href="/mysite/news.php">Лента</a></div>
    </div>
    <?php if(isset($_SESSION["user_login"]) != null) { ?>
        <div class="header-user">
            <div>Привет, <a style="color: #dec28e;" href="/mysite/news.php?name=<?= $_SESSION['user_login'] ?>"><?= $_SESSION['user_login'] ?></a></div>
            <a href="/mysite/exit_user.php" class="auth-button">
                <div class="auth-button__out"></div>
                <div style="color: #dec28e; text-decoration: none;">Выйти</div>
            </a>
        </div>
    <?php } else {?>
        <div class="auth-button" id="auth-button">
            <div class="auth-button__in"></div>
            <div class="">Войти</div>
        </div>
    <?php } ?>
</header>
<div class="auth-background">
    <div class="auth-block">
        <div id="block-auth">
            <div>
                <div class="auth-block__title" style="text-align: center;">Вход</div>
                <span class="auth-block__icon"></span>
            </div>
            <div>
                <form action="auth_user.php" method="post" class="auth-block__form">
                    <input type="text" class="input-standart" id="login-auth" name="login-auth" placeholder="Логин">
                    <input type="password" class="input-standart" id="password-auth" name="password-auth" placeholder="Пароль">
                    <button type="submit" class="button-standart">Войти</button>
                    <input type="button" class="button-standart" id="reg-button" value="Регистрация" style="background-color: #44944A;">
                </form>
            </div>
        </div>
        <div style="display: none;" id="block-reg">
            <div>
                <span class="auth-block__back" id="auth-block__back"></span>
                <div class="auth-block__title" style="text-align: center;">Регистрация</div>
                <span class="auth-block__icon"></span>
            </div>
            <div>
                <form action="reg_user.php" method="post" class="auth-block__form">
                    <input type="text" class="input-standart" id="login-reg" name="login-reg" placeholder="Логин">
                    <input type="password" class="input-standart" id="password-reg" name="password-reg" placeholder="Пароль">
                    <button type="submit" class="button-standart">Зарегистрироваться</button>
                </form>
            </div>
        </div>
    </div>
</div>