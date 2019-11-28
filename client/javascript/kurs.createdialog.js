$.widget("kurs.createDialog", $.ui.dialog, {
    options: {
        autoOpen: false,
        modal: true,
        width: 500,
        buttons: [{
                text: "OK"
            },
            {
                text: "Abbrechen"
            }
        ]
    },

    open: function (kurs) {
        this._kurs = kurs;
        this._super();
    },

    _create: function () {
        var that = this;
        var ok = this.options.buttons[0];
        ok.click = function () {
            that._kurs = {
                title: that.element.find("#title_field").val(),
                notes: that.element.find("#notes_field").val(),
                trainer: that.element.find("#trainer_field").val(),
                startdate: that.element.find("#startdate_field").val(),
                duration: that.element.find("#duration_field").val(),
                numberOfPeople: that.element.find("#numberOfPeople_field").val(),
                price: that.element.find("#price_field").val(),
                url: "/fitnessportal/WebService/fitnesskurse"
            };

            $.ajax({
                type: "POST",
                url: that._kurs.url,
                data: that._kurs,
                success: function () {
                    that.close();
                    that._trigger("onKursCreated");
                },
                error: function (response) {
                    var kurs = that._kurs;
                    that.element.find(".validation_message").empty();
                    that.element.find("#title_field").val(kurs.title);
                    that.element.find("#title_field").removeClass("ui-state-error");
                    that.element.find("#notes_field").val(kurs.notes);
                    that.element.find("#trainer_field").val(kurs.trainer);
                    that.element.find("#trainer_field").removeClass("ui-state-error");
                    that.element.find("#startdate_field").val(kurs.startdate);
                    that.element.find("#startdate_field").removeClass("ui-state-error");
                    that.element.find("#duration_field").val(kurs.duration);
                    that.element.find("#duration_field").removeClass("ui-state-error");
                    that.element.find("#numberOfPeople_field").val(kurs.numberOfPeople);
                    that.element.find("#price_field").val(kurs.price);
                    that.element.find("#price_field").removeClass("ui-state-error");

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