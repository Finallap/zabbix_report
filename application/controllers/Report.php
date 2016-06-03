<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

	public function index()
	{
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
		$this->load->library('calculation_library');

		$type = $this->input->post('type');
		$itemid = $this->input->post('itemid');

		$start_day = $this->input->post('start_day');
		$end_day = $this->input->post('end_day');

		if($itemid == -1)
		{
			$data['alert_information']="请选择导出项目！";
			$data['href']="";
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

		$this->calculation_library->history_out($itemid ,$time_from ,$time_till ,$time_interval);
	}

}