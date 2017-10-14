$.widget("todo.todoList", {  
  _create: function() { 
	$.ajax({
		url: "/bangemann/5_WebService/todos",
		dataType: "json",
		success: this._appendTodos,
		context: this
	});
  },
		
		
  _appendTodos:	function(todos) {
			for (var i = 0; i < todos.length; i++) {
				var todo = todos[i];
				var todoElement = this.element.find(".template").clone().removeClass("template");
				todoElement.find(".title").text(todo.title);
				todoElement.find(".author").text(todo.author);
				todoElement.find(".due_date").text(todo.due_date);
				this.element.append(todoElement);
			}
  }
});