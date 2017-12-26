<?php 
require 'functions.php'; 
startSession(); 
if(loggedIn()){
  echo '<script>window.location="pages/agenda";</script>';
}
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AutoDuel | Welcome</title>
  <link rel="stylesheet" href="css/foundation.css" />
  <link rel="stylesheet" href="css/index.css">
  <link rel="icon" href="img/favicon.png">
  <script src="js/vendor/modernizr.js"></script>
  <script type="text/javascript" src="js/scripts.js"></script>
</head>
<body onload="indexAnim();">
  <div class="row">
    <div class="medium-12 columns" id="mainTitle">
      <span>Get Productive.<br><b>Start Now.</b></span>
    </div>
    <div class="row">
      <div class="medium-12 columns" id="frontPageButtons">
        <button class="button radius large mainbtn" onclick="redirect('about');">About</button>
        <button class="button radius large mainbtn" onclick="redirect('start');">Get Started</button>
      </div>
    </div>

  </div>
  <script src="js/vendor/jquery.js"></script>
  <script type="text/javascript" src="js/scripts.js"></script>
  <script src="js/foundation.min.js"></script>
  <script>
    $(document).foundation();
  </script>
</body>
</html>
