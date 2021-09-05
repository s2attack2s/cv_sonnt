/**
 * ****************************************************************************
 * list-of- contact.js
 *
 * Description		:	Methods and events for list of  contact
 * Created at		:	2021/05/28
 * Created by		:	TriTD
 * package		    :	Admin
 * ****************************************************************************
 */
$(document).ready(function () {
    ListOfContactsModule.Init();
    ListOfContactsModule.InitEvents();
});

/**
 * Module contains handling for list of  contact
 * Author       :  TriTD - create
 * Param        :
 * Output       :   ListOfContactsModule.Init() - Initialize values
 * Output       :   ListOfContactsModule.InitEvents() - Initiating events
 */
var ListOfContactsModule = (function () {
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
     * Author :TriTD - create
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
     * Author :  TriTD - create
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
            $(document).on('change', '.check-show', function () {

                UpdateStatus($(this));
            });
        }
        catch (e) {
            console.log('Init: ' + e.message);
        }
    };

    /**
     * Search data follow search condition
     *
     * Author : TriTD - create
     * Params :
     * Return :
     * Access : public
     */
    var Search = function () {
        try {
            var data = Common.GetData(_obj);
            data['status'] = $('#status').val();
            $.ajax({
                type: 'GET',
                url: $('#btn-search').attr('link-search'),
                data: data,
                success: function (res) {
                    $('#div-table-contact').html(res);
                    AdminCommonModule.InitPage();
                    AdminCommonModule.InitCheckboxAndRadio();
                    Common.SetTabindex();
                    Common.ChangeUrl('ListOfContacts', Common.GetLastOfUrl(url.listOfContacts) + '?' + Common.Serialize(data));
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
     * Author :TriTD - create
     * Params : $chk - checkbox has changed state
     * Return :
     * Access : public
     */
     var UpdateStatus = function ($chk) {
        try {
            $.ajax({
                type: 'POST',
                url: url.updateStatus,
                global: false,
                data: {
                    id: $chk.attr('id-contact'),
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
            console.log('Update Status: ' + e.message);
        }
    };

    return {
        Init: Init,
        InitEvents: InitEvents
    };
})();
