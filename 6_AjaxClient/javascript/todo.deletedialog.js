$.widget("todo.deleteDialog", $.ui.dialog, {  
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
		]
	},
	
	open: function(todoUrl) {
		this._todoUrl  = todoUrl;
		this._super();
	},
	
	_create: function() {
		var that = this;
		var ok = this.options.buttons[0];
		ok.click = function() {
			that.close();
			$.ajax({
				type: "DELETE",
				url: that._todoUrl,
				success: function() {
					that._trigger("onTodoDeleted");
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