<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {


	function __construct() {
        parent::__construct();
        $this->load->helper('json_output');
    }

	public function login()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->MyModel->check_auth_client();
			if($check_auth_client == true){
				$params = json_decode(file_get_contents('php://input'), TRUE);
		        $username = $params['username'];
		        $password = $params['password'];
		        
		        $response = $this->MyModel->login($username,$password);
				json_output($response['status'],$response);
			}
		}
	}

	public function logout()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->MyModel->check_auth_client();
			if($check_auth_client == true){
		        $response = $this->MyModel->logout();
				json_output($response['status'],$response);
			}
		}
	}

	public function register()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->MyModel->check_auth_client();
			if($check_auth_client == true){
		        $respStatus = 200;
					$params = json_decode(file_get_contents('php://input'), TRUE);
					if ($params['username'] == "" || $params['password'] == "") {
						$respStatus = 400;
						$resp = array('status' => 400,'message' =>  'Username and Password cant be empty');
					} else {
		        		$resp = $this->MyModel->register($params);
					}
					json_output($respStatus,$resp);
		        
			}
		}
	}
	
}
