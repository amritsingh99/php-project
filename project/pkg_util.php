<?php

    $salt1 = 'qm&h';
    $salt2 = 'pg!@';

    function generateHash($password) {
        global $salt1, $salt2;
        $token = hash('ripemd128', "$salt1$password$salt2");
        return $token;
    }

    function line() {
        echo "<br>";
        return;
    }

    function printData() {
        global $query, $result, $cols, $rows;
        echo "<table>";
        for ($j = 0; $j < $rows; ++$j) {
            $result->data_seek($j);
            $row = $result->fetch_array(MYSQLI_NUM);
            for ($i = 0; $i < $cols; ++$i) {
                echo "<tr>";
                for ($i = 0; $i < $cols; ++$i) {
                    // echo $row[$i];
                    echo "<td>$row[$i]   \t      </td>";                
                }
                echo "</tr>";            
                line();            
            }
        }    
        echo "</table>";
    }
    function printTableHeader() {
        echo "<table><tr><th>Author</th><th>Title</th><th>Category</th><th>Year</th><th>ISBN</th></tr>";        
    }

    function fontpre() {
        echo "<pre>";
    }

    function sanitizeString($var) {
        $var = stripslashes($var);
        $var = strip_tags($var);
        $var = htmlentities($var);
        return $var;
    }

    function add_user($connection, $fn, $sn, $un, $pw) {
        $query = "SELECT * from users where ";
        $token = generateHash($pw);
        $query = "INSERT INTO users VALUES('$fn', '$sn', '$un', '$token')";
        $result = $connection->query($query);
        return $result;
    }

    function mysql_entities_fix_string($connection, $string) {
        return htmlentities(fix_string($connection, $string));
    }
    
    function fix_string($connection, $string) {
        if (get_magic_quotes_gpc()) $string = stripslashes($string);
        return $connection->real_escape_string($string);
    }    
    
    function destory_session_and_data() {
        $_SESSION = array();
        setcookie(session_name(), '', time() - 2592000, '/');
        session_destroy();
    }
?>