<?php
    $host     = 'localhost';
    $db       = 'mysitedb';
    $user     = 'root';
    $password = '';

    $conn = new mysqli($host, $user, $password, $db);
    if ($conn->connect_error) die($conn->connect_error);
?>