<?php
require "vendor\autoload.php";
require "Todo.php";
require "CreateTodoResult.php";
require "TodoService.php";

$config = [
  'settings' => [ 
    'displayErrorDetails' => true,
  ],
  'foundHandler' => function() {
    return new \Slim\Handlers\Strategies\RequestResponseArgs();
  }
];

$app = new \Slim\App($config);

$app->get(
  "/todos",
  function ($request, $response) {
	  $todo_service = new TodoService();
	  $todos = $todo_service->readTodos();
	  
	  if ($todos === TodoService::DATABASE_ERROR) {
		$response = $response->withStatus(500);
		return $response;
	  }
	  
	  foreach ($todos as $todo) {
		$todo->url = "/Bangemann/5_WebService/todos/$todo->id";
		unset($todo->id);
	  }
	  
	  $response = $response->withJson($todos);
	  return $response;
  });

$app->get(
	"/todos/{id}",
	function ($request, $response, $id) {
		$todo_service = new TodoService();
		$todo = $todo_service->readTodo($id);
		
		if ($todo === TodoService::NOT_FOUND){
			$response = $response->withStatus(404);
			return $response;
		}
		
		unset($todo->id);
		$response = $response->withJson($todo);
		return $response;
	});
$app->post(
	"/todos",
	function ($request, $response) {
		$todo = new Todo();
		$todo->title = $request->getParsedBodyParam("title");
		$todo->due_date = $request->getParsedBodyParam("due_date");
		$todo->notes = $request->getParsedBodyParam("notes");
		
		$todo_service = new TodoService();
		$result = $todo_service->createTodo($todo);
		
		if ($result->status_code === TodoService::INVALID_INPUT) {
			$response = $response->withHeader(400);
			return $response->withJson($result->validation_messages);
		}
		
		$response = $response->withStatus(201);
		$response = $response->withHeader("Location", "/Bangemann/5_WebService/todos/$result->id");
		return $response;
	});
	
$app->run();
?>
