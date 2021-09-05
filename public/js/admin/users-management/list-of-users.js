/**
 * ****************************************************************************
 * list-of-Users.js
 *
 * Description		:	Methods and events for list of Users
 * Created at		:	2021/05/28
 * Created by		:	QuyPN – quy.pham@toploop.co
 * package		    :	Admin
 * ****************************************************************************
 */
$(document).ready(function () {
    ListOfUsersModule.Init();
    ListOfUsersModule.InitEvents();
});

/**
 * Module contains handling for list of Users
 * Author       :   QuyPN - 2021/05/28 - create
 * Param        :
 * Output       :   ListOfUsersModule.Init() - Initialize values
 * Output       :   ListOfUsersModule.InitEvents() - Initiating events
 */
var ListOfUsersModule = (function () {
    /**
     * Objects associated with items on the screen
     */
    var _obj = {
            'search':       { 'type': 'text', 'attr': { 'maxlength': 100 } }
        ,   'current_page': { 'type': 'text', 'attr': {} }
        ,   'per_page':     { 'type': 'text', 'attr': {} }
    };

    /**
     * Initialize system values
     *
     * Author : QuyPN - 2021/05/28 - create
     * Params :
     * Return :
     * Access : public
     */
    var Init = function () {
        try {
            AdminCommonModule.InitPage();
            Common.InitItem(_obj);
            $("#search").focus();
        }
        catch (e) {
            console.log('Init: ' + e.message);
        }
    };

    /**
     * Initiating events in the page
     *
     * Author : QuyPN - 2021/05/26 - create
     * Params :
     * Return :
     * Access : public
     */
    var InitEvents = function () {
        try {
            // Event click button search
            $('#btn-search').on('click', function () {
                if (CONSTANTS.RESET_PAGE) {
                    $('#current_page').val(1);
                }
                Search();
            });
            $('#btn-reset-password').on('click', function () {
                ResetPassword();
            });
            
        }
        catch (e) {
            console.log('Init: ' + e.message);
        }
    };

    /**
     * Search data follow search condition
     *
     * Author : QuyPN - 2021/05/28 - create
     * Params :
     * Return :
     * Access : public
     */
    var Search = function() {
        try {
            var data = Common.GetData(_obj);
            $.ajax({
                type: 'GET',
                url: $('#btn-search').attr('link-search'),
                data: data,
                success: function(res) {
                    $('#div-table-users').html(res);
                    AdminCommonModule.InitPage();
                    AdminCommonModule.InitCheckboxAndRadio();
                    Common.SetTabindex();
                    Common.ChangeUrl('ListUser', Common.GetLastOfUrl(url.ListUser) + '?' + Common.Serialize(data));
                    $("#search").focus();
                },
                error: function() {
                    Notification.Alert(MSG_NO.NUMBER_OF_RECORD_LARGER, function() {
                        $("#search").focus();
                    });
                }
            });
        } catch (e) {
            console.log('Search: ' + e.message);
        }
    };
     /**
     *Reset Password
     *
     * Author :
     * Params :
     * Return :
     * Access : public
     */
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
                            window.location.reload();
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
    return {
        Init: Init,
        InitEvents: InitEvents
    };
})();
