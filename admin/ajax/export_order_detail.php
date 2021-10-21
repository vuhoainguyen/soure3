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
	require_once _lib.'PHPExcel/PHPExcel.php';
	$i = (int)htmlspecialchars($_GET['id']);
	$item_order = $d->rawQueryOne("SELECT * from #_orders where id=? order by id desc",array($i));
	$items_order = $d->rawQuery("SELECT * from #_order_details where id_order=? order by id desc",array($i));

	$status_order = $func->getFieldId($item_order['order_status'],'order_status');
	$vat = 0;
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getProperties()->setCreator('Maarten Balliauw')->setLastModifiedBy('Maarten Balliauw')->setTitle('PHPExcel Test Document')->setSubject('PHPExcel Test Document')->setDescription('Test document for PHPExcel, generated using PHP classes.')->setKeywords('office PHPExcel php')->setCategory('Test result file');

	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->setActiveSheetIndex( 0 )->mergeCells( 'A1:E1' );
	$objPHPExcel->setActiveSheetIndex( 0 )->mergeCells( 'A3:C3' );
	$objPHPExcel->setActiveSheetIndex( 0 )->mergeCells( 'A4:C4' );
	$objPHPExcel->setActiveSheetIndex( 0 )->mergeCells( 'A5:C5' );
	$objPHPExcel->setActiveSheetIndex( 0 )->mergeCells( 'D3:E3' );
	$objPHPExcel->setActiveSheetIndex( 0 )->mergeCells( 'D4:E4' );
	$objPHPExcel->setActiveSheetIndex( 0 )->mergeCells( 'D5:E5' );

	$objPHPExcel->getActiveSheet()->getRowDimension( '1' )->setRowHeight( 42 );
	$objPHPExcel->getActiveSheet()->getStyle( 'A1' )->applyFromArray( array( 'font' => array( 'color' => array( 'rgb' => '000000' ),'name' => 'Calibri', 'bold' => true, 'italic' => false, 'size' => 16 ), 'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'wrap' => true ) ) );
	$objPHPExcel->getActiveSheet()->getColumnDimension( 'A' )->setWidth( 5 );
	$objPHPExcel->getActiveSheet()->getColumnDimension( 'B' )->setWidth( 30 );
	$objPHPExcel->getActiveSheet()->getColumnDimension( 'C' )->setWidth( 10 );
	$objPHPExcel->getActiveSheet()->getColumnDimension( 'D' )->setWidth( 17 );
	$objPHPExcel->getActiveSheet()->getColumnDimension( 'E' )->setWidth( 23 );

	$objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
	      
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'A1','THÔNG TIN ĐƠN HÀNG' );

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'A3','Họ tên: '.$item_order['fullname'] );
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'A4','Điện thoại: '.$item_order['phone'] );
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'A5','Địa chỉ: '.$item_order['address'] );

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'D3','Mã đơn hàng: '.$item_order['code'] );
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'D4','Ngày đặt: '.$item_order['createdAt'] );
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'D5','Tình trạng: '.$status_order['name_vi'] );

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'A7','STT' );
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'B7','Sản phẩm' );
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'C7','Số lượng' );
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'D7','Đơn giá' );
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'E7','Thành tiên' );


	$objPHPExcel->getActiveSheet()->getStyle('A7:E7' )->applyFromArray( array( 'font' => array( 'color' => array( 'rgb' => '000000' ), 'name' => 'Calibri', 'bold' => true, 'italic' => false, 'size' => 11 ), 'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'wrap' => true )));

	$objPHPExcel->getActiveSheet()->getStyle( 'B7' )->applyFromArray( array( 'font' => array( 'color' => array( 'rgb' => '000000' ), 'name' => 'Calibri', 'bold' => true, 'italic' => false, 'size' => 11 ), 'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'wrap' => true )));
	$dataArrayList = array();
	$position = 8;
	$styleArray = array(
		'borders' => array(
			'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN
			),
		),
	);
	$objPHPExcel->getActiveSheet()->getStyle('A7:E7')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getRowDimension( 7 )->setRowHeight( 20 );
	foreach ($items_order as $k => $v) {
		$dataArrayList[$k] = array($k+1,$v['name'],$v['qty'],$v['price'],$v['price']*$v['qty']);

		$objPHPExcel->getActiveSheet()->getStyle( 'A'.$position.':E'.$position )->applyFromArray( array( 'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'wrap' => true ) ) );

		$objPHPExcel->getActiveSheet()->getStyle( 'B'.$position )->applyFromArray( array( 'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'wrap' => true ) ) );

		$objPHPExcel->getActiveSheet()->getStyle('A'.$position.':E'.$position)->applyFromArray($styleArray);

		$objPHPExcel->getActiveSheet()->getStyle( 'D'.$position.':E'.$position )->applyFromArray( array( 'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'wrap' => true ) ) );
		$objPHPExcel->getActiveSheet()->getStyle('D'.$position.':E'.$position)->getNumberFormat()->setFormatCode('#,##0');
		$position += 1;
	}
	$objPHPExcel->getActiveSheet()->fromArray($dataArrayList, NULL, 'A8');

	$objPHPExcel->setActiveSheetIndex( 0 )->mergeCells( 'A'.$position.':D'.$position);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'A'.$position,'Tạm tính' );
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'E'.$position, $item_order['total_price']+$item_order['sale_off']);
	$objPHPExcel->getActiveSheet()->getStyle( 'A'.$position.':E'.$position )->applyFromArray( array( 'font' => array( 'color' => array( 'rgb' => '000000' ), 'name' => 'Calibri', 'bold' => false, 'italic' => false, 'size' => 11 )));
	$objPHPExcel->getActiveSheet()->getStyle('E'.$position)->getNumberFormat()->setFormatCode('#,##0');
	
	if($vat==1){
		$objPHPExcel->setActiveSheetIndex( 0 )->mergeCells( 'A'.($position+1).':D'.($position+1));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'A'.($position+1),'Thuế VAT (10%)' );
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'E'.($position+1), $item_order['total_price']/10);
		$objPHPExcel->getActiveSheet()->getStyle( 'A'.($position+1).':E'.($position+1) )->applyFromArray( array( 'font' => array( 'color' => array( 'rgb' => '000000' ), 'name' => 'Calibri', 'bold' => false, 'italic' => false, 'size' => 11 )));
		$objPHPExcel->getActiveSheet()->getStyle('E'.($position+1))->getNumberFormat()->setFormatCode('#,##0');

		$objPHPExcel->setActiveSheetIndex( 0 )->mergeCells( 'A'.($position+2).':D'.($position+2));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'A'.($position+2),'Giảm giá hóa đơn' );
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'E'.($position+2), $item_order['sale_off']);
		$objPHPExcel->getActiveSheet()->getStyle( 'A'.($position+2).':E'.($position+2) )->applyFromArray( array( 'font' => array( 'color' => array( 'rgb' => '000000' ), 'name' => 'Calibri', 'bold' => false, 'italic' => false, 'size' => 11 )));
		$objPHPExcel->getActiveSheet()->getStyle('E'.($position+2))->getNumberFormat()->setFormatCode('#,##0');

		$objPHPExcel->setActiveSheetIndex( 0 )->mergeCells( 'A'.($position+3).':D'.($position+3));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'A'.($position+3),'Tổng thành tiền' );
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'E'.($position+3), $item_order['total_price']/10 + $item_order['total_price']);
		$objPHPExcel->getActiveSheet()->getStyle( 'A'.($position+3).':E'.($position+3) )->applyFromArray( array( 'font' => array( 'color' => array( 'rgb' => '000000' ), 'name' => 'Calibri', 'bold' => false, 'italic' => false, 'size' => 11 )));
		$objPHPExcel->getActiveSheet()->getStyle('E'.($position+3))->getNumberFormat()->setFormatCode('#,##0');
	}else{
		$objPHPExcel->setActiveSheetIndex( 0 )->mergeCells( 'A'.($position+1).':D'.($position+1));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'A'.($position+1),'Giảm giá hóa đơn' );
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'E'.($position+1), $item_order['sale_off']);
		$objPHPExcel->getActiveSheet()->getStyle( 'A'.($position+1).':E'.($position+1) )->applyFromArray( array( 'font' => array( 'color' => array( 'rgb' => '000000' ), 'name' => 'Calibri', 'bold' => false, 'italic' => false, 'size' => 11 )));
		$objPHPExcel->getActiveSheet()->getStyle('E'.($position+1))->getNumberFormat()->setFormatCode('#,##0');

		$objPHPExcel->setActiveSheetIndex( 0 )->mergeCells( 'A'.($position+2).':D'.($position+2));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'A'.($position+2),'Tổng thành tiền' );
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'E'.($position+2), $item_order['total_price']);
		$objPHPExcel->getActiveSheet()->getStyle( 'A'.($position+2).':E'.($position+2) )->applyFromArray( array( 'font' => array( 'color' => array( 'rgb' => '000000' ), 'name' => 'Calibri', 'bold' => false, 'italic' => false, 'size' => 11 )));
		$objPHPExcel->getActiveSheet()->getStyle('E'.($position+2))->getNumberFormat()->setFormatCode('#,##0');

	}

	$objPHPExcel->getActiveSheet()->getStyle( 'A'.$position )->applyFromArray( array( 'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'wrap' => true ) ) );
	$objPHPExcel->getActiveSheet()->getStyle( 'A'.($position+1) )->applyFromArray( array( 'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'wrap' => true ) ) );
	$objPHPExcel->getActiveSheet()->getStyle( 'A'.($position+2) )->applyFromArray( array( 'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'wrap' => true ) ) );
	$objPHPExcel->getActiveSheet()->getStyle( 'A'.($position+3) )->applyFromArray( array( 'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'wrap' => true ) ) );


	$objPHPExcel->getActiveSheet()->getStyle( 'E'.$position )->applyFromArray( array( 'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'wrap' => true ) ) );
	$objPHPExcel->getActiveSheet()->getStyle( 'E'.($position+1) )->applyFromArray( array( 'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'wrap' => true ) ) );
	$objPHPExcel->getActiveSheet()->getStyle( 'E'.($position+2) )->applyFromArray( array( 'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'wrap' => true ) ) );
	$objPHPExcel->getActiveSheet()->getStyle( 'E'.($position+3) )->applyFromArray( array( 'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'wrap' => true ) ) );

	$objPHPExcel->getActiveSheet()->getRowDimension( $position )->setRowHeight( 25 );	
	$objPHPExcel->getActiveSheet()->getRowDimension( $position+1 )->setRowHeight( 25 );
	$objPHPExcel->getActiveSheet()->getRowDimension( $position+2 )->setRowHeight( 25 );
	$objPHPExcel->getActiveSheet()->getRowDimension( $position+3 )->setRowHeight( 25 );
	// $objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getFont()->setBold(true);
	// $objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
	$objPHPExcel->setActiveSheetIndex(0);
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="hoa-don-dien-tu-'.date('dmY').'-'.$item_order['code'].'.xlsx"');
	header('Cache-Control: max-age=0');
	// If you're serving to IE 9, then the following may be needed
	header('Cache-Control: max-age=1');

	// If you're serving to IE over SSL, then the following may be needed
	header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	exit;

?>