$(document).ready(function() {
    StoriesDetailModule.Init();
    StoriesDetailModule.InitEvents();
});

var StoriesDetailModule = (function() {

    var _obj = {
        'id': { 'type': 'text', 'attr': {} },
        'lang': { 'type': 'text', 'attr': {} },
        'title': { 'type': 'text', 'attr': { 'class': 'required' } },
        'description': { 'type': 'text', 'attr': { 'class': 'required' } },
        'url': { 'type': 'text', 'attr': { 'maxlength': 255 } },
        'image': { 'type': 'text', 'attr': { 'class': 'required' } },
        'show': { 'type': 'text', 'attr': {} }
    };
    var _objTrans = {
        'trans_lang': { 'type': 'select', 'attr': {} },
        'trans_title': { 'type': 'text', 'attr': { 'class': 'required' } },
        'trans_description': { 'type': 'text', 'attr': { 'maxlength': 255 } },
        'trans_url': { 'type': 'text', 'attr': { 'maxlength': 255 } },
        'trans_image': { 'type': 'text', 'attr': { 'class': 'required' } }
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
            $('#title').focus();
        } catch (e) {
            console.log('Init: ' + e.message);
        }
    };

    var InitEvents = function() {
        try {
            $('#btn-save-stories').on('click', function() {
                // console.log('asd');
                SaveStories();
            });
            $('#btn-delete-stories').on('click', function() {
                DeleteOurStories();
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

    var SaveStories = function() {
        try {
            var validate = ValidateModule.Validate(_obj);
            var validateTrans = true;
            if ($('#trans-status').val() === '1') {
                validateTrans = ValidateModule.Validate(_objTrans);
            }
            var validateImg = AdminCommonModule.ValidateFileImgs();
            if (validate && validateImg && validateTrans) {
                // console.log('torng');
                if ($('#trans-status').val() === '0') {
                    $('#trans_title').val($('#trans_title').val());
                    $('#trans_url').val($('#trans_url').val());
                    $('#trans_image').val($('#trans_image').val());
                    $('#trans_logo').val('');
                }
                if ($('#show_chk').is(':checked')) {
                    $('#show').val(1);
                } else {
                    $('#show').val(0);
                }
                $('#form-our-stories').ajaxSubmit({
                    beforeSubmit: function(a, f, o) {
                        o.dataType = 'json';
                    },
                    complete: function(XMLHttpRequest, textStatus) {
                        var res = XMLHttpRequest.responseJSON;
                        if (res) {
                            if (res.code === 200) {
                                Notification.Alert(MSG_NO.SAVE_DATA_SUCCESS, function(ok) {
                                    console.log('ss');

                                    dataInit = Common.GetData(_obj);
                                    dataTrans = Common.GetData(_objTrans);
                                    window.location = url.editOurStories.replace('/0', '/' + res.data.id);
                                });
                            } else if (res.code === 422) {
                                console.log('sss');
                                ValidateModule.FillError(res.errors.data);
                                ValidateModule.FocusFirstError();
                            } else {
                                Notification.Alert(res.msgNo, function(ok) {
                                    $('#title').focus();
                                    console.log('ssss');
                                });
                            }
                        } else {
                            Notification.Alert(MSG_NO.SERVER_ERROR, function() {
                                $("#title").focus();
                            });
                        }
                    }
                });
            } else {
                ValidateModule.FocusFirstError();
            }
        } catch (e) {
            console.log('SaveStories: ' + e.message);
        }
    };

    var DeleteOurStories = function() {
        try {
            Notification.Alert(MSG_NO.CONFIRM_DELETE_DATA, function(ok) {
                if (ok) {
                    $.ajax({
                        type: 'POST',
                        url: url.deleteOurStories,
                        data: {
                            ids: [$('#id').val()]
                        },
                        success: function(res) {
                            if (res.code === 200) {
                                Notification.Alert(MSG_NO.DELETE_DATA_SUCCESS, function(ok) {
                                    window.location = url.createOurStories;
                                });
                            } else {
                                Notification.Alert(res.msgNo, function(ok) {
                                    $('#title').focus();
                                });
                            }
                        },
                        error: function() {
                            Notification.Alert(MSG_NO.SERVER_ERROR, function(ok) {
                                $('#title').focus();
                            });
                        }
                    });
                }
            });
        } catch (e) {
            console.log('DeleteOurStories: ' + e.message);
        }
    };


    return {
        Init: Init,
        InitEvents: InitEvents
    };
})();