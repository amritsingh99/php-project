<?php 
    require_once 'header.php';
    echo "<div class='main'><h3>Please enter your details to log in</h3>";
    $error = $user = $pass = "";

    if (isset($_POST['user'])) {
        $user = sanitizeString($_POST['user']);
        $pass = sanitizeString($_POST['pass']);

        if ($user == "" || $pass == "") {
            $error = "Not all fields were entered ";
        } else {
            $result = queryMysql("select user, pass from members
            where user = '$user' and pass = '$pass'");

            if ($result->num_rows == 0) {
                $error = "<span class='error'>Username/Password invalid</span>";
            } else {
                $_SESSION['user'] = $user;
                $_SESSION['pass'] = $pass;
                die("You are now logged in. Please <a href='members.php?view=$user'>"
                ."click here to continue.");
            }
        }
    }
    
    echo <<< _END
    <form action="login.php" method="post">
    <span class="fieldname">Username</span>
    <input type="text" maxlength="16" name="user" onBlur="checkUser(this)">$error
    <span id="info"></span><br>
    <span class="fieldname">Password</span>
    <input type="password" id='pass' maxlength="16" name="pass">
    _END;
?>

<span class='fieldname'>&nbsp;</span>
<input type='submit' value='Log In'>
</form>
</div><br>
</body>

</html>