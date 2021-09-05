$(document).ready(function () {
    ContactDetailModule.Init();
    ContactDetailModule.InitEvents();
});

var ContactDetailModule = (function () {

    var _obj = {
            'id': { 'type': 'text', 'attr': {} }
        ,   'name': { 'type': 'text', 'attr': { 'maxlength': 255,'class': 'required' } }
        ,   'image': { 'type': 'text', 'attr': { 'class': 'required' } }
        
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
            $('#btn-save-contact').on('click', function () {
                SaveContact();
            });
            $('#btn-delete-contact').on('click', function () {
                DeleteContacts();
            });

            $('#btn-resolve-contact').on('click', function () {
                ResolveContact();
            });

            $('#btn-close-contact').on('click', function () {
                CloseContact();
            });

            $('#btn-reject-candidate').on('click', function () {
                RejectCandidate();
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

    var SaveContact = function () {
        try {
            var validate = ValidateModule.Validate(_obj);

            //var validateImg = AdminCommonModule.ValidateFileImgs();

            if (validate) {

                $('#form-contact').ajaxSubmit({
                    beforeSubmit: function (a, f, o) {
                        o.dataType = 'json';
                    },
                    complete: function (XMLHttpRequest, textStatus) {
                        var res = XMLHttpRequest.responseJSON;
                        if (res) {
                            if (res.code === 200) {
                                Notification.Alert(MSG_NO.SAVE_DATA_SUCCESS, function(ok) {
                                    dataInit = Common.GetData(_obj);
                                    window.location = url.editContact.replace('/0', '/' + res.data.id);
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
            console.log('SaveContact: ' + e.message);
        }
    };

    var DeleteContacts = function () {
        try {
            Notification.Alert(MSG_NO.CONFIRM_DELETE_DATA, function (ok) {
                if (ok) {
                    $.ajax({
                        type: 'POST',
                        url: url.deleteContact,
                        data: {
                            ids: [$('#id').val()]
                        },
                        success: function (res) {
                            if (res.code === 200) {
                                Notification.Alert(MSG_NO.DELETE_DATA_SUCCESS, function (ok) {
                                    window.location = url.listOfContacts;
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
            console.log('DeleteContact: ' + e.message);
        }
    };


    var ResolveContact = function () {
        try {

            Notification.Alert(MSG_NO.CONFIRM_SAVE_DATA, function (ok) {
                if (ok) {
                    $.ajax({
                        type: 'POST',
                        url: url.resolveContact,
                        data: {
                            id: [$('#id').val()]
                        },
                        success: function (res) {
                            if (res.code === 200) {
                                Notification.Alert(MSG_NO.SAVE_DATA_SUCCESS, function (ok) {
                                    window.location = url.listOfContacts;
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
            console.log('DeleteContact: ' + e.message);
        }
    };


    var CloseContact = function () {
        try {
            Notification.Alert(MSG_NO.CONFIRM_SAVE_DATA, function (ok) {
                if (ok) {
                    $.ajax({
                        type: 'POST',
                        url: url.closeContact,
                        data: {
                            id: [$('#id').val()]
                        },
                        success: function (res) {
                            if (res.code === 200) {
                                Notification.Alert(MSG_NO.SAVE_DATA_SUCCESS, function (ok) {
                                    window.location = url.listOfContacts;
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
            console.log('DeleteContact: ' + e.message);
        }
    };

    return {
        Init: Init,
        InitEvents: InitEvents
    };
})();
