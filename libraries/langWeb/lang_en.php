<?php 
	/**
	 * Application Main Page That Will Serve All Requests
	 * @package PRO CODE BMWEB FRAMEWORK
	 * @author  AP CAO
	 * @version 1.0.0
	 * @license https://bmweb.vn
	 * @PHP >=5.6
	 */

	@define('_timkiem', 'Search');
	@define('_tuvanbanhang', 'Sales Consultant');
	@define('_goingay', 'Call now');
	@define('_goimuahang_gio', 'Call for purchases (8h-21h)');
	@define('_goikhieunai_gio', 'Call appeal (8h-21h)');
	@define('_tatcacacngaytrongtuan', 'All days of the week');
	@define('_cacngaytrongtuantrule', 'Days of the week (except holidays)');
	@define('_theo_doi_ngay', 'Follow now');
	@define('_theo_doi', 'Follow');
	@define('_lien_he_chung_toi', 'Contact us');
	@define('_gioi_thieu_ve_chung_toi', 'About us');
	/*Newsletter*/
	@define('_nhanuudaingay', 'Get a discount now');
	@define('_nhap_email_cua_ban', 'Enter your email');
	/*Contact*/
	@define('_gui_yeu_cau_cho_chung_toi', 'Send us a request');
	@define('_nhap_noi_dung_can_lien_he', 'Enter text to contact');
	@define('_gui_lien_he_cua_ban', 'Send your contact');
	/*Menu*/
	@define('_trangchu', 'Home');
	@define('_gioithieu', 'Introduction');
	@define('_sanpham', 'Products');
	@define('_tintuc', 'News');
	@define('_tuyendung', 'Recruitment');
	@define('_dichvu', 'Services');
	@define('_congtrinh', 'Works');
	@define('_duan', 'Project');
	@define('_lienhe', 'Contact');
	@define('_chinhsach_kh', 'Customer Policy');
	@define('_huongdan_kh', 'Customer guide');
	@define('_thongtin_congty', 'Company information');
	@define('_baiviet', 'Posts');
	@define('_dieukhoansudung', 'Terms of use');
	@define('_chinhsachbaomat', 'Privacy Policy');

	/*Product*/
	@define('_ban_chay', 'bestseller');
	@define('_moi_nhat', 'latest');
	@define('_da_xem', 'viewed');
	@define('_xem_tat_ca', 'View all');
	@define('_xem_nhanh', 'Quick view');
	@define('_xem_chi_tiet', 'View details');
	@define('_danh_muc', 'Category');
	@define('_tinh_trang', 'Status');
	@define('_het_hang', 'Out of stock');
	@define('_con_hang', 'In stock');
	@define('_tiet_kiem_duoc', 'Save');
	@define('_mau_sac', 'Color');
	@define('_kich_thuoc', 'Size');
	@define('_them_vao_gio_hang', 'Add to cart');
	@define('_dat_hang_giao_tan_noi', 'Order delivery');
	@define('_buy_ngay', 'Buy now');
	@define('_goi', 'Call');
	@define('_de_duoc_tu_van', 'for advice and purchase');
	@define('_chi_tiet', 'Details');
	@define('_binh_luan', 'Comment');
	@define('_gia_tang_dan', 'Incremental price');
	@define('_gia_giam_dan', 'Descending price');
	@define('_hang_moi_nhat', 'Latest products');
	@define('_hang_cu_nhat', 'Oldest item');
	@define('_voi_tu_khoa', 'With the keyword');
	@define('_co', 'there are');
	@define('_sap_xep', 'Sort by');
	/*Post*/
	@define('_tin_lien_quan', 'Related news');
	@define('_doc_tiep', 'Read more');

	/*Account*/
	@define('_taikhoan', 'Account');
	@define('_thongtin', 'Information');
	@define('_taikhoan_kh', _taikhoan. 'customer');
	@define('_quan_ly_tai_khoan', 'Account management');
	@define('_thong_tin_ca_nhan', 'Personal Information');
	@define('_doi', 'Change');
	@define('_quen', 'Forgot');
	@define('_matkhau', 'password');
	@define('_nhap_mat_khau', 'Enter password');
	@define('_mat_khau', 'Password');
	@define('_thay_doi', 'Change');
	@define('_tao_tai_khoan', 'Create account');
	@define('_ban_da_yeu_cau_tao_tai_khoan', 'You have requested to create an account');
	@define('_de_kich_hoat_nhan_link_duoi', 'To activate the newly created account, please click the button below.');
	@define('_kich_hoat', 'Activate');
	@define('_lien_he_dich_vu_247', 'For any problems, contact our customer service 24/7');
	@define('_de_cap_den_id_khi_lien_he', 'When contacting support, be sure to mention your user ID');
	@define('_email_tu_dong', 'This is an automated email, please do not reply');
	@define('_yeu_cau_thay_doi_mat_khau', 'You have requested a password change for the account');
	@define('_mat_khau_thay_doi_la', 'Your password has been changed to');
	@define('_thong_bao_dang_ky_thanh_vien', 'Registration notice');
	@define('_thong_bao_dang_ky_thanh_vien_thanh_cong', 'Notice of successful member registration. Please go to the email you have registered to activate the account you have registered');
	@define('_thong_bao_email_that_bai', 'The system could not send your contact message. Please contact directly to be registered');

	@define('_thong_bao_thay_doi_mat_khau_thanh_vien', 'Notice of changing login password');
	@define('_thong_bao_thay_doi_mat_khau_thanh_vien_thanh_cong', 'You will receive a new password email. Please use that password to log in and change your new password again.');

	@define('_cu_', 'old');
	@define('_moi_', 'new');
	@define('_xac_nhan_', 'confirm');
	@define('_dangxuat', 'Log out');
	@define('_dangnhap', 'Login');
	@define('_dangky', 'Register');
	@define('_so_diachi', 'Address book');
	@define('_cap_nhat_dia_chi_thanh_cong', 'Successfully updated address');
	@define('_them_dia_chi_thanh_cong', 'Successfully added the address');

	@define('_danhsach', 'List');
	@define('_donhang', 'order');
	@define('_doitra', 'return and exchange');
	@define('_huy', 'cancel');
	@define('_hoac', 'or');
	@define('_nhap_email_lay_mat_khau', 'Enter your email address to retrieve your password via email.');
	@define('_lay_lai_mat_khau', 'Retrieve password');

	@define('_chua_co_tai_khoan_dang_ky_tai_day', 'You do not have an account. Sign up <a href="account/dang-ky" title="Sign up">here. </a>');
	@define('_da_co_tai_khoan_dang_nhap_tai_day', 'You already have an account. Sign in <a href="account/dang-nhap" title="Sign in">here. </a>');
	@define('_used_mat_khau_nhan_tai_day', 'Forgot your password? <a href="account/quen-mat-khau" class="btn-link-style" title="Click here">Click here </a> ');
	@define('_cam_ket_dang_ky_dang_nhap', 'We are committed to privacy and will never post or share information without your consent.');

	/*Cart*/
	@define('_empty_product_cart', 'The product has not been added to the shopping cart');
	@define('_cart_payment_empty', 'You will not be able to pay the order if there is no product?');
	@define('_thong_tin_don_hang', 'Order information');
	@define('_thong_bao_don_hang', 'Order notice');
	@define('_thong_tin_mua_hang', 'Purchase information');
	@define('_thong_tin_nhan_hang', 'Receipt information');
	@define('_thong_tin_dat_hang', 'Order information');
	@define('_thong_tin_nguoi_dat', 'Order information');
	@define('_thong_tin_nguoi_nhan', 'Recipient Information');
	@define('_chi_tiet_don_hang', 'Line item');
	@define('_quan_ly_don_hang', 'Order management');
	@define('_don_hang_cua_toi', 'My orders');
	@define('_don_hang_doi_tra', 'Return order');
	@define('_don_hang_huy', 'Order canceled');
	@define('_don_hang', 'Order');
	@define('_ma_don_hang', 'Mã Mã');
	@define('_quay_ve_trang_chu', 'Return to Home Page');
	@define('_giao_hang_den_dia_chi_khac', 'Ship to another address');
	@define('_quay_ve_gio_hang', 'Back to cart');
	@define('_di_den_gio_hang', 'Go to cart');
	@define('_dat_hang', 'Order');
	@define('_nhap_ma_giam_gia', 'Enter discount code');
	@define('_ngay_dat', 'Date set');
	@define('_hinh', 'Image');
	@define('_ma_san_pham', 'Code SP');
	@define('_ten_san_pham', 'Product name');
	@define('_gia_ban', 'Price');
	@define('_don_gia', 'Application for sale');
	@define('_so_luong', 'Quantity');
	@define('_thanh_tien', 'Amount');
	@define('_tong_tien', 'Total money');
	@define('_thanh_toan', 'payment');
	@define('_da', 'Already');
	@define('_chua', 'Not yet');
	@define('_da_tra_hang', 'Returned');
	@define('_tra_hang', 'Return');
	@define('_ma_tra_hang', 'Return code');
	@define('_da_tra_hang_thanh_cong', 'Successfully returned goods');
	@define('_da_tra_hang_that_bai', 'Returned failed');
	@define('_don_hang_da_duoc_tra', 'This order has been paid');
	@define('_gio_hang_rong', 'No products in the cart');

	@define('_ngay_tra', 'Date paid');
	@define('_so_tien', 'Amount');
	@define('_ap_dung', 'Apply');
	@define('_bo_ap_dung', 'Skip apply');
	@define('_van_chuyen', 'Shipping');
	@define('_tam_tinh', 'Temporarily');
	@define('_giam_gia', 'Discount');
	@define('_gio_hang', 'Shopping cart');
	@define('_thanh_toan', 'Payment');
	@define('_xac_nhan', 'Confirmation');
	@define('_ban_da_them', 'You have added');
	@define('_vao_gio_hang_thanh_cong', 'successfully entered the shopping cart');
	@define('_gio_hang_cua_ban_co', 'Your shopping cart has');
	@define('_xoa', 'Delete');
	@define('_tong_tien_thanh_toan', 'Total payment');
	@define('_thuc_hien_thanh_toan', 'Make payment');
	@define('_tiep_tuc_mua_hang', 'Continue shopping');
	@define('_tien_hanh_thanh_toan', 'Proceed to checkout');

	/*Info*/
	@define('_nhap', 'Enter');
	@define('_ho_ten', 'Full name');
	@define('_nhap_ho_ten', 'Enter full name');
	@define('_dia_chi', 'Address');
	@define('_nhap_dia_chi', 'Enter address');
	@define('_dien_thoai', 'Phone');
	@define('_nhap_dien_thoai', 'Enter phone');
	@define('_nhap_email', 'Enter email address');
	@define('_ngay_sinh', 'Date of birth');
	@define('_khu_vuc', 'Area');
	@define('_trang_thai', 'Status');
	@define('_thao_tac', 'Actions');
	@define('_mac_dinh', 'default');
	@define('_macdinh', 'Default');
	@define('_ban_co_chac_chan_muon_xoa', 'Are you sure you want to delete');
	@define('_them_dia_chi_moi', 'Add new address');
	@define('_sua', 'Edit');
	@define('_xem', 'view');
	@define('_tinh_thanh', 'Province');
	@define('_chon_tinh_thanh', 'Select province');
	@define('_quan_huyen', 'District');
	@define('_chon_quan_huyen', 'Select district');
	@define('_phuong_xa', 'Ward');
	@define('_chon_phuong_xa', 'Select ward');
	@define('_ghi_chu', 'Note');
	@define('_loai_dia_chi', 'Address type');
	@define('_nha_rieng', 'Home');
	@define('_cong_ty', 'Company');
	@define('_cap_nhat_thay_doi', 'Update changes');
	@define('_luu_them_moi', 'Save as new');

	/*Notification*/

	@define('_thong_bao_them_du_lieu_thanh_cong', 'Successfully added data');
	@define('_thong_bao_he_thong_gui_don_hang_loi', 'The system could not send your application information. Please contact us directly for confirmation!');
	@define('_thong_bao_xoa_ma_giam_gia_thanh_cong', 'Removed the discount code in use');
	@define('_thong_bao_su_dung_ma_giam_gia', 'You can use this discount code. span style = "color: red;"> Note: Click the <span style="color: red; font-weight: bold;">\'Apply\'</span> if you want to use this code. If you do not click the button above you will not be able to apply this code. </span> ');
	@define('_thong_bao_su_dung_ma_giam_gia_qua_han', 'This discount code does not exist or expires or has not been used');
	@define('_thong_bao_gui_mail_thanh_cong', 'We will respond to you as soon as possible');
	@define('_lien_he_den_tu', 'Contact from');
	@define('_thong_bao_gui_mail_that_bai', 'The system could not send your contact message. Please contact us directly for advice');
	@define('_thong_bao_spam_he_thong', 'You have spam the system please stop immediately');
	@define('_email_sai_dinh_dang', 'Email is malformed');
	@define('_khong_duoc_de_trong', 'Do not leave blank');
	@define('_dien_thoai_sai_dinh_dang', 'Invalid phone number');
	@define('_sai_dang_nhap', 'Email or password is incorrect or this account has not been activated.');
	@define('_du_lieu_khong_thoa_dieu_kien', 'The data does not meet the conditions.');
	@define('_da_cap_nhat_thanh_cong', 'Successfully updated information');
	@define('_mat_khau_cu_va_moi_trung', 'Old and new passwords must not be duplicated');
	@define('_da_thay_doi_mat_khau', 'Password changed');
	@define('_email_khong_ton_tai', 'This email does not exist');
?>