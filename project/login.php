<?php
    $hn = 'localhost';
    $db = 'publications';
    $un = 'root';
    $pw = '';

    $conn = new mysqli($hn, $un, $pw, $db, "3308");
    if ($conn->connect_error) {
        die($conn->connect_error);
    }     

?>


