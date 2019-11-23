$.widget("kurs.menuBar", {
	_create: function() {
		var that = this;
		this.element.find(".show_kurse").click(function() {
			that._trigger("onShowKurseClicked");
			return false;
        });
        this.element.find(".create_kurs").click(function() {
            that._trigger("onCreateKursClicked");
            return false;
        });
	}
});