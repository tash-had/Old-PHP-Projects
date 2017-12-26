<?php

function inputValidtion($item)
{
    if (isset($_POST[$item]) && !empty($_POST[$item])) {
        return true;
    }
}

function login($userBox, $passBox)
{
    if (inputValidtion($userBox) && inputValidtion($passBox)) {
        $conn          = dbconnect();
        $usernameGiven = $_POST[$userBox];
        $passwordGiven = md5($_POST[$passBox]);
        
        if ($stmt = mysqli_prepare($conn, "SELECT username, password FROM user_info WHERE username=? AND password=?")) {
            mysqli_stmt_bind_param($stmt, "ss", $usernameGiven, $passwordGiven);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $usernameGiven, $passwordGiven);
            if (mysqli_stmt_fetch($stmt)) {
                $_SESSION["usernameInput"] = $_POST[$userBox];
                echo '<script>window.location="agenda";</script>';
            } else {
                failed("Invalid Login Credentials.");
            }
            mysqli_stmt_close($stmt);
        }
        mysqli_close($conn);
    } else {
        failed('Please fill all fields');
    }
}


function failed($message)
{
    importAlertify();
    echo '<script>alertify.okBtn("Ok");alertify.alert("' . $message . '");</script>';
}
function logMessage($message)
{
    importAlertify();
    echo '<script>alertify.success("' . $message . '");</script>';
}

function startSession()
{
    ob_start();
    session_start();
}

function loggedIn()
{
    if (isset($_SESSION['usernameInput']) && !empty($_SESSION['usernameInput'])) {
        return true;
    } else {
        return false;
    }
}

function logout()
{
    @ob_end_flush();
    session_destroy();
}

function dbconnect()
{
    $conn = new mysqli("localhost", "root", "", "autoduel_users");
    if ($conn->connect_error) {
        die("Connection Error" . $conn->connect_error);
    }
    return $conn;
}
function register($user, $pass, $email)
{
    $usernameMatch = false;
    $emailMatch    = false;
    
    $emailEntered = strtolower($_POST[$email]);
    
    if (filter_var($emailEntered, FILTER_VALIDATE_EMAIL)) {
        if (inputValidtion($user) && inputValidtion($pass) && inputValidtion($email)) {

            $conn = dbconnect();
            
            if($stmt = mysqli_prepare($conn, "SELECT username FROM user_info WHERE username = ?")){
                $userInput = strtolower($_POST[$user]);
                mysqli_stmt_bind_param($stmt, "s", $userInput);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $userName); 
                if(mysqli_stmt_fetch($stmt)){
                    $usernameMatch = true;
                    mysqli_stmt_close($stmt);
                }

                if($stmt = mysqli_prepare($conn, "SELECT email FROM user_info WHERE email=?")){
                    $userEmailInput = strtolower($_POST[$email]);
                    mysqli_stmt_bind_param($stmt, "s", $userEmailInput);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $email); 

                    if(mysqli_stmt_fetch($stmt)){
                        $emailMatch = true;
                        mysqli_stmt_close($stmt);
                    }
                }
            }
            mysqli_close($conn);
            $userPass = md5($_POST[$pass]);
            if ($usernameMatch || $emailMatch) {
                failed('Username or E-Mail Already Exists.');
            } else {
                $conn = dbconnect();
                if($stmt = mysqli_prepare($conn, "INSERT INTO user_info VALUES('',?,?,?)")){
                    mysqli_stmt_bind_param($stmt, "sss", $userInput, $userPass, $userEmailInput); 
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);
                }
                mysqli_close($conn);
                $_SESSION["usernameInput"] = strtolower($_POST[$user]);
                echo '<script>window.location="agenda";</script>';
            }
        } else {
            failed('Please fill all fields.');
        }
    } else {
        failed("Please enter a valid e-mail address");
    }
}

function addTask($user, $name, $priority, $due)
{
    if (inputValidtion($name) && inputValidtion($priority) && inputValidtion($due)) {
        $conn = dbconnect();
        if($stmt = mysqli_prepare($conn, "INSERT INTO task_db VALUES('',?, ?,?, ?)")){
            $name     = $_POST[$name];
            $priority = $_POST[$priority];
            $due      = strtotime($_POST[$due]);

            mysqli_stmt_bind_param($stmt, "ssis", $user, $name, $due, $priority);
            if($due!=0){
                mysqli_stmt_execute($stmt); 
                mysqli_stmt_close($stmt);
            }else{
                failed("Invalid Due Date");
            }
        }
        mysqli_close($conn);
    } else {
        failed('Please fill all fields');
    }
}

function deleteTask(){
    $user = $_SESSION['usernameInput']; 
    $conn = dbconnect(); 
    if($stmt = mysqli_prepare($conn, "DELETE FROM task_db WHERE user = ?")){
        mysqli_stmt_bind_param($stmt, "s", $user);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }else{
        failed("An error has occured");
    }
    mysqli_close($conn);
}
function getAgenda($user)

{   
    $conn = dbconnect();
    
    if($stmt = mysqli_prepare($conn,"SELECT id, name, duedate, priority FROM task_db WHERE user = ? AND duedate >? ORDER BY duedate ASC, priority='High' DESC, priority='Medium' DESC, priority='Low' DESC"))
    {   

        $date = strtotime(date('Y-m-d H:i:s'));
        $date = strtotime('-1 day', $date);
        mysqli_stmt_bind_param($stmt, "si", $user, $date);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $id, $name, $due, $priority);
        while(mysqli_stmt_fetch($stmt)){
            if ($priority == 'High') {
                echo "<span class='highPriority' onclick='taskClick(this);' id=".$id."><span class='highprioritySpan'>*</span>" . $name . "</span><br>";
            } elseif ($priority == 'Medium') {
                echo "<span class='mediumPriority' onclick='taskClick(this);' id=".$id."><span class='medprioritySpan'>*</span>" . $name . "</span><br>";

            } elseif ($priority == 'Low') {
                echo "<span class='lowPriority' onclick='taskClick(this);' id=".$id."><span class='lowprioritySpan'>*</span>" . $name . "</span><br>";
            }

        }
        mysqli_stmt_close($stmt);
    }else{
        failed("An error has occured");
    }
    mysqli_close($conn);
}
function getQuote()
{
    importAlertify();
    
    $quotes    = array(
        "Productivity is never an accident. It is always the result of a commitment to excellence, intelligent planning, and focused effort.-Paul J. Meyer",
        "Strength and growth come only through continuous effort and struggle. -Napoleon Hill",
        "The starting point of all achievement is desire.-Napoleon Hill",
        "A goal is a dream with a deadline.-Napoleon Hill",
        "Great achievement is usually born of great sacrifice, and is never the result of selfishness. -Napoleon Hill",
        "Patience, persistence and perspiration make an unbeatable combination for success. -Napoleon Hill",
        "Action is the real measure of intelligence. -Napoleon Hill",
        "Effort only fully releases its reward after a person refuses to quit. -Napoleon Hill",
        "Edison failed 10,000 times before he made the electric light. Do not be discouraged if you fail a few times. -Napoleon Hill",
        "I hated every minute of training, but I said, 'Don't quit. Suffer now and live the rest of your life as a champion.'-Muhammad Ali",
        "He who who says he can and he who says he can’t are both usually right -Confucius",
        "The true sign of intelligence is not knowledge but imagination.-Albert Einstein",
        "If opportunity doesn't knock, build a door. -Milton Berle",
        "Put your heart, mind, and soul into even your smallest acts. This is the secret of success. -Swami Sivananda",
        "Believe you can and you're halfway there. -Theodore Roosevelt",
        "Nothing is impossible, the word itself says 'I'm possible'! -Audrey Hepburn",
        "Somewhere, something incredible is waiting to be known. -Carl Sagan",
        "Keep your eyes on the stars, and your feet on the ground. -Theodore Roosevelt"
        );
$randQuote = array_rand($quotes);

echo '
<script>
    alertify
    .okBtn("Ok")
    .cancelBtn("Real motivation")
    .confirm("Go to work or you might fail.", function(event) {
        event.preventDefault();
        alertify.success("Awesome, get to work now.");
    }, function(event) {

        event.preventDefault();

        alertify.alert("' . $quotes[$randQuote] . '");

    });

</script>
';

}

function googleRecaptcha()
{
    $captcha;
    if (isset($_POST['g-recaptcha-response'])) {
        $captcha = $_POST['g-recaptcha-response'];
    }
    if (!$captcha) {
        failed('Please verify that you are a human');
        return false;
    }
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LfcegwTAAAAAIDxtgsdCI29KWaox_swBQeamJ2L&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
    if ($response) {
        return true;
    } else {
        return false;
    }
}

function importAlertify()
{
    echo '<link rel="stylesheet" href="../css/alertify.css">';
    echo '<script src="../js/alertify.js"></script>';
}
?>