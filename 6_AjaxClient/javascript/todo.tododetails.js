$.widget("todo.todoDetails", {  
	load: function(todoUrl) {
		$.ajax({
			url: todoUrl,
			dataType: "json",
			success: function(todo) {
				alert("HTTP-Antwort erhalten");
			}
		});
	}
});