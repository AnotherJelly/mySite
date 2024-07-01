<?php
$dir1 = 'images/userfile';
$dir2 = 'images/unsplash';
$time = strtotime('-3 day');

clearDirectory($dir1, $time);
clearDirectory($dir2, $time);

function clearDirectory($dir, $time) {
    $files = scandir($dir);
    foreach ($files as $file) {
        $filepath = $dir . '/' . $file;
        if (is_file($filepath) && !is_link($filepath)) {
            $fileCreationTime = filectime($filepath);
            if ($fileCreationTime < $time) {
                unlink($filepath);
                echo "Файл $file удален из $dir.<br>";
            }
        }
    }
}
?>