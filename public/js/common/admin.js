/**
 * ****************************************************************************
 * QUYPN COMMON CODE
 * ADMIN.JS
 *
 * description		:	Các phương thức và sự kiện chung trên trang Admin
 * created at		:	2018/08/29
 * created by		:	QuyPN – quypn09@gmail.com
 * package		    :	COMMON
 * copyright	    :	Copyright (c) QUYPN
 * version		    :	1.0.0
 * ****************************************************************************
 */

/** Các hằng số chưng sử dụng trên trang Admin */
const ADMIN_CONSTANTS = {
    /** Dung lượng tối đa của file ảnh tải lên */
    MAX_SIZE_FILE_IMAGE: 10,
    /** Dung lượng tối đa của file bình thường tải lên */
    MAX_SIZE_FILE: 10,
    /** Có đưa trang hiện tại về trang đầu tiên (trang 1) khi tìm kiếm hay không */
    RESET_PAGE: true,
    /** Link server của Wiris dùng để render công thức toán học */
    MATHTYPE_LINK: '',
    /** Link đến sever của CkFinder dùng để quản lý file*/
    CKFINDER_LINK: ''
};

/*********************************/
/**     Module Admin Common      */
/*********************************/

/**
 * Module chứa các xử lý chung trên trang admin
 *
 * Author:   QuyPN - 2018/07/07 - create
 *
 * Output:   AdminCommonModule.Init() - Khởi tạo các item và giá trị trên trang admin
 * Output:   AdminCommonModule.InitEvents() - Khởi tạo các sự kiện xử lý chung trên trang Admin
 * Output:   AdminCommonModule.InitCheckboxAndRadio() - Định dạng lại checkbox và radiobox của hệ thống
 * Output:   AdminCommonModule.SetTwoScroll() - Tạo thêm 1 scroll phía trên của table nếu table có scroll ngang để tiện thao tác
 * Output:   AdminCommonModule.OpenPopupColorbox(href, callback) - Mở popup hiển thị 1 trang nào đó trên trang chính
 * Output:   AdminCommonModule.InitPage() - Render danh sách các trang dùng để phân trang ở trang danh sách
 * Output:   AdminCommonModule.ValidateFileImgs() - Kiểm tra lại toàn bộ lỗi của một tất cả file ảnh trên màn hình trước khi upload
 * Output:   AdminCommonModule.ValidateFileImg() - Kiểm tra lại toàn bộ lỗi của một file ảnh trước khi upload
 */

var AdminCommonModule = (function () {
    /** Các đối tuowngj HTML thường sử dụng trên trang Admin */
    const LAYOUT_CONTROL = {
        /** Body của website */
        $BODY: $('body'),
        /** Button ẩn. hiện menu */
        $MENU_TOGGLE: $('#menu_toggle'),
        /** Vùng Menu bên trái của giao diện */
        $SIDEBAR_MENU: $('#sidebar-menu'),
        /** Vùng Footer của giao diện */
        $SIDEBAR_FOOTER: $('.sidebar-footer'),
        /** Cột bên trái của giao diện */
        $LEFT_COL: $('.left_col'),
        /** Cột bên phải của giao diện */
        $RIGHT_COL: $('.right_col'),
        /** Menu phía bên trái của giao diện */
        $NAV_MENU: $('.nav_menu'),
        /** Footer của giao diện */
        $FOOTER: $('footer')
    };
    /** Đường dẫn hiện tại của hệ thống */
    var CURRENT_URL = window.location.href.split('#')[0].split('?')[0];

    /**
     * Các lỗi liên quan đến upload image hiện tại
     * @type {string[]}
     */
    var ErrorFileImg = [];

    /**
     * Khởi tạo các item và giá trị trên trang admin
     *
     * Author : QuyPN - 2018/07/07 - create
     */
    var Init = function () {
        try {
            //$SIDEBAR_MENU.find('a[href="' + CURRENT_URL + '"]').parent('li').addClass('current-page');
            // Active menu của màn hình hiện tại trên menu
            LAYOUT_CONTROL.$SIDEBAR_MENU.find('a').filter(function () {
                return this.href === CURRENT_URL;
            }).parent('li').addClass('current-page').parents('ul').slideDown().parent().addClass('active');
            // Nếu có thể điều chỉnh của menu trái khi menu trái ở chế đọ fixed thì điều chỉnh
            if ($.fn.mCustomScrollbar) {
                $('.menu_fixed').mCustomScrollbar({
                    autoHideScrollbar: true,
                    theme: 'minimal',
                    mouseWheel: { preventDefault: true }
                });
            }
            // Thực hiện các công việc cần thiết
            SetContentHeight();
            InitUploadImg();
            InitCheckboxAndRadio();
            SetTwoScroll();
            // Nếu có Tooltip thì khởi tạo Tooltip
            if ($('[data-toggle="tooltip"]').length > 0) {
                $('[data-toggle="tooltip"]').tooltip({
                    container: 'body'
                });
            }
            // Nếu có Progressbar thì khởi tạo Progressbar
            if ($(".progress .progress-bar").length > 0) {
                $('.progress .progress-bar').progressbar();
            }
            // Nếu có Switchery thì khởi tạo Switchery
            if ($(".js-switch").length > 0) {
                var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
                elems.forEach(function (html) {
                    var switchery = new Switchery(html, {
                        color: '#26B99A'
                    });
                });
            }
            // Nếu có iCheck thì khởi tạo iCheck
            if ($("input.flat").length > 0) {
                $('input.flat').iCheck({
                    checkboxClass: 'icheckbox_flat-green',
                    radioClass: 'iradio_flat-green'
                });
            }
            // Nếu có NProgress thì khởi tạo NProgress
            //if (typeof NProgress != 'undefined') {
            //    NProgress.start();
            //    $(window).on('load', function () {
            //        NProgress.done();
            //    });
            //}

            //Khóa các chức năng tương ứng với vai trò của tài khoản đăng nhập
            if ($('#GroupIdOfUser').length > 0 && $('#GroupIdOfUser').val() !== '1') {
                Common.DisableFunction();
            }
            RefreshToken();
            $('#btn-logout, .btn-logout').on('click', function () {
                $.ajax({
                    type: 'get',
                    url: $(this).attr('link'),
                    dataType: 'json',
                    data: {},
                    success: function (res) {
                        $.removeCookie("token");
                        $.removeCookie("expires");
                        window.location = '/admin/login';
                    },
                    error: function (res) {
                        window.location = '/admin/login';
                    }
                });
            });
        }
        catch (e) {
            console.log('Init: ' + e.message);
        }
    };

    var RefreshToken = function () {
        try {
            setInterval(function () {
                DoRefreshToken();
            }, 1000);
        }
        catch (e) {
            console.log('RefreshToken: ' + e.message);
        }
    }

    var REFRESHING_TOKEN = false;
    var DoRefreshToken = function () {
        try {
            var token = $.cookie('token');
            if (!StringModule.IsNullOrEmpty(token) && !REFRESHING_TOKEN) {
                var expiresFrom = new Date($.cookie('expires'));
                expiresFrom.setTime(expiresFrom.getTime() - (60 * 1000));
                var expiresTo = new Date($.cookie('expires'));
                var now = new Date();
                if (now >= expiresFrom && now <= expiresTo) {
                    REFRESHING_TOKEN = true;
                    $.ajax({
                        type: 'post',
                        url: '/admin/login/refresh-token',
                        dataType: 'json',
                        data: {},
                        global: false,
                        success: function (res) {
                            if (res.code === 200) {
                                $.cookie('token', res.data.token, { expires: 1, path: '/' });
                                var date = new Date();
                                date.setTime(date.getTime() + (NumberModule.ToNumber(res.data.expires) * 60 * 1000));
                                $.cookie('expires', date.toUTCString(), { expires: 1, path: '/' });
                            }
                            REFRESHING_TOKEN = false;
                        },
                        error: function () {
                            REFRESHING_TOKEN = false;
                        }
                    });
                }
            }
        }
        catch (e) {
            REFRESHING_TOKEN = false;
            console.log('DoRefreshToken: ' + e.message);
        }
    }

    /**
     * Khởi tạo các sự kiện xử lý chung trên trang Admin
     *
     * Author : QuyPN - 2018/07/07 - create
     */
    var InitEvents = function () {
        try {
            // Sự kiện khi click vào item ở menu bên trái
            LAYOUT_CONTROL.$SIDEBAR_MENU.find('a').on('click', function () {
                ClickMenu($(this));
            });
            // Sự kiện click ẩn hiện menu
            LAYOUT_CONTROL.$MENU_TOGGLE.on('click', function () {
                ToglgeMenu();
            });
            // Sự kiện khi thay đổi kích thước của sổ
            $(window).resize(function () {
                // Set lại kích thước cho phần nội dung chính
                SetContentHeight();
                try {
                    // Set lại kích thước cho popup search nếu có
                    $.colorbox.resize({
                        width: '90%',
                        height: '90%'
                    });
                }
                catch (e) {
                    console.log('colorbox.resize: ' + e.message);
                }
            });
            // Sự kiện click thu nhỏ phóng to 1 khối trên nội dung chính
            $('.collapse-link').on('click', function () {
                CollapsePanel($(this));
            });
            // Sự kiện xóa 1 khối trên nội dung chính
            $('.close-link').click(function () {
                $(this).closest('.x_panel').remove();
            });
            // Sự kiện click dấu cộng hoặc trừ để hiện hoặc ẩn chi tiết
            $('.expand').on('click', function () {
                AccordionEvent($(this));
            });
            // Sự kiện click nút đóng popup
            $('.btn-close-colorbox').on('click', function () {
                try {
                    parent.$.colorbox.close();
                }
                catch (e) {
                    console.log('colorbox.close: ' + e.message);
                }
            });
            // Sự kiện check hoặc bỏ check cho checkbox check vào toàn bộ các dòng trong cột
            $(document).on('change', 'table .check-all', function () {
                CheckAllCheckboxInColumn($(this));
            });
            // Sự kiện check hoặc bỏ check cho checkbox ở 1 hàng
            $(document).on('change', 'table .check-item', function () {
                ToglgeCheckboxCheckAll($(this));
            });
            // Sự kiện click nút xóa trên hàng
            $(document).on('click', '.btn-delete', function () {
                DeleteRows([$(this).attr('id-del')], $(this));
            });
            // Sự kiện click nút xóa các hàng được chọn
            $(document).on('click', '.btn-delete-selected', function () {
                var ids = [];
                // Lấy Id của đối tượng cần xóa ở các hàng được chọn
                $(this).closest('.table-result').find('td .check-item.check-delete:checked').each(function () {
                    ids.push($(this).attr('id-del'));
                });
                // Tiens hành xóa
                DeleteRows(ids, $(this));
            });
            // Sự kiện click chọn file ảnh upload
            $(document).on('click', '.fileImg', function () {
                // Xóa lỗi của phần hiển thị ảnh
                $('#' + $(this).attr('id-view')).RemoveError();
            });
            // Sự kiện khi chọn một hình ảnh upload
            $(document).on('change', '.fileImg', function (e) {
                CheckFileImg($(this), e);
            });
            // Sự kiện khi thay đổi số lượng item hiển thị trên 1 trang
            $(document).on('change', '#page-size', function () {
                // Tiến hành tìm kiếm lại với sự thay đổi có số lượng item trên 1 trang
                $('#per_page').val($(this).val());
                // nhưng vẫn giữ nguyên trang hiện tại
                CONSTANTS.RESET_PAGE = false;
                $('#btn-search').trigger('click');
                CONSTANTS.RESET_PAGE = true;
            });
            $('#btn-no-trans').on('click', function () {
                $('#btn-trans').removeClass('hidden');
                $('.col-main-lang').removeClass('col-sm-6');
                $('.col-trans').addClass('hidden');
                $(this).addClass('hidden');
                $('#trans-status').val(0);
            });
            $('#btn-trans').on('click', function () {
                $('.col-trans').removeClass('hidden');
                $('#btn-no-trans').removeClass('hidden');
                $('.col-main-lang').addClass('col-sm-6');
                $(this).addClass('hidden');
                $('#trans-status').val(1);
            });
        } catch (e) {
            console.log('InitEvents: ' + e.message);
        }
    };

    /**
     * Ẩn hiện nội dung chi tiết bên dưới
     *
     * Author : QuyPN - 2018/07/07 - create
     * @param {object} $item Đối tượng HTML được click để xem hoặc ẩn chi tiết
     */
    var AccordionEvent = function ($item) {
        try {
            $item.next().slideToggle(200);
            $expand = $item.find(">:first-child");
            if ($expand.text() === "+") {
                $expand.text("-");
            } else {
                $expand.text("+");
            }
        } catch (e) {
            console.log('AccordionEvent:' + e.message);
        }
    };

    /**
     * Thay đổi chiều cao của phần nội dung bên phải (phần nội dung chính của giao diện)
     *
     * Author : QuyPN - 2018/07/07 - create
     */
    var SetContentHeight = function () {
        try {
            // reset lại chiều cao
            LAYOUT_CONTROL.$RIGHT_COL.css('min-height', $(window).height());
            // Lấy giá trị các chiều cao của các đối tượng cần thiết
            var bodyHeight = LAYOUT_CONTROL.$BODY.outerHeight();
            var footerHeight = LAYOUT_CONTROL.$FOOTER.height();
            var leftColHeight = LAYOUT_CONTROL.$LEFT_COL.first().height() + LAYOUT_CONTROL.$SIDEBAR_FOOTER.height();
            // Tính lại chiều cao phần nội dung
            var contentHeight = bodyHeight < leftColHeight ? leftColHeight : bodyHeight;
            contentHeight -= LAYOUT_CONTROL.$NAV_MENU.height() + footerHeight + 30;
            // Đặt lại chiều cao mới
            LAYOUT_CONTROL.$RIGHT_COL.css('min-height', contentHeight);
        } catch (e) {
            console.log('SetContentHeight:' + e.message);
        }
    };

    /**
     * Ẩn hiện menu bên trái giao diện
     *
     * Author : QuyPN - 2018/07/07 - create
     */
    var ToglgeMenu = function () {
        try {
            // Nếu đang mở rộng thì thu nhỏ lại
            if (LAYOUT_CONTROL.$BODY.hasClass('nav-md')) {
                LAYOUT_CONTROL.$SIDEBAR_MENU.find('li.active ul').hide();
                LAYOUT_CONTROL.$SIDEBAR_MENU.find('li.active').addClass('active-sm').removeClass('active');
            }
            // Nếu đang thu nhỏ thì mở rộng ra
            else {
                LAYOUT_CONTROL.$SIDEBAR_MENU.find('li.active-sm ul').show();
                LAYOUT_CONTROL.$SIDEBAR_MENU.find('li.active-sm').addClass('active').removeClass('active-sm');
            }
            LAYOUT_CONTROL.$BODY.toggleClass('nav-md nav-sm');
            SetContentHeight();
            $('.dataTable').each(function () { $(this).dataTable().fnDraw(); });
        } catch (e) {
            console.log('ToglgeMenu: ' + e.message);
        }
    };

    /**
     * Xử lý điều hướng hoặc hiển thị menu con khi click vào 1 item ở menu
     *
     * Author : QuyPN - 2018/07/07 - create
     * @param {object} $menu Đối tượng THML của item menu được click
     */
    var ClickMenu = function ($menu) {
        try {
            var $li = $menu.parent();
            // Nếu menu đang mở menu con thì đóng menu con lại
            if ($li.is('.active')) {
                $li.removeClass('active active-sm');
                $('ul:first', $li).slideUp(function () {
                    SetContentHeight();
                });
            }
            // Nếu đang không mở menu con
            else {
                // Thì nếu có menu con khác đang mở thì đóng lại
                if (!$li.parent().is('.child_menu')) {
                    LAYOUT_CONTROL.$SIDEBAR_MENU.find('li').removeClass('active active-sm');
                    LAYOUT_CONTROL.$SIDEBAR_MENU.find('li ul').slideUp();
                }
                // Mở menu con của menu được click
                $li.addClass('active');
                $('ul:first', $li).slideDown(function () {
                    SetContentHeight();
                });
            }
            // Nếu có link điều hướng thì sau khi thoát khỏi hàm sẽ tự động diều hướng
        } catch (e) {
            console.log('ClickMenu: ' + e.message);
        }
    };

    /**
     * Ẩn hoặc hiện nội dung 1 panel
     *
     * Author : QuyPN - 2018/07/07 - create
     * @param {object} $btn Đối tượng HTML của button ẩn hiện được click
     */
    var CollapsePanel = function ($btn) {
        try {
            /** Panel của button được click */
            var $BOX_PANEL = $btn.closest('.x_panel');
            /** Icon của button được click */
            var $ICON = $btn.find('i');
            /** Nội dung của panel có button được click */
            var $BOX_CONTENT = $BOX_PANEL.find('.x_content');
            // Nếu đan ghiện nội dung thì ẩn đi
            if ($BOX_PANEL.attr('style')) {
                $BOX_CONTENT.slideToggle(200, function () {
                    $BOX_PANEL.removeAttr('style');
                });
            }
            // Nếu đang ẩn nội dung thì hiện ra
            else {
                $BOX_CONTENT.slideToggle(200);
                $BOX_PANEL.css('height', 'auto');
            }
            // Đổi icon của button cho phù hợp
            $ICON.toggleClass('fa-chevron-up fa-chevron-down');
        } catch (e) {
            console.log('CollapsePanel: ' + e.message);
        }
    };

    /**
     * Định dạng lại checkbox và radiobox của hệ thống
     *
     * Author : QuyPN - 2018/07/07 - create
     *
     * Cấu trúc để sử dụng common
     <div class="custom-checkbox">
        <input type="checkbox" id="..." class="...">
     </div>
     Hoặc
     <div class="custom-checkbox is-radio">
        <input type="radio" id="..." class="...">
     </div>
     */
    var InitCheckboxAndRadio = function () {
        try {
            // Duyệt qua tất cả checkbox hoặc radiobox cần định dạng
            $('.custom-checkbox').each(function () {
                $_this = $(this);
                // Nếu đã định dạng lại thì bỏ qua
                if (!$_this.hasClass('had-render')) {
                    // Nếu không thì thêm các thành phần class và đối tượng để định dạng lại
                    var html = '<div class="show-check"><i class="fa fa-check" aria-hidden="true"></i></div>';
                    if ($_this.hasClass('is-radio')) {
                        html = '<div class="show-check"><i class="fa fa-circle" aria-hidden="true"></i></div>';
                    }
                    $_this.append(html);
                    // Đánh dấu là item đã định dạng lại
                    $_this.addClass('had-render');
                }
            });
        }
        catch (e) {
            console.log('InitCheckboxAndRadio: ' + e.message);
        }
    };

    /**
     * Chọn hoặc bỏ chọn tất cả các checkbox trong 1 cột khi chọn hoặc bỏ chọn checkbox check all của cột đó
     *
     * Author : QuyPN - 2018/07/07 - create
     *
     * Cấu trức để sử dụng common
     <table class="">
        <thead>
            <tr>
                <th class="">
                    <div class="custom-checkbox">
                        <input type="checkbox" id="..." class="check-all" column="...">
                    </div>
                </th>
                {Các cột dữ liệu khác}
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="">
                    <div class="custom-checkbox">
                        <input type="checkbox" class="check-item" column="...">
                    </div>
                </td>
                {Các cột dữ liệu khác}
            </tr>
        </tbody>
     </table>
     * @param {object} $checkbox Đối tượng HTML của check box được chọn hoặc bỏ chọn
     */
    var CheckAllCheckboxInColumn = function ($checkbox) {
        try {
            // Lấy column cần tương tác checkbox
            var column = $checkbox.attr('col_idx');
            if (column === undefined || column === null) {
                column = '';
            }
            else {
                column = '[col_idx="' + column + '"]';
            }
            // Thực hiện chọn hay bỏ chọn theo checkbox check all
            $('table .check-item' + column).prop('checked', $checkbox.is(':checked'));
        } catch (e) {
            console.log('CheckAllCheckboxInColumn: ' + e.message);
        }
    };

    /**
     * Chọn hoặc bỏ chọn checkbox check all của một cột theo hành động chọn hoặc bỏ chọn 1 checkbox thành phần
     *
     * Author : QuyPN - 2018/07/07 - create
     *
     * Cấu trức để sử dụng common
     <table class="">
        <thead>
            <tr>
                <th class="">
                    <div class="custom-checkbox">
                        <input type="checkbox" id="..." class="check-all" column="...">
                    </div>
                </th>
                {Các cột dữ liệu khác}
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="">
                    <div class="custom-checkbox">
                        <input type="checkbox" class="check-item" column="...">
                    </div>
                </td>
                {Các cột dữ liệu khác}
            </tr>
        </tbody>
     </table>
     * @param {object} $checkbox Đối tượng HTML của checkbox được chọn hoặc bỏ chọn
     */
    var ToglgeCheckboxCheckAll = function ($checkbox) {
        try {
            // Lấy lại cột của checkbox đó
            var column = $checkbox.attr('col_idx');
            if (column === undefined || column === null) {
                column = '';
            } else {
                column = '[col_idx="' + column + '"]';
            }
            // Nếu tất cả các item trong cột điều được chọn thì check vào checkbox check all
            // Nếu tồn tại 1 item không được chọn thì bỏ chọn checkbox chec kall
            $('table .check-all' + column).prop('checked', $('table .check-item' + column).length === $('table .check-item' + column + ':checked').length);
        } catch (e) {
            console.log('ToglgeCheckboxCheckAll: ' + e.message);
        }
    };

    /**
     * Xóa dữ liệu ở nhiều hàng một lúc
     *
     * Author : QuyPN - 2018/07/07 - create
     *
     * Cấu trức để sử dụng common
     <div class="table-result" id="table-result" link-del="{link đến action xóa dữ liệu}">
        <div class="table-responsive">
            <table class="table table-striped table-bordered jambo_table">
                <thead>
                    <tr>
                        <th class="text-center col-checkbox max-50">
                            <div class="custom-checkbox">
                                <input type="checkbox" id="check-all" class="check-all">
                            </div>
                        </th>
                        {Các cột dữ liệu khác}
                        <th class="text-center max-50">Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center middle col-checkbox max-50">
                            <div class="custom-checkbox">
                                <input type="checkbox" class="check-item check-delete" name="check-remove" id-del="{Id cần xóa}">
                            </div>
                        </td>
                        {Các cột dữ liệu khác}
                        <td class="text-center middle max-50">
                            <button type="button" class="btn btn-xs btn-danger btn-delete" id-del="{Id cần xóa}">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
     </div>
     * @param {string[]|number[]} ids Mãng chưa Id các đối tượng cần xóa lấy được ở các hàng được chọn
     * @param {object} $button Đối tượng HTML của nút xóa dduowwcj click
     */
    var DeleteRows = function (ids, $button) {
        try {
            if (ids.length === 0) {
                // Nếu ko có dữ liệu để xóa thì báo lỗi
                Notification.Alert(MSG_NO.SELECT_AT_LEAST_1_LINE);
                return;
            }
            // Lấy link serve để xóa
            var linkDel = $button.closest('.table-result').attr('link-del');
            // Hiển thị confirrm
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
                            // Nếu xóa thành công
                            if (res.code === 200) {
                                // Hiển thị thông báo
                                Notification.Alert(MSG_NO.DELETE_DATA_SUCCESS, function (ok) {
                                    if (ok) {
                                        // Xóa dòng chứa button xóa đã click trên giao diện nếu click xóa trên dòng
                                        if ($button.hasClass('btn-delete')) {
                                            $button.closest('tr').remove();
                                        }
                                        // Xóa các dòng đã chọn trong bảng trên giao diện nếu click xóa nhiều dòng 1 lúc
                                        if ($button.hasClass('btn-delete-selected')) {
                                            $button.closest('table tbody').find('td.check-item.check-delete').closest('tr').remove();
                                        }
                                        // Load lại table mà không thay đổi trang hiện tại
                                        CONSTANTS.RESET_PAGE = false;
                                        $('#btn-search').trigger('click');
                                        CONSTANTS.RESET_PAGE = true;
                                    }
                                });
                            } else {
                                // Nếu lỗi thì hiển thị thông báo lỗi
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
     * Khởi tạo cho bộ item upload hình ảnh lên server
     *
     * Author : QuyPN - 2018/07/07 - create
     *
     * Cấu trúc để sử dụng common (trong dấu ngoặc nhọn là có thể thay đổi được)
     <div class="form-group div-upload-img">
        <label for="{FileImage}">Hình ảnh minh họa (700 x 450px)</label>
        <div class="div-review-img">
            <img class="img-preview" src="{...}"/>
            <input type="hidden" min-of-width="{700}" min-rate="{1.50}" max-rate="{1.56}">
        </div>
        <div class="input-group">
            <input class="form-control filename" name="{Image}" id="{Image}" {readonly="readonly" value="..."} />
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary">
                    <i class="fa fa-upload" aria-hidden="true"></i>
                </button>
                <input type="file" class="file" name="{FileImage}" id="{FileImage}" />
            </span>
        </div>
     </div>
     */
    var InitUploadImg = function () {
        try {
            var index = 0;
            // Reset lỗi của các file ảnh
            ErrorFileImg = [];
            // Duyệt qua từng bộ item upload hình ảnh
            $('.div-upload-img').each(function () {
                var $_this = $(this);
                var $inputView = $_this.find('.filename').first();
                $inputView.addClass('imgPreview' + index);
                // Khởi tạo phần xem trước hình ảnh
                $_this.find('.img-preview').attr('id', 'imgPreview' + index);
                // Khởi tạo phần kiểm tra kích thước ảnh
                if ($_this.find('.img-size').length > 0) {
                    $_this.find('.img-size').attr('id', 'imgSize' + index);
                    $_this.find('.img-size').attr('id-view', $inputView.attr('id'));
                }
                // Khởi tạo phần chọn file upload ảnh
                if ($_this.find('.fileImg').length > 0) {
                    $_this.find('.fileImg').attr('err-idx', index);
                    $_this.find('.fileImg').attr('id-view', $inputView.attr('id'));
                    if ($_this.find('.fileImg').attr('accept') !== '.ico') {
                        $_this.find('.fileImg').attr('accept', '.jpg,.png,.jpeg');
                    }
                }
                // Khởi tạo nơi chứa lỗi phát sinh của ảnh
                ErrorFileImg.push(0);
                index++;
            });
        } catch (e) {
            console.log('InitUploadImg: ' + e.message);
        }
    };

    /**
     * Kiểm tra ảnh được chọn có phù hợp với yêu cầu đã cài đặt không
     *
     * Author : QuyPN - 2018/07/07 - create
     * @param {object} $btn Đối tượng HTML của thẻ chọn file ảnh
     * @param {object} e Sự kiện chọn file ảnh trên windows
     */
    var CheckFileImg = function ($btn, e) {
        try {
            /** Vị trí của bộ upload ảnh */
            var idx = $btn.attr('err-idx');
            /** Input hiển thị tên/đường dẫn của file ảnh */
            var $viewFilename = $('#' + $btn.attr('id-view'));
            /** Item xem trước ảnh */
            var $preview = $('#imgPreview' + idx);
            /** Các loại tệp cho hép tải */
            var typeFiles = $btn.attr('accept').split(',');
            /** File đã chọn */
            var files = e.target.files || e.dataTransfer.files;
            // Kiểm tra lỗi bắt buộc chọn file
            if (!files.length) {
                // Nếu không có file thì cho các giá trị về rỗng
                $viewFilename.val('');
                $preview.attr('src', '');
                // Nếu bắt buộc nhập thì hiển thị và lưu lại lỗi bắt buộc nhập
                if ($viewFilename.hasClass('required')) {
                    $viewFilename.ItemError(_msg[MSG_NO.YOU_MUST_CHOOSE_FILE].content);
                    ErrorFileImg[idx] = MSG_NO.YOU_MUST_CHOOSE_FILE;
                }
                return;
            }
            /** Đuôi tệp của file được chọn */
            var extension = ('.' + files[0].name.split('.').pop()).toLowerCase();
            // Nếu không nằm trong các loại tệp cho phép
            if (typeFiles.indexOf(extension) === -1) {
                // Thì báo lỗi
                ErrorFileImg[idx] = MSG_NO.EXTENSION_NOT_ALLOW;
                $viewFilename.ItemError(_msg[MSG_NO.EXTENSION_NOT_ALLOW].content);
                $viewFilename.val(files[0].name);
                $preview.attr('src', '');
                return;
            }
            // Nếu vượt quá dung luwongj cho phép thì báo lỗi
            if (files[0].size / 1024 / 1024 > ADMIN_CONSTANTS.MAX_SIZE_FILE_IMAGE) {
                ErrorFileImg[idx] = MSG_NO.FILE_SIZE_TOO_LARGER;
                $viewFilename.ItemError(msg[MSG_NO.FILE_SIZE_TOO_LARGER].content);
            }
            // Nếu file ảnh ok thì tiến hành đọc file ảnh ra để kiểm tra tiếp về kích thước và cho xem trước ảnh
            else {
                ErrorFileImg[idx] = 0;
                ReadImage(files[0], 'imgSize' + idx, 'imgPreview' + idx);
            }
            $viewFilename.val(files[0].name);
        } catch (e) {
            console.log('CheckFile: ' + e.message);
        }
    };

    /**
     * Đọc file để kiểm tra kích thước và cho hiển thị lên item xem truowcs ảnh nếu cần thiết
     *
     * Author : QuyPN - 2018/07/07 - create
     * @param {object} file File ảnh được chọn
     * @param {string} width_height Class của item quy định kích thước ảnh
     * @param {string} idImage Class của item xem trước ảnh
     * @param {boolean} [previewImg=true] Có cho xem trước hay không
     */
    var ReadImage = function (file, width_height, idImage, previewImg) {
        try {
            if (StringModule.IsNullOrEmpty(previewImg)) {
                previewImg = true;
            }
            // Tiến hành load file ra
            window.URL = window.URL || window.webkitURL;
            var useBlob = false && window.URL;
            var reader = new FileReader();
            reader.addEventListener("load", function () {
                var image = new Image();
                // Đọc dữ liệu hình ảnh từ file
                image.addEventListener("load", function () {
                    // Lưu lại kích thước của ảnh đã chọn
                    if (width_height !== '') {
                        $('#' + width_height).attr('data-width', image.width);
                        $('#' + width_height).attr('data-height', image.height);
                    }
                    // Nếu cho xem trước thì hiển thị ảnh lên item xem trước
                    if (previewImg) {
                        $('#' + idImage).attr('src', image.src);
                    } else {
                        $('#' + idImage).attr('src', '');
                    }
                    if (useBlob) {
                        // Giải phóng bộ nhớ sau khi hoàn tất
                        window.URL.revokeObjectURL(image.src);
                    }
                });
                // Đọc file vào hình ảnh
                image.src = useBlob ? window.URL.createObjectURL(file) : reader.result;
            });
            reader.readAsDataURL(file);
        } catch (e) {
            console.log('ReadImage: ' + e.message);
        }
    };

    /**
     * Kiểm tra kích thước chiều dài và rộng của ảnh có đúng yêu cầu hay không
     *
     * Author : QuyPN - 2018/07/07 - create
     * @param {number} idx Vị trí của bộ upload ảnh có ảnh cần kiểm tra
     * @return {boolean}
     * true: Nếu không có dữ liệu quy định kiểm tra kích thước hoặc kích thước đúng yêu cầu
     * false: Nếu kích thước không đúng yêu cầu
     */
    var CheckRateImg = function (idx) {
        try {
            // Xóa lỗi kích thước ảnh của file ảnh này
            if (ErrorFileImg[idx] === MSG_NO.SIZE_OF_IMG_RON) {
                ErrorFileImg[idx] = 0;
            }
            // Đọc các quy định về kích thước ảnh
            var $size = $('#imgSize' + idx);
            if ($size.length > 0) {
                var min_width = parseInt($size.attr('min-of-width'));
                var min_rate = parseFloat($size.attr('min-rate'));
                var max_rate = parseFloat($size.attr('max-rate'));
                // Nếu tồn tại thông tin về kích thước ảnh hiện tại
                if ($size.data('height') !== undefined && $size.data('width') !== undefined) {
                    // Đọc thông tin kích thước ra
                    var width = parseInt($size.attr('data-width'));
                    var height = parseInt($size.attr('data-height'));
                    var rate = parseFloat(width / height);
                    // Tiến hành kiểm tra và thông báo lỗi nếu có
                    if (!(width >= min_width && rate >= min_rate && rate <= max_rate)) {
                        $('#' + $size.attr('id-view')).ItemError(_msg[MSG_NO.SIZE_OF_IMG_RON].content);
                        ErrorFileImg[idx] = MSG_NO.SIZE_OF_IMG_RON;
                        return false;
                    }
                }
            }
            return true;
        }
        catch (e) {
            console.log('checkRateImg: ' + e.message);
            return false;
        }
    };

    /**
     * Kiểm tra lại toàn bộ lỗi của một file ảnh trước khi upload
     *
     * Author : QuyPN - 2018/07/07 - create
     * @param {number} idx Vị trí file ảnh muốn kiểm tra
     * @return {boolean}
     * true: Nếu không có lỗi nào của file ảnh
     * false: Nếu tồn tại ít nhất 1 lỗi của file ảnh
     */
    var ValidateFileImg = function (idx) {
        try {
            // Kiểm tra kích thước bức ảnh
            CheckRateImg(idx);
            // Xem lại đối tượng lưu lỗi của file này có tồn lại lỗi đã lưu không
            if (ErrorFileImg[idx] !== 0) {
                // Nếu có thì hiển thị lỗi lên
                $('.imgPreview' + index).ItemError(_msg[ErrorFileImg[idx]].content);
                return false;
            }
            $('#' + $('#imgSize' + idx).attr('id-view')).RemoveError();
            return true;
        }
        catch (e) {
            console.log('ValidateFile: ' + e.message);
            return false;
        }
    };

    /**
     * Kiểm tra lại toàn bộ lỗi của một tất cả file ảnh trên màn hình trước khi upload
     *
     * Author : QuyPN - 2018/07/07 - create
     * @return {boolean}
     * true: Nếu không có lỗi nào của tất cả các file ảnh
     * false: Nếu tồn tại ít nhất 1 lỗi của 1 file ảnh
     */
    var ValidateFileImgs = function () {
        try {
            var idx = 0;
            var validate = true;
            // Duyệt qua từng bộ upload ảnh
            $('.div-upload-img').each(function () {
                // Kiểm tra kích thước
                CheckRateImg(idx);
                // Kiểm tra có lỗi phát sinh được lưu lại hay không
                if (ErrorFileImg[idx] !== 0) {
                    $('#' + $('#imgSize' + idx).attr('id-view')).ItemError(_msg[ErrorFileImg[idx]].content);
                    validate = false;
                }
                else {
                    $('#' + $('#imgSize' + idx).attr('id-view')).RemoveError();
                }
                idx++;
            });
            return validate;
        }
        catch (e) {
            console.log('ValidateFile: ' + e.message);
            return false;
        }
    };

    /**
     * Tạo thêm 1 scroll phía trên của table nếu table có scroll ngang để tiện thao tác
     *
     * Author : QuyPN - 2018/07/07 - create
     *
     * Cấu trức để sử dụng common
     <div class="table-result" id="table-result">
        <div class="table-responsive">
            <table class="">
            </table>
        </div>
     </div>
     * @return {boolean}
     * true nếu tạo thành công hoặc đã có scroll thứ 2 trước đó
     * false nếu có lỗi sảy ra
     */
    var SetTwoScroll = function () {
        try {
            // Nếu có scroll ngang của table
            if ($('#table-result .table-responsive').width() < $('#table-result table').width()
                // Nếu đã tạo scroll thứ 2 phía bên trên rồi thì thôi
                && $('#table-result #double-scroll').length === 0) {
                // Nếu không thì thêm scroll thứ 2 vào phía trên
                $('#table-result').prepend('<div id="double-scroll"><div class="double-scroll-content"></div></div>');
                $('#table-result #double-scroll').css('width', $('#table-result .table-responsive').width());
                $('#table-result .double-scroll-content').css('width', $('#table-result table').width());
                // Khi kéo scroll chính thì cũng di chjuyeenr scroll phụ
                $('#table-result .table-responsive').on('scroll', MoveMainScroll);
                // Khi kéo scroll phụ thì cũng di chuyển scroll chính
                $('#table-result #double-scroll').on('scroll', function (e) {
                    e.preventDefault();
                    $('#table-result .table-responsive').scrollLeft($('#table-result #double-scroll').scrollLeft());
                    // Giữ nguyeenvij trí của các cột cố định
                    FixColumn(e);
                });
            }
            // Nếu table không có scroll ngang nữa thì xóa scroll phụ đi
            else {
                if ($('#table-result #double-scroll').length > 0) {
                    $('#table-result .table-responsive').off('scroll', MoveMainScroll);
                    $('#table-result #double-scroll').remove();
                }
            }
        }
        catch (e) {
            console.log('SetTwoScroll: ' + e.message);
            return true;
        }
        return true;
    };

    /**
     * Sự kiện di chuyển scroll phụ tương ứng khi di chuyển scroll chính.
     *
     * Author : QuyPN - 2018/07/07 - create
     * @param {object} e Sự kiện di chuyển cẩu scroll chính
     */
    var MoveMainScroll = function (e) {
        try {
            e.preventDefault();
            $('#table-result #double-scroll').scrollLeft($('#table-result .table-responsive').scrollLeft());
            FixColumn(e);
        } catch (e) {
            console.log('MoveMainScroll: ' + e.message);
        }
    };

    /**
     * Cố định cột được yêu cầu khi di chuyển scroll
     *
     * Author : QuyPN - 2018/07/07 - create
     *
     * Cấu trức để sử dụng common
     <table class="table table-striped table-bordered jambo_table fix-table">
        <thead>
            <tr>
                <th class="fix-column"></th>
                <th class="fix-column"></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="fix-column"></td>
                <td class="fix-column"></td>
            </tr>
        </tbody>
     </table>
     * @param {object} e Sự kiện di chuyển scroll
     */
    var FixColumn = function (e) {
        try {
            e.preventDefault();
            // Nếu màn hình lớn hơn 768px thì thực hiện cố định cột
            if ($(window).outerWidth() >= 768) {
                // Điều chỉnh lại ví trí các cột được cố định
                $('#table-result .fix-table tr .fix-column').css('left', $('#table-result .table-responsive').scrollLeft());
                $('#table-result .fix-table tr th.fix-column').css('background-color', '#354a5e');
            }
            // Nếu nhỏ hơn thì bỏ chức năng cố định cột
            else {
                $('#table-result .fix-table tr .fix-column').css('left', '');
                $('#table-result .fix-table tr th.fix-column').css('background-color', '');
            }
        } catch (e) {
            console.log('FixColumn: ' + e.message);
        }
    };

    /**
     * Mở popup hiển thị 1 trang nào đó trên trang chính
     *
     * Author : QuyPN - 2018/07/07 - create
     * @param {string} href Đường dẫn đến trang tìm kiếm
     * @param {Function} callback hàm sẽ thực hiện khi đóng popup
     */
    var OpenPopupColorbox = function (href, callback) {
        try {
            $.colorbox({
                href: href,
                iframe: true,
                closeButton: false,
                overlayClose: false,
                opacity: 0.6,
                width: '90%',
                height: '90%',
                onClosed: function () {
                    if (typeof callback === "function") {
                        callback();
                    }
                }
            });
        } catch (e) {
            console.log('OpenPopupSearch: ' + e.message);
        }
    };

    /**
     * Render danh sách các trang dùng để phân trang ở trang danh sách
     *
     * Author : QuyPN - 2018/07/07 - create
     */
    var InitPage = function () {
        try {
            if (parseInt($('#current_page').val()) > parseInt($('#total_pages').val())) {
                $('#current_page').val($('#total_pages').val());
            }
            $('.table-result .pagination').pagination({
                items: $('#total_pages').val(),
                itemOnPage: $('#per_page').val(),
                currentPage: $('#current_page').val(),
                /**
                 * Thực tiện tìm kiếm khi chọn 1 trang khác
                 * @param {number} page Trang được chọn
                 * @param {object} evt Sự kiện click
                 */
                onPageClick: function (page, evt) {
                    // Tìm kiếm theo trang mới mà không reset lại trang đầu
                    $('#current_page').val(page);
                    CONSTANTS.RESET_PAGE = false;
                    $('#btn-search').trigger('click');
                    CONSTANTS.RESET_PAGE = true;
                }
            });
            SetTwoScroll();
        }
        catch (e) {
            console.log('InitPage: ' + e.message);
        }
    };

    return {
        Init: Init,
        InitEvents: InitEvents,
        InitCheckboxAndRadio: InitCheckboxAndRadio,
        SetTwoScroll: SetTwoScroll,
        OpenPopupColorbox: OpenPopupColorbox,
        InitPage: InitPage,
        ValidateFileImgs: ValidateFileImgs,
        ValidateFileImg: ValidateFileImg
    };
})();

/**
 * Hàm callback sẽ thực hiện sau refer name của 1 item input
 *
 * @callback CallbackAfterRefer
 * @param {object} dataGeted Dữ liệu đã refer được
 */

/*********************************/
/**     Module Popup      */
/*********************************/

/**
 * Module chứa các xử lý liên quan đến popup search, suggest search và refer name
 *
 * Author:   QuyPN - 2018/07/07 - create
 *
 * Output:   AdminCommonModule.Init() - Khởi tạo các item và giá trị phục vụ popup search, suggest search và refer name
 * Output:   AdminCommonModule.InitEvents() - Khởi tạo các sự kiện phục vụ popup search, suggest search và refer name
 * Output:   AdminCommonModule.ReferNameOfKey($input, callback) - Refer name của 1 Id nào đó khi được nhập vào ô input có cài đặt refer name
 */
var PopupModule = (function () {
    /**
     * Khởi tạo các item và giá trị phục vụ popup search, suggest search và refer name
     *
     * Author : QuyPN - 2018/07/07 - create
     */
    var Init = function () {
        try {

        }
        catch (e) {
            console.log('Init: ' + e.message);
        }
    };

    /**
     * Khởi tạo các sự kiện phục vụ popup search, suggest search và refer name
     *
     * Author : QuyPN - 2018/07/07 - create
     */
    var InitEvents = function () {
        try {
            // Sự kiện click nút tìm kiếm trên input
            $(document).on('click', '.show-popup-search', function () {
                OpenPopupSearch($(this));
            });
            // Sự kiện chọn 1 dòng trên table kết quả của popup search
            $(document).on('click', '.set-data-back', function () {
                SetDataBack($(this));
            });
            // Sự kiện thay đổi nội dung nhập vào input có yêu cầu refer data
            $(document).on('change', '.input-refer-name', function (e) {
                ReferNameOfKey($(this));
            });
            // Sự kiện nhập vào 1 ô có suggest search
            $(document).on('keyup', '.input-suggest-search', function (e) {
                ShowSuggestSearch($(this));
            });
            // Sự kiện click ra khỏi suggest search
            $(document).mouseup(function (e) {
                CloseSuggestSearch(e);
            });
            // Sự kiện chọn 1 item trên suggest search
            $(document).on('click', '.panel-suggest-search .suggest-item', function () {
                SetDataFromSuggestSearch($(this));
            });
        } catch (e) {
            console.log('InitEvents: ' + e.message);
        }
    };

    /**
     * Mở popup search trên trang đang hiển thị, tìm kiếm giá trị cho input chứa button được click
     *
     * Author:   QuyPN - 2018/07/07 - create
     *
     * Cấu trúc để sử dụng common
     <div class="row control-search">
        <div class="col-xs-7 col-sm-5">
            <div class="input-group input-search">
                <input type="hidden" class="value-id" id="..." name=..." value="..." />
                <input class="form-control value-code input-main" id="..." name=..." link-search="list-of-high-schools" value="..." />
                <span class="input-group-btn">
                    <button type="button" class="btn btn-primary show-popup-search">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                </span>
            </div>
        </div>
        <div class="col-xs-5 col-sm-7 div-name-of-item-search">
            <span class="value-name">...</span>
        </div>
     </div>
     * @param {object} $btn Đối tượng HTML của button được click
     */
    var OpenPopupSearch = function ($btn) {
        try {
            /** Item tổng thể của input có popup search */
            var $parentAll = $btn.closest('.control-search');
            /** Input hiển thị dữ liệu chính */
            var $inputMain = $btn.closest('.input-search').find('.input-main');
            /** Lấy thành phần đường dẫn đến action tìm kiếm của popup */
            var linkSearch = $inputMain.attr('link-search');
            /** Đường dẫn đến action tìm kiếm có thêm query string */
            var linkSearchFull = linkSearch;
            /** Function dùng để lấy thêm key cần thiết khác để đặt default trên popup search */
            var getOtherKey = window[$inputMain.attr('get-other-key')];
            if (typeof getOtherKey === "function") {
                // Nếu có yêu cầu lấy thêm dữ lieuj khác thì tiến hành lấy dữ liệu
                var otherData = getOtherKey($inputMain);
                // Biến đổithành query string rồi gửi lên link
                linkSearchFull = linkSearch + '?' + Common.Serialize(otherData);
            }
            // Đánh dấu item nào đang được tìm kiếm
            $parentAll.addClass('searching-' + linkSearch);
            // Hiển thị popup tìm kiếm
            AdminCommonModule.OpenPopupColorbox('/common/popup-search/' + linkSearchFull);
        } catch (e) {
            console.log('OpenPopupSearch: ' + e.message);
        }
    };

    /**
     * Điền lại data đã chọn vào bộ popup search
     *
     * Author:   QuyPN - 2018/07/07 - create
     *
     * Cấu trúc để sử dụng common
     <table class="" link-search="list-of-high-schools">
        <thead>
            <tr>
                <th class=""></th>
                <th class=""></th>
            </tr>
        </thead>
        <tbody>
            <tr  value-id="..." value-code="..." value-name="..">
                <td class="set-data-back">...</td>
                <td class="set-data-back">...</td>
            </tr>
        </tbody>
    </table>
     * @param {object} $selected Đối tượng được chọn trên popup search
     */
    var SetDataBack = function ($selected) {
        try {
            /** Dòng của đối tượng được chọn */
            var $tr = $selected.closest('tr');
            /** Bảng chứa đối tượng được chọn */
            var $table = $selected.closest('table');
            /** Item đang sử dụng popup search */
            var $parentAll = parent.$('.control-search.searching-' + $table.attr('link-search'));
            // Set các giá trị từ popup search về lại cho bộ item search
            $parentAll.find('.value-id').val($tr.attr('value-id'));
            $parentAll.find('.value-code').val($tr.attr('value-code'));
            $parentAll.find('.value-name').text($tr.attr('value-name'));
            /** Item hiển thị chính nội dung ra màn hình */
            var $inputMain = $parentAll.find('.input-main');
            // Focus vào item hiển thị
            $inputMain.focus();
            // Báo cho item này biết đã được set name, không cần tiến hành refer name nữa
            $inputMain.attr('name-refered', 1);
            // Gọi sự kiện thay đổi gía trị item thể thực hiện các hành động khác tiếp theo nếu có
            $inputMain.trigger('change');
            // Bỏ đánh dấu item đang sử dụng popup search
            $parentAll.removeClass('searching-' + $table.attr('link-search'));
            // Đóng popup search
            parent.$.colorbox.close();
        } catch (e) {
            console.log('OpenPopupSearch: ' + e.message);
        }
    };

    /**
     * Refer name của 1 Id nào đó khi được nhập vào ô input có cài đặt refer name
     * để có thể nhìn trực quan hơn vè đối tượng được nhập vào
     *
     * Author:   QuyPN - 2018/07/07 - create
     *
     * Để sử dụng refer name thì thêm class input-refer-name vào
     <div class="row control-search">
        <div class="col-xs-7 col-sm-5">
            <div class="input-group input-search">
                <input type="hidden" class="value-id" id="..." name=..." value="..." />
                <input class="form-control value-code input-main input-suggest-search input-refer-name" id="..." name=..." link-search="list-of-high-schools" value="..." />
                <span class="input-group-btn">
                    <button type="button" class="btn btn-primary show-popup-search">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                </span>
            </div>
        </div>
        <div class="col-xs-5 col-sm-7 div-name-of-item-search">
            <span class="value-name">...</span>
        </div>
     </div>
     * @param {object} $input Ô input có Id nhập vào của đối tượng cần refer
     * @param {CallbackAfterRefer} callback Hoạt động sẽ thực hiện sau khi refer name xong
     */
    var ReferNameOfKey = function ($input, callback) {
        try {
            // Nếu tên của đối tượng đã được refer bằng cách này hay cách khác thì bỏ qua không refer name nữa
            if ($input.attr('name-refered') === '1') {
                $input.attr('name-refered', 0);
                return;
            }
            // Lấy lại bộ chứa dữ liệu refer
            var $parentAll = $input.closest('.control-search');
            // Link đến action refer dữ liệu
            var linkSearch = $input.attr('link-search');
            var dataGeted = {};
            var continueRefer = true;
            // Nếu nội dung nhập vào rỗng thì không tiến hành refer
            if ($input.val() === '') {
                continueRefer = false;
            }
            if (continueRefer) {
                // Set data để refer
                var data = {
                    Key: $input.val()
                };
                // Nếu cần lấy thêm các key khác để có thể refer đúng giá trị
                var getOtherKey = window[$input.attr('get-other-key')];
                if (typeof getOtherKey === "function") {
                    // Thì gọi hàm lấy các key khác đã được cài đặt và gán vào data refer
                    var otherData = getOtherKey($input);
                    for (var attrname in otherData) {
                        data[attrname] = otherData[attrname];
                    }
                }
                // Gọi action refer
                $.ajax({
                    type: 'POST',
                    url: '/common/refer-name/' + linkSearch,
                    data: data,
                    async: false,
                    success: function (res) {
                        if (res.Code === 200) {
                            dataGeted = res.Data;
                        }
                    },
                    error: function () {
                    }
                });
            }
            // Set các giá trị cơ bản vào bộ refer name
            // Nếu refer ra item không tồn tại thì sẽ set rỗng vào các giá trị
            $parentAll.find('.value-id').val(dataGeted.vaule_id ? dataGeted.vaule_id : '');
            $parentAll.find('.value-code').val(dataGeted.vaule_code ? dataGeted.vaule_code : '');
            $parentAll.find('.value-name').text(dataGeted.vaule_name ? dataGeted.vaule_name : '');
            if ($input.attr('for-search-condition') === '1' && StringModule.IsNullOrEmpty(dataGeted.vaule_id)) {
                // Đối mới item sử dụng cho màn hình tìm kiếm thì giữ lại giá trị đã nhập vào
                $input.val(data.Key);
            }
            // gọi callback
            if (typeof callback === "function") {
                callback(dataGeted);
            }
        } catch (e) {
            console.log('ReferNameOfKey: ' + e.message);
        }
    };

    /**
     * Hiển thị suggest seach cho 1 ô nhập liệu theo dữ liệu đang nhập
     *
     * Author:   QuyPN - 2018/07/07 - create
     *
     * Để sử dụng suggest search thì thêm class input-suggest-search vào
     <div class="row control-search">
        <div class="col-xs-7 col-sm-5">
            <div class="input-group input-search">
                <input type="hidden" class="value-id" id="..." name=..." value="..." />
                <input class="form-control value-code input-main input-suggest-search input-refer-name" id="..." name=..." link-search="list-of-high-schools" value="..." />
                <span class="input-group-btn">
                    <button type="button" class="btn btn-primary show-popup-search">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                </span>
            </div>
        </div>
        <div class="col-xs-5 col-sm-7 div-name-of-item-search">
            <span class="value-name">...</span>
        </div>
     </div>
     * @param {object} $input Đối tượng HTML của input được nhập giá trị và cần hiển thị suggest search
     */
    var ShowSuggestSearch = function ($input) {
        try {
            /** Thẻ cha của item đang nhập */
            var $parent = $input.parent();
            /** Link đến  action tìm kiếm cho suggest search*/
            var linkSearch = $input.attr('link-search');
            /** Nội dung suggest search */
            var html = '';
            // Nếu có nội dung trên item cần suggest search thì tiến hành tìm kiếm theo nội dung đó
            if ($input.val() !== '') {
                // Lấy dữ liệu đang nhập để tìm kiếm
                var data = {
                    Key: $input.val()
                };
                // Nếu cần theo các điều kiện tìm kiếm khác
                // Thì tiến hành gọi hàm đã cài đặt để tìm kiếm
                var getOtherKey = window[$input.attr('get-other-key')];
                if (typeof getOtherKey === "function") {
                    var otherData = getOtherKey($input);
                    for (var attrname in otherData) {
                        data[attrname] = otherData[attrname];
                    }
                }
                // Gọi đến action tìm kiếm cho suggest search
                $.ajax({
                    type: 'POST',
                    url: '/common/suggest-search/' + linkSearch,
                    data: data,
                    async: false,
                    success: function (res) {
                        if (res.Code === 200) {
                            // Lấy nội dung của suggest search từ server
                            html = res.Data.html;
                        }
                    },
                    error: function () {
                    }
                });
            }
            // Nếu đã có suggest search khác rồi thì xóa đi
            $('.showing-suggest-search').find('.panel-suggest-search').remove();
            $('.showing-suggest-search').removeClass('showing-suggest-search');
            // Thêm và đánh dáu suggest search mới
            $parent.addClass('showing-suggest-search');
            $parent.append(html);
            // Bật cờ để ngăn sự kiện change dữ liệu khi click vào popup search
            $input.attr('name-refered', 1);
            $input.attr('called-change', 1);
            if ($parent.find('.panel-suggest-search').length === 0) {
                // Nếu không có suggest search nào được hiển thị thì xóa cờ để sử dụng các sự kiện change dữ liệu bình thường
                $parent.removeClass('showing-suggest-search');
                $input.attr('name-refered', 0);
                $input.attr('called-change', 0);
            }
            // Điều chỉnh vị trí, độ cao của suggest search và hiển thị ra màn hình
            PositionOfSuggestSearch($input);
        } catch (e) {
            console.log('OpenPopupSearch: ' + e.message);
        }
    };

    /**
     * Đưa dữ liệu từ item được chọn của suggest search xuống item đang nhập.
     *
     * Author:   QuyPN - 2018/07/07 - create
     * @param {object} $selected Đối tượng HTML của item suggest search được chọn
     */
    var SetDataFromSuggestSearch = function ($selected) {
        try {
            /** Thẻ của bộ suggest search */
            var $parentAll = $selected.closest('.control-search');
            /** Input sử dụng suggest search */
            var $inputMain = $parentAll.find('.input-main');
            // Set các giá trị từ item suggest search xuống boojinput sử dụng suggest search
            $parentAll.find('.value-id').val($selected.attr('value-id'));
            $parentAll.find('.value-code').val($selected.attr('value-code'));
            $parentAll.find('.value-name').text($selected.attr('value-name'));
            // Xóa suggest search
            $('.showing-suggest-search').find('.panel-suggest-search').remove();
            $('.showing-suggest-search').removeClass('showing-suggest-search');
            // Nếu có yêu cầu callback thì gọi hàm callback
            var callback = $inputMain.attr('callback-suggest-search');
            if (typeof callback === "function") {
                callback($selected);
            }
            $inputMain.focus();
            // Báo không cần refer name nữa vì đã có name từ suggest search
            $inputMain.attr('name-refered', 1);
            // Xóa cờ khóa của sự kiện change dữ liệu
            $inputMain.attr('called-change', 0);
            // Bóa event thay đổi dữ liệu
            $inputMain.trigger('change');
        } catch (e) {
            console.log('SetDataFromSuggestSearch: ' + e.message);
        }
    };

    /**
     * Xóa suggest search khi click bất kì nơi nào ngoài suggest search
     *
     * Author:   QuyPN - 2018/07/07 - create
     * @param {object} ev Sự kiện click
     */
    var CloseSuggestSearch = function (ev) {
        try {
            // Nếu có suggest search đang hiển thị
            if ($('.showing-suggest-search').length > 0) {
                var $container = $('.showing-suggest-search');
                // Nếu không phải click vào suggest search
                if (!$container.is(ev.target) && $container.has(ev.target).length === 0) {
                    var $inputMain = $container.find('.input-main');
                    // Xóa suggest search
                    $('.showing-suggest-search .panel-suggest-search').remove();
                    $('.showing-suggest-search').removeClass('showing-suggest-search');
                    // Xóa cờ báo refer name và thực hiện change dữ liệu để tiến hành refer dữ liệu đã nhập vào
                    // (tương đương với hoạt động blur)
                    $inputMain.attr('name-refered', 0);
                    $inputMain.attr('called-change', 0);
                    $inputMain.trigger('change');
                }
            }
        } catch (e) {
            console.log('CloseSuggestSearch: ' + e.message);
        }
    };

    /**
     * Điều chỉnh vị trí hiển thị của suggest search phù hợp với vị trí hiện tại của item.
     *
     * Author:   QuyPN - 2018/07/07 - create
     * @param {object} $input Đối tượng cần hiển thị suggest search
     */
    function PositionOfSuggestSearch($input) {
        // Nếu đang có suggest search hiển thị
        if ($('.showing-suggest-search').length > 0) {
            // Quy định về chiều cao
            var minHeight = 105;
            var maxHeight = 261;
            // Vị trí hiển thị trên hay dưới của item
            var addClass = 'show-bottom';
            // Lấy vị trí hiện tại của item
            var curentPosition = $input.offset().top - $(window).scrollTop();
            // Lấy chiều cai của cửa sổ trình duyệt
            var windowsHeigth = $(window).outerHeight();
            // Chiều cao của item
            var inputHeight = $input.outerHeight();
            // Chiều cao có thể có của suggest search
            var heigthOfPanel = windowsHeigth - curentPosition - inputHeight;
            // Nếu phần phía dưới không đủ để hiển thị suggest search thì hiển thị lên bên trên
            if (curentPosition > heigthOfPanel) {
                addClass = 'show-top';
                heigthOfPanel = curentPosition;
            }
            // Tính lại chiều cao của suggest search phù hợp với màn hình hiện tại
            heigthOfPanel = heigthOfPanel - 10;
            heigthOfPanel = heigthOfPanel > maxHeight ? maxHeight : heigthOfPanel > minHeight ? heigthOfPanel : minHeight;
            $('.showing-suggest-search .panel-suggest-search').addClass(addClass);
            $('.showing-suggest-search .panel-suggest-search').css('max-height', heigthOfPanel);
        }
    };

    return {
        Init: Init,
        InitEvents: InitEvents,
        ReferNameOfKey: ReferNameOfKey
    };
})();

// Khởi tạo các giá trị cho trang admin
$(document).ready(function () {
    AdminCommonModule.Init();
    AdminCommonModule.InitEvents();
    PopupModule.Init();
    PopupModule.InitEvents();
});
