$(document).ready(function () {
    EmailSettingDetailModule.Init();
    EmailSettingDetailModule.InitEvents();
});

var EmailSettingDetailModule = (function () {

    var _obj = {
        'id': { 'type': 'text', 'attr': {} }
        , 'lang': { 'type': 'text', 'attr': {} }
        , 'mailer': { 'type': 'text', 'attr': { 'maxlength': 10, 'class': 'required' } }
        , 'mail_port': { 'type': 'text', 'attr': { 'maxlength': 255, 'class': 'required' } }
        , 'mail_host': { 'type': 'text', 'attr': { 'maxlength': 255, 'class': 'required' } }
        , 'mail_smtp_auth': { 'type': 'text', 'attr': { 'maxlength': 10, 'class': 'required' } }
        , 'mail_user': { 'type': 'email', 'attr': { 'maxlength': 255, 'class': 'required' } }
        , 'mail_password': { 'type': 'text', 'attr': { 'maxlength': 255, 'class': 'required' } }
        , 'mail_from': { 'type': 'email', 'attr': { 'maxlength': 255, 'class': 'required' } }
        , 'mail_received': { 'type': 'email', 'attr': { 'maxlength': 255, 'class': 'required' } }
    };

    var dataInit = null;

    var Init = function () {
        try {
            AdminCommonModule.InitCheckboxAndRadio();
            Common.InitItem(_obj);
            dataInit = Common.GetData(_obj);
            $('#mailer').focus();
        }
        catch (e) {
            console.log('Init: ' + e.message);
        }
    };

    var InitEvents = function () {
        try {
            $('#btn-save-emailsetting').on('click', function () {
                SaveEmailSetting();
            });
             // Event when clicking the button to see the mail_password
             $('#btn-show-mail_password').on('mousedown mouseup', function () {
                ToggleShowMailPassword();
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

     /**
     * Update SaveEmailSetting
     * 
     * Author : ThanhND - 2021/06/01 - create
     */
    var SaveEmailSetting = function () {
        try {
            var validate = ValidateModule.Validate(_obj);
            if (validate) {
                $('#form-emailsetting').ajaxSubmit({
                    beforeSubmit: function (a, f, o) {
                        o.dataType = 'json';
                    },
                    complete: function (XMLHttpRequest) {
                        var res = XMLHttpRequest.responseJSON;
                        if (res) {
                            if (res.code === 200) {
                                Notification.Alert(MSG_NO.SAVE_DATA_SUCCESS, function (ok) {
                                    dataInit = Common.GetData(_obj);
                                    window.location = url.editEmailSetting.replace('/1', '/');
                                });
                            }
                            else if (res.code === 422) {
                                ValidateModule.FillError(res.errors.data);
                                ValidateModule.FocusFirstError();
                            }
                            else {
                                Notification.Alert(res.msgNo, function (ok) {
                                    $('#mailer').focus();
                                });
                            }
                        }
                        else {
                            Notification.Alert(MSG_NO.SERVER_ERROR, function () {
                                $("#mailer").focus();
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
            console.log('SaveEmailSetting: ' + e.message);
        }
    };

    /**
     * Displays the entered password when pressing and holding the show mail_password button.
     *
     * Author : ThanhND - 2021/06/04 - create
     */
    var ToggleShowMailPassword = function () {
        try {
            if ($('#mail_password').attr('type') === 'password') {
                $('#mail_password').attr('type', 'text');
            }
            else {
                $('#mail_password').attr('type', 'password');
            }
        }
        catch (e) {
            console.log('ToggleShowMailPassword: ' + e.message);
        }
    };
    return {
        Init: Init,
        InitEvents: InitEvents
    };
})();
