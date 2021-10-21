<?php 
	/**
	 * Application Main Page That Will Serve All Requests
	 * @package PRO CODE BMWEB FRAMEWORK
	 * @author  AP CAO
	 * @version 1.0.0
	 * @license https://bmweb.vn
	 * @PHP >=5.6
	 */
	class cartAdmin
	{
		public function __construct($db,$func)
		{
			$this->db = $db;
			$this->func = $func;
		}
		public function getPropertiesName($pid,$field){
            $sql = "select $field from #_product_properties where id='".$pid."'";
            $row = $this->db->rawQueryOne($sql);
            return $row[$field];
        }
		public function getPrice($pid){
			$item = $this->db->rawQueryOne("SELECT price from #_products where id=? order by id desc",array($pid));
			return $item['price'];
		}
		public function getPriceProperties($pid,$code){
            $max=count($_SESSION['cart-admin']);
            $price=0;
            for($i=0;$i<$max;$i++){
                if($code==$_SESSION['cart-admin'][$i]['code']){
                    if($_SESSION['cart-admin'][$i]['color']!=0){
                        $price = $this->getPropertiesName($_SESSION['cart-admin'][$i]['color'],'price');
                        if($price!=0){
                            $price = $price;
                        }else{
                            $price = $this->getPrice($pid);
                        }
                    }else{
                        $price = $this->getPrice($pid);
                    }
                    break;
                }
            }
            return $price;
        }

		public function getTotalQty(){
			$max=count($_SESSION['cart-admin']);
			$sum=0;
			for($i=0;$i<$max;$i++){
				$q = $_SESSION['cart-admin'][$i]['qty'];
				$sum+=$q;
			}
			return $sum;
		}
		public function getTotalPrice(){
			$max=count($_SESSION['cart-admin']);
			$sum=0;
			for($i=0;$i<$max;$i++){
				$pid = $_SESSION['cart-admin'][$i]['productid'];
				$q = $_SESSION['cart-admin'][$i]['qty'];
				$code = $_SESSION['cart-admin'][$i]['code'];
				$color = $_SESSION['cart-admin'][$i]['color'];
                $price = ($color!=0) ? $this->getPriceProperties($pid,$code):$this->getPrice($pid);
				$sum += $price*$q;
			}
			return $sum;
		}
		function removeProduct($code){
			$max=count($_SESSION['cart-admin']);
			for($i=0;$i<$max;$i++){
				if($code==$_SESSION['cart-admin'][$i]['code']){
					unset($_SESSION['cart-admin'][$i]);
					break;
				}
			}
			$_SESSION['cart-admin'] = array_values($_SESSION['cart-admin']);
		}
		public function addToCart($pid,$color=0,$size=0,$q=1){
			if($pid<1 or $q<1) return;
			 $code = md5($pid.$color.$size);
			if(is_array($_SESSION['cart-admin'])){
				if($this->productExists($code,$q)) return;
				$max=count($_SESSION['cart-admin']);
				$_SESSION['cart-admin'][$max]['code']=$code;
				$_SESSION['cart-admin'][$max]['productid']=$pid;
				$_SESSION['cart-admin'][$max]['color']=$color;
				$_SESSION['cart-admin'][$max]['size']=$size;
				$_SESSION['cart-admin'][$max]['qty']=$q;
				return count($_SESSION['cart-admin']);
			}
			else{
				$_SESSION['cart-admin']=array();
				$_SESSION['cart-admin'][0]['code']=$code;
				$_SESSION['cart-admin'][0]['productid']=$pid;
				$_SESSION['cart-admin'][0]['qty']=$q;
				$_SESSION['cart-admin'][0]['color']=$color;
				$_SESSION['cart-admin'][0]['size']=$size;
				return count($_SESSION['cart-admin']);	
			}
		}

		public function productExists($code,$q){
			$max=count($_SESSION['cart-admin']);
			$flag=0;
			for($i=0;$i<$max;$i++){
				if($code==$_SESSION['cart-admin'][$i]['code']){
					$_SESSION['cart-admin'][$i]['qty'] = $_SESSION['cart-admin'][$i]['qty'] + $q;
					$flag=1;
					break;
				}
			}
			return $flag;
		}

		public function updateQty($code,$q){
			$max=count($_SESSION['cart-admin']);
			$flag=0;
			for($i=0;$i<$max;$i++){
				if($code==$_SESSION['cart-admin'][$i]['code']){
					$_SESSION['cart-admin'][$i]['qty'] = $q;
					$flag=1;
					break;
				}
			}
			return $flag;
		}

		public function viewCart(){
			global $config;
			$count_cart = count($_SESSION['cart-admin']);
			if($count_cart>0){
				$saleoff = ($_SESSION['sale-off']) ? $_SESSION['sale-off']:0;
				$result['total_price'] = $this->getTotalPrice();
				$result['total_price_str_sub'] = $this->func->moneyFormat($this->getTotalPrice(),'');
				$result['total_price_str'] = $this->func->moneyFormat($this->getTotalPrice()-$saleoff,'');
				$result['total_qty'] = $this->getTotalQty();
				$result['html'] = '<div class="row">';
					$result['html'] .= '<div class="table-responsive">';
						$result['html'] .= '<table class="table table-bordered cart-middle mb-0">';
							$result['html'] .= '<tbody>';
								foreach ($_SESSION['cart-admin'] as $k => $v) { 
									$product = $this->func->getFieldId($v['productid'],'products');
									$_color = $v['color'];
									$_size = $v['size'];
	                                $_code = $v['code'];
									$_price = ($_color!=0) ? $this->getPriceProperties($v['productid'],$_code):$this->getPrice($v['productid']);
									$_n_color = $this->getPropertiesName($_color,'name_vi');
	                                $_n_size = $this->getPropertiesName($_size,'name_vi');

					            $result['html'] .= '<tr id="product'.$v['code'].'">
								                        <td class="text-center"><button type="button" data-code="'.$v['code'].'" data-pid="'.$v['productid'].'" class="btn btn-light btn-circle btn-remove"><i class="fas fa-trash-alt"></i></button></td>
								                        <td style="max-width: 200px;" data-toggle="tooltip" data-placement="right" title="'.$product['name_vi'].'">'.$product['name_vi'].'</td>
								                        <td class="text-right">'.$this->func->moneyFormat($_price,'').'</td>';
								                        if($config['cart']['advance']==true){
									                        $result['html'] .= '<td class="text-center">'.$_n_color.'</td>
									                        <td class="text-center">Size '.$_n_size.'</td>';
									                    }
								                        $result['html'] .= '<td>
								                        <div class="input-group input-group-sm">
								                        	<span class="input-group-btn input-group-prepend minus-btn" data-code="'.$v['code'].'" data-pid="'.$v['productid'].'"><button class="btn btn-outline-secondary" type="button">-</button></span>
								                        	<input type="text" value="'.$v['qty'].'" id="qty'.$v['code'].'" data-code="'.$v['code'].'" data-pid="'.$v['productid'].'" class="input-sm form-control text-center update-qty">
								                        	<span class="input-group-btn input-group-append plus-btn" data-code="'.$v['code'].'" data-pid="'.$v['productid'].'"><button class="btn btn-outline-secondary" type="button">+</button></span></div>
								                        </td>
								                        <td class="text-right"><span id="price'.$v['code'].'">'.$this->func->moneyFormat($_price*$v['qty'],'').'</span></td>
								                    </tr>';
								}
					            $result['html'] .= '</tbody>';
						$result['html'] .= '</table>';
					$result['html'] .= '</div>';
				$result['html'] .= '</div>';
				$result['html'] .= '<div class="row align-items-center justify-content-between">
						                <div class="col-auto"></div>
						                <div class="col-auto">
						                    <table class="table none-table-order cart-middle">
						                        <tbody>
						                            <tr>
						                                <td class="text-right">Tổng số lượng:</td>
						                                <td class="text-right"><span id="totalQty">'.$result['total_qty'].'</span></td>
						                            </tr>
						                            <tr>
						                                <td class="text-right">Tổng tiền hàng:</td>
						                                <td class="text-right"><span id="totalPriceSub">'.$result['total_price_str_sub'].'</span></td>
						                            </tr>
						                            <tr>
						                                <td valign="middle" class="text-right">Giảm giá hóa đơn:</td>
						                                <td valign="middle" class="text-right">
															<input type="text" name="data[sale_off]" value="'.$saleoff.'" class="form-control money-cart sale-off text-right form-control-sm" placeholder="">
						                                </td>
						                            </tr>
						                            <tr>
						                                <td class="text-right">Khách cần trả:</td>
						                                <td class="text-right"><span id="totalPrice">'.$result['total_price_str'].'</span></td>
						                            </tr>
						                        </tbody>
						                    </table>
						                </div>
						            </div>';
			}
			return $result['html'];
		}
	}
?>