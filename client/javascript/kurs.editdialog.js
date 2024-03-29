$.widget("kurs.editDialog", $.ui.dialog, {
    options: {
        autoOpen: false,
        modal: true,
        buttons: [{
                text: "OK"
            },
            {
                text: "Abbrechen"
            }
        ],
        width: 550
    },

    open: function (kurs) {
        this._kurs = kurs;
        this.element.find(".validation_message").empty();
        this.element.find("#title_field").removeClass("ui-state-error");
        this.element.find("#title_field").val(kurs.title);
        this.element.find("#notes_field").val(kurs.notes);
        this.element.find("#trainer_field").val(kurs.trainer);
        this.element.find("#startdate_field").val(kurs.startdate);
        this.element.find("#duration_field").val(kurs.duration);
        this.element.find("#numberOfPeople_field").val(kurs.numberOfPeople);
        this.element.find("#price_field").val(kurs.price);
        this._super();
    },

    _create: function () {
        var that = this;

        var ok = this.options.buttons[0];
        ok.click = function () {
            var kurs = {
                title: that.element.find("#title_field").val(),
                notes: that.element.find("#notes_field").val(),
                trainer: that.element.find("#trainer_field").val(),
                startdate: that.element.find("#startdate_field").val(),
                duration: that.element.find("#duration_field").val(),
                numberOfPeople: that.element.find("#numberOfPeople_field").val(),
                price: that.element.find("#price_field").val(),
            }
            $.ajax({
                type: "PUT",
                url: that._kurs.url,
                data: kurs,
                headers: {
                    "If-Match": that._kurs.version
                },
                success: function () {
                    that.close();
                    that._trigger("onKursEdited");

                },
                error: function (response) {
                    that.element.find(".validation_message").empty();
                    that.element.find("#title_field").removeClass("ui-state-error");
                    that.element.find("#title_field").val(kurs.title);
                    that.element.find("#notes_field").val(kurs.notes);
                    that.element.find("#trainer_field").val(kurs.trainer);
                    that.element.find("#startdate_field").val(kurs.startdate);
                    that.element.find("#duration_field").val(kurs.duration);
                    that.element.find("#numberOfPeople_field").val(kurs.numberOfPeople);
                    that.element.find("#price_field").val(kurs.price);

                    if (response.status == 400) {
                        var validationMessages = $.parseJSON(response.responseText);
                        if (validationMessages.title) {
                            that.element.find(".validation_message").text(validationMessages.title);
                            that.element.find("#title_field").addClass("ui-state-error").focus();
                        } else if (validationMessages.trainer) {
                            that.element.find(".validation_message").text(validationMessages.trainer);
                            that.element.find("#trainer_field").addClass("ui-state-error").focus();
                        } else if (validationMessages.startdate) {
                            that.element.find(".validation_message").text(validationMessages.startdate);
                            that.element.find("#startdate_field").addClass("ui-state-error").focus();
                        } else if (validationMessages.duration) {
                            that.element.find(".validation_message").text(validationMessages.duration);
                            that.element.find("#duration_field").addClass("ui-state-error").focus();
                        } else if (validationMessages.price) {
                            that.element.find(".validation_message").text(validationMessages.price);
                            that.element.find("#price_field").addClass("ui-state-error").focus();
                        }
                    }
                }
            });
        };
        var cancel = this.options.buttons[1];
        cancel.click = function () {
            that.close();
        };
        this._super();
    }
});