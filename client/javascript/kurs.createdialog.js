$.widget("kurs.createDialog", $.ui.dialog, {  
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
	
	open: function(kurs) {
		this._kurs  = kurs;
		this._super();
	},
	
	_create: function() {
		var that = this;
		var ok = this.options.buttons[0];
		ok.click = function() {
			that.close();
		};
		var cancel = this.options.buttons[1];
		cancel.click = function() {
			that.close();
		};
		this._super();
	}
});