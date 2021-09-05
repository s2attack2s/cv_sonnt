/**
 * ****************************************************************************
 * list-of-challenges.js
 *
 * Description		:	Methods and events for list of challenges
 * Created at		:	2021/06/02
 * Created by		:	AnhHT <tienanhbk96@gmail.com>
 * package		    :	Admin
 * ****************************************************************************
 */
 $(document).ready(function () {
    ListOfChallengesModule.Init();
    ListOfChallengesModule.InitEvents();
});

/**
 * Module contains handling for list of challenges
 * Author       :   AnhHT - 2021/06/02 - create
 * Param        :
 * Output       :   ListOfChallengesModule.Init() - Initialize values
 * Output       :   ListOfChallengesModule.InitEvents() - Initiating events
 */
var ListOfChallengesModule = (function () {
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
     * Author : AnhHT - 2021/06/02 - create
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
     * Author : AnhHT - 2021/06/02 - create
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

            $(document).on('change', '.select-status', function (e) {
                UpdateStatus($(this));
            });

            $(document).on('click', '.btn-delete-challenges', function () {
                DeleteRowsChallenges([$(this).attr('id-del')], $(this));
            });

            $(document).on('click', '.btn-delete-selected-challenges', function () {
                var ids = [];
                $(this).closest('.table-result').find('td .check-item.check-delete:checked').each(function () {
                    ids.push($(this).attr('id-del'));
                });
                DeleteRowsChallenges(ids, $(this));
            });
        }
        catch (e) {
            console.log('Init: ' + e.message);
        }
    };

    /**
     * Search data follow search condition
     *
     * Author : AnhHT - 2021/06/02 - create
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
                    Common.ChangeUrl('ListOfChallenges', Common.GetLastOfUrl(url.listOfChallenges) + '?' + Common.Serialize(data));
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
     * Delete status of challenges form
     *
     * Author : AnhHT - 2021/06/25 - create
     * Params :
     * Return :
     * Access : public
     */
    var DeleteRowsChallenges = function (ids, $button) {
        try {
            if (ids.length === 0) {
                Notification.Alert(MSG_NO.SELECT_AT_LEAST_1_LINE);
                return;
            }
            var linkDel = $button.closest('.table-result').attr('link-del');
            Notification.Alert(MSG_NO.CONFIRM_DELETE_DATA, function (ok) {
                if (ok) {
                    $.ajax({
                        type: 'POST',
                        url: linkDel,
                        dataType: 'json',
                        data: {
                            ids: ids
                        },
                        success: function (res) {
                            if (res.code === 200) {
                                Notification.Alert(MSG_NO.DELETE_DATA_SUCCESS, function (ok) {
                                    if (ok) {
                                        if ($button.hasClass('btn-delete')) {
                                            $button.closest('tr').remove();
                                        }
                                        if ($button.hasClass('btn-delete-selected')) {
                                            $button.closest('table tbody').find('td.check-item.check-delete').closest('tr').remove();
                                        }
                                        CONSTANTS.RESET_PAGE = false;
                                        $('#btn-search').trigger('click');
                                        CONSTANTS.RESET_PAGE = true;
                                        $('#countNew').html(res.data);
                                    }
                                });
                            } else {
                                Notification.Alert(res.msgNo, function (ok) { });
                            }
                        }
                    });
                }
            });
        }
        catch (e) {
            console.log('DeleteRows: ' + e.message);
        }
    };

    /**
     * Update status of challenges form
     *
     * Author : AnhHT - 2021/06/02 - create
     * Params : 
     * Return :
     * Access : public
     */
     var UpdateStatus = function($chk) {
        try {
            $.ajax({
                type: 'POST',
                url: url.updateStatusOfChallenges,
                data: {
                    id: $chk.children("option").filter(":selected").attr('id-challenge'),
                    status: $chk.children("option").filter(":selected").val()
                },
                success: function (res) {
                    if (res.code === 200) {
                        Notification.Alert(MSG_NO.SAVE_DATA_SUCCESS, function(ok) {
                            $('#countNew').html(res.data);
                        });
                    }
                },
                error: function () {
                    Notification.Alert(MSG_NO.SERVER_ERROR, function (ok) {
                    });
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
