<?php 
    /*
    * var $conn: db connection
    */
    require_once 'loginDB.php';

    $get_page = (isset($_GET['page']) != null) ? intval($_GET['page']) - 1 : 0;
    $get_page = $get_page >= 0 ? $get_page : 0;

    $get_name = (isset($_GET['name']) != null) ? $_GET['name'] : false;
    $query = $get_name ? "select * from userimages where user_name = '$get_name' ORDER BY date_image DESC" : "select * from userimages ORDER BY date_image DESC";
    $result = $conn->query($query);
    $user_files = array();
    while ($row = $result->fetch_assoc()) {
        $user_files[] = $row;
    }  
    $count_files = count($user_files);
    $max_news = 5;
?>
<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>News</title>
        <link rel="stylesheet" type="text/css" href="style.css" />
        <link rel="stylesheet" type="text/css" href="style_auth.css" />
        <link rel="stylesheet" type="text/css" href="news.css" />
        <script src="script_auth.js"></script>
    </head>

    <body>
        <?php include(__DIR__.'/header.php'); ?>
        <div class="news-main">
            <div class="news-main-title"><?= $get_name ? "Публикации пользователя $get_name" : "Новые публикации" ?></div>
            <div class="news-main-block">
                <div>
                    <?php
                    if ($user_files != null) {
                        $first_news = $get_page * $max_news;
                        $last_news = ($first_news + $max_news) >= $count_files ? $count_files : $first_news + $max_news;
                        for ($i=$first_news; $i<$last_news; $i++) {?>
                            <div class="news-block">
                                <div>
                                    <a class="news-user-name" href="news.php?name=<?= $user_files[$i]['user_name'] ?>"><?= $user_files[$i]['user_name'] ?></a>
                                    <span class="news-user-date"><?= $user_files[$i]['date_image'] ?></span>
                                </div>
                                <div class="news-user-comment">
                                    <?= $user_files[$i]['comment'] ?>
                                </div>
                                <div>
                                    <img class="news-user-img" src="/mysite/images/serverfile/<?= $user_files[$i]['file_name'] ?>.png" alt="Публикация пользователя <?= $user_files[$i]['user_name'] ?>">
                                </div>
                                <div>
                                    Понравилась картинка? 
                                    <a href="/mysite/?img=<?= $user_files[$i]['file_name'] ?>" class="news-usage">Использовать</a>
                                </div>
                            </div>
                        <?php } 
                    }
                    else echo "Публикаций нет"?>
                </div>
                <div>
                    <a href="/mysite/news.php" style="color: inherit;">
                        Все авторы
                    </a>
                    <div class="news-authors">
                        <?php
                        $query = "select DISTINCT user_name from userimages ORDER BY user_name ASC";
                        $result = $conn->query($query);
                        while ($row = $result->fetch_assoc()) {
                            $all_users[] = $row;
                        }
                        foreach($all_users as $current_user) {?>
                            <a class="news-user-name" href="news.php?name=<?= $current_user['user_name'] ?>"><?= $current_user['user_name'] ?></a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div>
                <?php 
                $has_name = $get_name ? "&name=$get_name" : "";    
                $num_page = ceil($count_files/$max_news);          
                for ($i=1; $i<=$num_page; $i++) { 
                    $link = "/mysite/news.php?page=" . $i . $has_name;?>
                    <a href="<?= $link?>"><?= $i ?></a>
                <?php }?>
            </div>
        </div>
    </body>
</html>