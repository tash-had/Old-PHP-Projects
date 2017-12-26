<?php

function inputValidation($item)
{
    if (isset($_POST[$item]) && !empty($_POST[$item])) {
        return true;
    } else {
        return false;
    }
}
function loggedIn()
{
    if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
        return true;
    } else {
        return false;
    }
}
function dbConnect()
{
    $conn = new mysqli("localhost", "wmx10hos_westonm", "blueynally", "wmx10hos_westonmeditation");
    if ($conn->connect_error) {
        die("Connection Error " . $conn->connect_error);
    }
    return $conn;
    
}
function startSession()
{
    session_start();
    ob_start();
}
function refreshPage()
{
    echo '<script>window.location="index.php";</script>';
}
function login($user, $pass)
{
    if (inputValidation($user) && inputValidation($pass)) {
        $conn = dbConnect();
        
        $usernameInput = $_POST[$user];
        $passwordInput = md5($_POST[$pass]);
        if ($stmt = mysqli_prepare($conn, "SELECT username, password, admin FROM info_table WHERE username=? AND password=?")) {
            mysqli_stmt_bind_param($stmt, "ss", $usernameInput, $passwordInput);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $usernameInput, $passwordInput, $isAdmin);
            if (mysqli_stmt_fetch($stmt)) {
                $_SESSION['username'] = $_POST[$user];
                if ($isAdmin !== 0) {
                    $_SESSION['admin'] = "adminUser";
                }
                refreshPage();
            } else {
                failed("User not found.");
            }
            mysqli_stmt_close($stmt);
        }
        mysqli_close($conn);
    } else {
        failed("Please fill all fields and click Log-In.");
    }
    
}
function register($user, $pass, $email)
{
    if (inputValidation($user) && inputValidation($pass) && inputValidation($email)) {
        $userInput  = $_POST[$user];
        $emailInput = strtolower($_POST[$email]);
        
        if (filter_var($emailInput, FILTER_VALIDATE_EMAIL)) {
            $conn = dbConnect();
            if ($stmt = mysqli_prepare($conn, "SELECT username, email FROM info_table WHERE username=? OR email=?")) {
                mysqli_stmt_bind_param($stmt, "ss", $userInput, $emailInput);
                mysqli_stmt_execute($stmt);
                if (mysqli_stmt_fetch($stmt)) {
                    mysqli_stmt_close($stmt);
                    mysqli_close($conn);
                    failed("Username or Email Already Exists");
                } else {
                    $conn = dbConnect();
                    
                    $passInput = md5($_POST[$pass]);
                    if ($stmt = mysqli_prepare($conn, "INSERT INTO info_table VALUES('', ?, ?, ?, '', '')")) {
                        mysqli_stmt_bind_param($stmt, "sss", $_POST[$user], md5($_POST[$pass]), $_POST[$email]);
                        mysqli_stmt_execute($stmt);
                        $_SESSION['username'] = strtolower($_POST[$user]);
                        refreshPage();
                    } else {
                        failed("Uh oh! Something went wrong!");
                    }
                    mysqli_stmt_close($stmt);
                    mysqli_close($conn);
                }
            }
        } else {
            failed("Please enter a valid e-mail");
        }
    } else {
        failed("Please fill all fields");
    }
}

function checkAdmin()
{
    if (isset($_SESSION['admin'])) {
        return true;
    } else {
        return false;
    }
}
function getTimes()
{
    $conn = dbConnect();
    if ($stmt = mysqli_prepare($conn, "SELECT username, logTime FROM info_table ORDER BY logTime DESC")) {
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $logusername, $logusertime);
        echo '<ol>';
        while (mysqli_stmt_fetch($stmt)) {
            echo '<li>' . '<b>' . $logusername . '</b>' . '<br>' . 'Total Meditation Time:' . $logusertime . ' minutes' . '</li><br>';
        }
        echo '</ol>';
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
function getTotalTime()
{
    $conn     = dbConnect();
    $username = $_SESSION['username'];
    if ($stmt = mysqli_prepare($conn, "SELECT logTime FROM info_table WHERE username=?")) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $totalLogTime);
        if (mysqli_stmt_fetch($stmt)) {
            echo $totalLogTime;
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
function getLogs()
{
    $conn     = dbConnect();
    $username = $_SESSION['username'];
    if ($stmt = mysqli_prepare($conn, "SELECT session FROM logs_table WHERE username=? ORDER BY id DESC")) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $session);
        while (mysqli_stmt_fetch($stmt)) {
            echo $session;
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
function logTime($time)
{
    $conn = dbConnect();
    $user = $_SESSION['username'];
    
    if ($time > 0 && $time < 180) {
        if ($stmt = mysqli_prepare($conn, "SELECT logTime FROM info_table WHERE username=?")) {
            mysqli_stmt_bind_param($stmt, "s", $user);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $totalLogTimeFetched);
            if (mysqli_stmt_fetch($stmt)) {
                $totalTimeInsert = $time + $totalLogTimeFetched;
                $conn            = dbConnect();
                if ($stmt = mysqli_prepare($conn, "UPDATE info_table SET logTime=? WHERE username=?")) {
                    mysqli_stmt_bind_param($stmt, "is", $totalTimeInsert, $user);
                    mysqli_stmt_execute($stmt);
                }
            }
        }
        $sessionFinal = "<li><b>" . $time . " minutes</b> on " . date('l jS \of F Y h:i:s A') . "</li>";
        if ($stmt = mysqli_prepare($conn, "INSERT INTO logs_table VALUES('',?,?)")) {
            mysqli_stmt_bind_param($stmt, "ss", $user, $sessionFinal);
            mysqli_stmt_execute($stmt);
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    } else {
        failed("Your session length looks a bit irrational.");
    }
}
function getInfo()
{
    $conn = dbConnect();
    if ($stmt = mysqli_prepare($conn, "SELECT label, link FROM link_table")) {
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $label, $link);
        while (mysqli_stmt_fetch($stmt)) {
            echo "<a class='linkClass' target='_blank' href='" . $link . "'>" . $label . "</a><br>";
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
}
function addInfo($title, $link)
{
    $conn = dbConnect();
    if (inputValidation($title) && inputValidation($link)) {
        if ($stmt = mysqli_prepare($conn, "INSERT INTO link_table VALUES('',?,?)")) {
            mysqli_stmt_bind_param($stmt, "ss", $_POST[$title], $_POST[$link]);
            mysqli_stmt_execute($stmt);
            logMessage("Link Published Successfully");
        }
        mysqli_stmt_close($stmt);
    } else {
        failed("Please fill all fields");
    }
    mysqli_close($conn);
}
function failed($message)
{
    echo '<script>alertify.okBtn("Ok");alertify.alert("' . $message . '");</script>';
}
function logMessage($message)
{
    echo '<script>alertify.success("' . $message . '");</script>';
}
?>