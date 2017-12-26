<?php 
require 'functions.php'; 
startSession();
if(isset($_FILES['uploadMain']) && !empty($_FILES['uploadMain'])){
    $uploadFxn = new fileHandle($_SESSION['username']); 
    $uploadFxn->uploadFile("main");
}
if(isset($_FILES['uploadExternal']) && !empty($_FILES['uploadExternal'])){
    $uploadExternalFxn = new fileHandle($_SESSION['username']);
    $uploadExternalFxn->uploadFile("external");
}
if(isset($_POST['logoutSubmit']) && !empty($_POST['logoutSubmit'])){
    logOut(); 
}
if(isset($_POST['deleteSubmit']) && !empty($_POST['deleteSubmit'])){
    $deleteHandle = new fileHandle($_SESSION['username']);
    $deleteHandle->removeFile('deleteName'); 
}
if(isset($_POST['allFilesReq']) && !empty($_POST['allFilesReq'])){
    $fileRequest = new fileHandle($_SESSION['username']); 
    $fileRequest->delete(); 
}
if(isset($_POST['mySiteSubmit']) && !empty($_POST['mySiteSubmit'])){
    $uploadBoolRequest = new fileHandle($_SESSION['username']); 
    if($uploadBoolRequest->uploadBoolean("get", 1)){
        global $echoStmt; 
        $echoStmt = '<script>alertify.okBtn("Okay");alertify.alert("Your webpage is live under: <a target=_blank href=http://exist.ml/me/'.$_SESSION['username'].'>exist.ml/me/'.$_SESSION['username'].'</a>");</script>';
    }else{
        failed("You must upload an index.html file first!"); 
    }
}
if(isset($_POST['seenVerifiedMessage']) && !empty($_POST['seenVerifiedMessage'])){
    $verifyMessageSeen = new creds(); 
    $verifyMessageSeen->changeVerifiedBool("public_site", $_SESSION['username']); 
}
if(isset($_POST['dontWantShowcase']) && !empty($_POST['dontWantShowcase'])){   
    $privateSite = new creds(); 
    $privateSite->changeVerifiedBool("private_site", $_SESSION['username']); 
}
if(!isLoggedIn()){
  header("Location: index.php");
}
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Exist | Dashboard</title>
    <script src="js/vendor/jquery.js"></script>
    <script src="js/alertify.js"></script>
    <link rel="stylesheet" href="css/alertify.css">
    <link rel="stylesheet" href="css/foundation.css" />
    <link rel="icon" type="img/png" href="img/favicon.png">
    <link rel="stylesheet" href="css/dashboard.css" />
    <script src="js/vendor/modernizr.js"></script>
    <script src="js/foundation.min.js"></script>
    <script src='js/jquery-input-file-text.js'></script>
    <script src="js/vex.combined.min.js"></script>
    <script>
        vex.defaultOptions.className = 'vex-theme-os';
    </script>
    <link rel="stylesheet" href="css/vex.css" />
    <link rel="stylesheet" href="css/vex-theme-os.css" />
    <script src="js/main.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            onDocumentLoad();
        });
    </script>
</head>

<body>
    <?php echo $echoStmt;echo $logStmt;$credObject = new creds();
    $credObject->verifiedMessage($_SESSION['username']);?>
    <a href="http://tash-had.com" id="contactLink">Contact</a>
    <div class="row">
        <div class="medium-12 columns" id="startContent">
            <h1 id="mainTitle" class="startContentText"><img id="logoImg" src="img/favicon.png" width="80" height="80">Exist</h1>
        </div>
    </div>
    <div class="row" id="manageFilesBtnRow">
        <div class="medium-12 columns">
            <button id="manageFilesBtn" class="button expand" onclick="manageFiles();">Manage Files</button>
        </div>
    </div>
    <div class="row" id="fileActionButtons">
        <div class="medium-4 columns">
            <form enctype="multipart/form-data" id="mainFileFormId" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                <input name="uploadMain" id="mainUploadBtn" type="file" />
            </form>
        </div>
        <div class="medium-4 columns">
            <form enctype="multipart/form-data" id="externalFormId" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                <input name="uploadExternal" id="externalUploadBtn" type="file" />
            </form>
        </div>
        <div class="medium-4 columns">
            <button id="DeleteFileBtn" class="button expand" onclick="deleteBtnFunction();">Delete File</button>
        </div>
    </div>
    <div class="row">
        <div class="medium-8 columns">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                <input type="submit" name="mySiteSubmit" value="My Site" class="button expand" id="mySiteBtn" id="logOutbtn" />
            </form>
        </div>
        <div class="medium-4 columns">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                <input type="submit" name="logoutSubmit" value="Logout" class="button expand" id="logOutbtn" />
            </form>
        </div>
    </div>
    <div class="row">
        <hr>
        <h2 id="showcaseHead">Recently Uploaded</h2>
        <div class="medium-12 columns">
            <?php showCase(); ?>
            <br>
        </div>
    </div>

    <script>
        $(document).foundation();
    </script>
    <script type="text/javascript">
        $('.iframeViewButton').on('click', function() {
            window.open(this.id);
        });
    </script>

    <script type="text/javascript">
        $('#mainUploadBtn').change(function() {
            $('#mainFileFormId').submit();
        });
        $('#externalUploadBtn').change(function() {
            $('#externalFormId').submit();
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