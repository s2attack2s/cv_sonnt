$(document).ready(function() {
    SettingDetailModule.Init();
    SettingDetailModule.InitEvents();
});

var SettingDetailModule = (function() {

    var _obj = {
        'id': { 'type': 'text', 'attr': {} },
        'lang': { 'type': 'text', 'attr': {} },
        'facebook': { 'type': 'text', 'attr': { 'maxlength': 255, 'class': 'required' } },
        'linkedin': { 'type': 'text', 'attr': { 'maxlength': 255, 'class': 'required' } },
        'about_us': { 'type': 'text', 'attr': { 'maxlength': 500, 'class': 'required' } },
        'stories': { 'type': 'text', 'attr': { 'maxlength': 255, 'class': 'required' } },
        'process': { 'type': 'text', 'attr': { 'maxlength': 255, 'class': 'required' } },
        'image': { 'type': 'text', 'attr': { 'maxlength': 255, 'class': 'required' } },
        'description': { 'type': 'text', 'attr': { 'maxlength': 500, 'class': 'required' } },
        'keyword': { 'type': 'text', 'attr': { 'maxlength': 100, 'class': 'required' } },
        'author': { 'type': 'text', 'attr': { 'maxlength': 100, 'class': 'required' } },
        'phone': { 'type': 'number', 'attr': { 'maxlength': 20, 'class': 'required' } },
        'address': { 'type': 'text', 'attr': { 'maxlength': 200, 'class': 'required' } },
        'email': { 'type': 'text', 'attr': { 'maxlength': 255, 'class': 'required' } }
    };
    var _objTrans = {
        'trans_lang': { 'type': 'select', 'attr': {} },
        'trans_about_us': { 'type': 'text', 'attr': { 'maxlength': 500, 'class': 'required' } },
        'trans_stories': { 'type': 'text', 'attr': { 'maxlength': 255, 'class': 'required' } },
        'trans_process': { 'type': 'text', 'attr': { 'maxlength': 255, 'class': 'required' } },
        'trans_image': { 'type': 'text', 'attr': { 'maxlength': 255, 'class': 'required' } },
        'trans_description': { 'type': 'text', 'attr': { 'maxlength': 500, 'class': 'required' } },
        'trans_keyword': { 'type': 'text', 'attr': { 'maxlength': 100, 'class': 'required' } },
        'trans_author': { 'type': 'text', 'attr': { 'maxlength': 100, 'class': 'required' } },
        'trans_phone': { 'type': 'number', 'attr': { 'maxlength': 20, 'class': 'required' } },
        'trans_address': { 'type': 'text', 'attr': { 'maxlength': 200, 'class': 'required' } }
    };

    var dataInit = null;
    var dataTrans = null;

    var Init = function() {
        try {
            AdminCommonModule.InitCheckboxAndRadio();
            Common.InitItem(_obj);
            Common.InitItem(_objTrans);
            dataInit = Common.GetData(_obj);
            dataTrans = Common.GetData(_objTrans);
            $('#about_us').focus();
        } catch (e) {
            console.log('Init: ' + e.message);
        }
    };

    var InitEvents = function() {
        try {
            $('#btn-save-setting').on('click', function() {
                SaveSetting();
            });

            $('.number-only').on('keyup', function(e) {
                OnlyInputNumber(e, $(this));
            });

            window.onbeforeunload = function(e) {
                if (!Common.CompareDataInScreen(dataInit, Common.GetData(_obj)) && ($('#trans-status').val() !== '1' ||
                        !Common.CompareDataInScreen(dataTrans, Common.GetData(_objTrans)))) {
                    return _msg[MSG_NO.WARNING_NOT_SAVE_CHANGE].content;
                }
            };
        } catch (e) {
            console.log('InitEvents: ' + e.message);
        }
    };


    /**
     * Validate OnlyInputNumber
     * 
     * Author : ThanhND - 2021/06/01 - create
     */
    var OnlyInputNumber = function(e, $input) {
        try {
            $input.val($input.val().replace(/[^0-9]/g, ""));
        } catch (e) {
            console.log('OnlyInputNumber: ' + e.message);
        }
    };

    /**
     * Update SaveSetting
     * 
     * Author : ThanhND - 2021/06/01 - create
     */
    var SaveSetting = function() {
        try {
            var validate = ValidateModule.Validate(_obj);
            var validateTrans = true;
            if ($('#trans-status').val() === '1') {
                validateTrans = ValidateModule.Validate(_objTrans);
            }
            var validateImg = AdminCommonModule.ValidateFileImgs();
            if (validate && validateImg && validateTrans) {
                if ($('#trans-status').val() === '0') {
                    $('#trans_about_us').val($('#about_us').val());
                    $('#trans_stories').val($('#stories').val());
                    $('#trans_process').val($('#process').val());
                    $('#trans_description').val($('#description').val());
                    $('#trans_keyword').val($('#keyword').val());
                    $('#trans_author').val($('#author').val());
                    $('#trans_phone').val($('#phone').val());
                    $('#trans_address').val($('#address').val());
                    $('#trans_image').val($('#image').val());
                    $('#trans_about_us_img').val('');
                }

                $('#form-setting').ajaxSubmit({
                    beforeSubmit: function(a, f, o) {
                        o.dataType = 'json';
                    },
                    complete: function(XMLHttpRequest, textStatus) {
                        var res = XMLHttpRequest.responseJSON;
                        if (res) {
                            if (res.code === 200) {
                                Notification.Alert(MSG_NO.SAVE_DATA_SUCCESS, function(ok) {
                                    dataInit = Common.GetData(_obj);
                                    dataTrans = Common.GetData(_objTrans);
                                    window.location = url.editSetting.replace('/1', '/');
                                });
                            } else if (res.code === 422) {
                                ValidateModule.FillError(res.errors.data);
                                ValidateModule.FocusFirstError();
                            } else {
                                Notification.Alert(res.msgNo, function(ok) {
                                    $('#about_us').focus();
                                });
                            }
                        } else {
                            Notification.Alert(MSG_NO.SERVER_ERROR, function() {
                                $("#about_us").focus();
                            });
                        }
                    }
                });
            } else {
                ValidateModule.FocusFirstError();
            }
        } catch (e) {
            console.log('SaveSetting: ' + e.message);
        }
    };

    return {
        Init: Init,
        InitEvents: InitEvents
    };
})();