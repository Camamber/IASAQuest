<?php 

class Team {
	public $floor=11;
	public $task_id=0;
	private $json="";
	
	function getTeam($name) {
		require("connection.php"); 
		$query = mysqli_query($link, "SELECT * FROM quest_teams WHERE name='".$name."'");
		if($query->num_rows>0) {			
			while($row=$query->fetch_assoc()) {
				$this->json = json_decode($row["route"]);
			}
		}
		$query->free();
		$this->floor=11;
		for ($i=0; $i < count($this->json->quest); $i++) {
			if ($this->json->quest[$i]->status=="false") {
				$this->task_id = $this->json->quest[$i]->task;
			 	$this->floor = $i+1;
			 	break;
			 } 		
		}
	}

	function getTask() {
		require("connection.php"); 
		$query = mysqli_query($link, "SELECT * FROM quest_tasks WHERE task_id='".$this->task_id."'");
		if($query->num_rows>0) {			
			while($row=$query->fetch_assoc()) {
				$description = $row["description"];
			}
		}
		$query->free();
		return $description;
	}

	function updateTeam($key) {
		require("connection.php");
		$query = mysqli_query($link, "SELECT * FROM quest_tasks WHERE task_id='".$this->task_id."'");
		if($query->num_rows>0) {
			while($row=$query->fetch_assoc()) {		
				if($row["key"]==$key){	
					$this->json->quest[$this->floor-1]->status = "true";

					$query->free();
					$query = mysqli_query($link, "UPDATE quest_teams SET route ='".json_encode($this->json)."' WHERE name='".$_SESSION["session_name"]."'");
					break;
				}
			}	
		}
		// $query->free();		
	}
}
?>