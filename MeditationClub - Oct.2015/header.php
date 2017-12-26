<?php require 'functions.php'; startSession(); ?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="js/vendor/jquery.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#userForm").hide();
        });
    </script>
    <script src="js/scripts.js"></script>
    <link rel="stylesheet" href="css/foundation.min.css" />
    <link rel="stylesheet" href="css/header.css" />
    <link rel="icon" type="img/png" href="img/favicon.png">
    <script src="js/vendor/modernizr.js"></script>
</head>

<body>
    <div class="row" id="navBarRow">
        <div class="medium-6 columns">
            <h1><img id="headerImgId" src="img/favicon.png" height="50" width="50"> Weston Meditation</h1>
        </div>
        <div class="medium-6 columns" id="navButtons">
            <a class="button" href="index.php">Home</a>
            <a class="button" onclick="aboutPage();">About</a>
            <a class="button" id="loginButton" <?php if (loggedIn()) { echo 'onclick=loginClick("loggedIn");'; } else { echo 'onclick=loginClick("notLoggedIn");'; } ?>><?php if (loggedIn()) {echo 'Logout';} else {echo 'Log-In';}?></a>
            <button class="button success" onclick="registerClick();" id="registerBtn">Register</button>
            <button id="adminButton" class="button alert" onclick="window.location='admin'">Admin</button>
        </div>
    </div>
    <script src="js/foundation.min.js"></script>
    <script>
        $(document).foundation();
    </script>
</body>

</html>