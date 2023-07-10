<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tms extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model("sql");
		$params = array(
			"user_code" => @$this->session->userdata("ucode")
		);
		$this->user = $this->sql->getTableRowDataOrder("users",$params);
	}
	public function index()
	{
		if(@$this->session->userdata("ucode") == "")
		{
			redirect(base_url()."login");
		}
		else{
			$data["user"] = $this->user;
			$data["menu"] = "tms";
			$data["smenu"] = "dashboard";
			$this->load->view('header',$data);
			$this->load->view('tms',$data);
			$this->load->view('footer',$data);
		}
	}
    
	public function issues()
	{
		if(@$this->session->userdata("ucode") == "")
		{
			redirect(base_url()."login");
		}
		else{
			$data["user"] = $this->user;
			$data["menu"] = "tms";
			$data["smenu"] = "issues";
			$this->load->view('header',$data);
			$this->load->view('tms-issues',$data);
			$this->load->view('footer',$data);
		}
	}
}
