$(document).ready(function () {
    CareerDetailModule.Init();
    CareerDetailModule.InitEvents();
});

var CareerDetailModule = (function () {

    var _obj = {
            'id': { 'type': 'text', 'attr': {} }
        ,   'language_id': { 'type': 'text', 'attr': {} }
        ,   'name': { 'type': 'text', 'attr': { 'maxlength': 255,'class': 'required' } }
        ,   'image': { 'type': 'text', 'attr': { 'class': 'required' } }
        ,   'short_desc': { 'type': 'text', 'attr': { } }
        ,   'detail': { 'type': 'text', 'attr': { } }
        ,   'priority': { 'type': 'text', 'attr': { } }
        ,   'benefit': { 'type': 'text', 'attr': { } }
        ,   'skill_required': { 'type': 'text', 'attr': { } }
        ,   'contact': { 'type': 'text', 'attr': { } }
        ,   'status': { 'type': 'text', 'attr': { } }
    };


    var dataInit = null;

    var Init = function () {
        try {
            AdminCommonModule.InitCheckboxAndRadio();
            Common.InitItem(_obj);
            dataInit = Common.GetData(_obj);
            $('#text').focus();
            CKEDITOR.replace( 'detail' );
            CKEDITOR.replace( 'short_desc' );
            CKEDITOR.replace( 'benefit' );
            CKEDITOR.replace( 'priority' );
            CKEDITOR.replace( 'skill_required' );
            CKEDITOR.replace( 'contact' );
        }
        catch (e) {
            console.log('Init: ' + e.message);
        }
    };

    var InitEvents = function () {
        try {
            $('#btn-save-career').on('click', function () {
                SaveCareer();
            });
            $('#btn-delete-career').on('click', function () {
                DeleteCareer();
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

    var SaveCareer = function () {
        try {
            var validate = ValidateModule.Validate(_obj);

            var validateImg = AdminCommonModule.ValidateFileImgs();

            if (validate) {
                var fd = $('#form-career').serializeArray();
                // if($('#status_chk').is(':checked')){
                //
                //     $('#status').val(1);
                //     fd.push({
                //         name: "status",
                //         value: 1
                //     });
                // }
                // else {
                //     $('#status').val(0);
                //     fd.push({
                //         name: "status",
                //         value: 0
                //     });
                // }
                fd.push({
                    name: "short_desc",
                    value: CKEDITOR.instances.short_desc.getData()
                });
                fd.push({
                    name: "detail",
                    value: CKEDITOR.instances.detail.getData()
                });
                fd.push({
                    name: "benefit",
                    value: CKEDITOR.instances.benefit.getData()
                });
                fd.push({
                    name: "priority",
                    value: CKEDITOR.instances.priority.getData()
                });
                fd.push({
                    name: "skill_required",
                    value: CKEDITOR.instances.skill_required.getData()
                });
                fd.push({
                    name: "contact",
                    value: CKEDITOR.instances.contact.getData()
                });
                $('#form-career').ajaxSubmit({
                    data: fd,
                    beforeSubmit: function (a, f, o) {
                        o.dataType = 'json';
                    },
                    complete: function (XMLHttpRequest, textStatus) {
                        var res = XMLHttpRequest.responseJSON;
                        if (res) {
                            if (res.code === 200) {
                                Notification.Alert(MSG_NO.SAVE_DATA_SUCCESS, function(ok) {
                                    dataInit = Common.GetData(_obj);
                                    window.location = url.editCareer.replace('/0', '/' + res.data.id);
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
            console.log('SaveCareer: ' + e.message);
        }
    };

    var DeleteCareer = function () {
        try {
            Notification.Alert(MSG_NO.CONFIRM_DELETE_DATA, function (ok) {
                if (ok) {
                    $.ajax({
                        type: 'POST',
                        url: url.deleteCareer,
                        data: {
                            ids: [$('#id').val()]
                        },
                        success: function (res) {
                            if (res.code === 200) {
                                Notification.Alert(MSG_NO.DELETE_DATA_SUCCESS, function (ok) {
                                    window.location = url.createCareer;
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
            console.log('DeleteCareer: ' + e.message);
        }
    };

    return {
        Init: Init,
        InitEvents: InitEvents
    };
})();
