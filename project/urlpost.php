<?php
        // echo file_get_contents('http://' . SanitizeString($_POST['url']));
    if (isset($_POST['url'])) {
        echo "madarchod";
        echo sanitizeString($_POST['url']);
    }
    

    function sanitizeString($var)
    {
        $var = strip_tags($var);
        $var = htmlentities($var);
        return stripslashes($var);
    }
?>