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
                }
                // error: function (response) {
                //     that.element.find('#first_name_field').removeClass('ui-state-error');
                //     //"if (response.responseJSON["first_name"] == "Der Vorname ist eine Pflichtangabe.")"
                //     if (response.status == 400 && response.responseJSON["first_name"] == "Der Vorname ist eine Pflichtangabe." /*response.responseJSON == "error_first_name"*/ ) {
                //         var validationMessages = $.parseJSON(response.responseText);

                //         console.log(validationMessages.first_name);
                //         that.element.find(".validation_messages").text(validationMessages.first_name);
                //         console.log(that.element.find(".validation_messages"));
                //         that.element.find("#first_name_field").addClass("ui-state-error").focus();
                //     } else if (response.status == 400 && response.responseJSON["last_name"] == "Der Nachname ist eine Pflichtangabe.") {
                //         var validationMessages = $.parseJSON(response.responseText);
                //         that.element.find(".validation_messages").text(validationMessages.last_name);
                //         that.element.find("#last_name_field").addClass("ui-state-error").focus();
                //     } else if (response.status == 400 && response.responseJSON == "error_prs_number") {
                //         var validationMessages = $.parseJSON(response.responseText);
                //         that.element.find(".validation_messages").text(validationMessages.prs_number);
                //         that.element.find("#prs_number_field").addClass("ui-state-error").focus();
                //     } else {
                //         that.element.find(".validation_messages").empty();
                //         that.element.find("#first_name_field").removeClass("ui-state-error");
                //         that.element.find("#last_name_field").removeClass("ui-state-error");
                //     }
                // }
            });

        };
        var cancel = this.options.buttons[1];
        cancel.click = function () {
            that.close();
        };
        this._super();
    }
});