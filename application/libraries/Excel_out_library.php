<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class  Excel_out_library
	{
		public function __construct() 
		{
			/*导入phpExcel核心类*/
			include_once('PHPExcel.php');
	    }

	    public function detailed_record_excel_out($data,$header_data)
	    {
	    	$name = $header_data['host_name'].$header_data['item_name']."报表——".$header_data['start_day'].'至'.$header_data['end_day'];

	    	$objPHPExcel = new PHPExcel();
	        /*以下是一些设置 ，什么作者  标题啊之类的*/
	         $objPHPExcel->getProperties()->setCreator("FANG YUANRUN")
	                               ->setLastModifiedBy("FANG YUANRUN")
	                               ->setTitle("Zabbix报表")
	                               ->setSubject("Zabbix报表")
	                               ->setDescription("Zabbix报表")
	                               ->setKeywords("Zabbix")
	                               ->setCategory("Zabbix");

	         /*以下就是对处理Excel里的数据， 横着取数据，主要是这一步，其他基本都不要改*/
	        $objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
	        $objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
	        $objPHPExcel->getActiveSheet()->mergeCells('A3:D3');
	        $objPHPExcel->getActiveSheet()->mergeCells('A4:D4');
	        $objPHPExcel->getActiveSheet()->mergeCells('A5:D5');

	        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	        $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);

			$objPHPExcel->setActiveSheetIndex(0)
	                        ->setCellValue('A1', '华住酒店管理有限公司运维报表')    
	                        ->setCellValue('A2', '机器分组：'.$header_data['group_name'])
	                        ->setCellValue('A3', '机器名称：'.$header_data['host_name'])
	                        ->setCellValue('A4', '项目名称：'.$header_data['item_name'])
	                        ->setCellValue('A5', '导出时间范围：'.$header_data['start_day'].'至'.$header_data['end_day']);

	        $objPHPExcel->setActiveSheetIndex(0)
	                        ->setCellValue('A6', '时间')
	                        ->setCellValue('B6', '最小值')
	                        ->setCellValue('C6', '最大值')
	                        ->setCellValue('D6', '平均值');

	        foreach($data as $k => $v)
	        {
	             $num=$k+7;
	             $objPHPExcel->setActiveSheetIndex(0)
	                          ->setCellValue('A'.$num, $v['clock'])    
	                          ->setCellValue('B'.$num, $v['min_value'])
	                          ->setCellValue('C'.$num, $v['max_value'])
	                          ->setCellValue('D'.$num, $v['avg_value']);
	        }
	        $objPHPExcel->getActiveSheet()->setTitle('数据EXCEL导出');
	        $objPHPExcel->setActiveSheetIndex(0);
	         header('Content-Type: application/vnd.ms-excel');
	        header('Content-Disposition: attachment;filename="'.$name.'.xls"');
	        header('Cache-Control: max-age=0');
	        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	        $objWriter->save('php://output');
	    }

	    public function all_record_excel_out($data = NULL,$header_data,$time_array)
	    {
	    	$name = $header_data['item_name']."报表——".$header_data['start_month'].'至'.$header_data['end_month'].'(导出时间：'.date('Y-m-d H:i:s',time()).')';

	    	$objPHPExcel = new PHPExcel();
	        /*以下是一些设置 ，什么作者  标题啊之类的*/
	        $objPHPExcel->getProperties()->setCreator("FANG YUANRUN")
	                               ->setLastModifiedBy("FANG YUANRUN")
	                               ->setTitle("Zabbix报表")
	                               ->setSubject("Zabbix报表")
	                               ->setDescription("Zabbix报表")
	                               ->setKeywords("Zabbix")
	                               ->setCategory("Zabbix");

	        $objPHPExcel->createSheet();
	        $objPHPExcel->getActiveSheet()->setTitle('平均值');
	        $objPHPExcel->setActiveSheetIndex(0);

	        $objPHPExcel->createSheet();
			$objPHPExcel->setactivesheetindex(1);
			$objPHPExcel->getActiveSheet()->setTitle('最大值');

			$objPHPExcel->createSheet();
			$objPHPExcel->setactivesheetindex(2);
			$objPHPExcel->getActiveSheet()->setTitle('最小值');

	         /*以下就是对处理Excel里的数据， 横着取数据，主要是这一步，其他基本都不要改*/
	        $column = 'A';

	        $objPHPExcel->setactivesheetindex(0);
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($column.'1', '主机名称');

			$objPHPExcel->setactivesheetindex(1);
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
			$objPHPExcel->setActiveSheetIndex(1)->setCellValue($column.'1', '主机名称');

			$objPHPExcel->setactivesheetindex(2);
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
			$objPHPExcel->setActiveSheetIndex(2)->setCellValue($column.'1', '主机名称');

			$column = chr(ord($column)+1); 

			foreach ($time_array as $key => $time_result)
			{
				$objPHPExcel->setactivesheetindex(0);
				$objPHPExcel->getActiveSheet()->getColumnDimension($column)->setWidth(15);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($column.'1', $time_result['date']);

				$objPHPExcel->setactivesheetindex(1);
				$objPHPExcel->getActiveSheet()->getColumnDimension($column)->setWidth(15);
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue($column.'1', $time_result['date']);

				$objPHPExcel->setactivesheetindex(2);
				$objPHPExcel->getActiveSheet()->getColumnDimension($column)->setWidth(15);
				$objPHPExcel->setActiveSheetIndex(2)->setCellValue($column.'1', $time_result['date']);

				$column = chr(ord($column)+1); 
			}

			$row = 2;
			foreach ($data as $key => $host_value)
			{
				$column = 'A';

				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($column.$row, $host_value['host_name']);
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue($column.$row, $host_value['host_name']);
				$objPHPExcel->setActiveSheetIndex(2)->setCellValue($column.$row, $host_value['host_name']);

				$column = chr(ord($column)+1);

				if($host_value['detail']==NULL)
				{
					$row++;
					continue;
				}

				foreach ($host_value['detail'] as $key => $value)
				{
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($column.$row, $value['avg_value']);
					$objPHPExcel->setActiveSheetIndex(1)->setCellValue($column.$row, $value['max_value']);
					$objPHPExcel->setActiveSheetIndex(2)->setCellValue($column.$row, $value['min_value']);
					$column = chr(ord($column)+1);
				}
				
				$row++;
			}

	        header('Content-Type: application/vnd.ms-excel');
	        header('Content-Disposition: attachment;filename="'.$name.'.xls"');
	        header('Cache-Control: max-age=0');
	        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	        $objWriter->save('php://output');
	    }
	}