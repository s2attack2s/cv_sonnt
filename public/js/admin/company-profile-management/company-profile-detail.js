$(document).ready(function () {
    CompanyProfileDetailModule.Init();
    CompanyProfileDetailModule.InitEvents();
});

var CompanyProfileDetailModule = (function () {

    var _obj = {
        'id': { 'type': 'name', 'attr': {} },
        'company_name': { 'type': 'text', 'attr': { 'class': 'required' } },
        'founded': { 'type': 'text', 'attr': { 'class': 'required' } },
        'tel': { 'type': 'text', 'attr': { 'class': 'required' } },
        'main_bank': { 'type': 'text', 'attr': { 'class': 'required' } },
        'capital': { 'type': 'text', 'attr': { 'class': 'required' } },
        'ceo_name': { 'type': 'text', 'attr': { 'class': 'required' } }
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
            $('#btn-save-company-profile').on('click', function () {
                SaveCompanyProfile();
            });
            $('#btn-delete-company-profile').on('click', function () {
                DeleteCompanyProfiles();
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

    var SaveCompanyProfile = function () {
        try {
            var validate = ValidateModule.Validate(_obj);

            if (validate) {

                $('#form-company-profile').ajaxSubmit({
                    beforeSubmit: function (a, f, o) {
                        o.dataType = 'json';
                    },
                    complete: function (XMLHttpRequest, textStatus) {
                        var res = XMLHttpRequest.responseJSON;
                        if (res) {
                            if (res.code === 200) {
                                Notification.Alert(MSG_NO.SAVE_DATA_SUCCESS, function(ok) {
                                    dataInit = Common.GetData(_obj);
                                    window.company_profile = url.editCompanyProfile.replace('/0', '/' + res.data.id);
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
            console.log('SaveCompanyProfile: ' + e.message);
        }
    };

    var DeleteCompanyProfiles = function () {
        try {
            Notification.Alert(MSG_NO.CONFIRM_DELETE_DATA, function (ok) {
                if (ok) {
                    $.ajax({
                        type: 'POST',
                        url: url.deleteCompanyProfile,
                        data: {
                            ids: [$('#id').val()]
                        },
                        success: function (res) {
                            alert(res.code);
                            if (res.code === 200) {
                                Notification.Alert(MSG_NO.DELETE_DATA_SUCCESS, function (ok) {
                                    window.company_profile = url.listOfCompanyProfiles;
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
            console.log('DeleteCompanyProfile: ' + e.message);
        }
    };

    return {
        Init: Init,
        InitEvents: InitEvents
    };
})();
