<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['login'] = 'home/index';
$route['logout'] = 'login/logout';
$route['validate'] = 'login/validate';
$route['dashboard'] = 'home/dashboard';
$route['projects'] = 'home/projects';
$route['team-projects'] = 'home/teamprojects';
$route['team-members'] = 'home/teammembers';
$route['add-team-member'] = 'home/createMember';
$route['assign-member-to-lead'] = 'home/assignMemberToLead';
$route['assign-project'] = 'home/assignProjectToLead';
$route['add-project'] = 'home/createProject';
$route['add-task'] = 'home/createTask';
$route['tasks'] = 'home/tasks';
$route['tms'] = 'tms/index';
$route['issues'] = 'tms/issues';
$route['discussions'] = 'discussions/index';
$route['add-item'] = 'discussions/createItem';

/*
require_once (BASEPATH .'database/DB.php');
$db =& DB();
$sql = "SELECT id,firstname FROM teams where position ='team-lead' ";
$query = $db->query($sql);
$listings = $query->result();
if(@sizeOf($listings) > 0)
{
	for($l=0;$l<sizeOf($listings);$l++)
	{
	    if(@$listings[$l]->id != '' && @$listings[$l]->firstname != '')
		{
			$route["lead-team/".$listings[$l]->firstname] = "home/myteam/".@$listings[$l]->id;
		}
	}
}

$sql1 = "SELECT id,s_code FROM solutions where sol_status =1 ";
$query1 = $db->query($sql1);
$listings1 = $query1->result();

if(@sizeOf($listings1) > 0)
{
	for($l1=0;$l1<sizeOf($listings1);$l1++)
	{
	    if(@$listings1[$l1]->id != '' && @$listings1[$l1]->s_code != '')
		{
			$route["view-topic/".$listings1[$l1]->s_code] = "discussions/viewTopic/".@$listings1[$l1]->s_code;
		}
	}
}

$sql2 = "SELECT id,task_code FROM tasks";
$query2 = $db->query($sql2);
$listings2 = $query2->result();

if(@sizeOf($listings2) > 0)
{
	for($l2=0;$l2<sizeOf($listings2);$l2++)
	{
	    if(@$listings2[$l2]->id != '' && @$listings2[$l2]->task_code != '')
		{
			$route["view-task/".$listings2[$l2]->task_code] = "home/viewTask/".@$listings2[$l2]->task_code;
			$route["edit-task/".$listings2[$l2]->task_code] = "home/editTask/".@$listings2[$l2]->task_code;
			$route["add-subtask/".$listings2[$l2]->task_code] = "home/addSubTask/".@$listings2[$l2]->task_code;
		}
	}
}
$sql3 = "SELECT id,project_code FROM projects";
$query3 = $db->query($sql3);
$listings3 = $query3->result();

if(@sizeOf($listings3) > 0)
{
	for($l3=0;$l3<sizeOf($listings3);$l3++)
	{
	    if(@$listings3[$l3]->id != '' && @$listings3[$l3]->project_code != '')
		{
			$route["view-project/".$listings3[$l3]->project_code] = "home/viewProjectCode/".@$listings3[$l3]->project_code;
		}
	}
}
*/
