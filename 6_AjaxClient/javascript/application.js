$(function() {
	$(document).ajaxError(function(event, response) {
		if(response.status == 400) {
			return;
		}
		$("#error_dialog").errorDialog("open", response.statusText);
		$("#todo_details").hide();
		$("#todo_list").show();
		if (response.status == 404) {
			$("#todo_list").todoList("reload");
		}
	});
	
	$(document).ajaxStart(function() {
		$.blockUI({ message: null });
	});
	
	$(document).ajaxStop(function() {
		$.unblockUI();
	});
	
	$("#error_dialog").errorDialog();
	$("#menu_bar").menuBar({
		onShowTodosClicked: function() {
			$("#todo_details").hide();
			$("#todo_list").show();
			$("#todo_list").todoList("reload");
		}
	});
	$("#todo_list").todoList({
		onTodoClicked: function(event, todoUrl) {
			$("#todo_list").hide();
			$("#todo_details").show();
			$("#todo_details").todoDetails("load", todoUrl);
		},
		onDeleteTodoClicked: function(event, todoUrl) {
			$("#delete_dialog").deleteDialog("open", todoUrl);
		},
		onEditTodoClicked: function(event, todo) {
			$("#edit_dialog").editDialog("open", todo);
		},
		onCreateTodoClicked: function(event, todo) {
			$("#create_dialog").createDialog("open", todo);
		}
	});
	$("#todo_details").todoDetails();
	$("#delete_dialog").deleteDialog({
			onTodoDeleted: function() {
				$("#todo_list").todoList("reload");
			}
	});
	$("#edit_dialog").editDialog({
		onTodoEdited: function() {
			$("#todo_list").todoList("reload");
		}
	});
	$("#create_dialog").createDialog({
		onTodoCreated: function() {
			$("#todo_list").todoList("reload");
		}
	});
});