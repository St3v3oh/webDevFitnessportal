<?php 
	function read_todo($id) {
		/*
		Erster Anlauf:
		$todo = array();
		$todo["title"] = $id;
		$todo["author"] = "Sebastian";
		$todo["due_date"] = "2013-08-03";
		$todo["created_date"] = "2013-07-21";
		$todo["notes"] = "Auch das ist noch zu tun";*/
		$link = mysqli_connect("localhost","root","","todolist");
		if($link === FALSE) {
			return FALSE;
		}
		mysqli_set_charset($link, "utf8");
		$sql_statement = 	"SELECT id, created_date, due_date, author, title, notes ".
							"FROM todo ".
							"WHERE id = $id";
		$result_set = mysqli_query($link, $sql_statement);
		if($result_set === FALSE) {
			mysqli_close($link);
			return FALSE;
		}
		
		$todo = mysqli_fetch_assoc($result_set);
		mysqli_close($link);
		return $todo;
	}
	function read_todos() {
		$todos = array();
		$link = mysqli_connect("localhost","root","","todolist");
		mysqli_set_charset($link, "utf8");
		$sql_statement = 	"SELECT id, created_date, due_date, author, title, notes ".
							"FROM todo ".
							"ORDER BY due_date ASC";
		$result_set = mysqli_query($link, $sql_statement);
		
		$todo = mysqli_fetch_assoc($result_set);
		while($todo !== NULL) {
			$due_date = strtotime($todo["due_date"]);
			$today = strtotime("today");
			$todo["due"] = $due_date >= $today;
			$todos[] = $todo;
			$todo = mysqli_fetch_assoc($result_set);
		}
		
		mysqli_close($link);
		return $todos;
	}
	
	function create_todo($todo) {
		if($todo["title"] === "") {
			return FALSE;
		}
		$link = mysqli_connect("localhost","root","","todolist");
		mysqli_set_charset($link, "utf8");
		$sql_statement = 	"INSERT INTO todo SET ".
							"created_date = CURDATE(), ".
							"due_date = '$todo[due_date]', ".
							"title = '$todo[title]', ".
							"notes = '$todo[notes]'";
		mysqli_query($link, $sql_statement);
		mysqli_close($link);
		return TRUE;
	}
?>