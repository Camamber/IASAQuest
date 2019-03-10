<?php 
session_start();
if(isset($_SESSION["session_name"])) {
	require_once("includes/connection.php"); 
	
	if ($_SESSION["session_name"]=="admin") {
		$json = array();
		$query = mysqli_query($link, "SELECT * FROM quest_teams");

		if($query->num_rows>0) {			
			while($row=$query->fetch_assoc()) {
				if ($row["name"]!="admin") {
					$json[] = $row;
				}	   
			}
			echo json_encode($json);
		}
		$query->free();	
	}
	else {
		echo "";
	}
	$query->close();
	$link->close();	
}	
?>