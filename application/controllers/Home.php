<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'third_party/PHPMailer/src/PHPMailer.php');
require_once(APPPATH.'third_party/PHPMailer/src/Exception.php');
require_once(APPPATH.'third_party/PHPMailer/src/SMTP.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require APPPATH.'third_party/PHPMailer/vendor/autoload.php';

class Home extends CI_Controller {

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
			$this->load->view('login');
		}
		else{
			redirect(base_url()."index.php/dashboard");
		}
	}
	public function dashboard()
	{
		if(@$this->session->userdata("ucode") == "")
		{
			redirect(base_url()."index.php/login");
		}
		else{
			$user = $this->user;
			$data["user"] = $user;
			$data["menu"] = "dashboard";
			if(@$user[0]->role != "superadmin" && @$user[0]->role != "management")
			{
				if(@$user[0]->role == "delivery-manager")
				{
					$tprojects = @$this->sql->getTableRowDataOrder("team_projects",array("project_status" => 1, "d_manager" => $user[0]->team_id));
				}
				else if(@$user[0]->role == "project-manager")
				{
					$tprojects = @$this->sql->getTableRowDataOrder("team_projects",array("project_status" => 1, "p_manager" => $user[0]->team_id));
				}
				else{
					$tprojects = @$this->sql->getTableRowDataOrder("team_projects",array("project_status" => 1, "team_id" => $user[0]->team_id));
				}	
				$tprojectsid = array();
				if(@sizeOf($tprojects) > 0)
				{
					for($t=0;$t<sizeOf($tprojects);$t++)
					{
						array_push($tprojectsid,$tprojects[$t]->project_id);
					}
					$data["projects"] = @$this->sql->getTableRowDataNoWhereArray("projects",$tprojectsid,"id");
				}
				else{
					$data["projects"] = array();
				}
			}
			else{
				$data["projects"] = @$this->sql->getAllInfo("projects");
			}
			if(@$user[0]->role != "superadmin" && @$user[0]->role != "management")
			{
				// if(@$user[0]->role == "lead")
				// {
				// 	$ttasks = @$this->sql->getTableRowDataOrder("team_tasks",array("task_status" => 1, "team_lead_id" => $user[0]->team_id));
				// }
				// else{
				// 	$ttasks = @$this->sql->getTableRowDataOrder("team_tasks",array("task_status" => 1, "team_id" => $user[0]->team_id));
				// }


				if(@$user[0]->role == "delivery-manager")
				{
					$tprojects = @$this->sql->getTableRowDataOrder("team_projects",array("project_status" => 1, "d_manager" => $user[0]->team_id));
					$tprojectsid = array();
					if(@sizeOf($tprojects) > 0)
					{
						for($t=0;$t<sizeOf($tprojects);$t++)
						{
							array_push($tprojectsid,$tprojects[$t]->project_id);
						}
					}
					$ttasks = @$this->sql->getTableRowDataNoWhereArray("team_tasks",$tprojectsid,"project_id");
					// $ttasks = @$this->sql->getTableRowDataOrder("team_tasks",array("task_status" => 1, "team_lead_id" => $user[0]->team_id));
					
				}
				else if(@$user[0]->role == "project-manager")
				{
					$tprojects = @$this->sql->getTableRowDataOrder("team_projects",array("project_status" => 1, "p_manager" => $user[0]->team_id));
					$tprojectsid = array();
					if(@sizeOf($tprojects) > 0)
					{
						for($t=0;$t<sizeOf($tprojects);$t++)
						{
							array_push($tprojectsid,$tprojects[$t]->project_id);
						}
					}
					$ttasks = @$this->sql->getTableRowDataNoWhereArray("team_tasks",$tprojectsid,"project_id");
				}
				else if(@$user[0]->role == "lead" || @$user[0]->role == "team-lead")
				{
					// $teamsarr = @$this->sql->getTableRowDataOrder("teams",array("team_lead_id" => @$user[0]->team_id));
					
					$tprojects = @$this->sql->getTableRowDataOrder("team_projects",array("team_lead_id "  => $user[0]->team_id));
					$tprojectsid = array();
					if(@sizeOf($tprojects) > 0)
					{
						for($t=0;$t<sizeOf($tprojects);$t++)
						{
							array_push($tprojectsid,$tprojects[$t]->project_id);
						}
					}
					$ttasks = @$this->sql->getTableRowDataNoWhereArray("team_tasks",$tprojectsid,"project_id");
				}
				else{
					$ttasks = @$this->sql->getTableRowDataOrder("team_tasks",array("task_status" => 1, "team_id" => $user[0]->team_id));
				}


				$ttaskid = array();
				if(@sizeOf($ttasks) > 0)
				{
					for($t1=0;$t1<sizeOf($ttasks);$t1++)
					{
						@array_push($ttaskid,$ttasks[$t1]->task_id);
					}
				}
				
				if(@sizeOf($ttaskid) > 0)
				{
					$alltasks = @$this->sql->getTableRowDataNoWhereArray("tasks",$ttaskid,"id");
				}
				else{
					$alltasks = array();
				}

			}
			else{
				$alltasks = @$this->sql->getAllInfo("tasks");
			}

			$data["tasks"] = $alltasks;
			$ontime=array();
			$overdue=array();
			$overdue2=array();
			$overdue3=array();
			$date1 = @date("Y-m-d");
			if(@sizeOf($alltasks) > 0)
			{
				for($a=0;$a<sizeOf($alltasks);$a++)
				{
					$date2 = @$alltasks[$a]->task_end_date;
					$diff = strtotime($date1) - strtotime($date2);
					if($diff<0)
					{
						$dVal = 0;
					}
					else{
						$dVal = $diff;
					}
					$days = @abs(round($dVal / 86400));
					
					if($days <= 0 && (@$alltasks[$a]->task_status == 1 || @$alltasks[$a]->task_status ==2 || @$alltasks[$a]->task_status ==3 || @$alltasks[$a]->task_status ==5))
					{
						@array_push($ontime,1);
					}
					if($days > 0 && $days <= 2)
					{
						@array_push($overdue,1);
					}
					if($days > 2 && $days <= 4)
					{
						@array_push($overdue2,1);
					}
					
					if($days > 4)
					{
						@array_push($overdue3,1);
					}
				}
			}
			$series=  array(
				"ontime" => @sizeOf($ontime),
				"overdue" => @sizeOf($overdue),
				"overdue2" => @sizeOf($overdue2),
				"overdue3" => @sizeOf($overdue3)
			);
			$data["chartSeries"] = $series;
			if(@$user[0]->role == "superadmin" || @$user[0]->role == "management")
			{
				$data["teams"] = @$this->sql->getAllInfo("teams");
			}
			// else if(@$user[0]->role == "lead")
			// {	
			// 	$data["teams"] = @$this->sql->getTableRowDataOrder("teams",array("team_lead_id" => $user[0]->team_id));
			// }
			else{
				// $data["teams"] = array();

				if(@$user[0]->role == "delivery-manager")
				{
					$tprojects = @$this->sql->getTableRowDataOrder("team_projects",array("project_status" => 1, "d_manager" => $user[0]->team_id));
					$tprojectsid = array();
					if(@sizeOf($tprojects) > 0)
					{
						for($t=0;$t<sizeOf($tprojects);$t++)
						{
							array_push($tprojectsid,$tprojects[$t]->team_id);
						}
					}
					$data["teams"] = @$this->sql->getTableRowDataNoWhereArray("teams",$tprojectsid,"id");
					// $ttasks = @$this->sql->getTableRowDataOrder("team_tasks",array("task_status" => 1, "team_lead_id" => $user[0]->team_id));
					
				}
				else if(@$user[0]->role == "project-manager")
				{
					$tprojects = @$this->sql->getTableRowDataOrder("team_projects",array("project_status" => 1, "p_manager" => $user[0]->team_id));
					$tprojectsid = array();
					if(@sizeOf($tprojects) > 0)
					{
						for($t=0;$t<sizeOf($tprojects);$t++)
						{
							array_push($tprojectsid,$tprojects[$t]->team_id);
						}
					}
					$data["teams"] = @$this->sql->getTableRowDataNoWhereArray("teams",$tprojectsid,"id");
				}
				else if(@$user[0]->role == "lead" || @$user[0]->role == "team-lead")
				{
					// $teamsarr = @$this->sql->getTableRowDataOrder("teams",array("team_lead_id" => @$user[0]->team_id));
					
					$tprojects = @$this->sql->getTableRowDataOrder("team_projects",array("team_lead_id "  => $user[0]->team_id));
					$tprojectsid = array();
					if(@sizeOf($tprojects) > 0)
					{
						for($t=0;$t<sizeOf($tprojects);$t++)
						{
							array_push($tprojectsid,$tprojects[$t]->team_id);
						}
					}
					$data["teams"] = @$this->sql->getTableRowDataNoWhereArray("teams",$tprojectsid,"id");
				}
				else{
					$data["teams"] = @$this->sql->getTableRowDataOrder("teams",array("team_status" => 1, "id" => $user[0]->team_id));
				}


			}
			if(@$user[0]->role == "executive" || @$user[0]->role == "team-executive")
			{
				$data["logs"] = @$this->sql->getTableLimitData("project_logs",array("team_id" => @$user[0]->team_id),30,"created_on","DESC");
			}
			else{
				$data["logs"] = @$this->sql->getTableLimitDataNoWhere("project_logs",30,"created_on","DESC");
			}
			if(@$user[0]->role == "superadmin" || @$user[0]->role == "management")
			{
				$data["recenttasks"] = @$this->sql->getTableLimitDataNoWhere("tasks",30,"created_on","DESC");
			}
			else
			{	
				// if(@$user[0]->role == "lead")
				// {
				// 	$rttasks = @$this->sql->getTableRowDataOrder("team_tasks",array("task_status" => 1, "team_lead_id" => $user[0]->team_id));
				// }
				// else{
				// 	$rttasks = @$this->sql->getTableRowDataOrder("team_tasks",array("task_status" => 1, "team_id" => $user[0]->team_id));
				// }
					

				if(@$user[0]->role == "delivery-manager")
				{
					$tprojects = @$this->sql->getTableRowDataOrder("team_projects",array("project_status" => 1, "d_manager" => $user[0]->team_id));
					$tprojectsid = array();
					if(@sizeOf($tprojects) > 0)
					{
						for($t=0;$t<sizeOf($tprojects);$t++)
						{
							array_push($tprojectsid,$tprojects[$t]->project_id);
						}
					}
					$rttasks = @$this->sql->getTableRowDataNoWhereArray("team_tasks",$tprojectsid,"project_id");
					// $ttasks = @$this->sql->getTableRowDataOrder("team_tasks",array("task_status" => 1, "team_lead_id" => $user[0]->team_id));
					
				}
				else if(@$user[0]->role == "project-manager")
				{
					$tprojects = @$this->sql->getTableRowDataOrder("team_projects",array("project_status" => 1, "p_manager" => $user[0]->team_id));
					$tprojectsid = array();
					if(@sizeOf($tprojects) > 0)
					{
						for($t=0;$t<sizeOf($tprojects);$t++)
						{
							array_push($tprojectsid,$tprojects[$t]->project_id);
						}
					}
					$rttasks = @$this->sql->getTableRowDataNoWhereArray("team_tasks",$tprojectsid,"project_id");
				}
				else if(@$user[0]->role == "lead" || @$user[0]->role == "team-lead")
				{
					// $teamsarr = @$this->sql->getTableRowDataOrder("teams",array("team_lead_id" => @$user[0]->team_id));
					
					$tprojects = @$this->sql->getTableRowDataOrder("team_projects",array("team_lead_id "  => $user[0]->team_id));
					$tprojectsid = array();
					if(@sizeOf($tprojects) > 0)
					{
						for($t=0;$t<sizeOf($tprojects);$t++)
						{
							array_push($tprojectsid,$tprojects[$t]->project_id);
						}
					}
					$rttasks = @$this->sql->getTableRowDataNoWhereArray("team_tasks",$tprojectsid,"project_id");
				}
				else{
					$rttasks = @$this->sql->getTableRowDataOrder("team_tasks",array("task_status" => 1, "team_id" => $user[0]->team_id));
				}


				$rttaskid = array();
				if(@sizeOf($rttasks) > 0)
				{
					for($t1=0;$t1<sizeOf($rttasks);$t1++)
					{
						@array_push($rttaskid,$rttasks[$t1]->task_id);
					}
				}
				$data["recenttasks"] = @$this->sql->getTableRowDataOrderArrayLimit("tasks","id",$rttaskid,5,"created_on","DESC");
			}

			$this->load->view('header',$data);
			$this->load->view('dashboard',$data);
			$this->load->view('footer',$data);
		}
	}
	public function projects()
	{
		if(@$this->session->userdata("ucode") == "")
		{
			redirect(base_url()."index.php/login");
		}
		else{
			
			$user = $this->user;
			$data["user"] = $user;
			$data["smenu"] = "projects";
			$data["menu"] = "projects";
			if(@sizeOf($user) > 0)
			{
				if(@$user[0]->role != "superadmin" && @$user[0]->role != "management")
				{
					if(@$user[0]->role == "delivery-manager")
					{
						$tprojects = @$this->sql->getTableRowDataOrder("team_projects",array("project_status" => 1, "d_manager" => $user[0]->team_id));
					}
					else if(@$user[0]->role == "project-manager")
					{
						$tprojects = @$this->sql->getTableRowDataOrder("team_projects",array("project_status" => 1, "p_manager" => $user[0]->team_id));
					}
					else{
						$tprojects = @$this->sql->getTableRowDataOrder("team_projects",array("project_status" => 1, "team_id" => $user[0]->team_id));
					}	
					// $tprojects = @$this->sql->getTableRowDataOrder("team_projects",array("project_status" => 1, "team_id" => $user[0]->team_id));
					$tprojectsid = array();
					if(@sizeOf($tprojects) > 0)
					{
						for($t=0;$t<sizeOf($tprojects);$t++)
						{
							array_push($tprojectsid,$tprojects[$t]->project_id);
						}
					}
					
					$projects = array();
					if(@sizeOf($tprojectsid) > 0)
					{
						$projectsarr = @$this->sql->getTableRowDataNoWhereArray("projects",$tprojectsid,"id");
						if(@sizeOf($projectsarr) > 0)
						{
							for($t=0;$t<sizeOf($projectsarr);$t++)
							{
								$projects[]=array(
									"id" => $projectsarr[$t]->id,
									"project_name" => $projectsarr[$t]->project_name,
									"project_mode" => $projectsarr[$t]->project_mode,
									"project_status" => $projectsarr[$t]->project_status,
									"project_start_date" => $projectsarr[$t]->project_start_date,
									"project_end_date" => $projectsarr[$t]->project_end_date,
									"created_on" => $projectsarr[$t]->created_on,
									"owner" => @$this->sql->getTableRowDataOrder("teams",array("id" => $projectsarr[$t]->project_owner)),
									"members" => @$this->sql->getTableRowDataOrder("team_projects",array("project_id" => $projectsarr[$t]->id)),
									"tasks" => @$this->sql->getTableRowDataOrder("team_tasks",array("project_id" => $projectsarr[$t]->id)),
									"attachments" => @$this->sql->getTableRowDataOrder("project_documents",array("project_id" => $projectsarr[$t]->id)),
								);
							}
						}
					}
				}
				else{
					$projects = array();
					$projectsarr = @$this->sql->getTableRowDataOrder("projects",array("project_status" => 1));
					if(@sizeOf($projectsarr) > 0)
					{
						for($t=0;$t<sizeOf($projectsarr);$t++)
						{
							$projects[]=array(
								"id" => $projectsarr[$t]->id,
								"project_name" => $projectsarr[$t]->project_name,
								"project_mode" => $projectsarr[$t]->project_mode,
								"project_status" => $projectsarr[$t]->project_status,
								"project_start_date" => $projectsarr[$t]->project_start_date,
								"project_end_date" => $projectsarr[$t]->project_end_date,
								"created_on" => $projectsarr[$t]->created_on,
								"members" => @$this->sql->getTableRowDataOrder("team_projects",array("project_id" => $projectsarr[$t]->id)),
								"tasks" => @$this->sql->getTableRowDataOrder("team_tasks",array("project_id" => $projectsarr[$t]->id)),
								"attachments" => @$this->sql->getTableRowDataOrder("project_documents",array("project_id" => $projectsarr[$t]->id)),
							);
						}
					}
				}
			}
			else{
				$projects = array();
			}
			
			if(@sizeOf($projects) > 0)
			{
				$prs = @json_encode($projects);
				
				$data["projects"] = @json_decode($prs);
			}
			else{
				$prs = array();
				$data["projects"] = $prs;
			}
			
			$this->load->view('header',$data);
			$this->load->view('projects',$data);
			$this->load->view('footer',$data);
		}
	}
	public function createProject()
	{
		if(@$this->session->userdata("ucode") == "")
		{
			redirect(base_url()."index.php/login");
		}
		else{
			
		
			$data["user"] = $this->user;
			$data["menu"] = "projects";
			$this->load->view('header',$data);
			$this->load->view('create-project',$data);
			$this->load->view('footer',$data);
		}
	}
	public function viewProject($rowid)
	{
		if(@$this->session->userdata("ucode") == "")
		{
			redirect(base_url()."index.php/login");
		}
		else{
			
			$data["user"] = $this->user;
			$data["menu"] = "projects";
			$data["rowid"] = @$rowid;
			$data["project"] = @$this->sql->getTableRowDataOrder("projects",array("id" => @$rowid));
			$data["projectdocs"] = @$this->sql->getTableRowDataOrder("project_documents",array("project_id" => @$rowid));
			$this->load->view('header',$data);
			$this->load->view('view-projects',$data);
			$this->load->view('footer',$data);
		}
	}
	public function viewProjectCode($code)
	{
		if(@$this->session->userdata("ucode") == "")
		{
			redirect(base_url()."index.php/login");
		}
		else{
			$prj = @$this->sql->getTableRowDataOrder("projects",array("project_code" => @$code));
			$data["user"] = $this->user;
			$data["menu"] = "projects";
			$data["rowid"] = @$prj[0]->id;
			$data["project"] = @$prj;
			$data["projectdocs"] = @$this->sql->getTableRowDataOrder("project_documents",array("project_id" => @$prj[0]->id));
			$this->load->view('header',$data);
			$this->load->view('view-projects',$data);
			$this->load->view('footer',$data);
		}
	}
	public function editProject($rowid)
	{
		if(@$this->session->userdata("ucode") == "")
		{
			redirect(base_url()."index.php/login");
		}
		else{
			$data["user"] = $this->user;
			$data["menu"] = "projects";
			$data["rowid"] = @$rowid;
			$data["project"] = @$this->sql->getTableRowDataOrder("projects",array("id" => @$rowid));
			$data["projectdocs"] = @$this->sql->getTableRowDataOrder("project_documents",array("project_id" => @$rowid));
			$this->load->view('header',$data);
			$this->load->view('edit-project',$data);
			$this->load->view('footer',$data);
		}
	}
	public function saveProject(){
		
		if(@$this->session->userdata("ucode") == "")
		{
			redirect(base_url()."index.php/login");
		}
		else{
			if(@isset($_POST["saveMember"]))
			{
				$projectcode = "PRJT-".@date("YmdHms");
				$params =array(
					"project_code" => $projectcode,
					"project_name" => @$this->input->post("project_name"),
					"project_mode" => @$this->input->post("project_mode"),
					"project_desc" => @$this->input->post("project_desc"),
					"project_start_date" => @date("Y-m-d",strtotime($this->input->post("project_start_date"))),
					"project_end_date" => @date("Y-m-d",strtotime($this->input->post("project_end_date"))),
					"project_status" => 1,
					"created_on" => @date("Y-m-d H:i:s")
				);
				$ins = $this->sql->storeItems("projects",$params);
				if($ins)
				{
					
					$user = $this->user;
					$team = @$this->sql->getTableRowDataOrder("teams",array("id" => @$user[0]->id));
					$params2 =array(
						"project_id" => @$ins,
						"task_id" => 0,
						"team_id" => 0,
						"log_message" => "A new project # <a href='".base_url()."view-project/".$projectcode."'>". @$this->input->post("project_name")."</a> has created by ".@$team[0]->firstname." ".@$team[0]->lastname." ",
						"created_on" => @date("Y-m-d H:i:s")
					);
					$ins2 = $this->sql->storeItems("project_logs",$params2);
					$this->session->set_userdata(array("projectmessage" => "Successfully added project"));
				}
				else{
					$this->session->set_userdata(array("projectmessage" => "Failed to added project"));
				}
				redirect(base_url()."index.php/home/editProject/".@$ins);
			}
		}
	}
	
	public function updateProject(){
		
		if(@$this->session->userdata("ucode") == "")
		{
			redirect(base_url()."index.php/login");
		}
		else{
			if(@isset($_POST["saveMember"]))
			{
				$rowid = $this->input->post("rowid");
				$project = @$this->sql->getTableRowDataOrder("projects",array("id" => @$rowid));
				$params =array(
					"project_name" => @$this->input->post("project_name"),
					"project_mode" => @$this->input->post("project_mode"),
					"project_desc" => @$this->input->post("project_desc"),
					"project_start_date" => @date("Y-m-d",strtotime($this->input->post("project_start_date"))),
					"project_end_date" => @date("Y-m-d",strtotime($this->input->post("project_end_date"))),
				);
				$ins = $this->sql->updateItemsWithWhere("projects",$params, array("id" => $rowid));
				if($ins)
				{
					$user = $this->user;
					$team = @$this->sql->getTableRowDataOrder("teams",array("id" => @$user[0]->id));
					$params2 =array(
						"project_id" => @$ins,
						"task_id" => 0,
						"team_id" => 0,
						"log_message" => "Project # <a href='".base_url()."'/view-project/'".@$project[0]->project_code."'>". @$this->input->post("project_name")."</a> has updated by ".@$team[0]->firstname." ".@$team[0]->lastname." ",
						"created_on" => @date("Y-m-d H:i:s")
					);
					$ins2 = $this->sql->storeItems("project_logs",$params2);
					$this->session->set_userdata(array("projectmessage" => "Successfully update project"));
				}
				else{
					$this->session->set_userdata(array("projectmessage" => "Failed to update project"));
				}
				redirect(base_url()."index.php/projects");
			}
		}
	}

	public function uploadProjectFolder($projectid){
		
		if(!empty($_FILES['file']['name'])){
			for($f=0;$f<sizeOf($_FILES['file']['name']);$f++)
			{

				// Set preference
				$filename = time()."_".$_FILES['file']['name'][$f];
				// $config['upload_path'] = FCPATH.'uploads/projects/docs/';	
				// $config['allowed_types'] = 'jpg|jpeg|png|gif|doc|docx|pdf|ppt|pptx|xls|xlsx|pdfx';
				// $config['max_size']    = 1024*5; // max_size in kb
				// $config['file_name'] = $filename;

						
				// //Load upload library
				// $this->load->library('upload',$config);			
					
				// // File upload
				// if($this->upload->do_upload('file')){
				// 	// Get data about the file
				// 	$uploadData = $this->upload->data();

					$params = array(
						"project_id" => $projectid,
						"project_doc" => $filename,
						"created_on" => @date("Y-m-d H:i:s"),
						"uploaded_by" => $this->user[0]->email,
						"uploaded_by_user_code" => $this->user[0]->user_code,
					);
					$ins = $this->sql->storeItems("project_documents",$params);
					if($ins)
					{
						$user = $this->user;		
						$team = @$this->sql->getTableRowDataOrder("teams",array("id" => @$user[0]->id));				
						$project = @$this->sql->getTableRowDataOrder("projects",array("id" => @$projectid));
						$params2 =array(
							"project_id" => @$projectid,
							"task_id" => 0,
							"team_id" => @$user[0]->id,
							"log_message" => "Uploaded files to project # <a href='".base_url()."'/view-project/'".@$project[0]->project_code."'>". @$project[0]->project_name."</a> by ".@$team[0]->firstname." ".@$team[0]->lastname." ",
							"created_on" => @date("Y-m-d H:i:s")
						);
						$ins2 = $this->sql->storeItems("project_logs",$params2);
						@move_uploaded_file($_FILES["file"]['tmp_name'][$f],"uploads/projects/docs/".$filename);
						//$this->reloadPage($projectid);
					}
				//}
			}
		}
	}
	public function reloadPage($projectid)
	{
		redirect(base_url()."index.php/home/editProject/".@$projectid);
	}
	public function teammembers()
	{
		if(@$this->session->userdata("ucode") == "")
		{
			redirect(base_url()."index.php/login");
		}
		else{
			$user = $this->user;
			$data["user"] = $user;
			$data["menu"] = "teams";
			if(@sizeOf($user) > 0)
			{
				if(@$user[0]->role != "superadmin" && @$user[0]->role != "management")
				{
					// if(@$user[0]->role == "lead")
					// {	
					// 	$teamsarr = @$this->sql->getTableRowDataOrder("teams",array("team_lead_id" => @$user[0]->team_id));
					// }
					// else{
					// 	$teamsarr = @$this->sql->getTableRowDataOrder("teams",array("id" => @$user[0]->team_id));
					// }


					if(@$user[0]->role == "delivery-manager")
					{
						$tprojects = @$this->sql->getTableRowDataOrder("team_projects",array("project_status" => 1, "d_manager" => $user[0]->team_id));
						$tprojectsid = array();
						if(@sizeOf($tprojects) > 0)
						{
							for($t=0;$t<sizeOf($tprojects);$t++)
							{
								array_push($tprojectsid,$tprojects[$t]->team_id);
							}
						}
						$teamsarr = @$this->sql->getTableRowDataNoWhereArray("teams",$tprojectsid,"id");
						
					}
					else if(@$user[0]->role == "project-manager")
					{
						$tprojects = @$this->sql->getTableRowDataOrder("team_projects",array("project_status" => 1, "p_manager" => $user[0]->team_id));
						$tprojectsid = array();
						if(@sizeOf($tprojects) > 0)
						{
							for($t=0;$t<sizeOf($tprojects);$t++)
							{
								array_push($tprojectsid,$tprojects[$t]->team_id);
							}
						}
						$teamsarr = @$this->sql->getTableRowDataNoWhereArray("teams",$tprojectsid,"id");
					}
					else if(@$user[0]->role == "lead" || @$user[0]->role == "team-lead")
					{
						// $teamsarr = @$this->sql->getTableRowDataOrder("teams",array("team_lead_id" => @$user[0]->team_id));
						
						$tprojects = @$this->sql->getTableRowDataOrder("team_projects",array("team_lead_id "  => $user[0]->team_id));
						$tprojectsid = array();
						if(@sizeOf($tprojects) > 0)
						{
							for($t=0;$t<sizeOf($tprojects);$t++)
							{
								array_push($tprojectsid,$tprojects[$t]->team_id);
							}
						}
						$teamsarr = @$this->sql->getTableRowDataNoWhereArray("teams",$tprojectsid,"id");
					}
					else{
						$teamsarr = @$this->sql->getTableRowDataOrder("teams",array("id" => @$user[0]->team_id));
						$tprojects = @$this->sql->getTableRowDataOrder("team_projects",array("team_id "  => $user[0]->team_id));
					}


					
				}
				else{
					$teamsarr = @$this->sql->getTableRowDataOrder("teams",array("team_status" => 1));
				}
			}
			
			if(@sizeOf($teamsarr) > 0)
			{
				for($t=0;$t<sizeOf($teamsarr);$t++)
				{
					$teams[]=array(
						"id" => $teamsarr[$t]->id,
						"team_lead_id" => $teamsarr[$t]->team_lead_id,
						"firstname" => $teamsarr[$t]->firstname,
						"lastname" => $teamsarr[$t]->lastname,
						"email" => $teamsarr[$t]->email,
						"mobile_no" => $teamsarr[$t]->mobile_no,
						"position" => $teamsarr[$t]->position,
						"team_status" => $teamsarr[$t]->team_status,
						"created_on" => $teamsarr[$t]->created_on,
						"projects" => @$this->sql->getTableRowDataOrder("team_projects",array("team_id" => $teamsarr[$t]->id)),
						"tasks" => @$this->sql->getTableRowDataOrder("team_tasks",array("team_id" => $teamsarr[$t]->id)),
						"logininfo" => @$this->sql->getTableRowDataOrder("users",array("team_id" => $teamsarr[$t]->id))
					);
				}
			}
			$data["teams"] = @json_encode($teams);
			$this->load->view('header',$data);
			$this->load->view('team-members',$data);
			$this->load->view('footer',$data);
		}
	}
	public function createMember()
	{
		if(@$this->session->userdata("ucode") == "")
		{
			redirect(base_url()."index.php/login");
		}
		else{
			$data["user"] = $this->user;
			$data["menu"] = "teams";
			$this->load->view('header',$data);
			$this->load->view('create-team-members',$data);
			$this->load->view('footer',$data);
		}
	}
	public function editTeamMember($rowid)
	{
		
		if(@$this->session->userdata("ucode") == "")
		{
			redirect(base_url()."index.php/login");
		}
		else{
			$data["user"] = $this->user;
			$data["menu"] = "teams";
			$data["rowid"] = @$rowid;
			$data["team"] = @$this->sql->getTableRowDataOrder("teams",array("id" => @$rowid));
			$this->load->view('header',$data);
			$this->load->view('edit-team-member',$data);
			$this->load->view('footer',$data);
		}
	}
	public function saveTeamMember(){
		
		if(@$this->session->userdata("ucode") == "")
		{
			redirect(base_url()."index.php/login");
		}
		else{
			if(@isset($_POST["saveMember"]))
			{
				if(@$this->input->post("team_position") == "team-lead")
				{
					$pos = "lead";
				}
				else{
					$pos = @$this->input->post("team_position");
				}
				$params =array(
					"firstname" => @$this->input->post("team_firstname"),
					"lastname" => @$this->input->post("team_lastname"),
					"email" => @$this->input->post("team_email"),
					"mobile_no" => @$this->input->post("team_mobile_no"),
					"position" => @$this->input->post("team_position"),
					"team_status" => 1,
					"created_on" => @date("Y-m-d H:i:s")
				);
				$ins = $this->sql->storeItems("teams",$params);
				if($ins)
				{
					$params1 =array(
						"team_id" => $ins,
						"user_code" => @$this->random_strings(16),
						"username" => @strtolower($this->input->post("team_firstname")."".@$this->input->post("team_lastname")),
						"email" => @$this->input->post("team_email"),
						"avatar" => "default.png",
						"password" => SHA1("enmovil@123"),
						"password_txt" => "enmovil@123",
						"is_active" => 1,
						"role" => $pos,
						"created_at" => @date("Y-m-d H:i:s")
					);
					$ins1 = $this->sql->storeItems("users",$params1);

					
					$user = $this->user;
					$team = @$this->sql->getTableRowDataOrder("teams",array("id" => @$user[0]->id));
					$params2 =array(
						"project_id" => 0,
						"task_id" => 0,
						"team_id" => @$ins,
						"log_message" => "A new user #". @$this->input->post("team_firstname")." ". @$this->input->post("team_lastname")." has added",
						"created_on" => @date("Y-m-d H:i:s")
					);
					$ins2 = $this->sql->storeItems("project_logs",$params2);
					if(@$this->input->post("team_email") != "")
					{
						$emailTemplate = @$this->sql->getTableRowDataOrder("email_templates",array("template_for" => "register"));
				
						if(@sizeOf($emailTemplate) > 0)
						{		
							$to =@$this->input->post("team_email");
							$subject = @$emailTemplate[0]->template_subject;
							$msg = '';
							$username = '';
							$username = @ucwords($this->input->post("team_firstname")." ".$this->input->post("team_lastname"));
							$msg = @str_replace("{{USER}}",$username,@$emailTemplate[0]->template_body);
							$msg1 = @str_replace("{{APP_URL}}",base_url(),$msg);
							$msg2 = @str_replace("{{USER_EMAIL}}",$to,$msg1);
							$msg3 = @str_replace("{{USER_PWD}}","enmovil@123",$msg2);
							$message = $msg3;

							$this->sendMail($to,$subject,$message);
						}
					}
					 
					$this->session->set_userdata(array("teammessage" => "Successfully added member"));
				}
				else{
					$this->session->set_userdata(array("teammessage" => "Failed to added member"));
				}
				redirect(base_url()."index.php/team-members");
			}
		}
	}
	
	public function updateTeamMember(){
		
		if(@$this->session->userdata("ucode") == "")
		{
			redirect(base_url()."index.php/login");
		}
		else{
			if(@isset($_POST["saveMember"]))
			{
				$rowid = $this->input->post("rowid");
				$params =array(
					"firstname" => @$this->input->post("team_firstname"),
					"lastname" => @$this->input->post("team_lastname"),
					"email" => @$this->input->post("team_email"),
					"mobile_no" => @$this->input->post("team_mobile_no"),
					"position" => @$this->input->post("team_position")
				);
				$ins = $this->sql->updateItemsWithWhere("teams",$params, array("id" => $rowid));
				if($ins)
				{
					$params1 =array(
						"email" => @$this->input->post("team_email"),
					);
					$ins1 = $this->sql->updateItemsWithWhere("users",$params1, array("team_id" => $rowid));

					$user = $this->user;
					$team = @$this->sql->getTableRowDataOrder("teams",array("id" => @$user[0]->id));
					$params2 =array(
						"project_id" => 0,
						"task_id" => 0,
						"team_id" => @$rowid,
						"log_message" => "User #". @$this->input->post("team_firstname")." ". @$this->input->post("team_lastname")." has update information",
						"created_on" => @date("Y-m-d H:i:s")
					);
					$ins2 = $this->sql->storeItems("project_logs",$params2);

					$this->session->set_userdata(array("teammessage" => "Successfully update member"));
				}
				else{
					$this->session->set_userdata(array("teammessage" => "Failed to update member"));
				}
				redirect(base_url()."index.php/team-members");
			}
		}
	}

	
	public function tasks()
	{
		
		if(@$this->session->userdata("ucode") == "")
		{
			redirect(base_url()."index.php/login");
		}
		else{
			$user =$this->user;
			$data["user"] = $user;
			$data["menu"] = "tasks";
			$tasks = array();
			if($user[0]->role != "superadmin" && @$user[0]->role != "management")
			{


				if(@$user[0]->role == "delivery-manager")
				{
					$tprojects = @$this->sql->getTableRowDataOrder("team_projects",array("project_status" => 1, "d_manager" => $user[0]->team_id));
					$tprojectsid = array();
					if(@sizeOf($tprojects) > 0)
					{
						for($t=0;$t<sizeOf($tprojects);$t++)
						{
							array_push($tprojectsid,$tprojects[$t]->project_id);
						}
					}
					$ttasks = @$this->sql->getTableRowDataNoWhereArray("team_tasks",$tprojectsid,"project_id");
					// $ttasks = @$this->sql->getTableRowDataOrder("team_tasks",array("task_status" => 1, "team_lead_id" => $user[0]->team_id));
					
				}
				else if(@$user[0]->role == "project-manager")
				{
					$tprojects = @$this->sql->getTableRowDataOrder("team_projects",array("project_status" => 1, "p_manager" => $user[0]->team_id));
					$tprojectsid = array();
					if(@sizeOf($tprojects) > 0)
					{
						for($t=0;$t<sizeOf($tprojects);$t++)
						{
							array_push($tprojectsid,$tprojects[$t]->project_id);
						}
					}
					$ttasks = @$this->sql->getTableRowDataNoWhereArray("team_tasks",$tprojectsid,"project_id");
				}
				else if(@$user[0]->role == "lead" || @$user[0]->role == "team-lead")
				{
					// $teamsarr = @$this->sql->getTableRowDataOrder("teams",array("team_lead_id" => @$user[0]->team_id));
					
					$tprojects = @$this->sql->getTableRowDataOrder("team_projects",array("team_lead_id "  => $user[0]->team_id));
					$tprojectsid = array();
					if(@sizeOf($tprojects) > 0)
					{
						for($t=0;$t<sizeOf($tprojects);$t++)
						{
							array_push($tprojectsid,$tprojects[$t]->project_id);
						}
					}
					$ttasks = @$this->sql->getTableRowDataNoWhereArray("team_tasks",$tprojectsid,"project_id");
				}
				else{
					$ttasks = @$this->sql->getTableRowDataOrder("team_tasks",array("task_status" => 1, "team_id" => $user[0]->team_id));
				}

				// if(@$user[0]->role == "lead")
				// {
				// 	$ttasks = @$this->sql->getTableRowDataOrder("team_tasks",array("task_status" => 1, "team_lead_id" => $user[0]->team_id));
				// }
				// else{
				// 	$ttasks = @$this->sql->getTableRowDataOrder("team_tasks",array("task_status" => 1, "team_id" => $user[0]->team_id));
				// }
				$ttaskid = array();
				if(@sizeOf($ttasks) > 0)
				{
					for($t1=0;$t1<sizeOf($ttasks);$t1++)
					{
						@array_push($ttaskid,$ttasks[$t1]->task_id);
					}
				}
				if(@sizeOf($ttaskid) > 0)
				{
					$teamsarr = @$this->sql->getTableRowDataOrderArray("tasks","id",$ttaskid,"created_on","ASC");
				}
				else{
					$teamsarr = array();
				}
			}
			else{
				$teamsarr = @$this->sql->getAllInfo("tasks");
			}
			
			if(@sizeOf($teamsarr) > 0)
			{
				for($t=0;$t<sizeOf($teamsarr);$t++)
				{
					$assigns = @$this->sql->getTableRowDataOrder("team_tasks",array("task_id" => $teamsarr[$t]->id));
					$assignedTo = array();
					if(@sizeOf($assigns) > 0)
					{
						for($s=0;$s<sizeOf($assigns);$s++)
						{
							$assignedTo[] = array(
								"id" => $assigns[$s]->id,
								"userinfo" => @$this->sql->getTableRowDataOrder("teams",array("id" => $assigns[$s]->team_id)),
							);
						}
					}
					if($teamsarr[$t]->parent_task != 0)
					{
						$subtasks = array();
					}
					else{
						$subtasks = @$this->sql->getTableRowDataOrder("tasks",array("parent_task" => $teamsarr[$t]->id));
					}
					$tasks[]=array(
						"id" => $teamsarr[$t]->id,
						"project_id" => $teamsarr[$t]->project_id,
						"task_code" => $teamsarr[$t]->task_code,
						"task_name" => $teamsarr[$t]->task_name,
						"task_desc" => @$teamsarr[$t]->task_desc,
						"task_start_date" => $teamsarr[$t]->task_start_date,
						"task_end_date" => $teamsarr[$t]->task_end_date,
						"task_status" => $teamsarr[$t]->task_status,
						"created_by" => $teamsarr[$t]->created_by,
						"created_on" => $teamsarr[$t]->created_on,
						"project" => @$this->sql->getTableRowDataOrder("projects",array("id" => $teamsarr[$t]->project_id)),
						"assignBy" => @$this->sql->getTableRowDataOrder("teams",array("id" => $teamsarr[$t]->created_by)),
						"attachments" => @$this->sql->getTableRowDataOrder("task_documents",array("task_id" => $teamsarr[$t]->id)),
						"assignTo" => @$assignedTo,
						"subtasks" => @$subtasks
					);
				}
			}
			if(@sizeOf($tasks) > 0)
			{
				$aa = @json_encode($tasks);
				$rcs = @json_decode($aa);
			}
			else{
				$rcs=array();
			}
			$data["tasks"] = @$rcs;
			$this->load->view('header',$data);
			$this->load->view('tasks',$data);
			$this->load->view('footer',$data);
		}
	}

	public function createTask()
	{
		
		if(@$this->session->userdata("ucode") == "")
		{
			redirect(base_url()."index.php/login");
		}
		else{
			$data["user"] = $this->user;
			$data["menu"] = "tasks";
			$data["projects"] = @$this->sql->getTableRowDataOrder("projects",array("project_status" => 1));
			$data["teams"] = @$this->sql->getTableRowDataOrder("teams",array("team_status" => 1));
			$this->load->view('header',$data);
			$this->load->view('create-task',$data);
			$this->load->view('footer',$data);
		}
	}
	
	public function saveTask(){
		// echo "<pre>";print_R($_REQUEST);
		// echo "<pre>";print_R($_FILES);
		
		// die();
		if(@$this->session->userdata("ucode") == "")
		{
			redirect(base_url()."index.php/login");
		}
		else{
			// if(@isset($_POST["saveMember"]))
			// {
				$user = $this->user;
				if(@$user[0]->team_id == 0)
				{
					$assingedby = 1;
				}
				else{
					$assingedby = @$user[0]->team_id;
				}
				$taskcode = "TK-".@date("Ymdhis");
				if(@$this->input->post("task_owners") != "")
				{
					if(@sizeOf($this->input->post("task_owners")) > 0)
					{
						$onrs = @implode("|",$this->input->post("task_owners"));
					}
					else{
						$onrs = "";
					}
				}
				else{
					$onrs = "";
				}
				if(@$this->input->post("parentTaskID") != '')
				{
					$ptask = @$this->sql->getTableRowDataOrder("tasks",array("id" => @$this->input->post("parentTaskID")));
					if(@sizeOf($ptask) > 0)
					{
						$pid = $ptask[0]->project_id;
					}
					else{
						$pid =0;
					}
					
					$project = @$this->sql->getTableRowDataOrder("projects",array("id" => @$pid));
					$params =array(
						"parent_task" => @$this->input->post("parentTaskID"),
						"project_id" => @$pid,
						"task_code" => $taskcode,
						"task_name" => @$this->input->post("task_name"),
						"task_desc" => @$this->input->post("task_desc"),
						"task_start_date" => @date("Y-m-d",strtotime($this->input->post("task_start_date"))),
						"task_end_date" => @date("Y-m-d",strtotime($this->input->post("task_end_date"))),
						"task_status" => 1,
						"severity" => @$this->input->post("severity"),
						"priority" => @$this->input->post("priority"),
						"resoltuion" => @$this->input->post("resoltuion"),
						"task_notes" => @$this->input->post("task_notes"),
						"task_owners" => @$onrs,
						"created_by" => @$user[0]->team_id,
						"created_on" => @date("Y-m-d H:i:s")
					);

				}
				else{
					
					$project = @$this->sql->getTableRowDataOrder("projects",array("id" => @$this->input->post("project_id")));
					$params =array(
						"project_id" => @$this->input->post("project_id"),
						"task_code" => $taskcode,
						"task_name" => @$this->input->post("task_name"),
						"task_desc" => @$this->input->post("task_desc"),
						"task_start_date" => @date("Y-m-d",strtotime($this->input->post("task_start_date"))),
						"task_end_date" => @date("Y-m-d",strtotime($this->input->post("task_end_date"))),
						"task_status" => 1,
						"severity" => @$this->input->post("severity"),
						"priority" => @$this->input->post("priority"),
						"resoltuion" => @$this->input->post("resoltuion"),
						"task_notes" => @$this->input->post("task_notes"),
						"task_owners" => @$onrs,
						"created_by" => @$user[0]->team_id,
						"created_on" => @date("Y-m-d H:i:s")
					);
				}
				$ins = $this->sql->storeItems("tasks",$params);
				if($ins)
				{
					if(!empty($_FILES['file']['name'])){
						for($f=0;$f<sizeOf($_FILES['file']['name']);$f++)
						{
			
							// Set preference
							$filename = time()."_".$_FILES['file']['name'][$f];
			
								$paramsat = array(
									"project_id" => $this->input->post("project_id"),
									"task_id" => $ins,
									"task_doc" => $filename,
									"created_on" => @date("Y-m-d H:i:s"),
									"uploaded_by" => $this->user[0]->email,
									"uploaded_by_user_code" => $this->user[0]->user_code,
								);
								$insa = $this->sql->storeItems("task_documents",$paramsat);
								if($insa)
								{
									$user = $this->user;
									$task = @$this->sql->getTableRowDataOrder("tasks",array("id" => @$ins));			
									$team = @$this->sql->getTableRowDataOrder("teams",array("id" => @$user[0]->id));				
									$project = @$this->sql->getTableRowDataOrder("projects",array("id" => @$projectid));
									$params2 =array(
										"project_id" => @$this->input->post("project_id"),
										"task_id" => $ins,
										"team_id" => @$user[0]->id,
										"log_message" => 'Uploaded files to task # <a href="'.base_url().'view-task/'.@$task[0]->task_code.'">'. @$task[0]->task_name.'</a> by '.@$team[0]->firstname.' '.@$team[0]->lastname,
										"created_on" => @date("Y-m-d H:i:s")
									);
									$ins2 = $this->sql->storeItems("project_logs",$params2);
									@move_uploaded_file($_FILES["file"]['tmp_name'][$f],"uploads/projects/docs/".$filename);
									//$this->reloadPage($projectid);
								}
							//}
						}
					}


					$user = $this->user;
					$team = @$this->sql->getTableRowDataOrder("teams",array("id" => @$user[0]->id));
					$assignuser = @$this->sql->getTableRowDataOrder("users",array("team_id" => @$this->input->post("team_id")));
					$assignteam = @$this->sql->getTableRowDataOrder("teams",array("id" => @$this->input->post("team_id")));
					if($assignuser[0]->role == "lead")
					{
						$leadid = $assignuser[0]->team_id;
					}
					else{
						$leadid = @$assignteam[0]->team_lead_id;
					}
					$params1 =array(
						"project_id" => @$this->input->post("project_id"),
						"task_id" => $ins,
						"team_lead_id" => @$leadid,
						"team_id" => @$this->input->post("team_id"),
						"start_date" => @date("Y-m-d",strtotime($this->input->post("task_start_date"))),
						"end_date" => @date("Y-m-d",strtotime($this->input->post("task_end_date"))),
						"task_status" => 1,
						"created_on" => @date("Y-m-d H:i:s")
					);
					$ins1 = $this->sql->storeItems("team_tasks",$params1);
					$msg = 'A new task # <a href="'.base_url().'view-task/'.$taskcode.'">'. @$this->input->post("task_name").'</a> has created by '.@$team[0]->firstname.' '.@$team[0]->lastname.' to the project #'.@$project[0]->project_name.'  and assigned to '.@$assignteam[0]->firstname.' '.@$assignteam[0]->lastname;
					$params2 =array(
						"project_id" => @$this->input->post("project_id"),
						"task_id" => $ins,
						"team_id" => @$this->input->post("team_id"),
						"log_message" => @$msg,
						"created_on" => @date("Y-m-d H:i:s")
					);
					$ins2 = $this->sql->storeItems("project_logs",$params2);
					$ownerlist = @$this->input->post("task_owners");
					if(@sizeOf($ownerlist) > 0)
					{
						for($w=0;$w<sizeOf($ownerlist);$w++)
						{
							$oUser = @$this->sql->getTableRowDataOrder("users",array("team_id" => $ownerlist[$w]));
							if(@sizeOf($oUser) > 0)
							{
								$to = @$oUser[0]->email;
								$subject = "New Task has created to project #".@$project[0]->project_name;
								$message = @$msg;
								$this->sendMail($to,$subject,$message);
								
							}
						}
					}
					$to1 = @$oUser[0]->email;
					$subject1 = "New Task has assigned";
					$message1 = @$msg;
					$this->sendMail($to1,$subject1,$message1);
					$this->session->set_userdata(array("taskmessage" => "Successfully added task"));
					if(empty($_FILES['file']['name']) == 1)
					{
						redirect(base_url()."index.php/tasks");
					}
					else{
						echo 1;
					}
				}
				else{
					$this->session->set_userdata(array("taskmessage" => "Failed to added task"));
					if(empty($_FILES['file']['name']) == 1)
					{
						redirect(base_url()."index.php/tasks");
					}
					else{
						echo 0;
					}
				}
				// 
			// }
		}
	}
	public function sendMail($to,$subject,$message,$cc=null)
	{

		
		$curl = curl_init();

		curl_setopt_array($curl, array(
		CURLOPT_URL => 'http://autometrics.in/ml/sendAdhocEmails',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS => 'to_emails='.$to.'&cc_emails='.$cc.'&subject='.$subject.'&body='.$message,
		CURLOPT_HTTPHEADER => array(
			'Content-Type: application/x-www-form-urlencoded'
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		echo $response;

		// $headers = "MIME-Version: 1.0" . "\r\n";
		// $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		// // More headers
		// $headers .= 'From: venjalla.j@gmail.com' . "\r\n";

		// @mail($to,$subject,$message,$headers);


		// $this->load->library('phpmailer_lib');
        
        // // PHPMailer object
        // $mail = $this->phpmailer_lib->load();
        // // SMTP configuration
        // $mail->isSMTP();
        // $mail->Host     = 'smtp.gmail.com';
        // $mail->SMTPAuth = true;
        // $mail->Username = 'venjalla.j@gmail.com';
        // $mail->Password = 'venJ@lla86';
        // $mail->SMTPSecure = 'tls';
        // $mail->Port     = 465;
        
        // $mail->setFrom('venjalla.j@gmail.com', 'Enmovil Team');
        // // $mail->addReplyTo('info@example.com', 'CodexWorld');
        
        // // Add a recipient
        // $mail->addAddress($to);
        
        // // Add cc or bcc 
        // // $mail->addCC('cc@example.com');
        // // $mail->addBCC('bcc@example.com');
        
        // // Email subject
        // $mail->Subject = $subject;
        
        // // Set email format to HTML
        // $mail->isHTML(true);
        
        // // Email body content
        // $mailContent = $message;
        // $mail->Body = $mailContent;
        // echo "<pre>"; print_R($mail);echo "</pre>";


		// use PHPMailer\PHPMailer\PHPMailer; 
		// use PHPMailer\PHPMailer\Exception; 
		
		// $email = new PHPMailer;
		// // getting post values
		// $toemail=$to;	
		// $subject=$subject;	
		// $message=$message;
		// $email = new PHPMailer();
		// $email->isSMTP();
		// $email->SMTPDebug = 1;
		// $email->SMTPAuth = true; 
		// $email->SMTPSecure = 'tls';
		// $email->Host = "smtp.gmail.com"; 
		// $email->Port = 465;
		// $email->Username = "venjalla.j@gmail.com"; 
		// $email->Password = "venJ@lla86";
		// $email->From = "venjalla.j@gmail.com"; 
		// $email->FromName = "Enmovil";
		// $email->Subject = $subject;
		// $email->Body = $message; 
		// $email->AddAddress($to);

		// //$mail->AddAttachment("module.txt"); // attachment
		// //$mail->AddAttachment("new.jpg"); // attachment
		// $email->IsHTML(true); 
		// $email->AltBody = "This is the body when user views in plain text format"; 

		// if(!$email->Send()) {
		// 	echo "Mailer Error: " . $email->ErrorInfo;
		// } else {
		// 	echo "Message has been sent";
		// }


		// $config = Array(
		// 	'protocol' => 'smtp',
		// 	'smtp_host' => 'smtp.gmail.com',
		// 	'smtp_port' => 465,
		// 	'smtp_user' => 'venjalla.j@gmail.com', // change it to yours
		// 	'smtp_pass' => 'venJ@lla86', // change it to yours
		// 	'mailtype' => 'html',
		// 	'charset' => 'iso-8859-1',
		// 	'wordwrap' => TRUE
		//   );
		  
		// $this->load->library('email',$config);
        // $this->email->from('venjalla.j@gmail.com', 'Enmovil');
        // $this->email->to($to);
        // $this->email->subject($subject);
        // $this->email->message($message);
        // //Send mail
        // echo "<pre>";print_r($this->email->send());echo "</pre>";
		// if($this->email->send())
		// {
		// 	echo "Mail sent successfully";
		// }
		// else{
		// 	echo "Failed to send Mail";
		// 	echo "<pre>";print_R($this->email);echo "</pre>";
		// }


	}
	public function viewTask($code)
	{
		
		if(@$this->session->userdata("ucode") == "")
		{
			redirect(base_url()."index.php/login");
		}
		else{
			$data["user"] = $this->user;
			$data["menu"] = "tasks";
			$data["rowid"] = @$code;
			$task = @$this->sql->getTableRowDataOrder("tasks",array("task_code" => @$code));
			$data["task"] = @$this->sql->getTableRowDataOrder("tasks",array("task_code" => @$code));
			$data["subtasks"] = @$this->sql->getTableRowDataOrder("tasks",array("parent_task" => @$task[0]->id));
			$data["projects"] = @$this->sql->getTableRowDataOrder("projects",array("project_status" => 1));
			$data["teams"] = @$this->sql->getTableRowDataOrder("teams",array("team_status" => 1));
			$data["teamtasks"] = @$this->sql->getTableRowDataOrder("team_tasks",array("task_id" => @$task[0]->id));
			$data["taskdocs"] = @$this->sql->getTableRowDataOrder("task_documents",array("task_id" => @$task[0]->id));
			$this->load->view('header',$data);
			$this->load->view('view-task',$data);
			$this->load->view('footer',$data);
		}
	}
	public function editTask($code)
	{
		
		if(@$this->session->userdata("ucode") == "")
		{
			redirect(base_url()."index.php/login");
		}
		else{
			$task = @$this->sql->getTableRowDataOrder("tasks",array("task_code" => @$code));
			$rowid = @$task[0]->id;
			$data["user"] = $this->user;
			$data["menu"] = "tasks";
			$data["rowid"] = @$rowid;
			$data["task"] =  $task;
			$data["projects"] = @$this->sql->getTableRowDataOrder("projects",array("project_status" => 1));
			$data["teams"] = @$this->sql->getTableRowDataOrder("teams",array("team_status" => 1));
			$data["teamtask"] = @$this->sql->getTableRowDataOrder("team_tasks",array("task_status" => 1,"task_id" => $rowid),"id","DESC");
			$data["taskdocs"] = @$this->sql->getTableRowDataOrder("task_documents",array("task_id" => @$rowid));
			$this->load->view('header',$data);
			$this->load->view('edit-task',$data);
			$this->load->view('footer',$data);
		}
	}
	public function updateTask(){
		
		if(@$this->session->userdata("ucode") == "")
		{
			redirect(base_url()."index.php/login");
		}
		else{
			if(@isset($_POST["saveMember"]))
			{
				$rowid = $this->input->post("rowid");
				$user = $this->user;
				$task = @$this->sql->getTableRowDataOrder("tasks",array("id" => @$rowid));	
				$team = @$this->sql->getTableRowDataOrder("teams",array("id" => @$user[0]->id));

				if(@$this->input->post("task_owners") != "")
				{
					if(@sizeOf($this->input->post("task_owners")) > 0)
					{
						$onrs = @implode("|",$this->input->post("task_owners"));
					}
					else{
						$onrs = "";
					}
				}
				else{
					$onrs = "";
				}
				$params =array(
					"project_id" => @$this->input->post("project_id"),
					"task_name" => @$this->input->post("task_name"),
					"task_desc" => @$this->input->post("task_desc"),
					"task_start_date" => @date("Y-m-d",strtotime($this->input->post("task_start_date"))),
					"task_end_date" => @date("Y-m-d",strtotime($this->input->post("task_end_date"))),
					"severity" => @$this->input->post("severity"),
					"priority" => @$this->input->post("priority"),
					"resoltuion" => @$this->input->post("resoltuion"),
					"task_owners" => @$onrs,
					"task_notes" => @$this->input->post("task_notes"),
				);


				// $params =array(
				// 	"task_name" => @$this->input->post("task_name"),
				// 	"project_id" => @$this->input->post("project_id"),
				// 	"task_start_date" => @date("Y-m-d",strtotime($this->input->post("task_start_date"))),
				// 	"task_end_date" => @date("Y-m-d",strtotime($this->input->post("task_end_date"))),
				// );
				$ins = $this->sql->updateItemsWithWhere("tasks",$params, array("id" => $rowid));
				if($ins)
				{
					$msg =  "A task # <a href='".base_url()."view-task/".@$task[0]->task_code."'>". @$task[0]->task_name."</a> has update by ".@$team[0]->firstname." ".@$team[0]->lastname." ";
					$user = $this->user;
					$team = @$this->sql->getTableRowDataOrder("teams",array("id" => @$user[0]->id));				
					$project = @$this->sql->getTableRowDataOrder("projects",array("id" => @$this->input->post("project_id")));
					$params2 =array(
						"project_id" => @$this->input->post("project_id"),
						"task_id" => $rowid,
						"team_id" => @$user[0]->id,
						"log_message" =>@$msg,
						"created_on" => @date("Y-m-d H:i:s")
					);
					$ins2 = $this->sql->storeItems("project_logs",$params2);

					$ownerlist = @$this->input->post("task_owners");
					if(@sizeOf($ownerlist) > 0)
					{
						for($w=0;$w<sizeOf($ownerlist);$w++)
						{
							$oUser = @$this->sql->getTableRowDataOrder("users",array("team_id" => $ownerlist[$w]));
							if(@sizeOf($oUser) > 0)
							{
								$to = @$oUser[0]->email;
								$subject = "Modeified Task #".@$task[0]->task_name;
								$message = @$msg;
								$this->sendMail($to,$subject,$message);
								
							}
						}
					}
					$to1 = @$oUser[0]->email;
					$subject1 = "Modeified Task #".@$task[0]->task_name;
					$message1 = @$msg;
					echo $this->sendMail($to1,$subject1,$message1);
					
					$this->session->set_userdata(array("taskmessage" => "Successfully update task"));
				}
				else{
					$this->session->set_userdata(array("taskmessage" => "Failed to update task"));
				}
				redirect(base_url()."index.php/tasks");
			}
		}
	}

	public function uploadTaskFolder($projectid, $taskid){
		// print_R($_FILES['file']['name']);
		if(!empty($_FILES['file']['name'])){
			for($f=0;$f<sizeOf($_FILES['file']['name']);$f++)
			{

				// Set preference
				$filename = time()."_".$_FILES['file']['name'][$f];
				// $config['upload_path'] = FCPATH.'uploads/projects/docs/';	
				// $config['allowed_types'] = 'jpg|jpeg|png|gif|doc|docx|pdf|ppt|pptx|xls|xlsx|pdfx';
				// $config['max_size']    = 1024*5; // max_size in kb
				// $config['file_name'] = $filename;

						
				// //Load upload library
				// $this->load->library('upload',$config);			
					
				// // File upload
				// if($this->upload->do_upload('file')){
				// 	// Get data about the file
				// 	$uploadData = $this->upload->data();

					$params = array(
						"project_id" => $projectid,
						"task_id" => $taskid,
						"task_doc" => $filename,
						"created_on" => @date("Y-m-d H:i:s"),
						"uploaded_by" => $this->user[0]->email,
						"uploaded_by_user_code" => $this->user[0]->user_code,
					);
					$ins = $this->sql->storeItems("task_documents",$params);
					if($ins)
					{
						$user = $this->user;
						$task = @$this->sql->getTableRowDataOrder("tasks",array("id" => @$taskid));			
						$team = @$this->sql->getTableRowDataOrder("teams",array("id" => @$user[0]->id));				
						$project = @$this->sql->getTableRowDataOrder("projects",array("id" => @$projectid));
						$params2 =array(
							"project_id" => @$projectid,
							"task_id" => $taskid,
							"team_id" => @$user[0]->id,
							"log_message" => "Uploaded files to task # <a href='".base_url()."'/view-task/'".@$task[0]->task_code."'>". @$task[0]->task_name."</a> by ".@$team[0]->firstname." ".@$team[0]->lastname." ",
							"created_on" => @date("Y-m-d H:i:s")
						);
						$ins2 = $this->sql->storeItems("project_logs",$params2);
						@move_uploaded_file($_FILES["file"]['tmp_name'][$f],"uploads/projects/docs/".$filename);
						//$this->reloadPage($projectid);
					}
				//}
			}
		}
	}

	public function updateTaskStatus($taskid,$project_id,$status)
	{
		
		if(@$this->session->userdata("ucode") == "")
		{
			redirect(base_url()."index.php/login");
		}
		else{
			$params = array(
				"task_status" => $status
			);
			$where=array("project_id" => $project_id,"id" => $taskid);
			$upd = $this->sql->updateItemsWithWhere("tasks", $params,$where);
		
			if($upd)
			{		
				$this->session->set_userdata(array("taskmessage" => "Successfully Update Task"));
				redirect(base_url()."index.php/tasks");	
			}
			else{
				$this->session->set_userdata(array("taskmessage" => "Failed To Update Task"));
				redirect(base_url()."index.php/tasks");
			}
		}
	}
	

	public function addSubTask($parentCode)
	{
		
		if(@$this->session->userdata("ucode") == "")
		{
			redirect(base_url()."index.php/login");
		}
		else{
			$data["user"] = $this->user;
			$data["menu"] = "tasks";
			$data["parentCode"] = $parentCode;
			$data["projects"] = @$this->sql->getTableRowDataOrder("projects",array("project_status" => 1));
			$data["teams"] = @$this->sql->getTableRowDataOrder("teams",array("team_status" => 1));
			$data["parentTask"] = @$this->sql->getTableRowDataOrder("tasks",array("task_code" => @$parentCode));
			$this->load->view('header',$data);
			$this->load->view('create-task',$data);
			$this->load->view('footer',$data);
		}
	}
	
	public function saveSubTask(){
		// echo "<pre>";print_R($_REQUEST);
		// echo "<pre>";print_R($_FILES);
		
		// die();
		if(@$this->session->userdata("ucode") == "")
		{
			redirect(base_url()."index.php/login");
		}
		else{
			// if(@isset($_POST["saveMember"]))
			// {
				$user = $this->user;
				if(@$user[0]->team_id == 0)
				{
					$assingedby = 1;
				}
				else{
					$assingedby = @$user[0]->team_id;
				}
				$taskcode = "TK-".@date("Ymdhis");
				if(@$this->input->post("task_owners") != "")
				{
					if(@sizeOf($this->input->post("task_owners")) > 0)
					{
						$onrs = @implode("|",$this->input->post("task_owners"));
					}
					else{
						$onrs = "";
					}
				}
				else{
					$onrs = "";
				}
				$params =array(
					"parent_task" => @$this->input->post("parentTaskID"),
					"project_id" => @$this->input->post("project_id"),
					"task_code" => $taskcode,
					"task_name" => @$this->input->post("task_name"),
					"task_desc" => @$this->input->post("task_desc"),
					"task_start_date" => @date("Y-m-d",strtotime($this->input->post("task_start_date"))),
					"task_end_date" => @date("Y-m-d",strtotime($this->input->post("task_end_date"))),
					"task_status" => 1,
					"severity" => @$this->input->post("severity"),
					"priority" => @$this->input->post("priority"),
					"resoltuion" => @$this->input->post("resoltuion"),
					"task_notes" => @$this->input->post("task_notes"),
					"task_owners" => @$onrs,
					"created_by" => @$user[0]->team_id,
					"created_on" => @date("Y-m-d H:i:s")
				);
				$ins = $this->sql->storeItems("tasks",$params);
				if($ins)
				{
					if(!empty($_FILES['file']['name'])){
						for($f=0;$f<sizeOf($_FILES['file']['name']);$f++)
						{
			
							// Set preference
							$filename = time()."_".$_FILES['file']['name'][$f];
			
								$paramsat = array(
									"project_id" => $this->input->post("project_id"),
									"task_id" => $ins,
									"task_doc" => $filename,
									"created_on" => @date("Y-m-d H:i:s"),
									"uploaded_by" => $this->user[0]->email,
									"uploaded_by_user_code" => $this->user[0]->user_code,
								);
								$insa = $this->sql->storeItems("task_documents",$paramsat);
								if($insa)
								{
									$user = $this->user;
									$task = @$this->sql->getTableRowDataOrder("tasks",array("id" => @$ins));			
									$team = @$this->sql->getTableRowDataOrder("teams",array("id" => @$user[0]->id));				
									$project = @$this->sql->getTableRowDataOrder("projects",array("id" => @$projectid));
									$params2 =array(
										"project_id" => @$this->input->post("project_id"),
										"task_id" => $ins,
										"team_id" => @$user[0]->id,
										"log_message" => 'Uploaded files to task # <a href="'.base_url().'view-task/'.@$task[0]->task_code.'">'. @$task[0]->task_name.'</a> by '.@$team[0]->firstname.' '.@$team[0]->lastname,
										"created_on" => @date("Y-m-d H:i:s")
									);
									$ins2 = $this->sql->storeItems("project_logs",$params2);
									@move_uploaded_file($_FILES["file"]['tmp_name'][$f],"uploads/projects/docs/".$filename);
									//$this->reloadPage($projectid);
								}
							//}
						}
					}


					$user = $this->user;
					$team = @$this->sql->getTableRowDataOrder("teams",array("id" => @$user[0]->id));
					$assignuser = @$this->sql->getTableRowDataOrder("users",array("team_id" => @$this->input->post("team_id")));
					$assignteam = @$this->sql->getTableRowDataOrder("teams",array("id" => @$this->input->post("team_id")));
					$project = @$this->sql->getTableRowDataOrder("projects",array("id" => @$this->input->post("project_id")));
					if($assignuser[0]->role == "lead")
					{
						$leadid = $assignuser[0]->team_id;
					}
					else{
						$leadid = @$assignteam[0]->team_lead_id;
					}
					$params1 =array(
						"project_id" => @$this->input->post("project_id"),
						"task_id" => $ins,
						"team_lead_id" => @$leadid,
						"team_id" => @$this->input->post("team_id"),
						"start_date" => @date("Y-m-d",strtotime($this->input->post("task_start_date"))),
						"end_date" => @date("Y-m-d",strtotime($this->input->post("task_end_date"))),
						"task_status" => 1,
						"created_on" => @date("Y-m-d H:i:s")
					);
					$ins1 = $this->sql->storeItems("team_tasks",$params1);
					$msg = 'A new task # <a href="'.base_url().'view-task/'.$taskcode.'">'. @$this->input->post("task_name").'</a> has created by '.@$team[0]->firstname.' '.@$team[0]->lastname.' to the project #'.@$project[0]->project_name.'  and assigned to '.@$assignteam[0]->firstname.' '.@$assignteam[0]->lastname;
					$params2 =array(
						"project_id" => @$this->input->post("project_id"),
						"task_id" => $ins,
						"team_id" => @$this->input->post("team_id"),
						"log_message" => @$msg,
						"created_on" => @date("Y-m-d H:i:s")
					);
					$ins2 = $this->sql->storeItems("project_logs",$params2);
					$ownerlist = @$this->input->post("task_owners");
					if(@sizeOf($ownerlist) > 0)
					{
						for($w=0;$w<sizeOf($ownerlist);$w++)
						{
							$oUser = @$this->sql->getTableRowDataOrder("users",array("team_id" => $ownerlist[$w]));
							if(@sizeOf($oUser) > 0)
							{
								$to = @$oUser[0]->email;
								$subject = "New Task has created to project #".@$project[0]->project_name;
								$message = @$msg;
								$this->sendMail($to,$subject,$message);
								
							}
						}
					}
					$to1 = @$oUser[0]->email;
					$subject1 = "New Task has assigned";
					$message1 = @$msg;
					$this->sendMail($to1,$subject1,$message1);
					$this->session->set_userdata(array("taskmessage" => "Successfully added task"));
					if(empty($_FILES['file']['name']) == 1)
					{
						redirect(base_url()."index.php/tasks");
					}
					else{
						echo 1;
					}
				}
				else{
					$this->session->set_userdata(array("taskmessage" => "Failed to added task"));
					if(empty($_FILES['file']['name']) == 1)
					{
						redirect(base_url()."index.php/tasks");
					}
					else{
						echo 0;
					}
				}
				// 
			// }
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
	public function assignMemberToLead()
	{
		
		if(@$this->session->userdata("ucode") == "")
		{
			redirect(base_url()."index.php/login");
		}
		else{
			$user = $this->user;
			$data["user"] = $this->user;
			$data["menu"] = "projects";
			if(@$user[0]->role == "delivery-manager")
			{
				$data["leads"] = @$this->sql->getTableRowDataOrder("teams",array("position" => "team-lead"));
				$data["teams"] = @$this->sql->getTableRowDataOrder("teams",array("position !=" => "team-lead"));
			}
			else if(@$user[0]->role == "project-manager")
			{
				$data["leads"] = @$this->sql->getTableRowDataOrder("teams",array("position" => "team-lead"));
				$data["teams"] = @$this->sql->getTableRowDataOrder("teams",array("position !=" => "team-lead"));
			}
			else if(@$user[0]->role == "lead" || @$user[0]->role == "team-lead")
			{
				$data["leads"] = @$this->sql->getTableRowDataOrder("teams",array("position" => "team-lead","id" => @$user[0]->team_id));
				$data["teams"] = @$this->sql->getTableRowDataOrder("teams",array("position " => "team-executive","team_lead_id" => @$user[0]->team_id));
			}
			else{
				$data["leads"] = @$this->sql->getTableRowDataOrder("teams",array("position" => "team-lead","team_id" => @$user[0]->team_id));
				$data["teams"] = @$this->sql->getTableRowDataOrder("teams",array("position " => "team-executive","id" => @$user[0]->team_id));
			}	
			$this->load->view('header',$data);
			$this->load->view('assign-team-member',$data);
			$this->load->view('footer',$data);
		}
	}
	public function saveAssignMember()
	{
		
		if(@$this->session->userdata("ucode") == "")
		{
			redirect(base_url()."index.php/login");
		}
		else{
			// print_R($_REQUEST);
			$teammembers = $this->input->post("teammembers");
			$set=0;
			if(@sizeOf($teammembers) > 0)
			{
				for($t=0;$t<sizeOf($teammembers);$t++)
				{
					$params = array(
						"team_lead_id" => @$this->input->post("team_lead")
					);
					$where = array("id" => $teammembers[$t]);
					$upd = $this->sql->updateItemsWithWhere("teams", $params,$where);
					if($upd)
					{
						$teamlead = @$this->sql->getTableRowDataOrder("teams",array("id" => @$this->input->post("team_lead")));
						$teammember = @$this->sql->getTableRowDataOrder("teams",array("id" => @$teammembers[$t]));
						$params2 =array(
							"project_id" => 0,
							"task_id" => 0,
							"team_id" => @$teammembers[$t],
							"log_message" => "User #".@$teammember[0]->firstname." ".@$teammember[0]->lastname." has assigned to lead ".@$teamlead[0]->firstname." ".@$teamlead[0]->lastname."",
							"created_on" => @date("Y-m-d H:i:s")
						);
						$ins2 = $this->sql->storeItems("project_logs",$params2);
						
						$set = 1;
					}
				}
			}
			if($set == 1)
			{	
				$this->session->set_userdata(array("teammessage" => "Successfully Assigned Members"));
				redirect(base_url()."index.php/team-members");	
			}
			else{
				$this->session->set_userdata(array("teammessage" => "Failed to assigned members"));
				redirect(base_url()."index.php/team-members");
			}
		}
	}
	public function myteam($leadname)
	{
		
		if(@$this->session->userdata("ucode") == "")
		{
			redirect(base_url()."index.php/login");
		}
		else{
			$lead=@$this->sql->getTableRowDataOrder("teams",array("team_status" => 1,"id" => $leadname));
			
			$data["user"] = $this->user;
			$data["menu"] = "teams";
			$teams = [];
			$teamsarr = @$this->sql->getTableRowDataOrder("teams",array("team_status" => 1,"team_lead_id" => $lead[0]->id));
			if(@sizeOf($teamsarr) > 0)
			{
				for($t=0;$t<sizeOf($teamsarr);$t++)
				{
					$teams[]=array(
						"id" => $teamsarr[$t]->id,
						"team_lead_id" => $teamsarr[$t]->team_lead_id,
						"firstname" => $teamsarr[$t]->firstname,
						"lastname" => $teamsarr[$t]->lastname,
						"email" => $teamsarr[$t]->email,
						"mobile_no" => $teamsarr[$t]->mobile_no,
						"position" => $teamsarr[$t]->position,
						"team_status" => $teamsarr[$t]->team_status,
						"created_on" => $teamsarr[$t]->created_on,
						"projects" => @$this->sql->getTableRowDataOrder("team_projects",array("team_id" => $teamsarr[$t]->id)),
						"tasks" => @$this->sql->getTableRowDataOrder("team_tasks",array("team_id" => $teamsarr[$t]->id)),
						"logininfo" => @$this->sql->getTableRowDataOrder("users",array("team_id" => $teamsarr[$t]->id))
					);
				}
			}
			if(@sizeOf($teams) > 0)
			{
				$tra = @json_encode($teams);
				$tr = @json_decode($tra);
			}
			else{
				$tr = array();
			}
			$data["teams"] = @$tr;
			$this->load->view('header',$data);
			$this->load->view('team-lead-members',$data);
			$this->load->view('footer',$data);
		}
	}

	public function teamprojects()
	{
		
		if(@$this->session->userdata("ucode") == "")
		{
			redirect(base_url()."index.php/login");
		}
		else{	
			
			$user = $this->user;
			$data["user"] = $user;
			$data["smenu"] = "teamprojects";
			$data["menu"] = "projects";
			$projects = array();
				
			if(@sizeOf($user) > 0)
			{
				if(@$user[0]->role != "superadmin" && @$user[0]->role != "management")
				{
					if(@$user[0]->role == "delivery-manager")
					{
						$projectsarr = @$this->sql->getTableRowDataOrder("team_projects",array("project_status" => 1, "d_manager" => $user[0]->team_id));
					}
					else if(@$user[0]->role == "project-manager")
					{
						$projectsarr = @$this->sql->getTableRowDataOrder("team_projects",array("project_status" => 1, "p_manager" => $user[0]->team_id));
					}
					else if(@$user[0]->role == "lead" || @$user[0]->role == "team-lead")
					{
						$projectsarr = @$this->sql->getTableRowDataOrder("team_projects",array("team_lead_id "  => $user[0]->team_id));
					}
					else{
						$projectsarr = @$this->sql->getTableRowDataOrder("team_projects",array("team_id "  => $user[0]->team_id));
					}	
					// $tprojectsid = array();
					// if(@sizeOf($tprojects) > 0)
					// {
					// 	for($t=0;$t<sizeOf($tprojects);$t++)
					// 	{
					// 		array_push($tprojectsid,$tprojects[$t]->project_id);
					// 	}
					// }
					// $data["projects"] = @$this->sql->getTableRowDataNoWhereArray("projects",$tprojectsid,"id");
					// if(@$user[0]->role == "lead")
					// {
					// 	$projectsarr = @$this->sql->getTableRowDataOrder("team_projects",array("team_lead_id "  => $user[0]->team_id));
					// }
					// else{
					// 	$projectsarr = @$this->sql->getTableRowDataOrder("team_projects",array("team_id "  => $user[0]->team_id));
					// }
				}
				else{
					$projectsarr = @$this->sql->getTableRowDataOrder("team_projects",array("project_status "  => 1));
				}
				if(@sizeOf($projectsarr) > 0)
				{
					for($t=0;$t<sizeOf($projectsarr);$t++)
					{
						$projects[]=array(
							"id" => $projectsarr[$t]->id,
							"team_lead_id" => $projectsarr[$t]->team_lead_id,
							"team_id" => $projectsarr[$t]->team_id,
							"project_id" => $projectsarr[$t]->project_id,
							"project_start_date" => $projectsarr[$t]->project_start_date,
							"project_end_date" => $projectsarr[$t]->project_end_date,
							"project_status" => $projectsarr[$t]->project_status,
							"created_on" => $projectsarr[$t]->created_on,
							"team" => @$this->sql->getTableRowDataOrder("teams",array("id" => $projectsarr[$t]->team_id)),
							"project" => @$this->sql->getTableRowDataOrder("projects",array("id" => $projectsarr[$t]->project_id)),
							"tasks" => @$this->sql->getTableRowDataOrder("team_tasks",array("project_id" => $projectsarr[$t]->project_id))
						);
					}
				}
			}
			else{
				$projects = array();
			}

			
			if(@sizeOf($projects) > 0)
			{
				$prs = @json_encode($projects);
				
				$data["projects"] = @json_decode($prs);
			}
			else{
				$prs = array();
				$data["projects"] = $prs;
			}
			
			$this->load->view('header',$data);
			$this->load->view('team-projects',$data);
			$this->load->view('footer',$data);
		}
	}
	public function assignProjectToLead()
	{
		
		if(@$this->session->userdata("ucode") == "")
		{
			redirect(base_url()."index.php/login");
		}
		else{
			$user = $this->user;
			$data["user"] = $this->user;
			$data["menu"] = "projects";
			$data["leads"] = @$this->sql->getTableRowDataOrder("teams",array("position" => "team-lead"));
			$data["dmanagers"] = @$this->sql->getTableRowDataOrder("teams",array("position" => "delivery-manager"));
			$data["managers"] = @$this->sql->getTableRowDataOrder("teams",array("position" => "project-manager"));
			if(@$user[0]->role == "superadmin" || @$user[0]->role == "management")
			{
				$data["projects"] = @$this->sql->getTableRowDataOrder("projects",array("project_status " => 1));
			}
			else{
				// $tprojects = @$this->sql->getTableRowDataOrder("team_projects",array("project_status" => 1, "team_id" => $user[0]->team_id));

				if(@$user[0]->role == "delivery-manager")
				{
					$data["members"] = @$this->sql->getTableRowDataOrder("teams",array("position" => "team-executive"));
					$tprojects = @$this->sql->getTableRowDataOrder("team_projects",array("project_status" => 1, "d_manager" => $user[0]->team_id));
				}
				else if(@$user[0]->role == "project-manager")
				{
					$data["members"] = @$this->sql->getTableRowDataOrder("teams",array("position" => "team-executive"));
					$tprojects = @$this->sql->getTableRowDataOrder("team_projects",array("project_status" => 1, "p_manager" => $user[0]->team_id));
				}
				else if(@$user[0]->role == "lead" || @$user[0]->role == "team-lead")
				{
					$data["members"] = @$this->sql->getTableRowDataOrder("teams",array("position" => "team-executive","team_lead_id" => @$user[0]->team_id));
					$tprojects = @$this->sql->getTableRowDataOrder("team_projects",array("team_lead_id "  => $user[0]->team_id));
				}
				else{
					$data["members"] = @$this->sql->getTableRowDataOrder("teams",array("position" => "team-executive","team_id" => @$user[0]->team_id));
					$tprojects = @$this->sql->getTableRowDataOrder("team_projects",array("team_id "  => $user[0]->team_id));
				}	
				$tprojectsid = array();
				if(@sizeOf($tprojects) > 0)
				{
					for($t=0;$t<sizeOf($tprojects);$t++)
					{
						array_push($tprojectsid,$tprojects[$t]->project_id);
					}
				}

				$data["projects"] = @$this->sql->getTableRowDataNoWhereArray("projects",$tprojectsid,"id");
			}

			
			$this->load->view('header',$data);
			$this->load->view('assign-project-team',$data);
			$this->load->view('footer',$data);
		}

	}
	public function saveAssignProjectToLead()
	{
		
		if(@$this->session->userdata("ucode") == "")
		{
			redirect(base_url()."index.php/login");
		}
		else{
			$proejctid = @$this->input->post("project_id");
			$project = @$this->sql->getTableRowDataOrder("projects",array("id " => @$proejctid));
			$user = $this->user;
			if(@$user[0]->role == "superadmin" || @$user[0]->role == "management")
			{
				$this->assingProjectByAdmin($_POST);
			}
			else{
				$this->assignProjectByLead($_POST);
			}
		}
	}
	public function assingProjectByAdmin($params){
		$proejctid = @$_POST["project_id"];
		$project = @$this->sql->getTableRowDataOrder("projects",array("id " => @$proejctid));
		$user = $this->user;
		
		$teamlead = @$this->sql->getTableRowDataOrder("teams",array("id" => @$_POST["team_lead_id"]));
		$d_manager = @$_POST["d_manager"];
		$p_manager = @$_POST["p_manager"];
	
		if(@sizeOf($teamlead) > 0)
		{
			if(@$teamlead[0]->position =="team-lead" || @$teamlead[0]->position =="lead")
			{
				$tlmid = $teamlead[0]->id;
			}
			else{
				$tlmid = 0;
			}
				
		}
		else{
			$tlmid = 0;
		}
		
		$check = @$this->sql->getTableRowDataOrder("team_projects",array("team_id" => @$_POST["team_lead_id"],"project_id" => @$_POST["project_id"]));
		if(@sizeOf($check) > 0)
		{

			$this->session->set_userdata(array("projmessage" => "Already Assigned this Project"));
			redirect(base_url()."index.php/team-projects");	
		}
		else{
			$params = array(
				"team_lead_id" => $tlmid,
				"team_id" => @$_POST["team_lead_id"],
				"d_manager" => @$d_manager,
				"p_manager" => @$p_manager,
				"project_id" => @$_POST["project_id"],
				"project_start_date" => @$project[0]->project_start_date,
				"project_end_date" => @$project[0]->project_end_date,
				"project_status" => 1,
				"created_on" => @date("Y-m-d H:i:s")
			);
			
			$upd = $this->sql->storeItems("team_projects", $params);
			if($upd)
			{		
				
				$teamlead = @$this->sql->getTableRowDataOrder("teams",array("id" => @$_POST["team_lead_id"]));
				$project = @$this->sql->getTableRowDataOrder("projects",array("id" => @$_POST["project_id"]));
				if(@$user[0]->role == "superadmin" || @$user[0]->role == "management")
				{
					$params2 =array(
						"project_id" => @$_POST["project_id"],
						"task_id" => 0,
						"team_id" => @$_POST["team_lead_id"],
						"log_message" => "A Team Lead #".@$teamlead[0]->firstname." ".@$teamlead[0]->lastname." has assigned to project ".@$project[0]->project_name."",
						"created_on" => @date("Y-m-d H:i:s")
					);
				}
				else{
					$params2 =array(
						"project_id" => @$this->input->post("project_id"),
						"task_id" => 0,
						"team_id" => @$this->input->post("team_id"),
						"log_message" => "A Team Lead #".@$teamlead[0]->firstname." ".@$teamlead[0]->lastname." has assigned to project ".@$project[0]->project_name."",
						"created_on" => @date("Y-m-d H:i:s")
					);
				}
				$ins2 = $this->sql->storeItems("project_logs",$params2);
				$this->session->set_userdata(array("projmessage" => "Successfully Assigned Project"));
				redirect(base_url()."index.php/team-projects");	
			}
			else{
				$this->session->set_userdata(array("projmessage" => "Failed To Assigned Project"));
				redirect(base_url()."index.php/team-projects");
			}
		}
	}
	public function assignProjectByLead(){
		$proejctid = @$_POST["project_id"];
		$project = @$this->sql->getTableRowDataOrder("projects",array("id " => @$proejctid));
		$user = $this->user;
		
		$teamlead = @$this->sql->getTableRowDataOrder("teams",array("id" => @$_POST["team_id"]));
		$pmdm = @$this->sql->getTableRowDataOrder("team_projects",array("team_id" => @$user[0]->team_id,"project_id" => @$_POST["project_id"]));
		
		$d_manager = @$pmdm[0]->d_manager;
		$p_manager = @$pmdm[0]->p_manager;
		
		if(@sizeOf($teamlead) > 0)
		{
			if(@$teamlead[0]->position =="team-lead" || @$teamlead[0]->position =="lead")
			{
				$tlmid = $teamlead[0]->id;
			}
			else{
				$tlmid = @$user[0]->team_id;
			}
			
		}
		else{
			$tlmid = 0;
		}

		$check = @$this->sql->getTableRowDataOrder("team_projects",array("team_id" => @$_POST["team_id"],"project_id" => @$_POST["project_id"]));
		if(@sizeOf($check) > 0)
		{

			$this->session->set_userdata(array("projmessage" => "Already Assigned this Project"));
			redirect(base_url()."index.php/team-projects");	
		}
		else{
			$params = array(
				"team_lead_id" => $tlmid,
				"team_id" => @$_POST["team_id"],
				"d_manager" => @$d_manager,
				"p_manager" => @$p_manager,
				"project_id" => @$_POST["project_id"],
				"project_start_date" => @$project[0]->project_start_date,
				"project_end_date" => @$project[0]->project_end_date,
				"project_status" => 1,
				"created_on" => @date("Y-m-d H:i:s")
			);
			
			$upd = $this->sql->storeItems("team_projects", $params);
			if($upd)
			{		
				
				$teamlead = @$this->sql->getTableRowDataOrder("teams",array("id" => @$_POST["team_lead_id"]));
				$project = @$this->sql->getTableRowDataOrder("projects",array("id" => @$_POST["project_id"]));
				if(@$user[0]->role == "superadmin" || @$user[0]->role == "management")
				{
					$params2 =array(
						"project_id" => @$_POST["project_id"],
						"task_id" => 0,
						"team_id" => @$_POST["team_lead_id"],
						"log_message" => "A Team Lead #".@$teamlead[0]->firstname." ".@$teamlead[0]->lastname." has assigned to project ".@$project[0]->project_name."",
						"created_on" => @date("Y-m-d H:i:s")
					);
				}
				else{
					$params2 =array(
						"project_id" => @$_POST["project_id"],
						"task_id" => 0,
						"team_id" => @$_POST["team_id"],
						"log_message" => "A Team Lead #".@$teamlead[0]->firstname." ".@$teamlead[0]->lastname." has assigned to project ".@$project[0]->project_name."",
						"created_on" => @date("Y-m-d H:i:s")
					);
				}
				$ins2 = $this->sql->storeItems("project_logs",$params2);
				$this->session->set_userdata(array("projmessage" => "Successfully Assigned Project"));
				redirect(base_url()."index.php/team-projects");	
			}
			else{
				$this->session->set_userdata(array("projmessage" => "Failed To Assigned Project"));
				redirect(base_url()."index.php/team-projects");
			}
		}
	}
	public function updateProjectStatus($project_id,$status,$team_lead_id,$role)
	{
		
		if(@$this->session->userdata("ucode") == "")
		{
			redirect(base_url()."index.php/login");
		}
		else{
			if(@$role == "superadmin" || @$role == "lead" || @$role == "management")
			{
				$params = array(
					"project_status" => $status
				);
				$where=array("project_id" => $project_id,"team_lead_id" => $team_lead_id);
				$upd = $this->sql->updateItemsWithWhere("team_projects", $params,$where);
				$where1=array("project_id" => $project_id);
				$upd1 = $this->sql->updateItemsWithWhere("projects", $params,$where1);
			
			}
			else{
				$params = array(
					"team_project_status" => $status
				);
				$where=array("project_id" => $project_id,"team_lead_id" => $team_lead_id);
				$upd = $this->sql->updateItemsWithWhere("team_projects", $params,$where);
			
			}
			
			if($upd)
			{		
				
				$teamlead = @$this->sql->getTableRowDataOrder("teams",array("id" => @$team_lead_id));
				$project = @$this->sql->getTableRowDataOrder("projects",array("id" => @$project_id));
				$params2 =array(
					"project_id" => @$project_id,
					"task_id" => 0,
					"team_id" => @$team_lead_id,
					"log_message" => "User #".@$teamlead[0]->firstname." ".@$teamlead[0]->lastname." has udpate project ".@$project[0]->project_name." status",
					"created_on" => @date("Y-m-d H:i:s")
				);
				$ins2 = $this->sql->storeItems("project_logs",$params2);
				$this->session->set_userdata(array("projmessage" => "Successfully Update Project"));
				redirect(base_url()."index.php/team-projects");	
			}
			else{
				$this->session->set_userdata(array("projmessage" => "Failed To Update Project"));
				redirect(base_url()."index.php/team-projects");
			}
		}
	}
	
	public function assignProjectToTeam($projectid,$teamleadid)
	{
		
		if(@$this->session->userdata("ucode") == "")
		{
			redirect(base_url()."index.php/login");
		}
		else{
			$data["user"] = $this->user;
			$data["menu"] = "projects";
			$data["projectid"] = $projectid;
			$data["teamleadid"] = $teamleadid;
			$data["project"] = @$this->sql->getTableRowDataOrder("projects",array("id" => $projectid));
			$data["teams"] = @$this->sql->getTableRowDataOrder("teams",array("position !=" => "team-lead"));
			$this->load->view('header',$data);
			$this->load->view('assign-project-team-members',$data);
			$this->load->view('footer',$data);
		}
	}
	public function saveAssignMemberToProject()
	{
		
		if(@$this->session->userdata("ucode") == "")
		{
			redirect(base_url()."index.php/login");
		}
		else{
		// print_R($_REQUEST);
			$teammembers = $this->input->post("teammembers");
			$projectid = @$this->input->post("projectid");
			$teamleadid = @$this->input->post("teamleadid");
			$project = @$this->sql->getTableRowDataOrder("team_projects",array("project_id" => $projectid, "team_lead_id" => $teamleadid));
			$set=0;
			if(@sizeOf($teammembers) > 0)
			{
				for($t=0;$t<sizeOf($teammembers);$t++)
				{
					$params = array(
						"team_lead_id" => @$teamleadid,
						"team_id" => @$teammembers[$t],
						"project_id" => @$projectid,
						"project_start_date" => @$project[0]->project_start_date,
						"project_end_date" => @$project[0]->project_end_date,
						"project_status" => 1,
						"created_on" => @date("Y-m-d H:i:s")
					);
					$where = array("team_id" => $teammembers[$t], "project_id" => $projectid, "team_lead_id" => $teamleadid);
					
					$team = @$this->sql->getTableRowDataOrder("team_projects",$where);	
					if(@sizeOf($team) > 0)
					{
						$upd = $this->sql->updateItemsWithWhere("team_projects", $params,$where);
						
									
						$teamlead = @$this->sql->getTableRowDataOrder("teams",array("id" => @$teamleadid));
						$teammember = @$this->sql->getTableRowDataOrder("teams",array("id" => @$teammembers[$t]));
						$project = @$this->sql->getTableRowDataOrder("projects",array("id" => @$projectid));
						$params2 =array(
							"project_id" => @$projectid,
							"task_id" => 0,
							"team_id" => @$teamleadid,
							"log_message" => "User #".@$teammember[0]->firstname." ".@$teammember[0]->lastname." has assigned to project ".@$project[0]->project_name."",
							"created_on" => @date("Y-m-d H:i:s")
						);
						$ins2 = $this->sql->storeItems("project_logs",$params2);
					}
					else{
						$upd = $this->sql->storeItems("team_projects", $params);
						
									
						$teamlead = @$this->sql->getTableRowDataOrder("teams",array("id" => @$teamleadid));
						$teammember = @$this->sql->getTableRowDataOrder("teams",array("id" => @$teammembers[$t]));
						$project = @$this->sql->getTableRowDataOrder("projects",array("id" => @$projectid));
						$params2 =array(
							"project_id" => @$projectid,
							"task_id" => 0,
							"team_id" => @$teamleadid,
							"log_message" => "User #".@$teammember[0]->firstname." ".@$teammember[0]->lastname." has assigned to project ".@$project[0]->project_name."",
							"created_on" => @date("Y-m-d H:i:s")
						);
						$ins2 = $this->sql->storeItems("project_logs",$params2);
					}
					
					if($upd)
					{
						$set = 1;
					}
				}
			}
			if($set == 1)
			{		
				$this->session->set_userdata(array("teammessage" => "Successfully Assigned Project To Members"));
				redirect(base_url()."index.php/team-projects");	
			}
			else{
				$this->session->set_userdata(array("teammessage" => "Failed to assigned Project To Members"));
				redirect(base_url()."index.php/team-projects");
			}
		}
	}
	public function viewteamprojects($projectid,$teamleadid)
	{
		
		if(@$this->session->userdata("ucode") == "")
		{
			redirect(base_url()."index.php/login");
		}
		else{
			$data["user"] = $this->user;
			$data["menu"] = "projects";
			$data["smenu"] = "teamprojects";
			$data["projectid"] = $projectid;
			$data["teamleadid"] = $teamleadid;
			$data["project"] = @$this->sql->getTableRowDataOrder("projects",array("id "  => $projectid));
			$projectsarr = @$this->sql->getTableRowDataOrder("team_projects",array("team_lead_id "  => $teamleadid, "project_id "  => $projectid));
			$projects = array();
			if(@sizeOf($projectsarr) > 0)
			{
				for($t=0;$t<sizeOf($projectsarr);$t++)
				{
					$projects[]=array(
						"id" => $projectsarr[$t]->id,
						"team_lead_id" => $projectsarr[$t]->team_lead_id,
						"team_id" => $projectsarr[$t]->team_id,
						"project_id" => $projectsarr[$t]->project_id,
						"project_start_date" => $projectsarr[$t]->project_start_date,
						"project_end_date" => $projectsarr[$t]->project_end_date,
						"project_status" => $projectsarr[$t]->project_status,
						"created_on" => $projectsarr[$t]->created_on,
						"team" => @$this->sql->getTableRowDataOrder("teams",array("id" => $projectsarr[$t]->team_id)),
						"project" => @$this->sql->getTableRowDataOrder("projects",array("id" => $projectsarr[$t]->project_id)),
						"tasks" => @$this->sql->getTableRowDataOrder("team_tasks",array("project_id" => $projectsarr[$t]->project_id))
					);
				}
			}
			if(@sizeOf($projects) > 0)
			{
				$prs = @json_encode($projects);
				
				$data["projects"] = @json_decode($prs);
			}
			else{
				$prs = array();
				$data["projects"] = $prs;
			}
			
			$this->load->view('header',$data);
			$this->load->view('team-project-members',$data);
			$this->load->view('footer',$data);
		}
	}
	
	public function viewProjectsMembers($projectid)
	{
		
		if(@$this->session->userdata("ucode") == "")
		{
			redirect(base_url()."index.php/login");
		}
		else{
			$data["user"] = $this->user;
			$data["menu"] = "projects";
			$data["smenu"] = "projects";
			$data["projectid"] = $projectid;
			$data["project"] = @$this->sql->getTableRowDataOrder("projects",array("id "  => $projectid));
			$projectsarr = @$this->sql->getTableRowDataOrder("team_projects",array("project_id "  => $projectid));
			$projects = array();
			if(@sizeOf($projectsarr) > 0)
			{
				for($t=0;$t<sizeOf($projectsarr);$t++)
				{
					$projects[]=array(
						"id" => $projectsarr[$t]->id,
						"team_lead_id" => $projectsarr[$t]->team_lead_id,
						"team_id" => $projectsarr[$t]->team_id,
						"project_id" => $projectsarr[$t]->project_id,
						"project_start_date" => $projectsarr[$t]->project_start_date,
						"project_end_date" => $projectsarr[$t]->project_end_date,
						"project_status" => $projectsarr[$t]->project_status,
						"created_on" => $projectsarr[$t]->created_on,
						"team" => @$this->sql->getTableRowDataOrder("teams",array("id" => $projectsarr[$t]->team_id)),
						"project" => @$this->sql->getTableRowDataOrder("projects",array("id" => $projectsarr[$t]->project_id)),
						"tasks" => @$this->sql->getTableRowDataOrder("team_tasks",array("project_id" => $projectsarr[$t]->project_id))
					);
				}
			}
			if(@sizeOf($projects) > 0)
			{
				$prs = @json_encode($projects);
				
				$data["projects"] = @json_decode($prs);
			}
			else{
				$prs = array();
				$data["projects"] = $prs;
			}
			
			$this->load->view('header',$data);
			$this->load->view('view-project-teams',$data);
			$this->load->view('footer',$data);
		}
	}
	
	public function viewProjectFromTeams($rowid)
	{
		
		if(@$this->session->userdata("ucode") == "")
		{
			redirect(base_url()."index.php/login");
		}
		else{
			$data["user"] = $this->user;
			$data["menu"] = "projects";
			$data["actionfrom"] = "teams";
			$data["rowid"] = @$rowid;
			$data["project"] = @$this->sql->getTableRowDataOrder("projects",array("id" => @$rowid));
			$data["projectdocs"] = @$this->sql->getTableRowDataOrder("project_documents",array("project_id" => @$rowid));
			$this->load->view('header',$data);
			$this->load->view('view-projects',$data);
			$this->load->view('footer',$data);
		}
	}
	public function memberProjects($rowid)
	{
		
		if(@$this->session->userdata("ucode") == "")
		{
			redirect(base_url()."index.php/login");
		}
		else{
			$data["user"] = $this->user;
			$data["menu"] = "teams";
			$data["actionfrom"] = "teams";
			$data["rowid"] = @$rowid;
			$projectsarr = @$this->sql->getTableRowDataOrder("team_projects",array("team_id "  => $rowid));
			$projects = array();
			if(@sizeOf($projectsarr) > 0)
			{
				for($t=0;$t<sizeOf($projectsarr);$t++)
				{
					$projects[]=array(
						"id" => $projectsarr[$t]->id,
						"team_lead_id" => $projectsarr[$t]->team_lead_id,
						"team_id" => $projectsarr[$t]->team_id,
						"project_id" => $projectsarr[$t]->project_id,
						"project_start_date" => $projectsarr[$t]->project_start_date,
						"project_end_date" => $projectsarr[$t]->project_end_date,
						"project_status" => $projectsarr[$t]->project_status,
						"created_on" => $projectsarr[$t]->created_on,
						"team" => @$this->sql->getTableRowDataOrder("teams",array("id" => $projectsarr[$t]->team_id)),
						"project" => @$this->sql->getTableRowDataOrder("projects",array("id" => $projectsarr[$t]->project_id)),
						"tasks" => @$this->sql->getTableRowDataOrder("team_tasks",array("project_id" => $projectsarr[$t]->project_id))
					);
				}
			}
			if(@sizeOf($projects) > 0)
			{
				$prs = @json_encode($projects);
				
				$data["projects"] = @json_decode($prs);
			}
			else{
				$prs = array();
				$data["projects"] = $prs;
			}
			
			$this->load->view('header',$data);
			$this->load->view('view-member-projects',$data);
			$this->load->view('footer',$data);
		}
	}
	
	public function memberTasks($rowid)
	{
		
		if(@$this->session->userdata("ucode") == "")
		{
			redirect(base_url()."index.php/login");
		}
		else{
			$data["user"] = $this->user;
			$data["menu"] = "teams";
			$data["actionfrom"] = "teams";
			$data["rowid"] = @$rowid;
			$projectsarr = @$this->sql->getTableRowDataOrder("team_tasks",array("team_id "  => $rowid));
			$projects = array();
			if(@sizeOf($projectsarr) > 0)
			{
				for($t=0;$t<sizeOf($projectsarr);$t++)
				{
					$projects[]=array(
						"id" => $projectsarr[$t]->id,
						"team_id" => $projectsarr[$t]->team_id,
						"task_id" => $projectsarr[$t]->task_id,
						"project_id" => $projectsarr[$t]->project_id,
						"start_date" => $projectsarr[$t]->start_date,
						"end_date" => $projectsarr[$t]->end_date,
						"task_status" => $projectsarr[$t]->task_status,
						"created_on" => $projectsarr[$t]->created_on,
						"team" => @$this->sql->getTableRowDataOrder("teams",array("id" => $projectsarr[$t]->team_id)),
						"project" => @$this->sql->getTableRowDataOrder("projects",array("id" => $projectsarr[$t]->project_id)),
						"task" => @$this->sql->getTableRowDataOrder("tasks",array("id" => $projectsarr[$t]->task_id))
					);
				}
			}
			if(@sizeOf($projects) > 0)
			{
				$prs = @json_encode($projects);
				
				$data["projects"] = @json_decode($prs);
			}
			else{
				$prs = array();
				$data["projects"] = $prs;
			}
			
			$this->load->view('header',$data);
			$this->load->view('view-member-tasks',$data);
			$this->load->view('footer',$data);
		}
	}
}
