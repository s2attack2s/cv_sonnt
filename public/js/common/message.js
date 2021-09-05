/**
 * Các giá trị cần thiết cho một thông báo
 * @typedef {Object} SystemMessage
 * @property {string} content Nội dung thông báo
 * @property {string} title Tiêu đề thông báo
 * @property {number} type Loại thông báo
 */

/**
 * Các thông báo của hệ thống
 * @type {...Object<string,SystemMessage>}
 */
 var _msgLang = {
    'vi': {
        'C001': {
            'content': 'Bạn có thực sự muốn lưu dữ liệu này không?',
            'title': 'Confirm',
            'type': 1
        },
        'C002': {
            'content': 'Bạn có thực sự muốn xóa dữ liệu này không?',
            'title': 'Confirm',
            'type': 1
        },
        'C003': {
            'content': 'Đã lưu dữ liệu thành công, bạn có muốn trở về trang danh sách không?',
            'title': 'Confirm',
            'type': 1
        },
        'C004': {
            'content': 'Đã xóa dữ liệu thành công, bạn có muốn trở về trang danh sách không?',
            'title': 'Confirm',
            'type': 1
        },
        'C005': {
            'content': 'Bạn có thật sự muốn reset mật khẩu cho tài khoản này không?',
            'title': 'Confirm',
            'type': 1
        },
        'C006': {
            'content': 'Bạn có chắc chắn muốn thay đổi mật khẩu không?',
            'title': 'Confirm',
            'type': 1
        },
        'C007': {
            'content': 'Khi lưu tạm, blog này sẽ không còn xuất hiện trên trang chủ nữa. Bạm có thực sự muốn lưu tạm blog này không?',
            'title': 'Confirm',
            'type': 1
        },
        'C008': {
            'content': 'Khi lưu tạm, nhóm blog này sẽ không còn xuất hiện trên trang chủ nữa. Bạm có thực sự muốn lưu tạm nhóm blog này không?',
            'title': 'Confirm',
            'type': 1
        },
        'C009': {
            'content': 'Khi ở trạng thái ẩn, sản phẩm này sẽ không còn xuất hiện trên trang chủ nữa. Bạm có thực sự muốn ẩn sản phẩm này không?',
            'title': 'Confirm',
            'type': 1
        },
        'C010': {
            'content': 'Đã thêm vào giỏ hàng thành công, bạn có muốn tiếp tục mua sắm không?',
            'title': 'Confirm',
            'type': 1
        },
        'C011': {
            'content': 'Are you sure Approve?',
            'title': 'Confirm',
            'type': 1
        },

        'C012': {
            'content': 'Are you sure Reject?',
            'title': 'Confirm',
            'type': 1
        },
        'E001': {
            'content': 'Nội dung này không được để trống.',
            'title': 'Error',
            'type': 4
        },
        'E002': {
            'content': 'Email không đúng định dạng.',
            'title': 'Error',
            'type': 4
        },
        'E003': {
            'content': 'Ngày tháng không đúng định dạng.',
            'title': 'Error',
            'type': 4
        },
        'E004': {
            'content': 'Đường dẫn sai định dạng.',
            'title': 'Error',
            'type': 4
        },
        'E005': {
            'content': 'Bạn không được phép nhập quá {0} kí tự.',
            'title': 'Error',
            'type': 4
        },
        'E006': {
            'content': 'Bạn phải nhập tối thiểu {1} kí tự.',
            'title': 'Error',
            'type': 4
        },
        'E007': {
            'content': 'Giá trị này phải lớn hơn {2}.',
            'title': 'Error',
            'type': 4
        },
        'E008': {
            'content': 'Giá trị này phải nhỏ hơn {3}.',
            'title': 'Error',
            'type': 4
        },
        'E009': {
            'content': 'Số điện thoại sai định dạng.',
            'title': 'Error',
            'type': 4
        },
        'E010': {
            'content': 'Thời gian bắt đầu phải bé hơn thời gian kết thúc.',
            'title': 'Error',
            'type': 4
        },
        'E011': {
            'content': 'Giá trị này đang bị trùng lặp.',
            'title': 'Error',
            'type': 4
        },
        'E012': {
            'content': 'Tài khoản không tồn tại.',
            'title': 'Error',
            'type': 4
        },
        'E013': {
            'content': 'Mật khẩu không chính xác.',
            'title': 'Error',
            'type': 4
        },
        'E014': {
            'content': 'Tài khoản hoặc mật khẩu không chính xác.',
            'title': 'Error',
            'type': 4
        },
        'E015': {
            'content': 'Tên đăng nhập đã được sử dụng.',
            'title': 'Error',
            'type': 4
        },
        'E016': {
            'content': 'Hệ thống phải tồn tại ít nhất 1 tài khoản để sử dụng.',
            'title': 'Error',
            'type': 4
        },
        'E017': {
            'content': 'Mật khẩu phải chứa ít nhất 8 ký tự, có chứa chữ hoa, chữ thường và ký tự đặc biệt.',
            'title': 'Error',
            'type': 4
        },
        'E018': {
            'content': 'Mật khẩu xác nhận không trùng khớp, vui lòng kiểm tra lại.',
            'title': 'Error',
            'type': 4
        },
        'E019': {
            'content': 'Tên đăng nhập phải có ít nhất 4 ký tự, chỉ được nhập các ký tự chữ cái, chữ số và các dấu chấm (.), gạch nối (-), gạch dưới (_).',
            'title': 'Error',
            'type': 4
        },
        'E020': {
            'content': 'File vượt quá dung lượng cho phép.',
            'title': 'Error',
            'type': 4
        },
        'E021': {
            'content': 'File không đúng định dạng.',
            'title': 'Error',
            'type': 4
        },
        'E022': {
            'content': 'Không thể upload quá {0} file cùng lúc.',
            'title': 'Error',
            'type': 4
        },
        'E023': {
            'content': 'Có lỗi trong quá trình tải file, vui lòng thử lại.',
            'title': 'Error',
            'type': 4
        },
        'E024': {
            'content': 'Vui lòng chọn file tải lên.',
            'title': 'Error',
            'type': 4
        },
        'E025': {
            'content': 'Kích thước hình ảnh không đúng yêu cầu.',
            'title': 'Error',
            'type': 4
        },
        'E026': {
            'content': 'Không thể thực hiện thao tác này, vì số item hiển thị trên trang chủ đã đạt mức tối thiểu.',
            'title': 'Error',
            'type': 4
        },
        'E027': {
            'content': 'Link này chỉ có thể chứa chuỗi không dấu bao gồm chữ thường, chữ hoa và dấu gạch nối (-).',
            'title': 'Error',
            'type': 4
        },
        'E028': {
            'content': 'Lưu dữ liệu không thành công, vui lòng thử lại.',
            'title': 'Error',
            'type': 4
        },
        'E029': {
            'content': 'Xóa dữ liệu không thành công, vui lòng thử lại.',
            'title': 'Error',
            'type': 4
        },
        'E030': {
            'content': 'Không thể hiển thị số lượng kết quả quá lớn.',
            'title': 'Error',
            'type': 4
        },
        'E031': {
            'content': 'Có lỗi trong quá trình tạo file, vui lòng thử lại.',
            'title': 'Error',
            'type': 4
        },
        'E032': {
            'content': 'Dữ liệu này đã tồn tại trong hệ thống',
            'title': 'Error',
            'type': 4
        },
        'E033': {
            'content': 'Mã của thông báo đã tồn tại trong hệ thống',
            'title': 'Error',
            'type': 4
        },
        'E034': {
            'content': 'Mã của chức năng đã tồn tại trong hệ thống',
            'title': 'Error',
            'type': 4
        },
        'E035': {
            'content': 'Bạn phải chọn ít nhất 1 dòng',
            'title': 'Error',
            'type': 4
        },
        'E036': {
            'content': 'Địa chỉ IP không đúng định dạng',
            'title': 'Error',
            'type': 4
        },
        'E037': {
            'content': 'Không có dữ liệu export',
            'title': 'Error',
            'type': 4
        },
        'E038': {
            'content': 'Chức năng này hiện không hoạt động trên mobile',
            'title': 'Error',
            'type': 4
        },
        'E039': {
            'content': 'Email này không tồn tại',
            'title': 'Error',
            'type': 4
        },
        'E040': {
            'content': 'Quá hạn để thay đổi mật khẩu',
            'title': 'Error',
            'type': 4
        },
        'E041': {
            'content': 'Email đã được sử dụng',
            'title': 'Error',
            'type': 4
        },
        'E042': {
            'content': 'Bạn phải chọn file sản phẩm',
            'title': 'Error',
            'type': 4
        },
        'E043': {
            'content': 'Bạn phải chọn hình ảnh minh hoạ cho sản phẩm',
            'title': 'Error',
            'type': 4
        },
        'E044': {
            'content': 'Bạn phải nhập giá bán cho sản phẩm',
            'title': 'Error',
            'type': 4
        },
        'E045': {
            'content': 'Mã sản phẩm bị trùng',
            'title': 'Error',
            'type': 4
        },
        'E046': {
            'content': 'Bạn cần đồng ý với điều khoản sử dụng và chính sách bảo mật của chúng tôi',
            'title': 'Error',
            'type': 4
        },
        'E047': {
            'content': 'Tài khoản của bạn chưa được kích hoạt. Chúng tôi đã gửi lại thông tin kích hoạt tài khoản đến email mà bạn đã đăng ký, vui lòng kiểm tra email để kích hoạt tài khoản',
            'title': 'Error',
            'type': 4
        },
        'E048': {
            'content': 'Bạn cần phải xác nhận ',
            'title': 'Error',
            'type': 4
        },
        'E049': {
            'content': 'Xác nhận thành công ',
            'title': 'Success',
            'type': 2
        },
        'E402': {
            'content': 'Bạn cần đăng nhập để thực hiện hành động này',
            'title': 'Error',
            'type': 4
        },
        'E403': {
            'content': 'Bạn không có quyền để thực hiện hành động này',
            'title': 'Error',
            'type': 4
        },
        'E500': {
            'content': 'Hệ thống bị lỗi, vui lòng thử lại sau.',
            'title': 'Error',
            'type': 4
        },
        'S001': {
            'content': 'Đã lưu dữ liệu thành công.',
            'title': 'Success',
            'type': 2
        },
        'S002': {
            'content': 'Đã xóa dữ liệu thành công.',
            'title': 'Success',
            'type': 2
        },
        'S003': {
            'content': 'Đã tạo file javascript thành công',
            'title': 'Success',
            'type': 2
        },
        'S004': {
            'content': 'Đã reset password thành công',
            'title': 'Success',
            'type': 2
        },
        'S005': {
            'content': 'Đã sao chép dữ liệu thành công',
            'title': 'Success',
            'type': 2
        },
        'S006': {
            'content': 'Vui lòng kiểm tra email của bạn để đặt lại mật khẩu. Nếu nó không xuất hiện trong vài phút, hãy kiểm tra thư mục rác của bạn',
            'title': 'Success',
            'type': 2
        },
        'S007': {
            'content': 'Mail kích hoạt đã được gửi đến địa chỉ email bạn đăng ký, vui lòng kiểm tra email để kích hoạt tài khoản',
            'title': 'Success',
            'type': 2
        },
        'S008': {
            'content': 'Đã gửi liên hệ thành công. Chúng tôi sẽ liên lạc trong thời gian sớm nhất. Cảm ơn bạn đã quan tâm đến các sản phẩm của VBO Solution',
            'title': 'Success',
            'type': 2
        },
        'S009': {
            'content': 'Cảm ơn bạn đã đánh giá sản phẩm của chúng tôi. Chúng tôi sẽ tiếp nhận ý kiến và cải thiện dịch vụ ngày một tốt hơn',
            'title': 'Success',
            'type': 2
        },
        'S010': {
            'content': 'Chúng tôi đã gửi lại thông tin kích hoạt tài khoản đến email mà bạn đã đăng ký. Vui lòng kiểm tra email để kích hoạt tài khoản',
            'title': 'Success',
            'type': 2
        },
        'W001': {
            'content': 'Việc tạo lại file javascript này có thể gây ra một số thay đổi không mong muốn cho hệ thống, bạn có muốn tiếp tục không?',
            'title': 'Warning',
            'type': 3
        },
        'W003': {
            'content': 'Bạn đã thay đổi link SEO của blog này, nếu tiếp tục lưu tất cả dữ liệu SEO của blog này sẽ bị mất, bạn có muốn tiếp tục không?',
            'title': 'Warning',
            'type': 3
        },
        'W004': {
            'content': 'Khi lưu tạm, blog này sẽ không  xuất hiện trên trang chủ. Bạn cũng đã thay đổi link SEO, nếu tiếp tục lưu tất cả dữ liệu SEO của blog này sẽ bị mất, bạn có muốn tiếp tục không?',
            'title': 'Warning',
            'type': 3
        },
        'W005': {
            'content': 'Dữ liệu bạn thay đổi vẫn chưa được lưu, bạn có muốn tiếp tục không?',
            'title': 'Warning',
            'type': 3
        },
        'W006': {
            'content': 'Bạn đã thay đổi link SEO của nhóm blog này, nếu tiếp tục lưu tất cả dữ liệu SEO của nhóm blog này sẽ bị mất, bạn có muốn tiếp tục không?',
            'title': 'Warning',
            'type': 3
        },
        'W007': {
            'content': 'Khi lưu tạm, nhóm blog này sẽ không  xuất hiện trên trang chủ. Bạn cũng đã thay đổi link SEO, nếu tiếp tục lưu tất cả dữ liệu SEO của nhóm blog này sẽ bị mất, bạn có muốn tiếp tục không?',
            'title': 'Warning',
            'type': 3
        },
        'W008': {
            'content': 'Bạn đã thay đổi link SEO của sản phẩm này, nếu tiếp tục lưu tất cả dữ liệu SEO của product này sẽ bị mất, bạn có muốn tiếp tục không?',
            'title': 'Warning',
            'type': 3
        },
        'W009': {
            'content': 'Khi ở trạng thái ẩn, sản phẩm này này sẽ không  xuất hiện trên trang chủ. Bạn cũng đã thay đổi link SEO, nếu tiếp tục lưu tất cả dữ liệu SEO của sản phẩm này sẽ bị mất, bạn có muốn tiếp tục không?',
            'title': 'Warning',
            'type': 3
        }
    },
    'en': {
        'C001': {
            'content': 'Bạn có thực sự muốn lưu dữ liệu này không?',
            'title': 'Confirm',
            'type': 1
        },
        'C002': {
            'content': 'Bạn có thực sự muốn xóa dữ liệu này không?',
            'title': 'Confirm',
            'type': 1
        },
        'C003': {
            'content': 'Đã lưu dữ liệu thành công, bạn có muốn trở về trang danh sách không?',
            'title': 'Confirm',
            'type': 1
        },
        'C004': {
            'content': 'Đã xóa dữ liệu thành công, bạn có muốn trở về trang danh sách không?',
            'title': 'Confirm',
            'type': 1
        },
        'C005': {
            'content': 'Bạn có thật sự muốn reset mật khẩu cho tài khoản này không?',
            'title': 'Confirm',
            'type': 1
        },
        'C006': {
            'content': 'Bạn có chắc chắn muốn thay đổi mật khẩu không?',
            'title': 'Confirm',
            'type': 1
        },
        'C007': {
            'content': 'Khi lưu tạm, blog này sẽ không còn xuất hiện trên trang chủ nữa. Bạm có thực sự muốn lưu tạm blog này không?',
            'title': 'Confirm',
            'type': 1
        },
        'C008': {
            'content': 'Khi lưu tạm,series tutorial này sẽ không còn xuất hiện trên trang chủ nữa. Bạm có thực sự muốn lưu tạm series tutorial này không?',
            'title': 'Confirm',
            'type': 1
        },
        'C009': {
            'content': 'Khi ở trạng thái ẩn, sản phẩm này sẽ không còn xuất hiện trên trang chủ nữa. Bạm có thực sự muốn ẩn sản phẩm này không?',
            'title': 'Confirm',
            'type': 1
        },

        'C010': {
            'content': 'Đã thêm vào giỏ hàng thành công, bạn có muốn tiếp tục mua sắm không?',
            'title': 'Confirm',
            'type': 1
        },
        'C011': {
            'content': 'Are you sure approve?',
            'title': 'Confirm',
            'type': 1
        },

        'C012': {
            'content': 'Are you sure Reject?',
            'title': 'Confirm',
            'type': 1
        },
        'E001': {
            'content': 'Nội dung này không được để trống.',
            'title': 'Error',
            'type': 4
        },
        'E002': {
            'content': 'Email không đúng định dạng.',
            'title': 'Error',
            'type': 4
        },
        'E003': {
            'content': 'Ngày tháng không đúng định dạng.',
            'title': 'Error',
            'type': 4
        },
        'E004': {
            'content': 'Đường dẫn sai định dạng.',
            'title': 'Error',
            'type': 4
        },
        'E005': {
            'content': 'Bạn không được phép nhập quá {0} kí tự.',
            'title': 'Error',
            'type': 4
        },
        'E006': {
            'content': 'Bạn phải nhập tối thiểu {1} kí tự.',
            'title': 'Error',
            'type': 4
        },
        'E007': {
            'content': 'Giá trị này phải lớn hơn {2}.',
            'title': 'Error',
            'type': 4
        },
        'E008': {
            'content': 'Giá trị này phải nhỏ hơn {3}.',
            'title': 'Error',
            'type': 4
        },
        'E009': {
            'content': 'Số điện thoại sai định dạng.',
            'title': 'Error',
            'type': 4
        },
        'E010': {
            'content': 'Thời gian bắt đầu phải bé hơn thời gian kết thúc.',
            'title': 'Error',
            'type': 4
        },
        'E011': {
            'content': 'Giá trị này đang bị trùng lặp.',
            'title': 'Error',
            'type': 4
        },
        'E012': {
            'content': 'Tài khoản không tồn tại.',
            'title': 'Error',
            'type': 4
        },
        'E013': {
            'content': 'Mật khẩu không chính xác.',
            'title': 'Error',
            'type': 4
        },
        'E014': {
            'content': 'Tài khoản hoặc mật khẩu không chính xác.',
            'title': 'Error',
            'type': 4
        },
        'E015': {
            'content': 'Tên đăng nhập đã được sử dụng.',
            'title': 'Error',
            'type': 4
        },
        'E016': {
            'content': 'Hệ thống phải tồn tại ít nhất 1 tài khoản để sử dụng.',
            'title': 'Error',
            'type': 4
        },
        'E017': {
            'content': 'Mật khẩu phải chứa ít nhất 8 ký tự, có chứa chữ hoa, chữ thường và ký tự đặc biệt.',
            'title': 'Error',
            'type': 4
        },
        'E018': {
            'content': 'Mật khẩu xác nhận không trùng khớp, vui lòng kiểm tra lại.',
            'title': 'Error',
            'type': 4
        },
        'E019': {
            'content': 'Tên đăng nhập phải có ít nhất 4 ký tự, chỉ được nhập các ký tự chữ cái, chữ số và các dấu chấm (.), gạch nối (-), gạch dưới (_).',
            'title': 'Error',
            'type': 4
        },
        'E020': {
            'content': 'File vượt quá dung lượng cho phép.',
            'title': 'Error',
            'type': 4
        },
        'E021': {
            'content': 'File không đúng định dạng.',
            'title': 'Error',
            'type': 4
        },
        'E022': {
            'content': 'Không thể upload quá {0} file cùng lúc.',
            'title': 'Error',
            'type': 4
        },
        'E023': {
            'content': 'Có lỗi trong quá trình tải file, vui lòng thử lại.',
            'title': 'Error',
            'type': 4
        },
        'E024': {
            'content': 'Vui lòng chọn file tải lên.',
            'title': 'Error',
            'type': 4
        },
        'E025': {
            'content': 'Kích thước hình ảnh không đúng yêu cầu.',
            'title': 'Error',
            'type': 4
        },
        'E026': {
            'content': 'Không thể thực hiện thao tác này, vì số item hiển thị trên trang chủ đã đạt mức tối thiểu.',
            'title': 'Error',
            'type': 4
        },
        'E027': {
            'content': 'Link này chỉ có thể chứa chuỗi không dấu bao gồm chữ thường, chữ hoa và dấu gạch nối (-).',
            'title': 'Error',
            'type': 4
        },
        'E028': {
            'content': 'Lưu dữ liệu không thành công, vui lòng thử lại.',
            'title': 'Error',
            'type': 4
        },
        'E029': {
            'content': 'Xóa dữ liệu không thành công, vui lòng thử lại.',
            'title': 'Error',
            'type': 4
        },
        'E030': {
            'content': 'Không thể hiển thị số lượng kết quả quá lớn.',
            'title': 'Error',
            'type': 4
        },
        'E031': {
            'content': 'Có lỗi trong quá trình tạo file, vui lòng thử lại.',
            'title': 'Error',
            'type': 4
        },
        'E032': {
            'content': 'Dữ liệu này đã tồn tại trong hệ thống',
            'title': 'Error',
            'type': 4
        },
        'E033': {
            'content': 'Mã của thông báo đã tồn tại trong hệ thống',
            'title': 'Error',
            'type': 4
        },
        'E034': {
            'content': 'Mã của chức năng đã tồn tại trong hệ thống',
            'title': 'Error',
            'type': 4
        },
        'E035': {
            'content': 'Bạn phải chọn ít nhất 1 dòng',
            'title': 'Error',
            'type': 4
        },
        'E036': {
            'content': 'Địa chỉ IP không đúng định dạng',
            'title': 'Error',
            'type': 4
        },
        'E037': {
            'content': 'Không có dữ liệu export',
            'title': 'Error',
            'type': 4
        },
        'E038': {
            'content': 'Chức năng này hiện không hoạt động trên mobile',
            'title': 'Error',
            'type': 4
        },
        'E039': {
            'content': 'Email này không tồn tại',
            'title': 'Error',
            'type': 4
        },
        'E040': {
            'content': 'Quá hạn để thay đổi mật khẩu',
            'title': 'Error',
            'type': 4
        },
        'E041': {
            'content': 'Email đã được sử dụng',
            'title': 'Error',
            'type': 4
        },
        'E042': {
            'content': 'Bạn phải chọn file sản phẩm',
            'title': 'Error',
            'type': 4
        },
        'E043': {
            'content': 'Bạn phải chọn hình ảnh minh hoạ cho sản phẩm',
            'title': 'Error',
            'type': 4
        },
        'E044': {
            'content': 'Bạn phải nhập giá bán cho sản phẩm',
            'title': 'Error',
            'type': 4
        },
        'E045': {
            'content': 'Mã sản phẩm bị trùng',
            'title': 'Error',
            'type': 4
        },
        'E046': {
            'content': 'Bạn cần đồng ý với điều khoản sử dụng và chính sách bảo mật của chúng tôi',
            'title': 'Error',
            'type': 4
        },
        'E047': {
            'content': 'Tài khoản của bạn chưa được kích hoạt. Chúng tôi đã gửi lại thông tin kích hoạt tài khoản đến email mà bạn đã đăng ký, vui lòng kiểm tra email để kích hoạt tài khoản',
            'title': 'Error',
            'type': 4
        },
        'E402': {
            'content': 'Bạn cần đăng nhập để thực hiện hành động này',
            'title': 'Error',
            'type': 4
        },
        'E403': {
            'content': 'Bạn không có quyền để thực hiện hành động này',
            'title': 'Error',
            'type': 4
        },
        'E500': {
            'content': 'Hệ thống bị lỗi, vui lòng thử lại sau.',
            'title': 'Error',
            'type': 4
        },
        'S001': {
            'content': 'Đã lưu dữ liệu thành công.',
            'title': 'Success',
            'type': 2
        },
        'S002': {
            'content': 'Đã xóa dữ liệu thành công.',
            'title': 'Success',
            'type': 2
        },
        'S003': {
            'content': 'Đã tạo file javascript thành công',
            'title': 'Success',
            'type': 2
        },
        'S004': {
            'content': 'Đã reset password thành công',
            'title': 'Success',
            'type': 2
        },
        'S005': {
            'content': 'Đã sao chép dữ liệu thành công',
            'title': 'Success',
            'type': 2
        },
        'S006': {
            'content': 'Vui lòng kiểm tra email của bạn để đặt lại mật khẩu. Nếu nó không xuất hiện trong vài phút, hãy kiểm tra thư mục rác của bạn',
            'title': 'Success',
            'type': 2
        },
        'S007': {
            'content': 'Mail kích hoạt đã được gửi đến địa chỉ email bạn đăng ký, vui lòng kiểm tra email để kích hoạt tài khoản',
            'title': 'Success',
            'type': 2
        },
        'S008': {
            'content': 'Đã gửi liên hệ thành công. Chúng tôi sẽ liên lạc trong thời gian sớm nhất. Cảm ơn bạn đã quan tâm đến các sản phẩm của VBO Solution',
            'title': 'Success',
            'type': 2
        },
        'S009': {
            'content': 'Cảm ơn bạn đã đánh giá sản phẩm của chúng tôi. Chúng tôi sẽ tiếp nhận ý kiến và cải thiện dịch vụ ngày một tốt hơn',
            'title': 'Success',
            'type': 2
        },
        'S010': {
            'content': 'Chúng tôi đã gửi lại thông tin kích hoạt tài khoản đến email mà bạn đã đăng ký. Vui lòng kiểm tra email để kích hoạt tài khoản',
            'title': 'Success',
            'type': 2
        },
        'W001': {
            'content': 'Việc tạo lại file javascript này có thể gây ra một số thay đổi không mong muốn cho hệ thống, bạn có muốn tiếp tục không?',
            'title': 'Warning',
            'type': 3
        },
        'W003': {
            'content': 'Bạn đã thay đổi link SEO của blog này, nếu tiếp tục lưu tất cả dữ liệu SEO của blog này sẽ bị mất, bạn có muốn tiếp tục không?',
            'title': 'Warning',
            'type': 3
        },
        'W004': {
            'content': 'Khi lưu tạm, blog này sẽ không  xuất hiện trên trang chủ. Bạn cũng đã thay đổi link SEO, nếu tiếp tục lưu tất cả dữ liệu SEO của blog này sẽ bị mất, bạn có muốn tiếp tục không?',
            'title': 'Warning',
            'type': 3
        },
        'W005': {
            'content': 'Dữ liệu bạn thay đổi vẫn chưa được lưu, bạn có muốn tiếp tục không?',
            'title': 'Warning',
            'type': 3
        },
        'W006': {
            'content': 'Bạn đã thay đổi link SEO của series tutorial này, nếu tiếp tục lưu tất cả dữ liệu SEO của series tutorial này sẽ bị mất, bạn có muốn tiếp tục không?',
            'title': 'Warning',
            'type': 3
        },
        'W007': {
            'content': 'Khi lưu tạm, nhóm blog này sẽ không  xuất hiện trên trang chủ. Bạn cũng đã thay đổi link SEO, nếu tiếp tục lưu tất cả dữ liệu SEO của nhóm blog này sẽ bị mất, bạn có muốn tiếp tục không?',
            'title': 'Warning',
            'type': 3
        },
        'W008': {
            'content': 'Bạn đã thay đổi link SEO của sản phẩm này, nếu tiếp tục lưu tất cả dữ liệu SEO của product này sẽ bị mất, bạn có muốn tiếp tục không?',
            'title': 'Warning',
            'type': 3
        },
        'W009': {
            'content': 'Khi ở trạng thái ẩn, sản phẩm này này sẽ không  xuất hiện trên trang chủ. Bạn cũng đã thay đổi link SEO, nếu tiếp tục lưu tất cả dữ liệu SEO của sản phẩm này sẽ bị mất, bạn có muốn tiếp tục không?',
            'title': 'Warning',
            'type': 3
        }
    }
};
var _msg = _msgLang[lang];

/**  Danh sách mã các câu thông báo trong hệ thống */
var MSG_NO = {
    /** Bạn có thực sự muốn lưu dữ liệu này không? */
    CONFIRM_SAVE_DATA: 'C001',
    /** Bạn có thực sự muốn xóa dữ liệu này không? */
    CONFIRM_DELETE_DATA: 'C002',
    /** Đã lưu dữ liệu thành công, bạn có muốn trở về trang danh sách không? */
    CONFIRM_AFTER_SAVE: 'C003',
    /** Đã xóa dữ liệu thành công, bạn có muốn trở về trang danh sách không? */
    CONFIRM_AFTER_DELETE: 'C004',
    /** Bạn có thật sự muốn reset mật khẩu cho tài khoản này không? */
    CONFIRM_RESET_PASSWORD: 'C005',
    /** Bạn có chắc chắn muốn thay đổi mật khẩu không? */
    CONFIRM_CHANGE_PASSWORD: 'C006',
    /** Khi lưu tạm, blog này sẽ không còn xuất hiện trên trang chủ nữa. Bạm có thực sự muốn lưu tạm blog này không? */
    CONFIRM_TEMP_SAVE_TUTORIAL: 'C007',
    /** Khi lưu tạm, nhóm blog này sẽ không còn xuất hiện trên trang chủ nữa. Bạm có thực sự muốn lưu tạm nhóm blog này không? */
    CONFIRM_TEMP_SAVE_SERIES: 'C008',
    /** Khi ở trạng thái ẩn, sản phẩm này sẽ không còn xuất hiện trên trang chủ nữa. Bạm có thực sự muốn ẩn sản phẩm này không? */
    CONFIRM_HIDDEN_PRODUCT: 'C009',
    /** Đã thêm vào giỏ hàng thành công, bạn có muốn tiếp tục mua sắm không? */
    ADD_TO_CART_SUCCESS: 'C010',

    CONFIRM_APPROVE_DATA: 'C011',
    CONFIRM_REJECT_DATA: 'C012',
    /** Nội dung này không được để trống. */
    REQUIRED: 'E001',
    /** Email không đúng định dạng. */
    EMAIL_FORMAT_RON: 'E002',
    /** Ngày tháng không đúng định dạng. */
    DATE_FORMAT_RON: 'E003',
    /** Đường dẫn sai định dạng. */
    URL_FORMAT_RON: 'E004',
    /** Bạn không được phép nhập quá {0} kí tự. */
    EXCEED_MAXLENGTH: 'E005',
    /** Bạn phải nhập tối thiểu {1} kí tự. */
    NOT_ENOUGH_MIN_LENGTH: 'E006',
    /** Giá trị này phải lớn hơn {2}. */
    VALUE_MUST_GEATER: 'E007',
    /** Giá trị này phải nhỏ hơn {3}. */
    VALUE_MUST_LESSER: 'E008',
    /** Số điện thoại sai định dạng. */
    PHONE_NUMBER_FORMAT_RON: 'E009',
    /** Thời gian bắt đầu phải bé hơn thời gian kết thúc. */
    TIME_FROM_MUST_LESSER_TIME_TO: 'E010',
    /** Giá trị này đang bị trùng lặp. */
    DATA_DUPLICATE: 'E011',
    /** Tài khoản không tồn tại. */
    USERNAME_NOT_INCORRECT: 'E012',
    /** Mật khẩu không chính xác. */
    PASSWORD_NOT_INCORRECT: 'E013',
    /** Tài khoản hoặc mật khẩu không chính xác. */
    USERNAME_OR_PASSWORD_NOT_INCORRECT: 'E014',
    /** Tên đăng nhập đã được sử dụng. */
    USERNAME_HAD_USED: 'E015',
    /** Hệ thống phải tồn tại ít nhất 1 tài khoản để sử dụng. */
    SYSTEM_MUST_HAVE_LEAST_1_USER: 'E016',
    /** Mật khẩu phải chứa ít nhất 8 ký tự, có chứa chữ hoa, chữ thường và ký tự đặc biệt. */
    PASSWORD_WRONG_FORMAT: 'E017',
    /** Mật khẩu xác nhận không trùng khớp, vui lòng kiểm tra lại. */
    CORNFIRM_PASSWORD_ERROR: 'E018',
    /** Tên đăng nhập phải có ít nhất 4 ký tự, chỉ được nhập các ký tự chữ cái, chữ số và các dấu chấm (.), gạch nối (-), gạch dưới (_). */
    USERNAME_WRONG_FORMAT: 'E019',
    /** File vượt quá dung lượng cho phép. */
    FILE_SIZE_TOO_LARGER: 'E020',
    /** File không đúng định dạng. */
    EXTENSION_NOT_ALLOW: 'E021',
    /** Không thể upload quá {0} file cùng lúc. */
    CANNOT_UPLOAD_MANY_FILES: 'E022',
    /** Có lỗi trong quá trình tải file, vui lòng thử lại. */
    UPLOAD_FILE_ERROR: 'E023',
    /** Vui lòng chọn file tải lên. */
    YOU_MUST_CHOOSE_FILE: 'E024',
    /** Kích thước hình ảnh không đúng yêu cầu. */
    SIZE_OF_IMG_RON: 'E025',
    /** Không thể thực hiện thao tác này, vì số item hiển thị trên trang chủ đã đạt mức tối thiểu. */
    EROR_MIN_ITEM_SHOW: 'E026',
    /** Link này chỉ có thể chứa chuỗi không dấu bao gồm chữ thường, chữ hoa và dấu gạch nối (-). */
    BEAUTYID_WRONG_FORMAT: 'E027',
    /** Lưu dữ liệu không thành công, vui lòng thử lại. */
    SAVE_DATA_ERROR: 'E028',
    /** Xóa dữ liệu không thành công, vui lòng thử lại. */
    DELETE_DATA_ERROR: 'E029',
    /** Không thể hiển thị số lượng kết quả quá lớn. */
    NUMBER_OF_RECORD_LARGER: 'E030',
    /** Có lỗi trong quá trình tạo file, vui lòng thử lại. */
    CREATE_JS_ERROR: 'E031',
    /** Dữ liệu này đã tồn tại trong hệ thống */
    DATA_EXISTING: 'E032',
    /** Mã của thông báo đã tồn tại trong hệ thống */
    MESSAGE_CODE_EXISTING: 'E033',
    /** Mã của chức năng đã tồn tại trong hệ thống */
    FUNCTION_CODE_EXISTING: 'E034',
    /** Bạn phải chọn ít nhất 1 dòng */
    SELECT_AT_LEAST_1_LINE: 'E035',
    /** Địa chỉ IP không đúng định dạng */
    IP_ADDRESS_FORMAT_RON: 'E036',
    /** Không có dữ liệu export */
    DATA_EXPORT_NOT_EXISTS: 'E037',
    /** Chức năng này hiện không hoạt động trên mobile */
    FUNCTION_NOT_VALID_IN_MOBILE: 'E038',
    /** Email này không tồn tại */
    EMAIL_NOT_INCORRECT: 'E039',
    /** Quá hạn để thay đổi mật khẩu */
    TOKEN_TIMEOUT: 'E040',
    /** Email đã được sử dụng */
    EMAIL_HAD_USED: 'E041',
    /** Bạn phải chọn file sản phẩm */
    YOU_MUST_CHOOSE_FILE_PRODUCT: 'E042',
    /** Bạn phải chọn hình ảnh minh hoạ cho sản phẩm */
    YOU_MUST_CHOOSE_FILE_IMAGES: 'E043',
    /** Bạn phải nhập giá bán cho sản phẩm */
    YOU_NEED_ENTER_SALE_PRICE: 'E044',
    /** Mã sản phẩm bị trùng */
    SKU_IS_DUPLICATE: 'E045',
    /** Bạn cần đồng ý với điều khoản sử dụng và chính sách bảo mật của chúng tôi */
    YOU_MUST_AGREE_WITH_US: 'E046',
    /** Tài khoản của bạn chưa được kích hoạt. Chúng tôi đã gửi lại thông tin kích hoạt tài khoản đến email mà bạn đã đăng ký, vui lòng kiểm tra email để kích hoạt tài khoản */
    YOUR_ACCOUNT_NOT_ACTIVE: 'E047',
    /** Bạn cần đăng nhập để thực hiện hành động này */
    YOUR_CAPTCHA: 'E048',
    //** Bạn cần xác thực */
    YOUR_CAPTCHAS: 'E049',
    /** Xác thực thành công */
    YOU_MUST_LOGIN: 'E402',
    /** Bạn không có quyền để thực hiện hành động này */
    YOU_NOT_HAVE_PERMISSION: 'E403',
    /** Hệ thống bị lỗi, vui lòng thử lại sau. */
    SERVER_ERROR: 'E500',
    /** Đã lưu dữ liệu thành công. */
    SAVE_DATA_SUCCESS: 'S001',
    /** Đã xóa dữ liệu thành công. */
    DELETE_DATA_SUCCESS: 'S002',
    /** Đã tạo file javascript thành công */
    CREATE_JS_SUCCESS: 'S003',
    /** Đã reset password thành công */
    RESET_PASSWORD_SUCCESS: 'S004',
    /** Đã sao chép dữ liệu thành công */
    CLONE_DATA_SUCCESS: 'S005',
    /** Vui lòng kiểm tra email của bạn để đặt lại mật khẩu. Nếu nó không xuất hiện trong vài phút, hãy kiểm tra thư mục rác của bạn */
    SEND_EMAIL_FOR_RESET_PASSWORD_SUCCESS: 'S006',
    /** Mail kích hoạt đã được gửi đến địa chỉ email bạn đăng ký, vui lòng kiểm tra email để kích hoạt tài khoản */
    SEND_EMAIL_FOR_ACTIVE_ACCOUNT_SUCCESS: 'S007',
    /** Đã gửi liên hệ thành công. Chúng tôi sẽ liên lạc trong thời gian sớm nhất. Cảm ơn bạn đã quan tâm đến các sản phẩm của VBO Solution */
    SUBMIT_CONTACT_SUCCESS: 'S008',
    /** Cảm ơn bạn đã đánh giá sản phẩm của chúng tôi. Chúng tôi sẽ tiếp nhận ý kiến và cải thiện dịch vụ ngày một tốt hơn */
    SUBMIT_REVIEW_SUCCESS: 'S009',
    /** Chúng tôi đã gửi lại thông tin kích hoạt tài khoản đến email mà bạn đã đăng ký. Vui lòng kiểm tra email để kích hoạt tài khoản */
    RESEND_EMAIL_SUCCESS: 'S010',
    /** Việc tạo lại file javascript này có thể gây ra một số thay đổi không mong muốn cho hệ thống, bạn có muốn tiếp tục không? */
    WARNING_CREATE_JS: 'W001',
    /** Bạn đã thay đổi link SEO của blog này, nếu tiếp tục lưu tất cả dữ liệu SEO của blog này sẽ bị mất, bạn có muốn tiếp tục không? */
    WARNING_CHANGE_TUTORIAL_BEAUTYID: 'W003',
    /** Khi lưu tạm, blog này sẽ không  xuất hiện trên trang chủ. Bạn cũng đã thay đổi link SEO, nếu tiếp tục lưu tất cả dữ liệu SEO của blog này sẽ bị mất, bạn có muốn tiếp tục không? */
    WARNING_TEMP_SAVE_CHANGE_TUTORIAL_BEAUTYID: 'W004',
    /** Dữ liệu bạn thay đổi vẫn chưa được lưu, bạn có muốn tiếp tục không? */
    WARNING_NOT_SAVE_CHANGE: 'W005',
    /** Bạn đã thay đổi link SEO của nhóm blog này, nếu tiếp tục lưu tất cả dữ liệu SEO của nhóm blog này sẽ bị mất, bạn có muốn tiếp tục không? */
    WARNING_CHANGE_SERIES_BEAUTYID: 'W006',
    /** Khi lưu tạm, nhóm blog này sẽ không  xuất hiện trên trang chủ. Bạn cũng đã thay đổi link SEO, nếu tiếp tục lưu tất cả dữ liệu SEO của nhóm blog này sẽ bị mất, bạn có muốn tiếp tục không? */
    WARNING_TEMP_SAVE_CHANGE_SERIES_BEAUTYID: 'W007',
    /** Bạn đã thay đổi link SEO của sản phẩm này, nếu tiếp tục lưu tất cả dữ liệu SEO của product này sẽ bị mất, bạn có muốn tiếp tục không? */
    WARNING_CHANGE_PRODUCT_BEAUTYID: 'W008',
    /** Khi ở trạng thái ẩn, sản phẩm này này sẽ không  xuất hiện trên trang chủ. Bạn cũng đã thay đổi link SEO, nếu tiếp tục lưu tất cả dữ liệu SEO của sản phẩm này sẽ bị mất, bạn có muốn tiếp tục không? */
    WARNING_HDDEN_CHANGE_PRODUCT_BEAUTYID: 'W009'
};