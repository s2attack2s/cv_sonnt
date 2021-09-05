$(document).ready(function () {
    SystemVariableDetailModule.Init();
    SystemVariableDetailModule.InitEvents();
});

var SystemVariableDetailModule = (function () {

    var _obj = {
        'id': { 'type': 'name', 'attr': {} },
        'key': { 'type': 'text', 'attr': { 'class': 'required' } },
        'value': { 'type': 'text', 'attr': { 'class': 'required' } },
    };


    var dataInit = null;

    var Init = function () {
        try {
            AdminCommonModule.InitCheckboxAndRadio();
            Common.InitItem(_obj);
            dataInit = Common.GetData(_obj);
            $('#text').focus();
        }
        catch (e) {
            console.log('Init: ' + e.message);
        }
    };

    var InitEvents = function () {
        try {
            $('#btn-save-system-variable').on('click', function () {
                SaveSystemVariable();
            })

        }
        catch (e) {
            console.log('InitEvents: ' + e.message);
        }
    };

    var SaveSystemVariable = function () {
        try {
            var validate = ValidateModule.Validate(_obj);

            if (validate) {

                $('#form-system-variable').ajaxSubmit({
                    beforeSubmit: function (a, f, o) {
                        o.dataType = 'json';
                    },
                    complete: function (XMLHttpRequest, textStatus) {
                        var res = XMLHttpRequest.responseJSON;
                        if (res) {
                            if (res.code === 200) {
                                Notification.Alert(MSG_NO.SAVE_DATA_SUCCESS, function(ok) {
                                    dataInit = Common.GetData(_obj);
                                    window.system_variable = url.editSystemVariable.replace('/0', '/' + res.data.id);
                                });
                            }
                            else if (res.code === 422) {
                                ValidateModule.FillError(res.errors.data);
                                ValidateModule.FocusFirstError();
                            }
                            else {
                                Notification.Alert(res.msgNo, function(ok) {
                                    $('#text').focus();
                                });
                            }
                        }
                        else {
                            Notification.Alert(MSG_NO.SERVER_ERROR, function () {
                                $("#text").focus();
                            });
                        }
                    }
                });
            }
            else {
                ValidateModule.FocusFirstError();
            }
        }
        catch (e) {
            console.log('SaveSystemVariable: ' + e.message);
        }
    };

    var DeleteSystemVariables = function () {
        try {
            Notification.Alert(MSG_NO.CONFIRM_DELETE_DATA, function (ok) {
                if (ok) {
                    $.ajax({
                        type: 'POST',
                        url: url.deleteSystemVariable,
                        data: {
                            ids: [$('#id').val()]
                        },
                        success: function (res) {
                            alert(res.code);
                            if (res.code === 200) {
                                Notification.Alert(MSG_NO.DELETE_DATA_SUCCESS, function (ok) {
                                    window.system_variable = url.listOfSystemVariables;
                                });
                            }
                            else {
                                Notification.Alert(res.msgNo, function (ok) {
                                    $('#text').focus();
                                });
                            }
                        },
                        error: function () {
                            Notification.Alert(MSG_NO.SERVER_ERROR, function (ok) {
                                $('#text').focus();
                            });
                        }
                    });
                }
            });
        }
        catch (e) {
            console.log('DeleteSystemVariable: ' + e.message);
        }
    };

    return {
        Init: Init,
        InitEvents: InitEvents
    };
})();
