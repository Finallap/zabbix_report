<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Host_group_model extends CI_Model{

	var $db_connect;

	public function __construct() 
	{	
		parent::__construct();
		$this->db_connect= $this->load->database ('zabbix_db', TRUE);
	}

	public function get_groups()
	{
		$query = $this->db_connect->get('groups');
		return $query->result_array();
	}

		public function get_classroom_number()
	{
		$this->db_connect->select('teaching_building_number');
		$this->db_connect->from('classroom_information');
		$this->db_connect->group_by("teaching_building_number");
		$qurey=$this->db_connect->get();
		$qurey=$qurey->result_array();

		$result=array();

		foreach ($qurey as $key => $value) 
		{
			$teaching_building_number=$value['teaching_building_number'];

			$this->db_connect->select('classroom_number');
			$this->db_connect->from('classroom_information');
			$this->db_connect->where("teaching_building_number",$teaching_building_number);
			$qurey=$this->db_connect->get();
			$qurey=$qurey->result_array();

			$result[$teaching_building_number]=$qurey;
		}

		return $result;
	}
}