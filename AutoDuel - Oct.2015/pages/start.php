<?php 
require '../header.php'; 

if(loggedIn()){
	logout(); 
	echo '<script>window.location="../";</script>';
}

if(isset($_POST['loginButton'])){
	if(googleRecaptcha()){
		login('usernameInput', 'passwordInput');
	}
}
if(isset($_POST['loginButtonNew'])){
	register('usernameInputNew', 'passwordInputNew', 'emailInputNew'); 
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>
		AutoDuel | Start
	</title>
	<link rel="stylesheet" type="text/css" href="../css/start.css">
	<script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body onload="startAnim();">
	<div class="row" id="formRow">
		<div class="medium-6 columns">
			<div class="panel">
				<h3 class="panelHeader">I'm a Member</h3>
				<div class="inputSection">
					<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" class='inputForm' autocomplete="off">
						<label>Username</label>
						<input type="text" name="usernameInput" class="inputBox" autocomplete="off">
						<label>Password</label>
						<input type="password" name="passwordInput" class="inputBox" autocomplete="off">
						<div class="g-recaptcha" data-sitekey="6LfcegwTAAAAAFAQRJwlnchh5zYsRlvW8HT9dNH5"></div><br>
						<input type="submit" class="button round expand submitButton" name="loginButton" value="Log-In"/>
					</form>				
				</div>
			</div>
		</div>
		<div class="medium-6 columns" id="bottomForm">
			<div class="panel">
				<h3 class="panelHeader">I'm New</h3>
				<div class="inputSection">
					<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" class='inputForm'>
						<label>Username</label>
						<input type="text" name="usernameInputNew" class="inputBox" autocomplete="off">
						<label>Password</label>
						<input type="password" name="passwordInputNew" class="inputBox" autocomplete="off">
						<label>E-Mail</label>
						<input type="text" name="emailInputNew" class="inputBox" autocomplete="off"><br>
						<input type="submit" class="button round expand submitButton" name="loginButtonNew" value="Sign-Up" autocomplete="off"/>
					</form>				
				</div>
			</div>
		</div>
		<hr>
	</div>
</body>
</html>