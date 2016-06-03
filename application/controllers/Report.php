<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

	public function index()
	{
		$this->load->library('calculation_library');
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
		echo $type = $this->input->post('type');
		echo $itemid = $this->input->post('itemid');

		echo $start_day = $this->input->post('start_day');
		echo $end_day = $this->input->post('end_day');
	}

}