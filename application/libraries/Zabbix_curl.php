<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class  Zabbix_curl{

	protected $CI;
	protected $user = "zabbixt";
	protected $password = "123456";
	protected $url = "http://zbx.huazhu.com/api_jsonrpc.php";
	protected $headers;
	protected $auth;

	public function __construct()
    {
        $this->CI =& get_instance();

        $this->headers[] = 'Content-Type: application/json';

        $json_array ['jsonrpc'] = "2.0";
		$json_array ['method'] = "user.authenticate";
		$json_array ['params']['user'] = $this->user;
		$json_array ['params']['password'] = $this->password;
		$json_array ['auth'] = NULL;
		$json_array ['id'] = 0;

		$post_data = json_encode($json_array);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
	    curl_setopt($ch, CURLOPT_URL,$this->url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	    curl_setopt($ch, CURLOPT_POST,1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	    $auth_code_json = curl_exec($ch);

	    $auth_code_array = json_decode($auth_code_json,true);

	    $this->auth = $auth_code_array['result'];
    }

    protected function zabbix_curl_device($method,$params)
	{
		$post_json_array ['jsonrpc'] = "2.0";
		$post_json_array ['method'] = $method;
		$post_json_array ['params'] = $params;
		$post_json_array ['auth'] = $this->auth;
		$post_json_array ['id'] = 1;

		$post_data = json_encode($post_json_array);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
	    curl_setopt($ch, CURLOPT_URL,$this->url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	    curl_setopt($ch, CURLOPT_POST,1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	    return curl_exec($ch);
	}

	public function get_history($itemids_array = NULL,$time_from = 0,$time_till = 0)
	{
	    $method = "history.get";

	    $params['history'] = 0;
	    $params['itemids'] = $itemids_array;
	    $params['output'] = 'extend';
	    $params['time_from'] = $time_from;
	    $params['time_till'] = $time_till;

	    return $this->zabbix_curl_device($method,$params);
	}

	public function get_item($hostids_array = NULL)
	{
	    $method = "history.get";
	    
	    $params['history'] = 0;
	    $params['hostids'] = $hostids_array;
	    $params['output'] = 'extend';
	    $params['time_from'] = $time_from;
	    $params['time_till'] = $time_till;

	    return $this->zabbix_curl_device($method,$params);
	}


}