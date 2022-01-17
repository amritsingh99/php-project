<?php 
    require_once 'functions.php';

    if (isset($_POST['user'])) {
        $user = sanitizeString($_POST['user']);
        
        if  ($user == "") {
            echo "field should not be blank";
        } elseif (strlen($user) < 3) {
            echo "username length should be greater than 3";
        }
        else {
            $result = queryMysql("select * from members where user = '$user'");
            if ($result->num_rows) {
                echo "<span class='taken'>&nbsp;&#x2718; " .
                        "This username is taken</span>";
            }
            else {
                echo "<span class='available'>&nbsp;&#x2714; " .
                        "This username is available</span>";
            }
        }
    }
?>