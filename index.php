<?php
session_start();
?>

<?php require_once("includes/connection.php"); ?>
<?php// include("includes/header.php"); ?>

<?php
if(isset($_SESSION["session_name"])){
	
	$name =  $_SESSION['session_name'];
	// echo "Session is set"; // for testing purposes
	if($name == 'admin') {
		header("Location: admin.php");
	}
   	else {
   		header('Location: team.php');
   	}	
}

if(isset($_POST['password'])){

	if(!empty($_POST['password'])) {

	    $password=md5($_POST['password']);

	    $query = mysqli_query($link, "SELECT * FROM quest_teams WHERE password='".$password."'");

	    if($query->num_rows>0) {

		    while($row=$query->fetch_assoc())
		    {
		    	$dbname=$row['name'];
		    	$dbpassword=$row['password'];
		    }

		    if($password == $dbpassword) {
		    	$_SESSION['session_name']=$dbname;
		    	$link->close();
		    	/* Redirect browser */
		    	if($dbname == 'admin') {
		    		header("Location: admin.php");
		    	}
		    	else {
		    		header('Location: team.php');
		    	}
		    }
	    } 
	    else {
	 		$message = 'Wrong password!';
	    }
	} 
	else {
	    $message = "Please enter the password!";
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
   	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>IASA Quest</title>
    <link rel="stylesheet" href="css/style.css">	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<!-- <script src="js/main.js"></script> -->
</head>
<body id="index">
	<canvas id="canvas"></canvas>
	<section>
		<h1>WELCOME</h1>
		<form name="loginform" method="POST">
		    <input type="password" name="password" class="password" size="32" />
		    <input type="submit" name="login" value="LET'S START" />
		</form>
		<?php if (!empty($message)) {echo "<p class=\"error\">" . "MESSAGE: ". $message . "</p>";} ?>		
	</section>
	<?php //include("includes/footer.php"); ?>
	<script>				
		$( document ).ready(function() {
		  var canvas = document.getElementById("canvas");
		  start(canvas);
		});

		function start(q) {
		    var s = window.screen;
		    var width = q.width = s.width;
		    var height = q.height = s.height;
		    var letters = Array(256).join(1).split('');

		    var draw = function () {
		        q.getContext('2d').fillStyle='rgba(0,0,0,.05)';
		        q.getContext('2d').fillRect(0,0,width,height);
		        q.getContext('2d').fillStyle='#0F0';
		        letters.map(function(y_pos, index){
		        	text = String.fromCharCode(3e4+Math.random()*33);
		          	x_pos = index * 10;
		          	q.getContext('2d').fillText(text, x_pos, y_pos);
		          	letters[index] = (y_pos > 758 + Math.random() * 1e4) ? 0 : y_pos + 10;
		        });
		    };
		    setInterval(draw, 40);
		}
	</script>
</body>
</html>

	
