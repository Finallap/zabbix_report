<?php
set_time_limit(7200);
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

	public function index()
	{
		$this->load->view('template/header');
		$this->load->view('home');
		$this->load->view('template/footer');
	}

	public function host_select()
	{
		date_default_timezone_set('PRC');
		$this->load->library('zabbix_curl');

		$groupid_array = NULL; 

		$hostgroup_decode_result = $this->zabbix_curl->get_hostgroup();

		foreach ($hostgroup_decode_result as $key => $value) {
			$groupid = $value['groupid'];
			$groupname = $value['name'];
			$groupid_array[$groupid]= $groupname;
		}

		$select_data['name']='groupid';
		$select_data['default_value']='请选择';
		$select_data['details']=$groupid_array;

		$this->load->view('template/header');
		$this->load->view('main',$select_data);
		$this->load->view('template/footer');
	}

	public function item_select()
	{
		date_default_timezone_set('PRC');
		$this->load->library('calculation_library');
		$this->load->library('zabbix_curl');

		$groupid = $this->input->post('groupid');
		$hostid = $this->input->post('hostid');

		$data['group_name'] = $this->zabbix_curl->get_group_name($groupid);
		$data['host_name'] = $this->zabbix_curl->get_host_name($hostid);

		$item_decode_result = $this->zabbix_curl->get_item($hostid);

		foreach ($item_decode_result as $key => $value) {
			$itemid = $value['itemid'];
			$itemname = $value['name'];
			$itemid_array[$itemid]= $itemname;
		}

		$select_data['name']='itemid';
		$select_data['default_value']='请选择';
		$select_data['details']=$itemid_array;

		$data['item_select'] = $this->load->view('template/select',$select_data, TRUE);

		$data['start_day'] = date("Y-m-d",strtotime("-1 week"));
		$data['end_day'] = date("Y-m-d");

		$this->load->view('template/header');
		$this->load->view('item_select_page' , $data);
		$this->load->view('template/footer');
		$this->load->view('template/datepicker_js');
		$this->load->view('template/datepicker_end_js');
	}

	public function excel_out_action()
	{
		ignore_user_abort(true);
		date_default_timezone_set('PRC');
		$this->load->library('calculation_library');
		$this->load->library('zabbix_curl');

		$type = $this->input->post('type');
		$itemid = $this->input->post('itemid');

		$start_day = $this->input->post('start_day');
		$end_day = $this->input->post('end_day');

		if($itemid == -1)
		{
			$data['alert_information']="请选择导出项目！";
			$data['href']="report/host_select";
			$this->load->view('template/alert_and_location_href',$data);
		}

		$start_time=strtotime($start_day);
		$end_time=strtotime($end_day);
		if($start_time>$end_time){$temp=$start_time;$start_time=$end_time;$end_time=$temp;}

		$y=date("Y",$start_time); 
		$m=date("m",$start_time); 
		$d=date("d",$start_time); 

		$time_from = mktime(0, 0, 0, $m, $d ,$y);

		$y=date("Y",$end_time); 
		$m=date("m",$end_time); 
		$d=date("d",$end_time); 

		$time_till = mktime(23, 59, 59, $m, $d ,$y);

		if($type=="hour")
			$time_interval = 3600;
		else
			$time_interval = 86400;

		$header_data['group_name'] = $this->input->post('group_name');
	    $header_data['host_name'] = $this->input->post('host_name');
	    $header_data['item_name'] = $this->zabbix_curl->get_item_name($itemid);
	    $header_data['start_day'] = date("Y-m-d",$time_from);
	    $header_data['end_day'] = date("Y-m-d",$time_till);

		$this->calculation_library->history_out($itemid ,$time_from ,$time_till ,$time_interval ,$header_data);
	}

	public function all_item_select()
	{
		date_default_timezone_set('PRC');
		$this->load->library('calculation_library');
		$this->load->library('zabbix_curl');

		$data['start_day'] = date("Y-m-d",strtotime("-2 month"));
		$data['end_day'] = date("Y-m-d");

		$this->load->view('template/header');
		$this->load->view('all_item_select_page' , $data);
		$this->load->view('template/footer');
		$this->load->view('template/datepicker_js');
		$this->load->view('template/datepicker_end_js');
	}

	public function all_excel_out_action()
	{
		ignore_user_abort(true);
		date_default_timezone_set('PRC');
		$this->load->library('calculation_library');
		$this->load->library('time_library');
		$this->load->library('zabbix_curl');
		$this->load->library('excel_out_library');

		$result = NULL ;

		$item_name = $this->input->post('itemname');
		$start_day = $this->input->post('start_day');
		$end_day = $this->input->post('end_day');

		$header_data['item_name'] = $item_name;
		$header_data['start_month'] = date('Y-m', strtotime($start_day));
		$header_data['end_month'] = date('Y-m', strtotime($start_day));

		$time_array = $this->time_library->get_time_array($start_day , $end_day);

		// $item_array = array_slice($this->zabbix_curl->get_item_from_name($item_name), 0, 20);
		$item_array = $this->zabbix_curl->get_item_from_name($item_name);
		foreach ($item_array as $key => $one_host)
		{
			$host_result = NULL ;

			$host_result['hostid'] = $one_host['hostid'];
			$host_result['host_name'] = $this->zabbix_curl->get_host_name($host_result['hostid']);
			$host_result['itemid'] = $one_host['itemid'];
			$host_result['detail'] = $this->calculation_library->calculation_month($host_result['itemid'] , $time_array);

			$result[] = $host_result;

			// var_dump($host_result);
		}

		$this->excel_out_library->all_record_excel_out($result,$header_data,$time_array);
	}
	
}