$(document).ready(function () {
    ProcessDetailModule.Init();
    ProcessDetailModule.InitEvents();
});

var ProcessDetailModule = (function () {

    var _obj = {
            'id': { 'type': 'text', 'attr': {} }
        ,   'lang': { 'type': 'text', 'attr': {} }
        ,   'title': { 'type': 'text', 'attr': {'maxlength': 255 , 'class' : 'required'} }
        ,   'description': { 'type': 'text', 'attr': {'class' : 'required'} }
        ,   'content': { 'type': 'text', 'attr': {'class' : 'required'} }
        ,   'show': { 'type': 'text', 'attr': { } }
    };
    var _objTrans = {
            'trans_lang': { 'type': 'select', 'attr': {} }
        ,   'trans_title': { 'type': 'text', 'attr': { 'maxlength': 255 , 'class' : 'required'} }
        ,   'trans_description': { 'type': 'text', 'attr': { 'class' : 'required' } }
        ,   'trans_content': { 'type': 'text', 'attr': { 'class': 'required' } }
    };

    var dataInit = null;
    var dataTrans = null;

    var Init = function () {
        try {
            AdminCommonModule.InitCheckboxAndRadio();
            Common.InitItem(_obj);
            Common.InitItem(_objTrans);
            dataInit = Common.GetData(_obj);
            dataTrans = Common.GetData(_objTrans);
            $('#title').focus();
        }
        catch (e) {
            console.log('Init: ' + e.message);
        }
    };

    var InitEvents = function () {
        try {
            $('#btn-save-process').on('click', function () {
                SaveProcess();
            });
            $('#btn-delete-process').on('click', function () {
                DeleteProcess();
            });
            window.onbeforeunload = function (e) {
                if (!Common.CompareDataInScreen(dataInit, Common.GetData(_obj)) && ($('#trans-status').val() !== '1'
                    || !Common.CompareDataInScreen(dataTrans, Common.GetData(_objTrans)))) {
                    return _msg[MSG_NO.WARNING_NOT_SAVE_CHANGE].content;
                }
            };
        }
        catch (e) {
            console.log('InitEvents: ' + e.message);
        }
    };

    var SaveProcess = function () {
        try {
            var validate = ValidateModule.Validate(_obj);
            var validateTrans = true;
            if ($('#trans-status').val() === '1') {
                validateTrans = ValidateModule.Validate(_objTrans);
            }
            // var validateImg = AdminCommonModule.ValidateFileImgs();
            if (validate && validateTrans) {
                if ($('#trans-status').val() === '0') {
                    $('#trans_title').val($('#title').val());
                    $('#trans_description').val($('#description').val());
                    $('#trans_content').val($('#content').val());
                }
                if($('#show_chk').is(':checked')){
                    $('#show').val(1);
                }
                else {
                    $('#show').val(0);
                }
                $('#form-process').ajaxSubmit({
                    beforeSubmit: function (a, f, o) {
                        o.dataType = 'json';
                    },
                    complete: function (XMLHttpRequest, textStatus) {
                        var res = XMLHttpRequest.responseJSON;
                        if (res) {
                            if (res.code === 200) {
                                Notification.Alert(MSG_NO.SAVE_DATA_SUCCESS, function(ok) {
                                    dataInit = Common.GetData(_obj);
                                    dataTrans = Common.GetData(_objTrans);
                                    window.location = url.editProcess.replace('/0', '/' + res.data.id);
                                });
                            }
                            else if (res.code === 422) {
                                ValidateModule.FillError(res.errors.data);
                                ValidateModule.FocusFirstError();
                            }
                            else {
                                Notification.Alert(res.msgNo, function(ok) {
                                    $('#title').focus();
                                });
                            }
                        }
                        else {
                            Notification.Alert(MSG_NO.SERVER_ERROR, function () {
                                $("#title").focus();
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
            console.log('SaveProcess: ' + e.message);
        }
    };

    var DeleteProcess = function () {
        try {
            Notification.Alert(MSG_NO.CONFIRM_DELETE_DATA, function (ok) {
                if (ok) {
                    $.ajax({
                        type: 'POST',
                        url: url.deleteProcess,
                        data: {
                            ids: [$('#id').val()]
                        },
                        success: function (res) {
                            if (res.code === 200) {
                                Notification.Alert(MSG_NO.DELETE_DATA_SUCCESS, function (ok) {
                                    window.location = url.createSlide;
                                });
                            }
                            else {
                                Notification.Alert(res.msgNo, function (ok) {
                                    $('#title').focus();
                                });
                            }
                        },
                        error: function () {
                            Notification.Alert(MSG_NO.SERVER_ERROR, function (ok) {
                                $('#title').focus();
                            });
                        }
                    });
                }
            });
        }
        catch (e) {
            console.log('DeleteProcess: ' + e.message);
        }
    };

    return {
        Init: Init,
        InitEvents: InitEvents
    };
})();
