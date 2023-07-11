<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Discussions extends CI_Controller {

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
			redirect(base_url()."index.php/login");
		}
		else{
			$data["user"] = $this->user;
			$data["menu"] = "discussions";
			$data["discussions"] = @$this->sql->getTableRowDataOrder("solutions",array("sol_status" => 1));
			$this->load->view('header',$data);
			$this->load->view('discussions',$data);
			$this->load->view('footer',$data);
		}
	}
	public function createItem()
	{
		if(@$this->session->userdata("ucode") == "")
		{
			redirect(base_url()."index.php/login");
		}
		else{
			$data["user"] = $this->user;
			$data["menu"] = "discussions";
			$this->load->view('header',$data);
			$this->load->view('create-discussion',$data);
			$this->load->view('footer',$data);
		}
	}
	public function saveDiscussion()
	{
        $user =$this->user;
		// echo "<pre>";print_R($_REQUEST);echo "</pre>";
		$params=array(
			"s_code" => "SOL-".@date("Ymdhis"),
			"solution_title" => $this->input->post('solution_title'),
			"solution_desc" => $this->input->post('solution_desc'),
			"solution_code" => $this->input->post('solution_code'),
			"solution_tags" => $this->input->post('solution_tags'),
			"created_by" => @$user[0]->email,
            "created_on" => @date("Y-m-d H:i:s")
		);
		$ins2 = $this->sql->storeItems("solutions",$params);
        if($ins2){
            $this->session->set_userdata(array("discussionmessage" => "Successfully"));
            redirect(base_url()."index.php/discussions");
        }
        else{
            $this->session->set_userdata(array("discussionmessage" => "Failed"));
            redirect(base_url()."index.php/discussions");

        }
		

	}
    
	public function viewTopic($code)
	{
		if(@$this->session->userdata("ucode") == "")
		{
			redirect(base_url()."index.php/login");
		}
		else{
			$data["user"] = $this->user;
			$data["code"] = $code;
			$data["menu"] = "discussions";
			$data["discussions"] = @$this->sql->getTableRowDataOrder("solutions",array("s_code" => $code,"sol_status" => 1));
			$this->load->view('header',$data);
			$this->load->view('view-discussion',$data);
			$this->load->view('footer',$data);
		}
	}
}
