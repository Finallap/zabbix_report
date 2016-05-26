<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->model('Host_group_model');
		$this->load->library('zabbix_curl');

		var_dump($this->zabbix_curl->get_history(array('27223'),1462896000,1463414400));

		// var_dump($this->Host_group_model->get_groups());
		$this->load->view('template/header');
		$this->load->view('main');
		$this->load->view('template/footer');
	}
}