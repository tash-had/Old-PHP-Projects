<?php 
require '../header.php';

if(!loggedIn()){
	echo '<script>window.location="start";</script>';
}

if(isset($_POST['addTask'])){
	addTask($_SESSION['usernameInput'], 'taskInput', 'priorityInput', 'dateInput');
}
if(isset($_POST['motivationBtn'])){
	getQuote();
}
if(isset($_POST['deleteBtn'])){
	deleteTask();
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>
		AutoDuel | Agenda
	</title>
	<link rel="stylesheet" href="../css/pikaday.css">
	<link rel="stylesheet" href="../css/agenda.css">
</head>
<body onload="agendaAnim();">
	<div class="row" id="formRow">
		<div class="medium-6 columns">
			<div class="panel agendaContent">
				<h3 class="panelHeader" style="@import url(https://fonts.googleapis.com/css?family=Merriweather);
				font-family: 'Merriweather', serif;color: white;font-weight: bold;">Add a Task</h3>
				<div class="inputSection">
					<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" class='inputForm' id="addForm">
						<label>Task Name</label>
						<input type="text" name="taskInput" class="inputBox" autocomplete="off">
						<label>Task Priority</label>
						<select name='priorityInput' autocomplete="off">
							<option>
								High
							</option>
							<option>
								Medium
							</option>
							<option>
								Low
							</option>
						</select>
						<label>Task Due Date</label>
						<input type="text" id="datepicker" name="dateInput" autocomplete="off" id="dateInputId">
						<input type="submit" class="button expand submitButton" name="addTask" value="Add Task"/>
					</form>				
				</div>
			</div>
		</div>
		<div class="medium-6 columns" id="agendaColumn">
			<div class="panel agendaContent" id="agendaPanel">
				<h3 class="panelHeader" style="@import url(https://fonts.googleapis.com/css?family=Merriweather);
				font-family: 'Merriweather', serif;color: white;font-weight: bold;">My Agenda</h3>
				<div id="contentSection"><br>
					<?php 
					getAgenda($_SESSION['usernameInput']);
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="medium-6 columns">
			<button class="button round expand submitButton" id="bottomButton1" onclick="printPage();">Print</button>
		</div>
		<div class="medium-6 columns">
			<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
				<input type="submit" name="motivationBtn" class="button round expand submitButton" id="bottomButton2" value="Motivation"/>	
			</form>		
		</div>
	</div>
	<div class="row">
		<div class="medium-12 columns">
			<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
				<input type="submit" onclick="return confirm('Are you sure you want to delete your tasks? This is irreversible.')" name="deleteBtn" class="button round expand submitButton" value="Delete Tasks">
			</form>
		</div>
	</div>
	<script type="text/javascript" src="../js/moment.js"></script>
	<script type="text/javascript" src="../js/pikaday.js"></script>
	<script>
		var picker = new Pikaday(
		{
			field: document.getElementById('datepicker'),
			firstDay: 1,
			minDate: new Date(),
			format: 'MMMM DD YYYY'
		});
	</script>
	<script type="text/javascript">
		function taskClick(item) {
			var clickedTask = "#" + $(item).attr("id");
			$(clickedTask).toggleClass("stroked");
		}
		function agendaAnim() {
			$(".panel").hide();
			$(".panel").show(1000);
			$("span").hide();
			$("span").show(1000);
		}
	</script>
</body>
</html>