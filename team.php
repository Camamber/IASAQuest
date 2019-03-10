<?php 
session_start();
if(!isset($_SESSION["session_name"])) {
	header("location:index.php");
} 
else {
	if ($_SESSION["session_name"]=="admin") {
		header("location:admin.php");
	} 
	require_once("includes/connection.php"); 
	require_once("includes/send.php"); 

	$team = new Team($link);
	$team->getTeam($_SESSION["session_name"]);

	if(isset($_POST["key"])){
		if(!empty($_POST["key"])) {
			$team->updateTeam($_POST["key"]);
		}
	}
	$team->getTeam($_SESSION["session_name"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
   	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>IASA Quest</title>
    <link rel="stylesheet" href="css/style.css?ver=15ddaffdкsa">	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body id="party">
	<script>
		$( document ).ready(function() {
			if($("section").height()+30>$(window).height()){
		  $("#wall").height($("section").height()+30);}
		});
	</script>
	<div id="wall" class="overlay"></div>
	<section>
		<div class="wrap">
			<a class="logout" href="logout.php">Выйти</a>
			<div class="floor">
				<div class="circle">
					<p> <?php echo $team->floor ?> </p>
				</div>
				<h1>FLOOR</h1>
			</div>		
			<div class="task">
				<h3>Ваше следующее задание, <?php echo $_SESSION["session_name"]?></h3>
				<p class="description">
					<?php 
						if ($team->floor<11) {
							echo $team->getTask($team->task_id); 
						}
						else{
							echo "Толик проснись ты обосрался </br> Беги к метро Олимпийская";
						}	
					?>
				</p>
			</div>
			<?php if ($team->floor<11) {?>
			<form name="loginform" id="loginform" action="" method="POST">
				<input type="text" name="key" value="" size="32" />
				<input type="submit" name="login" class="button" value="Дальше" />
			</form>		
			<?php }	?>
			<br><br><br>
			<ul>
				Доп. точки (фото):
				<li>Парк Руставели (памятник)</li>
				<li>БЦ Парус (вход)</li>
				<li>Начало лестницы к 26 (кол-во ступенек)</li>
				<li>Наводницкая башня</li>
				<li>Леся Украинка (памятник)</li>
				<li>Памятник Павлова</li>
				<li>Планетарий (экспонат)</li>
			</ul>	
		</div>
	</section>		
</body>
</html>

<?php
//$query->close();
//$link->close();
}
?>