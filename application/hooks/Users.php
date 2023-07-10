<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model("sql");
	}
	public function index($uCode)
	{
		$params = array(
			"user_code" => @$uCode[0]
		);
		$userinfo = $this->sql->getTableRowDataOrder("users",$params);
		return @$userinfo;
	}	
}
