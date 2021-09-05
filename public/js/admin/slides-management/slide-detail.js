$(document).ready(function () {
    SlideDetailModule.Init();
    SlideDetailModule.InitEvents();
});

var SlideDetailModule = (function () {

    var _obj = {
            'id': { 'type': 'text', 'attr': {} }
        ,   'lang': { 'type': 'text', 'attr': {} }
        ,   'text': { 'type': 'text', 'attr': { 'maxlength': 255 } }
        ,   'link': { 'type': 'text', 'attr': { 'maxlength': 255, 'class': 'url' } }
        ,   'image': { 'type': 'text', 'attr': { 'maxlength': 255, 'class': 'required' } }
        ,   'show': { 'type': 'text', 'attr': { } }
    };
    var _objTrans = {
            'trans_lang': { 'type': 'select', 'attr': {} }
        ,   'trans_text': { 'type': 'text', 'attr': { 'maxlength': 255 } }
        ,   'trans_link': { 'type': 'text', 'attr': { 'maxlength': 255, 'class': 'url' } }
        ,   'trans_image': { 'type': 'text', 'attr': { 'maxlength': 255, 'class': 'required' } }
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
            $('#text').focus();
        }
        catch (e) {
            console.log('Init: ' + e.message);
        }
    };

    var InitEvents = function () {
        try {
            $('#btn-save-slide').on('click', function () {
                SaveSlide();
            });
            $('#btn-delete-slide').on('click', function () {
                DeleteSlide();
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

    var SaveSlide = function () {
        try {
            var validate = ValidateModule.Validate(_obj);
            var validateTrans = true;
            if ($('#trans-status').val() === '1') {
                validateTrans = ValidateModule.Validate(_objTrans);
            }
            var validateImg = AdminCommonModule.ValidateFileImgs();
            if (validate && validateImg && validateTrans) {
                if ($('#trans-status').val() === '0') {
                    $('#trans_text').val($('#text').val());
                    $('#trans_link').val($('#trans_link').val());
                    $('#trans_image').val($('#image').val());
                    $('#trans_img').val('');
                }
                if($('#show_chk').is(':checked')){
                    $('#show').val(1);
                }
                else {
                    $('#show').val(0);
                }
                $('#form-slide').ajaxSubmit({
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
                                    window.location = url.editSlide.replace('/0', '/' + res.data.id);
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
            console.log('SaveSlide: ' + e.message);
        }
    };

    var DeleteSlide = function () {
        try {
            Notification.Alert(MSG_NO.CONFIRM_DELETE_DATA, function (ok) {
                if (ok) {
                    $.ajax({
                        type: 'POST',
                        url: url.deleteSlide,
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
            console.log('DeleteSlide: ' + e.message);
        }
    };

    return {
        Init: Init,
        InitEvents: InitEvents
    };
})();
