<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model("sql");
	}
	public function index()
	{
		$params = array(
			"user_code" => @$this->session->userdata("ucode")
		);
		$userinfo = $this->sql->getTableRowDataOrder("users",$params);
		return @$userinfo;
	}
}
