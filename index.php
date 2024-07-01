<?php
    /*
    * var $conn: db connection
    */
    require_once '../loginDB.php';
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION["user_login"]) == null) {
        echo "Необходима авторизация";
        die();
    }

    $login = $_SESSION["user_login"];
    $query = "select * from users where login = '$login'";
    $result = $conn->query($query);
    $user = $result->fetch_assoc();
    if ($user['user_group'] != 'admin') {
        echo "Ошибка доступа";
        die();
    } 

    $query = "select * from userimages ORDER BY date_image DESC";
    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
        $user_files[] = $row;
    }
?>

<html>
    <head>
        <title>admin</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="/mysite/style.css" />
        <link rel="stylesheet" type="text/css" href="/mysite/style_auth.css" />
        <link rel="stylesheet" type="text/css" href="admin.css" />
        <script src="/mysite/script_auth.js"></script>
        <script src="admin.js"></script>
    </head>
    <body>

        <?php include('../header.php'); ?>

        <div class="admin-main">
            <div class="admin-title">Коллекция</div>
            <div class="admin-block-files">
                <?php foreach($user_files as $current_file) {?>
                    <div class="admin-element">
                        <div>
                            <img class="admin-img" src="/mysite/images/serverfile/<?= $current_file['file_name'] ?>.png" alt="">
                        </div>
                        <div>
                            <?= $current_file['file_name'] ?>.png
                        </div>
                        <input type="checkbox" class="admin-element-checkbox" data-file-name="<?= $current_file['file_name'] ?>">
                    </div>
                <?php } ?>
            </div>
            <div>
                <div>
                    <input type="checkbox" id="admin-select-all-checkbox">
                    <label for="admin-select-all-checkbox">Выбрать все</label>
                </div>
                <input type="button" class="button-standart" value="Скачать" id="admin-button-download">
            </div>
        </div>
    </body>
</html>