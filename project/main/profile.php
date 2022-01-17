<?php 
    require_once 'header.php';

    if (!$loggedin) die();
    echo "<div class='main'><h3>Your Profile</h3>";

    $result = queryMysql("select * from profiles where user='$user'");

    if (isset($_POST['text'])) {
        $text = sanitizeString($_POST['text']);
        $text = preg_replace('/\s\s+/', ' ', $text);

        if ($result->num_rows) {
            queryMysql("update profiles set text = '$text' where user = '$user'");
        } else {
            queryMysql("insert into profiles values('$user', '$text')");
        }
    } else {
        if ($result->num_rows) {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $text = stripslashes($row['text']);
        } else {
            $text = "";
        }
    }

    $text = preg_replace('/\s\s+/', ' ', $text);
    

    // echo $_FILES['image']['name'];
    // showProfile($user);

    if ($_FILES['image']['name']) {
        $saveto = "$user.jpg";
        move_uploaded_file($_FILES['image']['name'], $saveto);
        $typeok = TRUE;

        switch ($_FILES['image']['name']) {
            case 'image/gif':
                $src = imagecreatefromgif($saveto);
                break;
            case 'image/jpeg':
                
            case 'image/pjpeg':
                $src = imagecreatefromjpeg($saveto);
                break
            case 'image/png':
                $src = imagecreatefrompng($saveto);
                break;
            default:
                $typeok = FALSE
                break;
                # code...
                break;
        }

        if ($typeok) {
            
        }
    }


?>