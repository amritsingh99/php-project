<?php 
    require_once 'header.php';
    echo <<< _END
        <script>
    function checkUser(user) {
        if (user.value == '') {
            O('info').innerHTML = ''
        }

        params = "user=" + user.value
        console.log(params)
        request = new ajaxRequest()
        request.open("POST", "checkuser.php", true)
        console.log(request)

        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
        console.log(user.value)

        request.onreadystatechange = function() {
            console.log(this.readyState)
            if (this.readyState == 4) {
                if (this.status == 200) {
                    if (this.responseText != null) {
                        O('info').innerHTML = this.responseText
                    }
                }
            }
        }
        request.send(params)
    }

    function ajaxRequest() {
        try {
            var request = new XMLHttpRequest()
        } catch (e1) {
            try {
                request = new ActiveXObject("Msxml2.XMLHTTP")
            } catch (e2) {
                try {
                    request = new ActiveXObject("Microsoft.XMLHTTP")
                } catch (e3) {
                    request = false
                }
            }
        }
        return request
    }
    </script>
    <div class='main'>
        <h3>Please enter your details to sign up</h3>
        
_END;
    $error = $user = $pass = "";
    if (isset($_SESSION['user'])) destroySession();

    if (isset($_POST['user'])) {
        $user = sanitizeString($_POST['user']);
        $pass = sanitizeString($_POST['pass']);

        if ($user == "" || $pass == "") {
            $error = "Not all fields were entered <br><br>";
        } else {
            $result = queryMysql("select * from members where user = '$user'");

            if ($result->num_rows)
                $error = "That username already exists";
            else {
                queryMysql("insert into members values('$user', '$pass')");
                die("<h4>Account Created</h4>Please Log in.<br><br>");
            }
        }
    }
    
    echo <<< _END
    <form action="signup.php" method="post">
    <span class="fieldname">Username</span>
    <input type="text" maxlength="16" name="user" onBlur="checkUser(this)">$error
    <span id="info"></span><br>
    <span class="fieldname">Password</span>
    <input type="password" maxlength="16" name="pass">
    
    _END;
?>
<span class='fieldname'>&nbsp;</span>
<input type='submit' value='Sign up'>
</form>
</div><br>
</body>

</html>