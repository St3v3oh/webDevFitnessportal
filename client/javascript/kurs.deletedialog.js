$.widget("kurs.deleteDialog", $.ui.dialog, {  
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
	
	open: function(kursUrl) {
		this._kursUrl  = kursUrl;
		this._super();
	},
	
	_create: function() {
		var that = this;
		var ok = this.options.buttons[0];
		ok.click = function() {
			that.close();
			$.ajax({
				type: "DELETE",
				url: that._kursUrl,
				success: function() {
					that._trigger("onKursDeleted");
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