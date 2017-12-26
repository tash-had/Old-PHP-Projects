<?php 
require '../header.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>
		AutoDuel | About		
	</title>
	<link rel="stylesheet" type="text/css" href="../css/about.css">
</head>
<body onload="aboutAnim();">
	<div class="row">
		<div class="medium-12 columns" id="aboutSection">
			<p>
				Being able to plan an efficient work schedule is is essential to maximizing productivity. Often, this can get overwhelming, tedious and even confusing. AutoDuel changes that by organizing your work for you! All you have to do is enter your tasks with just a bit of information and AutoDuel will do the rest. <a style="color:#2196F3" href=<?php if(!loggedIn()){echo "start.php"; }else{echo "agenda.php";} ?>>Get Started Now!</a>
			</p>      
			<p>				
				AutoDuel is still in beta, so if you have any feedback, questions or comments, feel free to <span style='color: #2196F3;cursor: pointer;'onclick='emailFunction();'>contact me!</span> You can also visit my website at <span style='color: #2196F3;cursor: pointer;'onclick="window.location='http://www.tash-had.com'";>tash-had.com.</span>
			</p>
		</div>
		<hr>
	</div>
</body>
</html>