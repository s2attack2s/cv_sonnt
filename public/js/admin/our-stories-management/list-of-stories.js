/**
 * ****************************************************************************
 * list-of-stories.js
 *
 * Description		:	Methods and events for list of stories
 * Created at		:	2021/06/03
 * Created by		:	Trung
 * package		    :	Admin
 * ****************************************************************************
 */
$(document).ready(function() {
    ListOfOurStoriesModule.Init();
    ListOfOurStoriesModule.InitEvents();
});

/**
 * Module contains handling for list of stories
 * Author       :   QuyPN - 2021/06/03 - create
 * Param        :
 * Output       :   ListOfOurStoriesModule.Init() - Initialize values
 * Output       :   ListOfOurStoriesModule.InitEvents() - Initiating events
 */
var ListOfOurStoriesModule = (function() {
    /**
     * Objects associated with items on the screen
     */
    var _obj = {
        'search': { 'type': 'text', 'attr': { 'maxlength': 100 } },
        'current_page': { 'type': 'text', 'attr': {} },
        'per_page': { 'type': 'text', 'attr': {} }
    };

    /**
     * Initialize system values
     *
     * Author : Trung - 2021/06/03 - create
     * Params :
     * Return :
     * Access : public
     */
    var Init = function() {
        try {
            AdminCommonModule.InitPage();
            Common.InitItem(_obj);
            $("#search").focus();
        } catch (e) {
            console.log('Init: ' + e.message);
        }
    };

    /**
     * Initiating events in the page
     *
     * Author : Trung - 2021/06/03 - create
     * Params :
     * Return :
     * Access : public
     */
    var InitEvents = function() {
        try {
            // Event click button search
            $('#btn-search').on('click', function() {
                if (CONSTANTS.RESET_PAGE) {
                    $('#current_page').val(1);
                }
                Search();
            });
            $(document).on('change', '.check-show', function() {
                UpdateShow($(this));
            });
        } catch (e) {
            console.log('Init: ' + e.message);
        }
    };

    /**
     * Search data follow search condition
     *
     * Author : Trung - 2021/06/03 - create
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
                    $('#div-table-slides').html(res);
                    AdminCommonModule.InitPage();
                    AdminCommonModule.InitCheckboxAndRadio();
                    Common.SetTabindex();
                    Common.ChangeUrl('ListOfOurStories', Common.GetLastOfUrl(url.listOfOurStories) + '?' + Common.Serialize(data));
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
     * Show or hide stories
     *
     * Author : Trung - 2021/06/03 - create
     * Params : $chk - checkbox has changed state
     * Return :
     * Access : public
     */
    var UpdateShow = function($chk) {
        try {
            $.ajax({
                type: 'POST',
                url: url.updateStatus,
                global: false,
                data: {
                    id: $chk.attr('id-stories'),
                    status: $chk.is(':checked')
                },
                success: function(res) {
                    if (res.code !== 200) {
                        Notification.Alert(res.msgNo);
                        $chk.prop('checked', !$chk.is(':checked'));
                    }
                },
                error: function() {
                    $chk.prop('checked', !$chk.is(':checked'));
                }
            });
        } catch (e) {
            console.log('UpdateShow: ' + e.message);
        }
    };


    return {
        Init: Init,
        InitEvents: InitEvents
    };
})();