<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		// $this->load->model('Host_group_model');
		$this->load->library('zabbix_curl');
		$this->load->library('excel_out_library');

		$history_decode_result = $this->zabbix_curl->get_history(array('27223'),1462896000,1463414400);
		// var_dump($history_decode_result);
		$history_first_clock = $history_decode_result[0]['clock'];
		$history_end_clock = end($history_decode_result)['clock'];

		$time_interval = 3600;

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

				var_dump(date('Y-m-d H:i:s', $start_clock));
				var_dump($average);
				var_dump($max_value);
				var_dump($min_value);

				$count = 0;
				$sum = 0;
				$max_value = $history_decode_result[$key+1]['value'];
				$min_value = $history_decode_result[$key+1]['value'];

				$start_clock += $time_interval;
				$end_clock += $time_interval;
			}
		}

		$hostgroup_decode_result = $this->zabbix_curl->get_hostgroup();

		foreach ($hostgroup_decode_result as $key => $value) {
			var_dump($value['groupid']);
			var_dump($value['name']);
		}

		// var_dump($this->zabbix_curl->get_item_from_group(array('【Mail】邮件服务器')));
		// var_dump($this->zabbix_curl->get_item(NULL , array(11)));

		// var_dump($this->Host_group_model->get_groups());
		$this->load->view('template/header');
		$this->load->view('main');
		$this->load->view('template/footer');
	}
}