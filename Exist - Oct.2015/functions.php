<?php
$echoStmt = "";
$logStmt  = "";
function inputValidation($item)
{
    if (isset($_POST[$item]) && !empty($_POST[$item])) {
        return true;
    } else {
        return false;
    }
}
function isLoggedIn()
{
    if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
        return true;
    } else {
        return false;
    }
}
function startSession()
{
    session_start();
    ob_start();
}
function logOut()
{
    session_destroy();
    ob_end_flush();
    header("Location: index.php");
}
function dbConnect()
{
    $conn = new mysqli("localhost", "existx12_user", "blueynally", "existx12_db");
    if ($conn->connect_error) {
        die("Sorry, there was an error" . $conn->connect_error);
    }
    return $conn;
}

function failed($message)
{
    global $echoStmt;
    $echoStmt = '<script>alertify.okBtn("Ok");alertify.alert("' . $message . '");</script>';
}
function logMessage($message)
{
    global $logStmt;
    $logStmt = '<script>alertify.success("' . $message . '");</script>';
}

function showCase()
{
    $conn = dbConnect();
    if ($stmt = mysqli_prepare($conn, "SELECT username, legit_user, has_site FROM user_info ORDER BY latest_upload DESC")) {
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $siteOwner, $legitStatus, $siteStatus);
        while (mysqli_stmt_fetch($stmt)) {
            if ($legitStatus == 1 && $siteStatus == 1) {
                echo '<h4 class="iframeDivClassHeading">' . $siteOwner . '</h4>' . '<div class="iframeClass">
                <iframe height="500" width="700" src="me/' . $siteOwner . '" class="showCaseIframe"></iframe><br><br><button id="me/' . $siteOwner . '" class="button expand iframeViewButton">View Site</button></div>
                ';
            }
        }
        mysqli_stmt_close($stmt); 
    }
    mysqli_close($conn); 
    
}
class creds
{
    public function login($user, $pass)
    {
        if (inputValidation($user) && inputValidation($pass)) {
            $conn = dbConnect();
            if ($stmt = mysqli_prepare($conn, "SELECT username, password FROM user_info WHERE username=? AND password=?")) {
                $username = strtolower($_POST[$user]);
                $password = md5($_POST[$pass]);
                mysqli_stmt_bind_param($stmt, "ss", $username, $password);
                mysqli_stmt_execute($stmt);
                if (mysqli_stmt_fetch($stmt)) {
                    $_SESSION['username'] = strtolower($_POST[$user]);
                    mysqli_stmt_close($stmt);
                    mysqli_close($conn);
                    header("Location: dashboard.php");
                } else {
                    failed("User not found");
                    mysqli_stmt_close($stmt);
                    mysqli_close($conn);
                }
            } else {
                failed("User not found");
            }
        } else {
            failed("Please fill all fields and click Log-In");
        }
    }
    public function verifiedMessage($username){
        $conn = dbConnect(); 
        if($stmt = mysqli_prepare($conn, "SELECT legit_user, verified_message FROM user_info WHERE username=?")){
            mysqli_stmt_bind_param($stmt, "s", $username); 
            mysqli_stmt_execute($stmt); 
            mysqli_stmt_bind_result($stmt, $legitUser, $verifiedMessage);
            if(mysqli_stmt_fetch($stmt)){
                if($legitUser ==1 && $verifiedMessage==0){
                    echo '<script>verifiedMessageDialog();</script>';
                }
            }
            mysqli_stmt_close($stmt); 
        }
        mysqli_close($conn);
    }
    public function changeVerifiedBool($action, $user){
        if($action == "private_site"){
            $conn = dbConnect(); 
            if($stmt = mysqli_prepare($conn, "UPDATE user_info SET legit_user=44, verified_message=44 WHERE username=?")){
                mysqli_stmt_bind_param($stmt, "s", $user); 
                mysqli_stmt_execute($stmt); 
                mysqli_stmt_close($stmt); 
                logMessage("Your website will not show up on the showcase.");
            }
            mysqli_close($conn); 

        }else if($action == "public_site"){
            $conn = dbConnect(); 
            if($stmt = mysqli_prepare($conn, "UPDATE user_info SET verified_message=1 WHERE username=?")){
                mysqli_stmt_bind_param($stmt, "s", $user); 
                mysqli_stmt_execute($stmt); 
                mysqli_stmt_close($stmt);
                logMessage("Your webpage will now show up on the showcase.");

            }
            mysqli_close($conn); 
        }
    }
    private function checkExists($user, $email)
    {
        $conn = dbConnect();
        if ($stmt = mysqli_prepare($conn, "SELECT username, email FROM user_info WHERE username=? OR email=?")) {
            mysqli_stmt_bind_param($stmt, "ss", $user, $email);
            mysqli_stmt_execute($stmt);
            if (mysqli_stmt_fetch($stmt)) {
                return true;
                mysqli_stmt_close($stmt);
            } else {
                return false;
                mysqli_stmt_close($stmt);
            }
        }
        mysqli_close($conn);
    }
    public function register($user, $pass, $email)
    {
        if (inputValidation($user) && inputValidation($pass) && inputValidation($email)) {
            if (filter_var($_POST[$email], FILTER_VALIDATE_EMAIL)) {
                $username  = strtolower($_POST[$user]);
                $password  = md5($_POST[$pass]);
                $userEmail = strtolower($_POST[$email]);
                if (!$this->checkExists($username, $userEmail)) {
                    $conn = dbConnect();
                    if ($stmt = mysqli_prepare($conn, "INSERT INTO user_info VALUES('',?,?,?,0,0,'',0)")) {
                        mysqli_stmt_bind_param($stmt, "sss", $username, $password, $userEmail);
                        mysqli_stmt_execute($stmt);
                        mkdir("me/" . $username, 0777, true);
                        $this->login($user, $pass);
                        mysqli_stmt_close($stmt);
                    }
                    mysqli_close($conn);
                } else {
                    failed("User already exists");
                }
            } else {
                failed("Please enter a valid e-mail");
            }
        } else {
            failed("Please fill all fields");
        }
    }
}
class fileHandle
{
    private $CURRENT_USER;
    public function __construct($user)
    {
        $this->CURRENT_USER = $user;
    }
    private function validate($type)
    {
        if ($type == "main") {
            $targetFile = $_FILES['uploadMain']['name'];
            $fileType   = pathinfo($targetFile, PATHINFO_EXTENSION);
            if ($targetFile == "index.html" || $targetFile == "index.html") {
                if ($fileType == "html" || $fileType == "htm") {
                    if ($_FILES['uploadMain']['size'] < 1000000) {
                        return true;
                    } else {
                        failed("Your file is too large. Please compress it to 1 MB.");
                    }
                } else {
                    failed("Please ensure your file is an HTML file");
                }
            } else {
                failed("Please submit an HTML file named 'index'");
            }
        } else if ($type == "external") {
            $targetFile   = $_FILES['uploadExternal']['name'];
            $fileArray    = $_FILES['uploadExternal'];
            $fileType     = pathinfo($targetFile, PATHINFO_EXTENSION);
            $allowedTypes = array(
                "jpg",
                "jpeg",
                "png",
                "gif",
                "html",
                "htm",
                "js",
                "css",
                "docx",
                "pdf"
                );
            if (in_array($fileType, $allowedTypes)) {
                if ($fileArray['size'] < 1000000) {
                    return true;
                } else {
                    failed("Your file must be 1 MB or less");
                }
            } else {
                failed("Your file is not in a supported format. The supported file types are JPG/JPEG, PNG, GIF, HTML/HTM, JS, CSS, PDF and DOCX");
            }
        }
    }
    public function uploadFile($type)
    {
        if ($type == "main") {
            if ($this->validate($type)) {
                $location = "me/" . $this->CURRENT_USER . "/" . $_FILES['uploadMain']['name'];
                if (move_uploaded_file($_FILES['uploadMain']['tmp_name'], $location)) {
                    logMessage("index.html has been successfully uploaded.");
                    $this->uploadBoolean("insert", 1);
                } else {
                    failed("There was an error uploading your file");
                }
            }
        } else if ($type == "external") {
            if ($this->validate($type)) {
                $location = "me/" . $this->CURRENT_USER . "/" . $_FILES['uploadExternal']['name'];
                if (move_uploaded_file($_FILES['uploadExternal']['tmp_name'], $location)) {
                    logMessage($_FILES['uploadExternal']['name'] . " has been uploaded successfully.");
                }
            }
        }
    }
    public function uploadBoolean($action, $bool)
    {
        if ($action == "get") {
            $conn = dbConnect();
            if ($stmt = mysqli_prepare($conn, "SELECT has_site FROM user_info WHERE username=?")) {
                mysqli_stmt_bind_param($stmt, "s", $this->CURRENT_USER);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $has_site_bool);
                if (mysqli_stmt_fetch($stmt)) {
                    if ($has_site_bool == 1) {
                        return true;
                    } else {
                        return false;
                    }
                }
                mysqli_stmt_close($stmt);
            }
            mysqli_close($conn);
            
        } else if ($action == "insert") {
            $conn = dbConnect();
            if ($stmt = mysqli_prepare($conn, "UPDATE user_info SET has_site=?, latest_upload=? WHERE username=?")) {
                $currentTImeStamp = $this->getTimestamp(); 
                $currentUser = $this->CURRENT_USER;
                mysqli_stmt_bind_param($stmt, "iis", $bool, $currentTImeStamp, $currentUser);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            }
            mysqli_close($conn);
        }
    }
    public function delete()
    {
        global $allFilesInDir;
        $fileNamesRootDir = scandir('me/' . $this->CURRENT_USER);
        foreach ($fileNamesRootDir as $value) {
            if ($value == "." || $value == "..") {
            } else {
                $allFilesInDir = $allFilesInDir . $value . "<br>";
            }
        }
        failed("<b>Files In Your Directory</b><br>" . $allFilesInDir);
    }
    public function removeFile($fileNameInput)
    {
        if (inputValidation($fileNameInput)) {
            if ($_POST[$fileNameInput] == "index.html") {
                $this->uploadBoolean("insert", 0);
            }
            if (@unlink("me/" . $this->CURRENT_USER . "/" . $_POST[$fileNameInput])) {
                logMessage('Your file has been successfully deleted');
            } else {
                failed("Please ensure that you've entered a valid file name.");
            }
        } else {
            failed("You must enter a filename");
        }
    }
    public function getTimestamp()
    {
        $date = new DateTime(); 
        return $date->getTimestamp(); 
    }
}
?>