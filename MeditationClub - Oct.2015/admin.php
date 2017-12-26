<link rel="stylesheet" href="css/alertify.css">
<script src="js/alertify.js"></script>
<?php 
require 'header.php'; 
echo '<script>loggedIn();</script>';
if(!loggedIn() || !checkAdmin()){
	echo '<script>window.location="index"</script>';
}
if(isset($_POST['linkSubmit'])){
	addInfo('linkTitle', 'inputLink');
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>
		WM | Admin
	</title>
</head>
<style type="text/css">
	#linkPanel{
		padding: 5%;
	}
</style>

<body>
	<div class="row" id="linkPanel">
		<div class="medium-12 columns">
			<div class="panel">
				<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
					<label>Link Title</label>
					<input type="text" name="linkTitle"> 
					<input type="url" name="inputLink" value="http://www.">
					<input class="button round" type="submit" name="linkSubmit"> 
				</form>
			</div>
		</div>
	</div>
</body>
</html>