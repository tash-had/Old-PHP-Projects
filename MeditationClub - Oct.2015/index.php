<link rel="stylesheet" href="css/alertify.css">
<script src="js/alertify.js"></script>
<?php require 'header.php'; if(isset($_POST[ 'registerSubmit'])){ register( 'username', 'password', 'email'); } if(isset($_POST[ 'loginSubmit'])){ login( 'username', 'password'); } if(isset($_POST[ 'logSubmit'])){ if(inputValidation( 'timeLogged')){ logTime($_POST[ 'timeLogged']); }else{ failed( "Please enter a valid session length"); } } ?>

<head>
    <title>Weston Meditation | Home</title>
</head>
<link rel="stylesheet" type="text/css" href="css/index.css">

<body>
    <?php if(loggedIn()){ echo '<script>loggedIn();</script>'; if(checkAdmin()){ echo '<script>adminPage("admin");</script>;'; }else{ echo '<script>adminPage("not");</script>;'; } }else{ echo '<script>adminPage("not");</script>;'; } ?>
    <div class="row">
        <div class="large-12 columns">
            <div class="panel">
                <div class="row">
                    <div class="medium-8 columns" id="leaderPanel">
                        <h3>Current Meditators</h3>
                        <?php getTimes(); ?>
                    </div>
                    <div class="medium-4 columns" id="newsPanel">
                        <h3>Meditation News/Facts</h3>
                        <?php getInfo(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" id="userEnterForm">
        <div class="medium-12 columns">
            <form id="userForm" class="panel" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                <label>Username</label>
                <input type="text" name="username" />
                <label>Password</label>
                <input type="password" name="password" />
                <label class="signup">E-mail</label>
                <input class="signup" type="text" name="email" />
                <input class="button round signup btnSubmit" type="submit" value="Register" name="registerSubmit" />
                <input class="button round login btnSubmit" type="submit" value="Log-In" name="loginSubmit" />
            </form>
        </div>
        <?php if(loggedIn()){ ?>
        <div class="medium-12 columns">
            <div class="panel">
                <h3><?php echo $_SESSION['username'];?>'s Stats</h3>
                <span class="totalTimeSpan"><b>Total Meditated Time:</b> <?php getTotalTime(); ?> minutes</span>
                <br>
                <span class="allLogsSpan"><b><span class="logsSpanTitle">Sessions:</span>
                </b>
                <br>
                <?php getLogs(); ?>
                </span>
                <br>
                <br>
                <form id="logForm" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                    <h3>Log a Session</h3>
                    <label>Session Length (Minutes)</label>
                    <input type="number" name="timeLogged">
                    <input class="button expand" id="submitLogButton" type="submit" name="logSubmit" value="Log Time">
                </form>
            </div>
        </div>
        <?php } ?>
    </div>
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