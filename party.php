<?php 
session_start();
if(!isset($_SESSION["session_name"])) {
	header("location:index.php");
} 
else {
?>

<?php include("includes/header.php"); ?>

<?php echo "<h1>Привет, ".$_SESSION["session_name"]."</h1>"; ?>
<p><a href="logout.php">Выйти</a></p>
<?php include("includes/footer.php"); ?>
<?php if (!empty($message)) {echo "<p class=\"error\">" . "MESSAGE: ". $message . "</p>";} ?>

<?php
}
?>