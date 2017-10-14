$(function() {
	$(document).ajaxError(function(event, response) {
		$("#error_dialog").errorDialog("open", response.statusText);
	});
	
	$("#error_dialog").errorDialog();
	$("#todo_list").todoList();
	$("#todo_details").todoDetails();
});