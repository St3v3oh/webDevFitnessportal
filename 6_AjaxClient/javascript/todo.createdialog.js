$.widget("todo.createDialog", $.ui.dialog, {  
	options: {
		autoOpen: false,
		modal: true,
		buttons: [
			{
				text: "OK"
			},
			{
				text: "Abbrechen"
			}
		],
		width: 550
	},
	
	open: function(todo) {
		this._todo  = todo;
		this.element.find(".validation_message").empty();
		this.element.find("#title_field").removeClass("ui-state-error");
		this.element.find("#title_field").val(todo.title);
		this.element.find("#due_date_field").val(todo.due_date);
		this.element.find("#notes_field").val(todo.notes);
		this._super();
	},
	
	_create: function() {
		var that = this;
		this.element.find("#due_date_field").datepicker({ dateFormat: "yy-mm-dd" });
		var ok = this.options.buttons[0];
		ok.click = function() {
			var todo = {
				title: that.element.find("#title_field").val(),
				due_date: that.element.find("#due_date_field").val(),
				notes: that.element.find("#notes_field").val()
			}
			$.ajax({
				type: "POST",
				url: that._todo.url,
				data: todo,
				headers: { "If-Match": that._todo.version },
				success: function() {
					that.close();
					that._trigger("onTodoCreated");
					
				},
				error: function(response) {
					if(response.status == 400) {
						var validationMessages = $.parseJSON(response.responseText);
						that.element.find(".validation_message").text(validationMessages.title);
						that.element.find("#title_field").addClass("ui-state-error").focus();
					}
				}
			});
		};
		var cancel = this.options.buttons[1];
		cancel.click = function() {
			that.close();
		};
		this._super();
	}
});