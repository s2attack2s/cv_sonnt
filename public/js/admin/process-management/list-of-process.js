/**
 * ****************************************************************************
 * list-of-process.js
 *
 * Description		:	Methods and events for list of process
 * Created at		:	2021/06/01
 * Created by		:	DinhAn – dinhan0209@gmail.com
 * package		    :	Admin
 * ****************************************************************************
 */
$(document).ready(function () {
    ListOfProcessModule.Init();
    ListOfProcessModule.InitEvents();
});

/**
 * Module contains handling for list of process
 * Author       :   DinhAn - 2021/06/01 - create
 * Param        :
 * Output       :   ListOfProcessModule.Init() - Initialize values
 * Output       :   ListOfProcessModule.InitEvents() - Initiating events
 */
var ListOfProcessModule = (function () {
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
     * Author : DinhAn - 2021/06/01 - create
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
     * Author : DinhAn - 2021/06/01 - create
     * Params :
     * Return :
     * Access : public
     */
    var InitEvents = function () {  
        try {
            $('#btn-search').on('click', function () {
                if (CONSTANTS.RESET_PAGE) {
                    $('#current_page').val(1);
                }
                Search();
            });
            $(document).on('change', '.check-show', function () {
                UpdateShow($(this));
            });
        }
        catch (e) {
            console.log('Init: ' + e.message);
        }
    };

    /**
     * Search data follow search condition
     *
     * Author : DinhAn - 2021/06/01 - create
     * Params :
     * Return :
     * Access : public
     */
    var Search = function () {
        try {
            var data = Common.GetData(_obj);
            $.ajax({
                type: 'GET',
                url: $('#btn-search').attr('link-search'),
                data: data,
                success: function (res) {
                    $('#div-table-slides').html(res);
                    AdminCommonModule.InitPage();
                    AdminCommonModule.InitCheckboxAndRadio();
                    Common.SetTabindex();
                    Common.ChangeUrl('ListOfProcess', Common.GetLastOfUrl(url.listOfProcess) + '?' + Common.Serialize(data));
                    $("#search").focus();
                },
                error: function () {
                    Notification.Alert(MSG_NO.NUMBER_OF_RECORD_LARGER, function () {
                        $("#search").focus();
                    });
                }
            });
        }
        catch (e) {
            console.log('Search: ' + e.message);
        }
    };

    /**
     * Show or hide slide
     *
     * Author : DinhAn - 2021/06/01 - create
     * Params : $chk - checkbox has changed state
     * Return :
     * Access : public
     */
     var UpdateShow = function ($chk) {
        try {
            $.ajax({
                type: 'POST',
                url: url.updateStatus,
                global: false,
                data: {
                    id: $chk.attr('id-process'),
                    status: $chk.is(':checked')
                },
                success: function (res) {
                    if (res.code !== 200) {
                        Notification.Alert(res.msgNo);
                        $chk.prop('checked', !$chk.is(':checked'));
                    }
                },
                error: function () {
                    $chk.prop('checked', !$chk.is(':checked'));
                }
            });
        }
        catch (e) {
            console.log('UpdateShow: ' + e.message);
        }
    };



    return {
        Init: Init,
        InitEvents: InitEvents
    };
})();
