<?php
	class TodoService {
		const DATABASE_ERROR = "DATABASE_ERROR";
		const NOT_FOUND = "NOT_FOUND";
		const INVALID_INPUT = "INVALID_INPUT";
		const OK = "OK";
		const VERSION_OUTDATED = "VERSION_OUTDATED";
		
		public function updateTodo($todo) {
			$link = new mysqli("localhost", "root", "", "todolist");
			$link->set_charset("utf8");
			$update_statement = "UPDATE todo SET ".
								"title = '$todo->title', ".
								"due_date = '$todo->due_date', ".
								"notes = '$todo->notes', ".
								"version = version + 1 ".
								"WHERE id = $todo->id AND version = $todo->version";
			$link->query($update_statement);
			$affected_rows = $link->affected_rows;
			if ($affected_rows === 0) {
				$select_statement = "SELECT COUNT(*) FROM todo WHERE id = $todo->id";
				$result_set = $link->query($select_statement);
				$row = $result_set->fetch_row();
				$count = intval($row[0]);
				$link->close();
				if ($count === 1) {
					return TodoService::VERSION_OUTDATED;
				}
				return TodoService::NOT_FOUND;
			}
			else {
				$link->close();
			}
		}
		
		public function deleteTodo($id) {
			$link = new mysqli("localhost", "root", "", "todolist");
			$link->set_charset("utf8");
			$delete_statement = "DELETE FROM todo WHERE id = $id";
			$link->query($delete_statement);
			$link->close();
		}
		
		public function createTodo($todo) {
			if ($todo->title === "") {
				$result = new CreateTodoResult();
				$result->status_code = TodoService::INVALID_INPUT;
				$result->validation_messages["title"] = "Der Titel ist eine Pflichtangabe.".
														" Bitte geben Sie einen Titel an.";
				return $result;
			}
			$link = new mysqli("localhost", "root", "", "todolist");
			$link->set_charset("utf8");
			$insert_statement = "INSERT INTO todo SET ".
								"created_date = CURDATE(), ".
								"due_date = '$todo->due_date', ".
								"title = '$todo->title', ".
								"notes = '$todo->notes'";
								"version = 1";
			$link->query($insert_statement);
			$id = $link->insert_id;
			$link->close();
			$result = new CreateTodoResult();
			$result->status_code = TodoService::OK;
			$result->id = $id;
			return $result;
		}
		
		public function readTodo($id) {
			$link = new mysqli("localhost", "root", "", "todolist");
			$link->set_charset("utf8");
			$select_statement = "SELECT id, created_date, due_date, version, ".
								"due_date <= CURDATE() as due, author, title, notes ".
								"FROM todo ".
								"WHERE id = $id";
			$result_set = $link->query($select_statement);
			$todo = $result_set->fetch_object("Todo");
			$link->close();
			if ($todo === NULL) {
				return TodoService::NOT_FOUND;
			}
			return $todo;
		}
		
		public function readTodos() {
			$link = new mysqli("localhost", "root", "", "todolist");
			if ($link->connect_error !== NULL) {
				return TodoService::DATABASE_ERROR;
			}
			$succeeded = $link->set_charset("utf8");
			if ($succeeded === FALSE) {
				$link->close();
				return TodoService::DATABASE_ERROR;
			}
			
			$select_statement = "SELECT id, created_date, due_date, version, ".
								"due_date <= CURDATE() as due, author, title, notes ".
								"FROM todo ".
								"ORDER BY due_date ASC";
			$result_set = $link->query($select_statement);
			
			$todos = array();
			$todo = $result_set->fetch_object("Todo");
			while($todo !== NULL) {
				$todos[] = $todo;
				$todo = $result_set->fetch_object("Todo");
			}
			
			$link->close();
			return $todos;
		}
	}
?>