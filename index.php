<?php
session_start();
?>

<?php require_once("includes/connection.php"); ?>
<?php include("includes/header.php"); ?>

<?php
if(isset($_SESSION["session_name"])){
	echo $_SESSION['session_name'];
	// echo "Session is set"; // for testing purposes
	if($_SESSION['session_name'] == 'admin') {
	//	header("Location: admin.php");
	}
   	else {
   	//	header('Location: party.php');
   	}	
}

if(isset($_POST['password'])){

	if(!empty($_POST['password'])) {

	    $password=md5($_POST['password']);

	    $query = mysqli_query($link, "SELECT * FROM party WHERE password='".$password."'");

	    if($query->num_rows>0) {

		    while($row=$query->fetch_assoc())
		    {
		    	$dbname=$row['name'];
		    	$dbpassword=$row['password'];
		    }

		    if($password == $dbpassword) {
		    	$_SESSION['session_name']=$dbname;
		    	/* Redirect browser */
		    	if($dbname == 'admin') {
		    		header("Location: admin.php");
		    	}
		    	else {
		    		header('Location: party.php');
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
		<div class="container mlogin">
		    <div id="login">
			    <h1>Enter</h1>
				<form name="loginform" id="loginform" action="" method="POST">
				    <p>
				        <label for="user_pass">Code:<br />
				        <input type="password" name="password" id="password" class="input" value="" size="20" /></label>
				    </p>

				    <p class="submit">
				        <input type="submit" name="login" class="button" value="Войти" />
				    </p>
				</form>
		    </div>
		</div>
	
<?php include("includes/footer.php"); ?>
	
<?php if (!empty($message)) {echo "<p class=\"error\">" . "MESSAGE: ". $message . "</p>";} ?>