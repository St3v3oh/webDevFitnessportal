$.widget("kurs.kursDetails", {  
	load: function(kursUrl) {
		$.ajax({
			url: kursUrl,
			dataType: "json",
			success: function(kurs) {
				this.element.find(".title").text(kurs.title);
				this.element.find(".notes").text(kurs.notes);
				this.element.find(".trainer").text(kurs.trainer);
				this.element.find(".startdate").text(this.formatDate(new Date(kurs.startdate)));
				this.element.find(".duration").text(kurs.duration);
				this.element.find(".numberOfPeople").text(kurs.numberOfPeople);
				this.element.find(".price").text(kurs.price);
			},
			context: this
		});
	},

    formatDate: function (date) {
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var ampm = hours >= 12 ? 'pm' : 'am';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? '0' + minutes : minutes;
        var strTime = hours + ':' + minutes + ' ' + ampm;
        return date.getMonth() + 1 + "." + date.getDate() + "." + date.getFullYear() + "  " + strTime;
    }
});