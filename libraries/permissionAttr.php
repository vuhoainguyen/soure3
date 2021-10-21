<?php 
	/**
	 * Application Main Page That Will Serve All Requests
	 * @package PRO CODE BMWEB FRAMEWORK
	 * @author  AP CAO
	 * @version 1.0.0
	 * @license https://bmweb.vn
	 * @PHP >=5.6
	 */

	$permission_attr = array(
		array(
			'name' => 'Quản lý sản phẩm cấp 1',
			'com' => 'lists',
			'type' => 'san-pham',
			'act' => array('man'=>'Xem','add'=>'Thêm','edit'=>'Sửa','delete'=>'Xóa','save'=>'Lưu','status'=>'Trạng thái')
		),
		array(
			'name' => 'Quản lý sản phẩm cấp 2',
			'com' => 'cats',
			'type' => 'san-pham',
			'act' => array('man'=>'Xem','add'=>'Thêm','edit'=>'Sửa','delete'=>'Xóa','save'=>'Lưu','status'=>'Trạng thái')
		),
		array(
			'name' => 'Quản lý sản phẩm cấp 3',
			'com' => 'items',
			'type' => 'san-pham',
			'act' => array('man'=>'Xem','add'=>'Thêm','edit'=>'Sửa','delete'=>'Xóa','save'=>'Lưu','status'=>'Trạng thái')
		),
		array(
			'name' => 'Quản lý sản phẩm cấp 4',
			'com' => 'subs',
			'type' => 'san-pham',
			'act' => array('man'=>'Xem','add'=>'Thêm','edit'=>'Sửa','delete'=>'Xóa','save'=>'Lưu','status'=>'Trạng thái')
		),
		array(
			'name' => 'Quản lý sản phẩm',
			'com' => 'products',
			'type' => 'san-pham',
			'act' => array('man'=>'Xem','add'=>'Thêm','edit'=>'Sửa','delete'=>'Xóa','save'=>'Lưu','status'=>'Trạng thái')
		),
		array(
			'name' => 'Quản lý tin tức cấp 1',
			'com' => 'lists',
			'type' => 'tin-tuc',
			'act' => array('man'=>'Xem','add'=>'Thêm','edit'=>'Sửa','delete'=>'Xóa','save'=>'Lưu','status'=>'Trạng thái')
		),
		array(
			'name' => 'Quản lý tin tức',
			'com' => 'posts',
			'type' => 'tin-tuc',
			'act' => array('man'=>'Xem','add'=>'Thêm','edit'=>'Sửa','delete'=>'Xóa','save'=>'Lưu','status'=>'Trạng thái')
		),
		array(
			'name' => 'Quản lý giới thiệu',
			'com' => 'pages',
			'type' => 'gioi-thieu',
			'act' => array('update'=>'Xem và cập nhật')
		),
		array(
			'name' => 'Quản lý dịch vụ',
			'com' => 'pages',
			'type' => 'dich-vu',
			'act' => array('update'=>'Xem và cập nhật')
		),
		array(
			'name' => 'Quản lý logo',
			'com' => 'photos',
			'type' => 'logo',
			'act' => array('update'=>'Xem và cập nhật')
		),
		array(
			'name' => 'Quản lý hình share',
			'com' => 'photos',
			'type' => 'share',
			'act' => array('update'=>'Xem và cập nhật')
		),
		array(
			'name' => 'Quản lý hình slider',
			'com' => 'multi_photos',
			'type' => 'slider',
			'act' => array('man'=>'Xem','add'=>'Thêm','edit'=>'Sửa','delete'=>'Xóa','save'=>'Lưu','status'=>'Trạng thái')
		),
		array(
			'name' => 'Quản lý clips',
			'com' => 'videos',
			'type' => 'clips',
			'act' => array('man'=>'Xem','add'=>'Thêm','edit'=>'Sửa','delete'=>'Xóa','save'=>'Lưu','status'=>'Trạng thái')
		),
		array(
			'name' => 'Quản lý khách hàng',
			'com' => 'customers',
			'type' => 'member',
			'act' => array('man'=>'Xem','add'=>'Thêm','edit'=>'Sửa','delete'=>'Xóa','save'=>'Lưu','status'=>'Trạng thái')
		),
		array(
			'name' => 'Quản lý đơn hàng',
			'com' => 'orders',
			'type' => 'don-hang',
			'act' => array('man'=>'Xem','add'=>'Thêm','edit'=>'Sửa','delete'=>'Xóa','save'=>'Lưu','status'=>'Trạng thái','export'=>'Xuất file','print'=>'In file','return'=>'Trả hàng')
		),
		array(
			'name' => 'Quản lý đăng ký nhận tin',
			'com' => 'newsletters',
			'type' => 'email',
			'act' => array('man'=>'Xem','add'=>'Thêm','edit'=>'Sửa','delete'=>'Xóa','save'=>'Lưu','status'=>'Trạng thái','send'=>'Gửi mail')
		),
		array(
			'name' => 'Quản lý danh sách tin gửi',
			'com' => 'sends',
			'type' => 'email',
			'act' => array('man'=>'Xem','edit'=>'Chi tiết','delete'=>'Xóa')
		),
		array(
			'name' => 'Quản lý danh sách liên hệ',
			'com' => 'contacts',
			'type' => 'contact',
			'act' => array('man'=>'Xem','edit'=>'Cập nhật','save'=>'Lưu','delete'=>'Xóa','status'=>'Trạng thái')
		),
		array(
			'name' => 'Quản lý profile',
			'com' => 'users',
			'type' => 'null',
			'act' => array('profile'=>'Xem và cập nhật')
		),
		array(
			'name' => 'Quản lý cấu hình website',
			'com' => 'settings',
			'type' => 'null',
			'act' => array('update'=>'Xem và cập nhật')
		),
		array(
			'name' => 'Quản lý tags sản phẩm',
			'com' => 'tags',
			'type' => 'san-pham',
			'act' => array('man'=>'Xem','add'=>'Thêm','edit'=>'Sửa','delete'=>'Xóa','save'=>'Lưu','status'=>'Trạng thái')
		),
		array(
			'name' => 'Quản lý tỉnh thành',
			'com' => 'place_citys',
			'type' => 'null',
			'act' => array('man'=>'Xem','add'=>'Thêm','edit'=>'Sửa','delete'=>'Xóa','save'=>'Lưu','status'=>'Trạng thái')
		),
	);
?>