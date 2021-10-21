<?php 
	/**
	 * Application Main Page That Will Serve All Requests
	 * @package PRO CODE BMWEB FRAMEWORK
	 * @author  AP CAO
	 * @version 1.0.0
	 * @license https://bmweb.vn
	 * @PHP >=5.6
	 */
	require_once 'config.php';
	$i = (int)htmlspecialchars($_POST['i']);
	$c = (string)htmlspecialchars($_POST['c']);
	$q = (int)htmlspecialchars($_POST['q']);
	$co = (int)htmlspecialchars($_POST['co']);
	$si = (int)htmlspecialchars($_POST['si']);
	$a = (string)htmlspecialchars($_POST['a']);
	$v = (string)htmlspecialchars($_POST['v']);
	if($a=='add'){
		$cart->addToCart($i,$co,$si,$q);
		$count_cart = count($_SESSION['cart-admin']);
		if($count_cart>0){
			$result['total_price'] = $cart->getTotalPrice();
			$result['total_price_str'] = $func->moneyFormat($cart->getTotalPrice(),'');
			$result['total_qty'] = $cart->getTotalQty();
			$result['html'] = $cart->viewCart();
		}
	}
	if($a=='edit'){
		$cart->updateQty($c,$q);
		$saleoff = ($_SESSION['sale-off']) ? $_SESSION['sale-off']:0;
		$result['total_price'] = $cart->getTotalPrice();
		$result['total_price_str_sub'] = $func->moneyFormat($cart->getTotalPrice(),'');
		$result['total_price_str'] = $func->moneyFormat($cart->getTotalPrice()-$saleoff,'');
		$result['total_qty'] = $cart->getTotalQty();
		$result['total_product'] = $cart->getPriceProperties($i,$c)*$q;
		$result['total_product_str'] = $func->moneyFormat($cart->getPriceProperties($i,$c)*$q,'');
	}

	if($a=='delete'){
		$cart->removeProduct($c);
		$saleoff = ($_SESSION['sale-off']) ? $_SESSION['sale-off']:0;
		$result['total_price'] = $cart->getTotalPrice();
		$result['total_price_str_sub'] = $func->moneyFormat($cart->getTotalPrice(),'');
		$result['total_price_str'] = $func->moneyFormat($cart->getTotalPrice()-$saleoff,'');
		$result['total_qty'] = $cart->getTotalQty();
		$count_cart = count($_SESSION['cart-admin']);
		if($count_cart==0){
			$result['count'] = 0;
		}else{
			$result['count'] = 1;
		}
	}

	if($a=='sale_off'){
		$_SESSION['sale-off'] = ($v) ? str_replace('.', '', $v):0;
		$result['total_price'] = $cart->getTotalPrice();
		$result['total_price_str'] = $func->moneyFormat($cart->getTotalPrice() - $_SESSION['sale-off'],'');
		$result['total_qty'] = $cart->getTotalQty();
	}
	
	echo json_encode($result);
?>
