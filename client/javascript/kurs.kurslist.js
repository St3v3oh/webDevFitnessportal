$.widget("kurs.kursList", {
    _create: function () {
        $.ajax({
            url: "/fitnessportal/webservice/fitnesskurse",
            dataType: "json",
            success: this._appendKurse,
            context: this
        });
    },

    reload: function () {
        this.element.find(".kurs:not(.template)").remove();
        $.ajax({
            dataType: "json",
            url: "/fitnessportal/webservice/fitnesskurse",
            success: this._appendKurse,
            context: this
        });
    },

    _appendKurse: function (kurse) {
        var that = this;
        for (var i = 0; i < kurse.length; i++) {
            var kurs = kurse[i];
            var kursElement = this.element.find(".template").clone().removeClass("template");
            kursElement.find(".title").text(kurs.title);
            kursElement.find(".trainer").text(kurs.trainer);
            kursElement.find(".startdate").text(kurs.startdate);
            kursElement.find(".duration").text(kurs.duration);
            
            kursElement.click(kurs.url, function (event) {
                that._trigger("onKursClicked", null, event.data);
            });
            kursElement.find(".delete_kurs").click(kurs.url, function (event) {
                that._trigger("onDeleteKursClicked", null, event.data);
                return false;
            });
            kursElement.find(".edit_kurs").click(kurs, function (event) {
                that._trigger("onEditKursClicked", null, event.data);
                return false;
            });
            $("#kurs_list_content").append(kursElement);
        }
    }
});