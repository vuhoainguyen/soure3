<?php if(!defined('_lib')) die("Error");
	/**
	 * Application Main Page That Will Serve All Requests
	 * @package PRO CODE BMWEB FRAMEWORK
	 * @version 1.0.0
	 * @license https://bmweb.vn
	 * @PHP >=5.6
	 */
	error_reporting(0);
	// error_reporting(E_ALL & ~E_NOTICE & ~8192);
	date_default_timezone_set('Asia/Ho_Chi_Minh');

	@define ( 'NN_MSHD' , '2160220w');
	@define ( 'NN_AUTHOR' , '');

	$config = array(
		'arrayDomainSSL' => array(),
		'meta-seo-debug' => false,
		'debug-style' => true,
		'debug-reponsive' => true,
		'paging-table' => false,
		'website' => array(
			'url'=> $_SERVER["SERVER_NAME"].'/test/',
			'lang' => array(
				"vi" => "Tiếng Việt",
			),
			'salt'=>'^~{i^9UrpS',
			'secret'=>'$Bmweb@',
			'theme-color'=>'#7da312',
			'facebookId' => '161909414494428',
			'zaloId' => '3607710785381490435',
			'sitekey'=> '6LeTG6AUAAAAACF9tnHd-OKXzAQkOqcYEWj9guFp',
			'secretkey'=>'6LeTG6AUAAAAADW2lk77fUMRsqpEFTCndImkRXeA'
		),
		'database' => array(
			'type' => 'mysql',
			'host' => 'localhost',
			'username' => 'root',
			'password' => '',
			'dbname'=> 'Bmweb_huynhmyhanh_2160220w',
			'port' => 3306,
			'prefix' => 'table_',
			'charset' => 'utf8'
		),
		'mail' => array(
			'email' => 'autonoreply2016@gmail.com',
			'password' => 'QaWsEd123zxc',
			'ip' => 'smtp.gmail.com',
			'smtp' => true,
			'secure' => 'ssl',
			'port' => 465,
			'gmail' => true
		),
		'author' => array(
			'name' => 'Nguyễn Thành Thắng',
			'nickname' => 'James Nguyễn',
			'email' => ''
		),
		'login' => array(
			'check' => false,
			'social' => false,
			'google-client-id'=> '245416644166-o1rde1sh4nvj1vblg3bldggda4hgdsdi.apps.googleusercontent.com'
		),
		'order' => array(
			'export-detail' => false,
			'export-list' => false,
			'bill-print' => false,
			'payment' => array('Chưa thanh toán', 'Đã thanh toán')
		),
		'cart' => array(
			'check' => false,
			'advance' => false,
			'coupon' => false
		),
		'other' => array(
			'sortby' => false,
			'rating' => false,
			'detail' => false,
			'quickview' => false,
			'quick-add-products' => false,
			'permission' => false,
			'place' => false,
		),
		'login-admin' => array(
			'attempt' => 5,
			'delay' => 15
		),
		'version' => '1.0.0'
	);
	/*ABGNXATD*/
	/*Check SSL*/
	require_once _lib.'checkSSL.php';
	$check_ssl = new checkSSL();
	/*$runDomainName = $check_ssl->getCurrentPageURLSSL();
	$check_ssl->checkChangSLL($runDomainName,$config['arrayDomainSSL']);*/
	$http = $check_ssl->getProtocol();

	$config_url = $config['website']['url'];
	$config_base = $http.$config['website']['url'];
	
	$_SESSION['ck-folder'] = $config_base;

	require_once _lib.'contants.php';
?>