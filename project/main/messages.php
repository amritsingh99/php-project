<?php 
    require_once 'header.php';

    if (!$loggedin) die();

    if (isset($_GET['view'])) $view = sanitizeString($_GET['view']);
    else $view = $user;

    if (isset($_POST['text'])) {
        $text = sanitizeString($_POST['text']);

        if ($text != "") {
            $pm = substr(sanitizeString($_POST['pm']), 0, 1);
            $time = time();
            queryMysql("Insert into messages values(null, '$user',
            '$view', '$pm', '$time', '$text')");
        }
    }

    if ($view != "") {
        if ($view == $user) $name1 = $name2 = "Your";
    } else {
        $name1 = "<a href='members.php?view=$view'>$view</a>'s";
        $name2 = "$view's";
    }

    echo "<div class='main'><h3>$name1 Messages</h3>";
    showProfile($view);

    echo <<<_END
    <form action='messages.php?view=$view' method="post">
    Type here to leave a message:<br>
    <textarea name="text" cols="30" rows="10"></textarea><br>
    Public
    <input type="radio" name="pm" value="0" checked='checked'>
    Private
    <input type="radio" name="pm" value="1" checked='checked'>
    <input type="submit" value="Post Message">
    </form>
    <br>    

    _END;

    if (isset($_GET['erase'])) {
        $erase = sanitizeString($_GET['erase']);
        queryMysql("Delete from messages where id=$erase and recip='$user'");
    }

    $query = "select * from messages where recip='$view' order by time desc";
    $result = queryMysql($query);
    $num = $result->num_rows;

    for ($j = 0 ; $j < $num ; ++$j)
    {
    $row = $result->fetch_array(MYSQLI_ASSOC);
    if ($row['pm'] == 0 || $row['auth'] == $user || $row['recip'] == $user)
    {
    echo date('M jS \'y g:ia:', $row['time']);
    echo " <a href='messages.php?view=" . $row['auth'] . "'>" .
    $row['auth']. "</a> ";
    if ($row['pm'] == 0)
    echo "wrote: &quot;" . $row['message'] . "&quot; ";
    else
    echo "whispered: <span class='whisper'>&quot;" .
    $row['message'] . "&quot;</span> ";
    if ($row['recip'] == $user)
    echo "[<a href='messages.php?view=$view" .
    "&erase=" . $row['id'] . "'>erase</a>]";
    echo "<br>";
    }
    }
    if (!$num) echo "<br><span class='info'>No messages yet</span><br><br>";
    echo "<br><a class='button' href='messages.php?view=$view'>Refresh messages</a>";
?>
</div><br>
</body>

</html>