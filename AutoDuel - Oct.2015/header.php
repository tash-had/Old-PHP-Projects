<?php 
require '../functions.php'; 
startSession(); 
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../css/foundation.css" />
  <link rel="stylesheet" href="../css/header.css" />
  <link rel="icon" type="image/png" href="../img/favicon.png">
  <script src="../js/vendor/modernizr.js"></script>
  <script type="text/javascript" src="../js/scripts.js"></script>
</head>
<body>
  <div class="row">
    <div class="medium-12 columns" id="navBarRow">
      <button class="button menuButton" id="homeBtn" onclick="window.location='../';"><?php if(loggedIn()){echo 'My Agenda';}else{echo 'Home';} ?></button>
      <button class="button menuButton" onclick="redirectPage('about')">About</button>
      <button class="button menuButton" onclick="window.open('http://taskattack.ml');">Break Habits</button>
      <button class="button menuButton" id="startBtn" onclick="redirectPage('start')"><?php if(loggedIn()){echo 'Logout';}else{echo 'Start';}  ?></button>
      <hr>
    </div>
  </div>
  <script src="../js/vendor/jquery.js"></script>
  <script src="../js/foundation.min.js"></script>
  <script>
    $(document).foundation();
  </script>
</body>
</html>
