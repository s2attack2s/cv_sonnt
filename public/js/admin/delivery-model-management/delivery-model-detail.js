$(document).ready(function () {
    DeliveryModelDetailModule.Init();
    DeliveryModelDetailModule.InitEvents();
});

var DeliveryModelDetailModule = (function () {

    var _obj = {
        'id': { 'type': 'name', 'attr': {} },
        'title': { 'type': 'text', 'attr': { 'class': 'required', 'max': '255' } },
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
            $('#btn-save-delivery-model').on('click', function () {
                SaveDeliveryModel();
            })

        }
        catch (e) {
            console.log('InitEvents: ' + e.message);
        }
    };

    var SaveDeliveryModel = function () {

        try {
            var validate = ValidateModule.Validate(_obj);

            if (validate) {
                $('#form-delivery-model').ajaxSubmit({
                    beforeSubmit: function (a, f, o) {
                        o.dataType = 'json';
                    },
                    complete: function (XMLHttpRequest, textStatus) {
                        var res = XMLHttpRequest.responseJSON;
                        if (res) {
                            if (res.code === 200) {
                                Notification.Alert(MSG_NO.SAVE_DATA_SUCCESS, function(ok) {
                                    dataInit = Common.GetData(_obj);
                                    window.system_variable = url.editDeliveryModel.replace('/0', '/' + res.data.id);
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
            console.log('SaveGlobalDeliveryModel: ' + e.message);
        }
    };

    var DeleteGlobalDeliveryModels = function () {
        try {
            Notification.Alert(MSG_NO.CONFIRM_DELETE_DATA, function (ok) {
                if (ok) {
                    $.ajax({
                        type: 'POST',
                        url: url.deleteDeliveryModel,
                        data: {
                            ids: [$('#id').val()]
                        },
                        success: function (res) {
                            alert(res.code);
                            if (res.code === 200) {
                                Notification.Alert(MSG_NO.DELETE_DATA_SUCCESS, function (ok) {
                                    window.system_variable = url.listOfDeliveryModels;
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
            console.log('DeleteDeliveryModel: ' + e.message);
        }
    };

    return {
        Init: Init,
        InitEvents: InitEvents
    };
})();
