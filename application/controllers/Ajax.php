<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {

	public function group_get_host()
	{
		header( 'Access-Control-Allow-Origin:*');
		header("Cache-Control: no-cache");

		$this->load->library('zabbix_curl');

		$hostid_decode_result = $this->zabbix_curl->get_hostid($_POST["groupid"]);

		$hostid_array = NULL; 

		foreach ($hostid_decode_result as $key => $value) {
			$hostid = $value['hostid'];
			$hostname = $value['name'];
			$hostid_array[$hostid]= $hostname;
		}

		$select_data['name']='hostid';

		if($hostid_array==NULL)
			$select_data['default_value']='该分组无机器';
		else
			$select_data['default_value']='请选择机器';
		
		$select_data['details']=$hostid_array;

		$this->load->view('template/select',$select_data);
	}
}