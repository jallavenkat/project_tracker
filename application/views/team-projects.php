<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<main id="main" class="main">

<div class="pagetitle">
  <h1>Team Projects
  <?php
      if(@sizeOf($user) > 0)
      {
        if(@$user[0]->role != "executive" && @$user[0]->role != "team-executive")
        {
        ?>
      <span class="hmenu">
          <a href="<?php echo base_url();?>assign-project" class="btn btn-warning">Assign Project</a>
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
          if(@$this->session->userdata("projmessage") != "")
          {
          ?>
          <div class="alert alert-info"><?php echo @$this->session->userdata("projmessage"); @$this->session->unset_userdata("projmessage");?></div>
          <?php
          }    

          ?>
          <table class="table datatable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Project Name</th>
                    <th scope="col">Team Member</th>
                    <th scope="col">Start Date</th>
                    <th scope="col">End Date</th>
                    <th scope="col">No of Tasks</th>
                    <th scope="col">Status</th>
                    <?php
                       if(@$user[0]->role == "superadmin" || @$user[0]->role == "lead")
                       {
                      ?> 
                    <th scope="col">Actions</th>
                    <?php
                       }
                      ?>
                      
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
                        <a href="<?php echo base_url()."home/viewProjectFromTeams/".@$projects[$t]->project_id;?>">
                          <?php echo @$projects[$t]->project[0]->project_name;?>
                        </a>
                      </td>
                      <td><?php echo @$projects[$t]->team[0]->firstname." ".$projects[$t]->team[0]->lastname;?></td>
                      <td><?php echo @$projects[$t]->project_start_date;?></td>
                      <td><?php echo @$projects[$t]->project_end_date;?></td>
                      <td><?php echo @sizeOf($projects[$t]->tasks);?></td>
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
                      <?php
                       if(@$user[0]->role == "superadmin" || @$user[0]->role == "lead")
                       {
                      ?> 
                      <td>
                       
                      <a href="<?php echo base_url()."home/viewteamprojects/".@$projects[$t]->project_id."/".@$projects[$t]->team_id;?>" class="anchr">
                          <i class="bi bi-people-fill"></i> View Team
                        </a>
                        &nbsp;|&nbsp;
                        <a href="<?php echo base_url()."home/assignProjectToTeam/".@$projects[$t]->project_id."/".@$projects[$t]->team_id;?>" class="anchr">
                          <i class="bi bi-people-fill"></i> Assign Team
                        </a>
                        &nbsp;|&nbsp;
                        <select name="proejctStatus" id="proejctStatus" onChange="updateProjectStatus('<?php echo @$projects[$t]->project_id;?>', this.value, '<?php echo @$projects[$t]->team_lead_id;?>')" class="f12" style="border:0px;">
                              <option value="">Update Status</option>
                              <option value="1">InProgress</option>
                              <option value="2">Ready to QA</option>
                              <option value="3">Completed</option>
                              <option value="4">Hold</option>
                              <option value="5">Deleted</option>
                              <option value="6">Risk</option>
                              <option value="7">Delayed</option>
                         
                          </select>
                      </td>
                      <?php
                       }
                      ?>
                      
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
<script type="text/javascript">
function updateProjectStatus(projectid,oVal,teamid){
 
  $.ajax({
    type:"POST",
    url:"<?php echo base_url();?>home/updateProjectStatus/"+projectid+"/"+oVal+"/"+teamid+"/<?php echo @$user[0]->role;?>",
    async:false,
    success:function(response){
      window.location.reload();
    }
  })
}
</script>