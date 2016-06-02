<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$this->load->library('calculation_library');
		$this->load->library('zabbix_curl');
		

		// $this->calculation_library->history_out(array('27223'),1462896000,1463414400,3600);

		$groupid_array = NULL; 

		$hostgroup_decode_result = $this->zabbix_curl->get_hostgroup();

		foreach ($hostgroup_decode_result as $key => $value) {
			$groupid = $value['groupid'];
			$groupname = $value['name'];
			$groupid_array[$groupid]= $groupname;
		}

		// var_dump($this->zabbix_curl->get_item_from_group(array('【Mail】邮件服务器')));
		// var_dump($this->zabbix_curl->get_item(NULL , array(11)));

		$select_data['name']='groupid';
		$select_data['default_value']='请选择';
		$select_data['details']=$groupid_array;

		$groupid_select = $this->load->view('template/select',$select_data, TRUE);

		// echo $groupid_select;

		$this->load->view('template/header');
		$this->load->view('main',$select_data);
		$this->load->view('template/footer');
	}

}