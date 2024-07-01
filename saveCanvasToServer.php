<?php

    /*
    * var $conn: db connection
    */
    require_once 'loginDB.php';
    if (isset($_SESSION['user_login']) != null) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        define('UPLOAD_DIR', getenv('DOCUMENT_ROOT').'/mysite/images/serverfile/');
        $img = $_POST['imgBase64'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $uniqid = uniqid();
        $file = UPLOAD_DIR . $uniqid . '.png';
        file_put_contents($file, $data);

        $comment = $_POST['userComment'] ? $_POST['userComment'] : "";
        $today = date("Y-m-d H:i:s");

        $user_name = $_SESSION['user_login'];
        $query = "insert into userimages (user_name, file_name, comment, date_image) values('$user_name', '$uniqid', '$comment', '$today')";
        $result = $conn->query($query);
    }

    exit;
?>