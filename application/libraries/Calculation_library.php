<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class  Calculation_library
	{
		protected $CI;

		public function __construct()
	    {
	        $this->CI =& get_instance();
	    }

	    public function history_out($itemids_array = NULL,$time_from = 0,$time_till = 0,$time_interval = 60)
	    {
	    	$this->CI->load->library('zabbix_curl');
	    	$this->CI->load->library('excel_out_library');

	    	$history_decode_result = $this->CI->zabbix_curl->get_history($itemids_array , $time_from , $time_till);
			$history_first_clock = $history_decode_result[0]['clock'];
			$history_end_clock = end($history_decode_result)['clock'];

			$y=date("Y",$history_first_clock); 
			$m=date("m",$history_first_clock); 
			$d=date("d",$history_first_clock); 
			$h=date("H",$history_first_clock);

			$start_clock = mktime($h, 0, 0, $m, $d ,$y); 
			$end_clock =  $start_clock + $time_interval;

			$count = 0;
			$sum = 0;
			$max_value = $history_decode_result[0]['value'];
			$min_value = $history_decode_result[0]['value'];

			$result = NULL;

			foreach ($history_decode_result as $key => $history_item_array)
			{
				if(($history_item_array['clock'] <= $end_clock) && ($history_item_array['clock'] >= $start_clock))
				{
					if($history_item_array['value']>$max_value)
						$max_value = $history_item_array['value'];
					if($history_item_array['value']<$min_value)
						$min_value = $history_item_array['value'];

					$sum += $history_item_array['value'];
					$count++;
				}
				else
				{
					if($count!=0)
						$average = $sum/$count ;

					$item['clock'] = date('Y-m-d H:i:s', $start_clock);
					$item['max_value'] = $max_value;
					$item['min_value'] = $min_value;
					$item['avg_value'] = $average;

					$result[] = $item;

					$count = 0;
					$sum = 0;
					$max_value = $history_decode_result[$key+1]['value'];
					$min_value = $history_decode_result[$key+1]['value'];

					$start_clock += $time_interval;
					$end_clock += $time_interval;
				}
			}

			$this->CI->excel_out_library->detailed_record_excel_out($result,$name='Excel');
	    }
	}