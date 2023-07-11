<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model("sql");
	}
	public function validate()
	{
		if(@$this->session->userdata("ucode") == "")
		{
			if(@isset($_POST["loginBtn"]) == 1)
			{
				$params = array(
					"email" => @$this->input->post("username"),
					"password" => @SHA1($this->input->post("password"))
				);
				//print_R($params);
				$verify = $this->sql->getTableRowDataOrder("users",$params);
				//print_R($verify);
				if(@sizeOf($verify) > 0)
				{
					$this->session->set_userdata(array(
						"ucode" => @$verify[0]->user_code
					));
					redirect(base_url()."index.php/dashboard");
				}
				else{
					$this->session->set_userdata(array(
						"logmessage" => "Invalid Email ID or Password."
					));
					redirect(base_url()."index.php/login");
				}
			}
		}
		else{
			redirect(base_url()."index.php/dashboard");
		}
			
	}
	public function logout()
	{
		if(@$this->session->userdata("ucode") != "")
		{
			
			$this->session->set_userdata(array(
				"ucode" => ""
			));
			$this->session->sess_destroy();
			redirect(base_url()."index.php/login");
		
		}
		else{
			redirect(base_url()."index.php/dashboard");
		}
			
	}
	function random_strings($length_of_string)
	{
	 
		// String of all alphanumeric character
		$str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
	 
		// Shuffle the $str_result and returns substring
		// of specified length
		return substr(str_shuffle($str_result),
						   0, $length_of_string);
	}
	 
}
