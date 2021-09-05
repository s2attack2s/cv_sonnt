$(document).ready(function () {
    NewsDetailModule.Init();
    NewsDetailModule.InitEvents();
});

var NewsDetailModule = (function () {

    var _obj = {
            'id': { 'type': 'text', 'attr': {} }
        ,   'language_id': { 'type': 'text', 'attr': {} }
        ,   'title': { 'type': 'text', 'attr': { 'maxlength': 255,'class': 'required' } }
        ,   'content': { 'type': 'text', 'attr': {} }
        ,   'thumbnail': { 'type': 'text', 'attr': { 'class': 'required' } }
        ,   'is_published': { 'type': 'text', 'attr': { } }
    };

    var dataInit = null;

    var Init = function () {
        try {
            AdminCommonModule.InitCheckboxAndRadio();
            Common.InitItem(_obj);
            dataInit = Common.GetData(_obj);
            $('#text').focus();
            CKEDITOR.replace( 'content' );
        }
        catch (e) {
            console.log('Init: ' + e.message);
        }
    };

    var InitEvents = function () {
        try {
            $('#btn-save-news').on('click', function () {
                SaveNews();
            });
            $('#btn-delete-news').on('click', function () {
                DeleteNews();
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

    var SaveNews = function () {
        try {
            var validate = ValidateModule.Validate(_obj);

            var validateImg = AdminCommonModule.ValidateFileImgs();
            if (validate) {
                var fd = $('#form-news').serializeArray();
                if($('#published_chk').is(':checked')){
                    $('#published').val(1);
                    fd.push({
                        name: "is_published",
                        value: 1
                    });
                }
                else {
                    $('#published').val(0);
                    fd.push({
                        name: "is_published",
                        value: 0
                    });
                }
                fd.push({
                    name: "content",
                    value: CKEDITOR.instances.content.getData()
                });
                $('#form-news').ajaxSubmit({
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
                                    window.location = url.editNews.replace('/0', '/' + res.data.id);
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
            console.log('SaveNews: ' + e.message);
        }
    };

    var DeleteNews = function () {
        try {
            Notification.Alert(MSG_NO.CONFIRM_DELETE_DATA, function (ok) {
                if (ok) {
                    $.ajax({
                        type: 'POST',
                        url: url.deleteNews,
                        data: {
                            ids: [$('#id').val()]
                        },
                        success: function (res) {
                            if (res.code === 200) {
                                Notification.Alert(MSG_NO.DELETE_DATA_SUCCESS, function (ok) {
                                    window.location = url.createNews;
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
            console.log('DeleteNews: ' + e.message);
        }
    };

    return {
        Init: Init,
        InitEvents: InitEvents
    };
})();
