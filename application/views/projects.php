<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

  <main id="main" class="main">

<div class="pagetitle">
  <h1>Projects
  <?php
      if(@sizeOf($user) > 0)
      {
        if(@$user[0]->role == "superadmin" || @$user[0]->role == "management")
        {
        ?>
      <span class="hmenu">
          <a href="<?php echo base_url();?>add-project" class="btn btn-warning">Add Project</a>
      </span>
      <?php
        }
      }
      ?>
  </h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
      <li class="breadcrumb-item active">Projects</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Projects List</h5>
          <?php
          if(@$this->session->userdata("projectmessage") != "")
          {
          ?>
          <div class="alert alert-info"><?php echo @$this->session->userdata("projectmessage"); @$this->session->unset_userdata("projectmessage");?></div>
          <?php
          }    

          ?>
          <table class="table datatable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Project Name</th>
                    <th scope="col">Project Mode</th>
                    <th scope="col">Project Owner</th>
                    <th scope="col">Project Status</th>
                    <th scope="col">Start Date</th>
                    <th scope="col">End Date</th>
                    <th scope="col">Team Members</th>
                    <th scope="col">No of Tasks</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                   try{
                    
                    if(@sizeOf($projects) > 0)
                    {
                      
                      for($t=0;$t<sizeOf($projects);$t++)
                      {
                    ?>
                    <tr>
                      <th scope="row"><?php echo ($t+1);?></th>
                      <td>
                        <?php
                        if(@sizeOf($projects[$t]->attachments) > 0)
                        {
                        ?>
                        <a href="<?php echo base_url()."home/viewProject/".@$projects[$t]->id;?>">
                          <i class="ri-attachment-2"></i>&nbsp;
                        </a>
                        <?php
                        }
                        ?>
                        <?php echo @$projects[$t]->project_name;?>
                      </td>
                      <td><?php echo @$projects[$t]->project_mode;?></td>
                      <td>
						  <?php
							echo @$projects[$t]->owner[0]->firstname." ".@$projects[$t]->owner[0]->lastname;
						  ?>
					  </td>
                      <td>
						<?php 
							if(@$projects[$t]->project_status == 1)
							{
								echo "<span class='inpgr p5 f12'>InProgress</span>";
							}
							else if(@$projects[$t]->project_status == 2)
							{
								echo "<span class='qa p5 f12'>Ready to QA</span>";
							}
							
							else if(@$projects[$t]->project_status == 3)
							{
								echo "<span class='complet p5 f12'>Completed</span>";
							}
							
							else if(@$projects[$t]->project_status == 4)
							{
								echo "<span class='hld p5 f12'>Hold</span>";
							}
							
							else if(@$projects[$t]->project_status == 5)
							{
								echo "<span class='dltd p5 f12'>Deleted</span>";
							}
							
							else if(@$projects[$t]->project_status == 6)
							{
								echo "<span class='dltd p5 f12'>Risk</span>";
							}
							else{
								echo "<span class='dltd p5 f12'>Delayed</span>";
							}
						?>
					  </td>
                      <td><?php echo @$projects[$t]->project_start_date;?></td>
                      <td><?php echo @$projects[$t]->project_end_date;?></td>
                      <td>
                       
                        <a href="<?php echo base_url()."home/viewProjectsMembers/".@$projects[$t]->id;?>">
                         <?php echo @sizeOf($projects[$t]->members);?>
                        </a>
                      </td>
                      <td><?php echo @sizeOf($projects[$t]->tasks);?></td>
                      <td>
                        <a href="<?php echo base_url()."home/editProject/".@$projects[$t]->id;?>">
                          <i class="bi bi-pencil-square"></i> Edit
                        </a>
                      </td>
                    </tr>
                    <?php
                      }
                    }
                   }
                   catch(Exception $e){
                    echo $e;
                   }
                   
                  
                  ?>
                </tbody>
          </table>
        </div>
      </div>

    </div>

  </div>
</section>

</main>
