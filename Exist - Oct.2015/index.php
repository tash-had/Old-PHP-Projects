<?php 
require 'functions.php'; 
startSession();
if(isset($_POST['loginSubmit'])){
    $loginFxn = new creds();
    $loginFxn->login('usernameLogin','passwordName'); 
}
if(isset($_POST['registerSubmit'])){
    $registerFxn = new creds(); 
    $registerFxn->register('usernameLogin', 'passwordName', 'emailName'); 
}
if(isLoggedIn()){
    header("Location: dashboard.php");
}
?>
<!doctype html>
<html class="no-js" lang="en">

<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Exist | Welcome</title>
    <script src="js/vendor/jquery.js"></script>
    <script src="js/alertify.js"></script>
    <link rel="stylesheet" href="css/alertify.css">
    <link rel="stylesheet" href="css/foundation.min.css" />
    <link rel="icon" type="img/png" href="img/favicon.png">
    <link rel="stylesheet" href="css/index.css" />
    <script src="js/vendor/modernizr.js"></script>
</head>

<body>
    <?php echo $echoStmt; ?>
    <a href="http://tash-had.com" id="contactLink">Contact</a>
    <div class="row">
        <div class="medium-12 columns" id="startContent">
            <h1 id="mainTitle" class="startContentText"><img id="logoImg" src="img/favicon.png" width="150" height="150">Exist</h1>
            <h4 id="mainCaption" class="startContentText">A Free HTML, CSS and JavaScript Host.</h4>
        </div>
    </div>
    <div class="row">
        <div class="medium-12 columns" id="linkRow">
            <br>
            <li><a onclick="homeInfo(1)" class="button round link">What's With The Name?</a>
            </li>
            <li><a onclick="homeInfo(2)" class="button round link">Why Exist?</a>
            </li>
            <li><a onclick="homeInfo(3)" class="button round link">Custom Domains</a>
            </li>
            <hr>
        </div>
    </div>
    <div class="row" id="startDiv">
        <div class="medium-12 columns">
            <button class="button success large" id="startMenuBtnOne" onclick="startBtnClick('login');">
                Log-In
            </button>
            <button class="button success large" id="startMenuBtnTwo" onclick="startBtnClick('register');">
                Register
            </button>
        </div>
    </div>
    <div class="row" id="mainFormRow">
        <div class="medium-12 columns">
            <div class="panel" id="panelId">
                <form id="startForm" method="POST" onsubmit="return submitConfirm();" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                    <label>Username:</label>
                    <input type="text" minlength="3" id="loginUsername" name="usernameLogin">
                    <label>Password:</label>
                    <input type="password" minlength="6" name="passwordName" id="passwordId">
                    <label id="emailLabel">E-Mail:</label>
                    <input type="text" minlength="10" name="emailName" id="emailId">
                    <input type="submit" name="loginSubmit" class="button round success expand" id="submitButton" value="Log-In">
                    <input type="submit" name="registerSubmit" class="button round success expand" id="registerSubmitId" value="Register">
                </form>
            </div>
        </div>
    </div>
    <script src="js/main.js"></script>
    <script src="js/foundation.min.js"></script>
    <script>
        $(document).foundation();
        $(document).ready(function() {
            $("#mainFormRow").hide();
        });
    </script>
</body>
<script>
    (function(i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function() {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-43160348-12', 'auto');
    ga('send', 'pageview');
</script>

</html>