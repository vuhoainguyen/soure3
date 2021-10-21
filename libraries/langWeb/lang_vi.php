<?php 
	/**
	 * Application Main Page That Will Serve All Requests
	 * @package PRO CODE BMWEB FRAMEWORK
	 * @author  AP CAO
	 * @version 1.0.0
	 * @license https://bmweb.vn
	 * @PHP >=5.6
	 */
	@define('_timkiem', 'Tìm kiếm');
	@define('_tuvanbanhang', 'Tư vấn bán hàng');
	@define('_goingay', 'Gọi ngay');
	@define('_goimuahang_gio', 'Gọi mua hàng (8h-21h)');
	@define('_goikhieunai_gio', 'Gọi khiếu nại (8h-21h)');
	@define('_tatcacacngaytrongtuan', 'Tất cả các ngày trong tuần');
	@define('_cacngaytrongtuantrule', 'Các ngày trong tuần (trừ ngày lễ)');
	@define('_theo_doi_ngay', 'Theo dõi ngay');
	@define('_theo_doi', 'Theo dõi');
	@define('_lien_he_chung_toi', 'Liên hệ với chúng tôi');
	@define('_gioi_thieu_ve_chung_toi', 'Giới thiệu về chúng tôi');
	/*Newsletter*/
	@define('_nhanuudaingay', 'Nhận ưu đãi ngay');
	@define('_nhap_email_cua_ban', 'Nhập email của bạn');
	/*Contact*/
	@define('_gui_yeu_cau_cho_chung_toi', 'Gửi yêu cầu cho chúng tôi');
	@define('_nhap_noi_dung_can_lien_he', 'Nhập nội dung cần liên hệ');
	@define('_gui_lien_he_cua_ban', 'Gửi liên hệ của bạn');
	/*Menu*/
	@define('_trangchu', 'Trang chủ');
	@define('_banggiaxe', 'Bảng giá xe');
	@define('_xedaquasudung', 'Xe đã qua sử dụng');
	@define('_tuvanxe', 'Tư vấn xe');
	@define('_vechungtoi', 'Về chúng tôi');
	@define('_gioithieu', 'Giới thiệu');
	@define('_sanpham', 'Sản phẩm');
	@define('_tintuc', 'Tin tức');
	@define('_dichvu', 'Dịch vụ');
	@define('_thuvien', 'Thư viện');
	@define('_video', 'Video');
	@define('_tuyendung', 'Tuyển dụng');
	@define('_dichvu', 'Dịch vụ');
	@define('_congtrinh', 'Công trình');
	@define('_duan', 'Dự án');
	@define('_lienhe', 'Liên hệ');
	@define('_chinhsach', 'Chính sách');
	@define('_chinhsach_ud_kh', 'Chính sách ưu đãi khách hàng');
	@define('_chinhsach_kh', 'Chính sách khách hàng');
	@define('_huongdan_kh', 'Hỗ trợ khách hàng');
	@define('_thongtin_congty', 'Thông tin công ty');
	@define('_baiviet', 'Bài viết');
	@define('_dieukhoansudung', 'Điều khoản sử dụng');
	@define('_chinhsachbaomat', 'Chính sách bảo mật');
	@define('_doitactieubieu', 'Đối tác tiêu biểu');
	@define('_thongketruycap', 'Thống kê truy cập');
	@define('_chuyenmucxe', 'Chuyên mục xe');

	/*Product*/
	@define('_noi_bat', 'nổi bật');
	@define('_ban_chay', 'bán chạy');
	@define('_moi_nhat', 'mới nhất');
	@define('_lien_quan', 'liên quan');
	@define('_khuyen_mai', 'khuyến mãi');
	@define('_da_xem', 'đã xem');
	@define('_xem_tat_ca', 'Xem tất cả');
	@define('_xem_nhanh', 'Xem nhanh');
	@define('_xem_chi_tiet', 'Xem chi tiết');
	@define('_danh_muc', 'Danh mục');
	@define('_tinh_trang', 'Tình trạng');
	@define('_het_hang', 'Hết hàng');
	@define('_con_hang', 'Còn hàng');
	@define('_tiet_kiem_duoc', 'Tiết kiệm được');
	@define('_mau_sac', 'Màu sắc');
	@define('_kich_thuoc', 'Kích thước');
	@define('_them_vao_gio_hang', 'Thêm giỏ hàng');
	@define('_dat_hang_giao_tan_noi', 'Đặt mua giao hàng tận nơi');
	@define('_mua_ngay', 'Mua ngay');
	@define('_goi', 'Gọi');
	@define('_de_duoc_tu_van', 'để được tư vấn và mua hàng');
	@define('_chi_tiet', 'Chi tiết');
	@define('_binh_luan', 'Bình luận');
	@define('_gia_tang_dan', 'Giá tăng dần');
	@define('_gia_giam_dan', 'Giá giảm dần');
	@define('_hang_moi_nhat', 'Hàng mới nhất');
	@define('_hang_cu_nhat', 'Hàng cũ nhất');
	@define('_voi_tu_khoa', 'Với từ khóa');
	@define('_co', 'có');
	@define('_sap_xep', 'Sắp xếp');


	/*Post*/
	@define('_tin_lien_quan', 'Tin liên quan');
	@define('_doc_tiep', 'Đọc tiếp');
	
	/*Account*/
	@define('_taikhoan', 'Tài khoản');
	@define('_thongtin', 'Thông tin');
	@define('_taikhoan_kh', _taikhoan.' khách hàng');
	@define('_quan_ly_tai_khoan', 'Quản lý tài khoản');
	@define('_thong_tin_ca_nhan', 'Thông tin cá nhân');
	@define('_doi', 'Đổi');
	@define('_quen', 'Quên');
	@define('_matkhau', 'mật khẩu');
	@define('_nhap_mat_khau', 'Nhập mật khẩu');
	@define('_mat_khau', 'Mật khẩu');
	@define('_thay_doi', 'Thay đổi');
	@define('_tao_tai_khoan', 'Tạo tài khoản');
	@define('_ban_da_yeu_cau_tao_tai_khoan', 'Bạn đã yêu cầu tạo tài khoản');
	@define('_de_kich_hoat_nhan_link_duoi', 'Để kích hoạt tài khoản vừa tạo, vui lòng nhấp vào nút bên dưới.');
	@define('_kich_hoat', 'Kích hoạt');
	@define('_lien_he_dich_vu_247', 'Đối với bất kỳ vấn đề, liên hệ với dịch vụ khách hàng của chúng tôi 24/7');
	@define('_de_cap_den_id_khi_lien_he', 'Khi liên hệ với bộ phận hỗ trợ, hãy đảm bảo đề cập đến ID người dùng của bạn');
	@define('_email_tu_dong', 'Đây là một email tự động, xin vui lòng đừng trả lời');
	@define('_yeu_cau_thay_doi_mat_khau', 'Bạn đã yêu cầu thay đổi mật khẩu cho tài khoản');
	@define('_mat_khau_thay_doi_la', 'Mật khẩu của bạn được thay đổi là');
	@define('_thong_bao_dang_ky_thanh_vien', 'Thông báo đăng ký thành viên');
	@define('_thong_bao_dang_ky_thanh_vien_thanh_cong', 'Thông báo đăng ký thành viên thành công. Vui lòng vào email đã đăng ký kích hoạt tài khoản vừa đăng ký');
	@define('_thong_bao_email_that_bai', 'Hệ thống không thể gửi thư liên hệ của bạn. Vui lòng liên hệ trực tiếp để được đăng ký');

	@define('_thong_bao_thay_doi_mat_khau_thanh_vien', 'Thông báo thay đổi mật khẩu đăng nhập');
	@define('_thong_bao_thay_doi_mat_khau_thanh_vien_thanh_cong', 'Bạn sẽ nhận được email mật khẩu mới. Vui lòng dùng mật khẩu đó đăng nhập và thay đổi lại mật khẩu mới.');

	@define('_cu_', 'cũ');
	@define('_moi_', 'mới');
	@define('_xac_nhan_', 'xác nhận');
	@define('_dangxuat', 'Đăng xuất');
	@define('_dangnhap', 'Đăng nhập');
	@define('_dangky', 'Đăng ký');
	@define('_so_diachi', 'Sổ địa chỉ');
	@define('_cap_nhat_dia_chi_thanh_cong', 'Đã cập nhật địa chỉ thành công');
	@define('_them_dia_chi_thanh_cong', 'Đã thêm địa chỉ thành công');

	@define('_danhsach', 'Danh sách');
	@define('_donhang', 'đơn hàng');
	@define('_doitra', 'đổi trả');
	@define('_huy', 'hủy');
	@define('_hoac', 'hoặc');
	@define('_nhap_email_lay_mat_khau', 'Nhập địa chỉ email để lấy lại mật khẩu qua email.');
	@define('_lay_lai_mat_khau', 'Lấy lại mật khẩu');
	@define('_chua_co_tai_khoan_dang_ky_tai_day', 'Bạn chưa có tài khoản. Đăng ký <a href="account/dang-ky" title="Đăng ký">tại đây.</a>');
	@define('_da_co_tai_khoan_dang_nhap_tai_day', 'Bạn đã có tài khoản. Đăng nhập <a href="account/dang-nhap" title="Đăng nhập">tại đây.</a>');
	@define('_quen_mat_khau_nhan_tai_day', 'Bạn quên mật khẩu? <a href="account/quen-mat-khau" class="btn-link-style" title="Nhấn tại đây">Nhấn tại đây</a>');
	@define('_cam_ket_dang_ky_dang_nhap', 'Chúng tôi cam kết bảo mật và sẽ không bao giờ đăng <br>hay chia sẻ thông tin mà chưa có được sự đồng ý của bạn.');
	/*Cart*/
	@define('_empty_product_cart', 'Sản phẩm chưa được thêm vào giỏ hàng');
	@define('_cart_payment_empty', 'Bạn sẽ không thanh toán được đơn hàng nếu không có sản phẩm nào?');
	@define('_thong_tin_don_hang', 'Thông tin đơn hàng');
	@define('_thong_bao_don_hang', 'Thông báo đơn hàng');
	@define('_thong_tin_mua_hang', 'Thông tin mua hàng');
	@define('_thong_tin_nhan_hang', 'Thông tin nhận hàng');
	@define('_thong_tin_dat_hang', 'Thông tin đặt hàng');
	@define('_thong_tin_nguoi_dat', 'Thông tin người đặt');
	@define('_thong_tin_nguoi_nhan', 'Thông tin người nhận');
	@define('_chi_tiet_don_hang', 'Chi tiết đơn hàng');
	@define('_quan_ly_don_hang', 'Quản lý đơn hàng');
	@define('_don_hang_cua_toi', 'Đơn hàng của tôi');
	@define('_don_hang_doi_tra', 'Đơn hàng đổi trả');
	@define('_don_hang_huy', 'Đơn hàng hủy');
	@define('_don_hang', 'Đơn hàng');
	@define('_ma_don_hang', 'Mã ĐH');
	@define('_quay_ve_trang_chu', 'Quay về Trang chủ');
	@define('_giao_hang_den_dia_chi_khac', 'Giao hàng đến địa chỉ khác');
	@define('_quay_ve_gio_hang', 'Quay về giỏ hàng');
	@define('_di_den_gio_hang', 'Đi đến giỏ hàng');
	@define('_dat_hang', 'Đặt hàng');
	@define('_nhap_ma_giam_gia', 'Nhập mã giảm giá');
	@define('_ngay_dat', 'Ngày đặt');
	@define('_hinh', 'Hình');
	@define('_ma_san_pham', 'Mã SP');
	@define('_ten_san_pham', 'Tên sản phẩm');
	@define('_gia_ban', 'Giá bán');
	@define('_don_gia', 'Đơn bán');
	@define('_so_luong', 'Số lượng');
	@define('_thanh_tien', 'Thành tiền');
	@define('_tong_tien', 'Tổng tiền');
	@define('_thanh_toan', 'Thanh toán');
	@define('_da', 'Đã');
	@define('_chua', 'Chưa');
	@define('_da_tra_hang', 'Đã trả hàng');
	@define('_tra_hang', 'Trả hàng');
	@define('_ma_tra_hang', 'Mã trả hàng');
	@define('_da_tra_hang_thanh_cong', 'Đã trả hàng thành công');
	@define('_da_tra_hang_that_bai', 'Đã trả hàng thất bại');
	@define('_don_hang_da_duoc_tra', 'Đơn hàng này đã được trả');
	@define('_gio_hang_rong', 'Không có sản phẩm nào trong giỏ hàng');

	
	@define('_ngay_tra', 'Ngày trả');
	@define('_so_tien', 'Số tiền');
	@define('_ap_dung', 'Áp dụng');
	@define('_bo_ap_dung', 'Bỏ áp dụng');
	@define('_van_chuyen', 'Vận chuyển');
	@define('_tam_tinh', 'Tạm tính');
	@define('_giam_gia', 'Giảm giá');
	@define('_gio_hang', 'Giỏ hàng');
	@define('_thanh_toan', 'Thanh toán');
	@define('_xac_nhan', 'Xác nhận');
	@define('_ban_da_them', 'Bạn đã thêm');
	@define('_vao_gio_hang_thanh_cong', 'vào giỏ hàng thành công');
	@define('_gio_hang_cua_ban_co', 'Giỏ hàng của bạn có');
	@define('_xoa', 'Xoá');
	@define('_tong_tien_thanh_toan', 'Tổng tiền thanh toán');
	@define('_thuc_hien_thanh_toan', 'Thực hiện thanh toán');
	@define('_tiep_tuc_mua_hang', 'Tiếp tục mua hàng');
	@define('_tien_hanh_thanh_toan', 'Tiến hành thanh toán');
	/*Info*/
	@define('_nhap', 'Nhập');
	@define('_ho_ten', 'Họ tên');
	@define('_nhap_ho_ten', 'Nhập họ tên');
	@define('_dia_chi', 'Địa chỉ');
	@define('_nhap_dia_chi', 'Nhập địa chỉ');
	@define('_dien_thoai', 'Điện thoại');
	@define('_nhap_dien_thoai', 'Nhập điện thoại');
	@define('_nhap_email', 'Nhập địa chỉ email');
	@define('_ngay_sinh', 'Ngày sinh');
	@define('_khu_vuc', 'Khu vực');
	@define('_trang_thai', 'Trạng thái');
	@define('_thao_tac', 'Thao tác');
	@define('_mac_dinh', 'mặc định');
	@define('_macdinh', 'Mặc định');
	@define('_ban_co_chac_chan_muon_xoa', 'Bạn có chắc chắn muốn xóa');
	@define('_them_dia_chi_moi', 'Thêm mới địa chỉ');
	@define('_sua', 'sửa');
	@define('_xem', 'xem');
	@define('_tinh_thanh', 'Tỉnh thành');
	@define('_chon_tinh_thanh', 'Chọn tỉnh thành');
	@define('_quan_huyen', 'Quận huyện');
	@define('_chon_quan_huyen', 'Chọn quận huyện');
	@define('_phuong_xa', 'Phường xã');
	@define('_chon_phuong_xa', 'Chọn phường xã');
	@define('_ghi_chu', 'Ghi chú');
	@define('_loai_dia_chi', 'Loại địa chỉ');
	@define('_nha_rieng', 'Nhà riêng');
	@define('_cong_ty', 'Công ty');
	@define('_cap_nhat_thay_doi', 'Cập nhật thay đổi');
	@define('_luu_them_moi', 'Lưu thêm mới');
	/*Notification*/
	@define('_thong_bao_them_du_lieu_thanh_cong', 'Đã thêm dữ liệu thành công');
	@define('_thong_bao_he_thong_gui_don_hang_loi', 'Hệ thống không thể gửi thư thông tin đơn của bạn. Vui lòng liên hệ trực tiếp để được xác nhận!');
	@define('_thong_bao_xoa_ma_giam_gia_thanh_cong', 'Đã xóa mã giảm giá đang sử dụng');
	@define('_thong_bao_su_dung_ma_giam_gia', 'Bạn có thể sử dụng mã giảm giá này. span style="color: red;">Lưu ý: Bấm vào nút <span style="color: red; font-weight: bold;">\'Áp dụng\'</span> nếu muốn sử dụng mã này. Nếu không bấm vào nút trên thì bạn sẽ không được áp dụng mã này.</span>');
	@define('_thong_bao_su_dung_ma_giam_gia_qua_han', 'Mã giảm giá này không tồn tại hoặc hết hạn sử dụng hoặc chưa được sử dụng');
	@define('_thong_bao_gui_mail_thanh_cong', 'Chúng tôi sẽ phản hồi bạn trong thời gian sớm nhất có thể');
	@define('_lien_he_den_tu', 'Liên hệ đến từ');
	@define('_thong_bao_gui_mail_that_bai', 'Hệ thống không thể gửi thư liên hệ của bạn. Vui lòng liên hệ trực tiếp để được tư vấn');
	@define('_thong_bao_spam_he_thong', 'Bạn đã spam hệ thống vui lòng dừng lại ngay');
	@define('_email_sai_dinh_dang', 'Email sai định dạng');
	@define('_khong_duoc_de_trong', 'Không được để trống');
	@define('_dien_thoai_sai_dinh_dang', 'Số điện thoại không hợp lệ');
	@define('_sai_dang_nhap', 'Email hoặc mật khẩu không đúng hoặc tài khoản này chưa được kích hoạt.');
	@define('_du_lieu_khong_thoa_dieu_kien', 'Dữ liệu không thỏa điểu kiện.');
	@define('_da_cap_nhat_thanh_cong', 'Đã cập nhật thông tin thành công');
	@define('_mat_khau_cu_va_moi_trung', 'Mật khẩu cũ và mới không được trùng nhau');
	@define('_da_thay_doi_mat_khau', 'Đã thay đổi mật khẩu');
	@define('_email_khong_ton_tai', 'Email này không tồn tại');


?>