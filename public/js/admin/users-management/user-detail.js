$(document).ready(function () {
    UserDetailModule.Init();
    UserDetailModule.InitEvents();
});

var UserDetailModule = (function () {

    var _obj = {
            'id': { 'type': 'hidden', 'attr': { 'class': 'required'}}
        ,   'username': { 'type': 'text', 'attr': {'class': 'required'} }
        ,   'password': { 'type': 'password', 'attr': {} }
        ,   'name': { 'type': 'text', 'attr': { 'maxlength': 255 , 'class': 'required'}}       
        ,   'address': { 'type': 'text', 'attr': { 'maxlength': 255, 'class': 'required' }  }
        ,   'email': { 'type': 'email', 'attr': { 'maxlength': 255 , 'class': 'required'} }
        ,   'phone': { 'type': 'text', 'attr': {'minlength': 10, 'maxlength': 15 , 'class': 'required'} }
    };
    var dataInit = null;
    var Init = function () {
        try {
            
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
            $('#btn-save-user').on('click', function () {
                SaveUser();
            });
            $('#btn-reset-password').on('click', function () {
                ResetPassword();
            });
            $('#btn-delete-user').on('click', function () {
                DeleteUser();
            });
            $('.number-only').on('keyup', function (e) {
                OnlyInputNumber(e, $(this));
            });
            window.onbeforeunload = function (e) {
             
                    return _msg[MSG_NO.WARNING_NOT_SAVE_CHANGE].content;
                
            };
        }
        catch (e) {
            console.log('InitEvents: '+ e.message);
        }
    };

    var ResetPassword =function(){
        $('#form-reset').ajaxSubmit({
            beforeSubmit: function (a, f, o) {
                o.dataType = 'json';
            },
            complete: function (XMLHttpRequest) {
                var res = XMLHttpRequest.responseJSON;
                if (res) {
                    if (res.code === 200) {
                        Notification.Alert(MSG_NO.RESET_PASSWORD_SUCCESS, function (ok) {
                            window.location = url.editUser.replace('/0', '/' + res.data.id);
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
    
    var SaveUser = function () {
        try {
            var validate = ValidateModule.Validate(_obj);
            if (validate) {         
                $('#form-user').ajaxSubmit({
                    beforeSubmit: function (a, f, o) {
                        o.dataType = 'json';
                    },
                    complete: function (XMLHttpRequest) {
                        var res = XMLHttpRequest.responseJSON;
                        if (res) {
                            if (res.code === 200) {
                                Notification.Alert(MSG_NO.SAVE_DATA_SUCCESS, function(ok) {                             
                                    dataInit = Common.GetData(_obj);
                                    window.location = url.editUser.replace('/0', '/' + res.data.id);
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
            console.log('SaveUser: ' + e.message);
        }
    };
   
    var DeleteUser = function () {
        try {
            Notification.Alert(MSG_NO.CONFIRM_DELETE_DATA, function (ok) {
                if (ok) {
                    $.ajax({
                        type: 'POST',
                        url: url.deleteUser,
                        data: {
                            ids: [$('#id').val()]
                        },
                        success: function (res) {
                            if (res.code === 200) {
                                Notification.Alert(MSG_NO.DELETE_DATA_SUCCESS, function (ok) {
                                    window.location = url.createUser;
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
            console.log('DeleteUser: ' + e.message);
        }
    };
    var OnlyInputNumber = function (e, $input) {
        try {
            $input.val($input.val().replace(/[^0-9]/g, ""));
            if ((e.which < 48 || e.which > 57)) {
                e.preventDefault();
            }
        }

        catch (e) {
            console.log('OnlyInputNumber: ' + e.message);
        }
    };
    return {
        Init: Init,
        InitEvents: InitEvents
    };
})();
