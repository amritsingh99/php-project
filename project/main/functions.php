<?php
    $hn = 'localhost';
    $db = 'publications';
    $un = 'root';
    $pw = '';
    $appname = "Amrit's Nest" ;

    $connection = new mysqli($hn, $un, $pw, $db, "3308");
    if ($connection->connect_error) {
        die($connection->connect_error);
    }
    function queryMysql($query) {
        global $connection;
        $result = $connection->query($query);
        if (!$result) die($connection->error);
        return $result;
    }

    function createTable($name, $query) {
        queryMysql("Create table if not exists $name($query)");
        echo "Table '$name' created or already exists.<br>";
    }

    function destroySession() {
        $_SESSION = array();
        if (session_id() != "" || isset($_COOKIE[session_name()]))
            setcookie(session_name(), '', time() - 2592000, '/');
        session_destroy();
    }

    function sanitizeString($var) {
        global $connection;
        $var = strip_tags($var);
        $var = htmlentities($var);
        $var = striplashes($var);
        return $connection->real_escape_string($var);
    }

    function showProfile($user) {
        if (file_exists("$user.jpg"))
            echo "<img src='$user.jpg' style='float:left;'>";

        $result = queryMysql("select * from users where forename = '$user'");
        
        if ($result->num_rows) {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            echo stripslashes($row['text']) . "<br style='clear:left;'><br>";
        }
    }
?>