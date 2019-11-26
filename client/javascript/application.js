$(function () {
    $(document).ajaxError(function (event, response) {
        if (response.status == 400) {
            return;
        }
        $("#error_dialog").errorDialog("open", response.statusText);
        $("#kurs_details").hide();
        $("#create_dialog").hide();
        $("#kurs_list").show();
        if (response.status == 404) {
            $("#kurs_list").kursList("reload");
        }
    });

    $(document).ajaxStart(function () {
        $.blockUI({
            message: null
        });
    });

    $(document).ajaxStop(function () {
        $.unblockUI();
    });

    $("#error_dialog").errorDialog();
    $("#menu_bar_top").menuBar({
        onShowKurseClicked: function () {
            $("#kurs_details").hide();
            $("#kurs_list").show();
            $("#kurs_list").kursList("reload");
        }
    });
    $("#menu_bar_bottom").menuBar({
        onCreateKursClicked: function (event, kurs) {
            $("#create_dialog").createDialog("open", kurs);
        }
    });
    $("#kurs_list").kursList({
        onKursClicked: function (event, kursUrl) {
            $("#kurs_list").hide();
            $("#kurs_details").show();
            $("#kurs_details").kursDetails("load", kursUrl);
        },
        onDeleteKursClicked: function (event, kursUrl) {
            $("#delete_dialog").deleteDialog("open", kursUrl);
        },
        onEditKursClicked: function (event, kurs) {
            $("#edit_dialog").editDialog("open", kurs);
        }
    });
    $("#kurs_details").kursDetails();
    $("#delete_dialog").deleteDialog({
        onKursDeleted: function () {
            $("#kurs_list").kursList("reload");
        }
    });
    $("#edit_dialog").editDialog({
        onKursEdited: function () {
            $("#kurs_list").kursList("reload");
        }
    });
    $("#create_dialog").createDialog({
        onKursCreated: function () {
            $("#kurs_list").kursList("reload");
        }
    });
});