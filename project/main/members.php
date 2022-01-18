<?php 
    require_once 'header.php';

    if (!$loggedin) die();

    echo "<div class='main'>";

    if (isset($_GET['view'])) {
        $view = sanitizeString($_GET['view']);
        if ($view == $user) {
            $name = "Your";
        } else {
            $name = "$view's";
        }
        echo "<h3>$name Profile";
        showProfile($view);
        echo "<a class='button' href='messages.php?view=$view''" .
        "View $name messages</a><br><br>";
        die("</div></body></html>");
    }

    if (isset($_GET['add'])) {
        $add = sanitizeString($_GET['add']);

        $result = queryMysql("select * from friends where user='$add'
        and friend ='$user'");
        if (!$result->num_rows) {
            queryMysql("insert into friends values ('$add', '$user')");
        }
    } elseif (isset($_GET['remove'])) {
        $remove = sanitizeString($_GET['remove']);
        queryMysql("delete from friends where user='$remove' and friend='$user'");
    }

    $result = queryMysql("select user from members order by user");
    $num = $result->num_rows;

    echo "<h3>Other Members</h3><ul>";

    for ($j = 0; $j < $num; ++$j) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        // echo 'Amrit';
        
        if ($row['user'] == $user) continue;

        echo "<li><a href='members.php?view=" . $row['user'] . "'>" . $row['user']. "</a>";
        $follow = "follow";

        $result1 = queryMysql("select * from friends where user='". $row['user'] . "'
                and friend='$user'");
        $t1 = $result1->num_rows;
        $result1 = queryMysql("select * from friends where user='$user'
                and friend='" . $row['user'] . "'");
        $t2 = $result1->num_rows;
        if (($t1 + $t2) > 1) echo " &harr; is a mutual friend";
        elseif ($t1)         echo " &larr; you are following";
        elseif ($t2)       { echo " &rarr; is following you";
            $follow = "recip";  }

        if (!$t1) {
            echo " <a href='members.php?add=" . $row['user'] ."'> [follow] </a>";
        } else {
            echo " <a href='members.php?remove=" . $row['user'] . "'>[drop]</a>";
        }
    }
?>

</ul>
</div>
</body>

</html>