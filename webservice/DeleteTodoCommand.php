<?php
	class DeleteTodoCommand {
		public function execute($request) {
			$id = request["id"];
			$todo_service = new TodoService();
			$todo_service->deleteTodo($id);
		}
	}
?>