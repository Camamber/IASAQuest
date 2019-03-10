<?php 
session_start();
if(!isset($_SESSION["session_name"])) {
	header("location:index.php");
} 
else {
	if ($_SESSION["session_name"]!="admin") {
		header("location:index.php");
	}
	require_once("includes/connection.php"); 
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
</head>
<body id="admin">
	<section>
		<h1>Admin Panel</h1>
		<table>
			<tr>
				<th>Team</th>
		<?php 
			class Task {
    			public $title;
   				public $description;
			}

			$query = mysqli_query($link, "SELECT * FROM quest_tasks");
			$tasks = array();
			echo '<th colspan="'.$query->num_rows.'"">Tasks</th></tr>';
			if($query->num_rows>0) {			
			    while($row=$query->fetch_assoc()) {
			    	$task = new Task();
			    	$task->title = $row['title'];
			    	$task->description = $row['description'];
			    	$tasks[] = $task;
			    }
			}
			$query->free();
			


			$query = mysqli_query($link, "SELECT * FROM quest_teams");
			if($query->num_rows>0) {			
				while($row=$query->fetch_assoc()) {
					if($row['name'] != 'admin') {
						$team_id = $row["team_id"];
		    			$name = $row['name'];
						$route = json_decode($row["route"]);

						echo '<tr id="team_'.$team_id.'">';
		    			echo "<td>".$name."</td>";
		    			foreach ($route->quest as &$value) {
		    				$state = ($value->status=='true')?'class="done"':'';
		    				echo '<td '.$state.'>'.$tasks[$value->task-1]->title.'</td>';
		    			}
		    			echo "</tr>";
					}
				}
			}
			 $query->free();
			 $link->close();
		?>
		</table>
		<p><a href="logout.php">Выйти</a></p>
		<p id="refresh">Refresh</p>
	</section>
	<script>
		$( document ).ready(function() {
		 	$("#refresh").click(Update);
		 	setInterval(Update, 3000);
		});

		function Update(){
		    $.post("update.php","",
		    function(data, status){
		        var obj = $.parseJSON(data);
		        obj.forEach(function(element) {
		        	var progress = $.parseJSON(element["route"]);
		        	for (var i = 0; i < progress["quest"].length; i++) {
		        		if (progress["quest"][i]["status"]=="true") {
		        			$("#team_"+element["team_id"]).children().eq(i+1).addClass("done");
		        		}
		        		else {
		        			$("#team_"+element["team_id"]).children().eq(i+1).removeClass("done");
		        		}
		        	}
				});
		    });
		}
	
	</script>
</body>
</html>


<?php
}
?>