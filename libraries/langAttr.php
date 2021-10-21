<?php 
	/**
	 * Application Main Page That Will Serve All Requests
	 * @package PRO CODE BMWEB FRAMEWORK
	 * @author  AP CAO
	 * @version 1.0.0
	 * @license https://bmweb.vn
	 * @PHP >=5.6
	 */
	$lang_attr = array();	
	#Cats
	$lang_attr[0]['name'] = 'cats';
	$lang_attr[0]['value'][0]['name'] = 'name';
	$lang_attr[0]['value'][0]['type'] = 'VARCHAR(255)';

	$lang_attr[0]['value'][1]['name'] = 'alias';
	$lang_attr[0]['value'][1]['type'] = 'VARCHAR(255)';

	$lang_attr[0]['value'][2]['name'] = 'desc';
	$lang_attr[0]['value'][2]['type'] = 'TEXT';

	$lang_attr[0]['value'][3]['name'] = 'content';
	$lang_attr[0]['value'][3]['type'] = 'TEXT';

	$lang_attr[0]['value'][4]['name'] = 'title';
	$lang_attr[0]['value'][4]['type'] = 'VARCHAR(255)';

	$lang_attr[0]['value'][5]['name'] = 'description';
	$lang_attr[0]['value'][5]['type'] = 'TEXT';

	$lang_attr[0]['value'][6]['name'] = 'keywords';
	$lang_attr[0]['value'][6]['type'] = 'TEXT';

	#Lists
	$lang_attr[1]['name'] = 'lists';
	$lang_attr[1]['value'][0]['name'] = 'name';
	$lang_attr[1]['value'][0]['type'] = 'VARCHAR(255)';

	$lang_attr[1]['value'][1]['name'] = 'alias';
	$lang_attr[1]['value'][1]['type'] = 'VARCHAR(255)';

	$lang_attr[1]['value'][2]['name'] = 'desc';
	$lang_attr[1]['value'][2]['type'] = 'TEXT';

	$lang_attr[1]['value'][3]['name'] = 'content';
	$lang_attr[1]['value'][3]['type'] = 'TEXT';

	$lang_attr[1]['value'][4]['name'] = 'title';
	$lang_attr[1]['value'][4]['type'] = 'VARCHAR(255)';

	$lang_attr[1]['value'][5]['name'] = 'description';
	$lang_attr[1]['value'][5]['type'] = 'TEXT';

	$lang_attr[1]['value'][6]['name'] = 'keywords';
	$lang_attr[1]['value'][6]['type'] = 'TEXT';

	#Items
	$lang_attr[2]['name'] = 'items';
	$lang_attr[2]['value'][0]['name'] = 'name';
	$lang_attr[2]['value'][0]['type'] = 'VARCHAR(255)';
	
	$lang_attr[2]['value'][1]['name'] = 'alias';
	$lang_attr[2]['value'][1]['type'] = 'VARCHAR(255)';
	
	$lang_attr[2]['value'][2]['name'] = 'desc';
	$lang_attr[2]['value'][2]['type'] = 'TEXT';
	
	$lang_attr[2]['value'][3]['name'] = 'content';
	$lang_attr[2]['value'][3]['type'] = 'TEXT';
	
	$lang_attr[2]['value'][4]['name'] = 'title';
	$lang_attr[2]['value'][4]['type'] = 'VARCHAR(255)';
	
	$lang_attr[2]['value'][5]['name'] = 'description';
	$lang_attr[2]['value'][5]['type'] = 'TEXT';
	
	$lang_attr[2]['value'][6]['name'] = 'keywords';
	$lang_attr[2]['value'][6]['type'] = 'TEXT';

	#Subs
	$lang_attr[3]['name'] = 'subs';
	$lang_attr[3]['value'][0]['name'] = 'name';
	$lang_attr[3]['value'][0]['type'] = 'VARCHAR(255)';
	
	$lang_attr[3]['value'][1]['name'] = 'alias';
	$lang_attr[3]['value'][1]['type'] = 'VARCHAR(255)';
	
	$lang_attr[3]['value'][2]['name'] = 'desc';
	$lang_attr[3]['value'][2]['type'] = 'TEXT';
	
	$lang_attr[3]['value'][3]['name'] = 'content';
	$lang_attr[3]['value'][3]['type'] = 'TEXT';
	
	$lang_attr[3]['value'][4]['name'] = 'title';
	$lang_attr[3]['value'][4]['type'] = 'VARCHAR(255)';
	
	$lang_attr[3]['value'][5]['name'] = 'description';
	$lang_attr[3]['value'][5]['type'] = 'TEXT';
	
	$lang_attr[3]['value'][6]['name'] = 'keywords';
	$lang_attr[3]['value'][6]['type'] = 'TEXT';

	#Posts
	$lang_attr[4]['name'] = 'posts';
	$lang_attr[4]['value'][0]['name'] = 'name';
	$lang_attr[4]['value'][0]['type'] = 'VARCHAR(255)';
	
	$lang_attr[4]['value'][1]['name'] = 'alias';
	$lang_attr[4]['value'][1]['type'] = 'VARCHAR(255)';
	
	$lang_attr[4]['value'][2]['name'] = 'desc';
	$lang_attr[4]['value'][2]['type'] = 'TEXT';
	
	$lang_attr[4]['value'][3]['name'] = 'content';
	$lang_attr[4]['value'][3]['type'] = 'TEXT';
	
	$lang_attr[4]['value'][4]['name'] = 'title';
	$lang_attr[4]['value'][4]['type'] = 'VARCHAR(255)';
	
	$lang_attr[4]['value'][5]['name'] = 'description';
	$lang_attr[4]['value'][5]['type'] = 'TEXT';
	
	$lang_attr[4]['value'][6]['name'] = 'keywords';
	$lang_attr[4]['value'][6]['type'] = 'TEXT';

	#Products
	$lang_attr[5]['name'] = 'products';
	$lang_attr[5]['value'][0]['name'] = 'name';
	$lang_attr[5]['value'][0]['type'] = 'VARCHAR(255)';
	
	$lang_attr[5]['value'][1]['name'] = 'alias';
	$lang_attr[5]['value'][1]['type'] = 'VARCHAR(255)';
	
	$lang_attr[5]['value'][2]['name'] = 'desc';
	$lang_attr[5]['value'][2]['type'] = 'TEXT';
	
	$lang_attr[5]['value'][3]['name'] = 'content';
	$lang_attr[5]['value'][3]['type'] = 'TEXT';
	
	$lang_attr[5]['value'][4]['name'] = 'title';
	$lang_attr[5]['value'][4]['type'] = 'VARCHAR(255)';
	
	$lang_attr[5]['value'][5]['name'] = 'description';
	$lang_attr[5]['value'][5]['type'] = 'TEXT';
	
	$lang_attr[5]['value'][6]['name'] = 'keywords';
	$lang_attr[5]['value'][6]['type'] = 'TEXT';

	#Pages
	$lang_attr[6]['name'] = 'pages';
	$lang_attr[6]['value'][0]['name'] = 'name';
	$lang_attr[6]['value'][0]['type'] = 'VARCHAR(255)';
	
	$lang_attr[6]['value'][1]['name'] = 'alias';
	$lang_attr[6]['value'][1]['type'] = 'VARCHAR(255)';
	
	$lang_attr[6]['value'][2]['name'] = 'desc';
	$lang_attr[6]['value'][2]['type'] = 'TEXT';
	
	$lang_attr[6]['value'][3]['name'] = 'content';
	$lang_attr[6]['value'][3]['type'] = 'TEXT';
	
	$lang_attr[6]['value'][4]['name'] = 'title';
	$lang_attr[6]['value'][4]['type'] = 'VARCHAR(255)';
	
	$lang_attr[6]['value'][5]['name'] = 'description';
	$lang_attr[6]['value'][5]['type'] = 'TEXT';
	
	$lang_attr[6]['value'][6]['name'] = 'keywords';
	$lang_attr[6]['value'][6]['type'] = 'TEXT';

	#Multi_photos
	$lang_attr[7]['name'] = 'multi_photos';
	$lang_attr[7]['value'][0]['name'] = 'name';
	$lang_attr[7]['value'][0]['type'] = 'VARCHAR(255)';
	
	$lang_attr[7]['value'][1]['name'] = 'alias';
	$lang_attr[7]['value'][1]['type'] = 'VARCHAR(255)';
	
	$lang_attr[7]['value'][2]['name'] = 'desc';
	$lang_attr[7]['value'][2]['type'] = 'TEXT';
	
	$lang_attr[7]['value'][3]['name'] = 'content';
	$lang_attr[7]['value'][3]['type'] = 'TEXT';
	
	$lang_attr[7]['value'][4]['name'] = 'title';
	$lang_attr[7]['value'][4]['type'] = 'VARCHAR(255)';
	
	$lang_attr[7]['value'][5]['name'] = 'description';
	$lang_attr[7]['value'][5]['type'] = 'TEXT';
	
	$lang_attr[7]['value'][6]['name'] = 'keywords';
	$lang_attr[7]['value'][6]['type'] = 'TEXT';

	#Photos
	$lang_attr[8]['name'] = 'photos';
	$lang_attr[8]['value'][0]['name'] = 'name';
	$lang_attr[8]['value'][0]['type'] = 'VARCHAR(255)';
	
	$lang_attr[8]['value'][1]['name'] = 'alias';
	$lang_attr[8]['value'][1]['type'] = 'VARCHAR(255)';
	
	$lang_attr[8]['value'][2]['name'] = 'desc';
	$lang_attr[8]['value'][2]['type'] = 'TEXT';
	
	$lang_attr[8]['value'][3]['name'] = 'content';
	$lang_attr[8]['value'][3]['type'] = 'TEXT';
	
	$lang_attr[8]['value'][4]['name'] = 'title';
	$lang_attr[8]['value'][4]['type'] = 'VARCHAR(255)';
	
	$lang_attr[8]['value'][5]['name'] = 'description';
	$lang_attr[8]['value'][5]['type'] = 'TEXT';
	
	$lang_attr[8]['value'][6]['name'] = 'keywords';
	$lang_attr[8]['value'][6]['type'] = 'TEXT';
	
	#Videos
	$lang_attr[9]['name'] = 'videos';
	$lang_attr[9]['value'][0]['name'] = 'name';
	$lang_attr[9]['value'][0]['type'] = 'VARCHAR(255)';
	
	$lang_attr[9]['value'][1]['name'] = 'alias';
	$lang_attr[9]['value'][1]['type'] = 'VARCHAR(255)';
	
	$lang_attr[9]['value'][2]['name'] = 'desc';
	$lang_attr[9]['value'][2]['type'] = 'TEXT';
	
	$lang_attr[9]['value'][3]['name'] = 'content';
	$lang_attr[9]['value'][3]['type'] = 'TEXT';
	
	$lang_attr[9]['value'][4]['name'] = 'title';
	$lang_attr[9]['value'][4]['type'] = 'VARCHAR(255)';
	
	$lang_attr[9]['value'][5]['name'] = 'description';
	$lang_attr[9]['value'][5]['type'] = 'TEXT';
	
	$lang_attr[9]['value'][6]['name'] = 'keywords';
	$lang_attr[9]['value'][6]['type'] = 'TEXT';


	#Settings
	$lang_attr[10]['name'] = 'settings';
	$lang_attr[10]['value'][0]['name'] = 'company';
	$lang_attr[10]['value'][0]['type'] = 'VARCHAR(255)';
	
	$lang_attr[10]['value'][1]['name'] = 'address';
	$lang_attr[10]['value'][1]['type'] = 'VARCHAR(255)';
	
	$lang_attr[10]['value'][2]['name'] = 'title';
	$lang_attr[10]['value'][2]['type'] = 'VARCHAR(255)';
	
	$lang_attr[10]['value'][3]['name'] = 'description';
	$lang_attr[10]['value'][3]['type'] = 'TEXT';
	
	$lang_attr[10]['value'][4]['name'] = 'keywords';
	$lang_attr[10]['value'][4]['type'] = 'TEXT';

	#Order_status
	$lang_attr[11]['name'] = 'order_status';
	$lang_attr[11]['value'][0]['name'] = 'name';
	$lang_attr[11]['value'][0]['type'] = 'VARCHAR(150)';
?>