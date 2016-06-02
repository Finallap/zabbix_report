<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class  Excel_out_library
	{
		public function __construct() 
		{
			/*导入phpExcel核心类*/
			include_once('PHPExcel.php');
	    }

	    public function detailed_record_excel_out($data,$name='Excel')
	    {
	    	$objPHPExcel = new PHPExcel();
	        /*以下是一些设置 ，什么作者  标题啊之类的*/
	         $objPHPExcel->getProperties()->setCreator("方垣闰")
	                               ->setLastModifiedBy("方垣闰")
	                               ->setTitle("数据EXCEL导出")
	                               ->setSubject("数据EXCEL导出")
	                               ->setDescription("数据EXCEL导出")
	                               ->setKeywords("excel")
	                               ->setCategory("excel");

	         /*以下就是对处理Excel里的数据， 横着取数据，主要是这一步，其他基本都不要改*/

			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(11);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(8);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(8);

	        $objPHPExcel->setActiveSheetIndex(0)
	                        ->setCellValue('A1', '时间')
	                        ->setCellValue('B1', '最小值')
	                        ->setCellValue('C1', '最大值')
	                        ->setCellValue('D1', '平均值');

	        foreach($data as $k => $v)
	        {
	             $num=$k+2;
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
	}