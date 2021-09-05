$(document).ready(function() {
    UserDetailModule.Init();
    UserDetailModule.InitEvents();
});

var UserDetailModule = (function() {

    var _obj = {
        'id': { 'type': 'hidden', 'attr': {} },
        'username': { 'type': 'text', 'attr': {} },
        'name': { 'type': 'text', 'attr': { 'maxlength': 255 } },
        'address': { 'type': 'text', 'attr': { 'maxlength': 255 } },
        'email': { 'type': 'email', 'attr': { 'maxlength': 255 } },
        'phone': { 'type': 'number', 'attr': { 'maxlength': 255 } },
        'old_password': { 'type': 'password', 'attr': { 'min': 4 } },
        'new_password': { 'type': 'password', 'attr': { 'min': 4 } },
        'confirm_password': { 'type': 'password', 'attr': { 'min': 4 } }

    };


    var dataInit = null;

    var Init = function() {
        try {

            Common.InitItem(_obj);

            dataInit = Common.GetData(_obj);

        } catch (e) {
            console.log('Init: ' + e.message);
        }
    };

    var InitEvents = function() {
        try {
            $('#btn-save-profile').on('click', function() {
                SaveProfile();
            });
            $('#btn-password').on('click', function() {
                SavePassword();
            });
            window.onbeforeunload = function(e) {
                return _msg[MSG_NO.WARNING_NOT_SAVE_CHANGE].content;
            };
        } catch (e) {
            console.log('InitEvents: ' + 'test' + e.message);
        }
    };

    var SaveProfile = function() {
        try {
            var validate = ValidateModule.Validate(_obj);
            if (validate) {
                $('#form-profile').ajaxSubmit({
                    beforeSubmit: function(a, f, o) {
                        o.dataType = 'json';
                    },
                    complete: function(XMLHttpRequest) {
                        var res = XMLHttpRequest.responseJSON;
                        if (res) {
                            if (res.code === 200) {
                                Notification.Alert(MSG_NO.SAVE_DATA_SUCCESS, function(ok) {
                                    dataInit = Common.GetData(_obj);
                                    console.log('a');
                                    window.location = url.profile.replace('/0', '/' + res.data.id);;
                                    
                                });
                            } else if (res.code === 422) {
                                console.log('a1');
                                ValidateModule.FillError(res.errors.data);
                                ValidateModule.FocusFirstError();
                            }else if (res.code === 500) {
                                Notification.Alert(res.msgNo, function(ok) {
                                    console.log(res,'5a');
                                });
                            }
                             else {
                                Notification.Alert(res.msgNo, function(ok) {
                                    console.log('2a');
                                });
                            }
                        } else {
                            Notification.Alert(MSG_NO.SERVER_ERROR, function() {
                                console.log('a3');
                            });
                        }
                    }
                });

            } else {
                console.log('a4');
                ValidateModule.FocusFirstError();
            }
        } catch (e) {
            console.log('SaveProfile: ' + e.message);
        }
    };
    var SavePassword = function() {
        try {
            var validate = ValidateModule.Validate(_obj);
            if (validate) {
                var data = Common.GetData(_obj);
                data.old_password = Secure.EncodeMD5(data.old_password);
                $('#form-password').ajaxSubmit({
                    beforeSubmit: function(a, f, o) {
                        o.dataType = 'json';
                    },
                    complete: function(XMLHttpRequest) {
                        var res = XMLHttpRequest.responseJSON;
                        if (res) {
                            if (res.code === 200) {
                                Notification.Alert(MSG_NO.SAVE_DATA_SUCCESS, function(ok) {
                                    dataInit = Common.GetData(_obj);
                                    window.location = url.profile.replace('/0', '/' + res.data.id);
                                });
                            } else if (res.code === 422) {
                                ValidateModule.FillError(res.errors.data);
                                ValidateModule.FocusFirstError();
                                Notification.Alert(res.msgNo, function(ok) {});
                            } else {
                                Notification.Alert(res.msgNo, function(ok) {});
                            }
                        } else {
                            Notification.Alert(MSG_NO.SERVER_ERROR, function() {});
                        }
                    }
                });

            } else {
                ValidateModule.FocusFirstError();
            }
        } catch (e) {
            console.log('SavePassword: ' + e.message);
        }
    };


    return {
        Init: Init,
        InitEvents: InitEvents
    };
})();