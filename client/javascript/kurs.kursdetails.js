$.widget("kurs.kursDetails", {  
	load: function(kursUrl) {
		$.ajax({
			url: kursUrl,
			dataType: "json",
			success: function(kurs) {
				this.element.find(".title").text(kurs.title);
				this.element.find(".author").text(kurs.author);
				this.element.find(".startdate").text(kurs.startdate);
				this.element.find(".notes").text(kurs.notes);
				this.element.find(".duration").text(kurs.duration);
				this.element.find(".trainer").text(kurs.trainer);
				this.element.find(".price").text(kurs.price);
				this.element.find(".numberOfPeople").text(kurs.numberOfPeople);
			},
			context: this
		});
	}
});