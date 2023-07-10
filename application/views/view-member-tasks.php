<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<main id="main" class="main">

<div class="pagetitle">
  <h1>Tasks
      <span class="hmenu">
          <a href="<?php echo base_url();?>team-members" class="btn btn-light">Back</a>
      </span>
  </h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
      <li class="breadcrumb-item active">Tasks</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Tasks List</h5>
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
                    <th scope="col">Task Name</th>
                    <th scope="col">Start Date</th>
                    <th scope="col">End Date</th>
                    <th scope="col">Status</th>
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
                      <td>
                        <a href="<?php echo base_url()."home/viewTask/".@$projects[$t]->task[0]->task_code;?>">
                          <?php echo @$projects[$t]->task[0]->task_name;?>
                        </a>
                      </td>
                      <td><?php echo @$projects[$t]->start_date;?></td>
                      <td><?php echo @$projects[$t]->end_date;?></td>
                      <td>
                        <?php
                        if(@$projects[$t]->task_status == 1)
                        {
                          echo "<span class='inpgr p5 f12'>InProgress</span>";
                        }
                        else if(@$projects[$t]->task_status == 2)
                        {
                          echo "<span class='qa p5 f12'>Ready to QA</span>";
                        }
                        
                        else if(@$projects[$t]->task_status == 3)
                        {
                          echo "<span class='complet p5 f12'>Completed</span>";
                        }
                        
                        else if(@$projects[$t]->task_status == 4)
                        {
                          echo "<span class='hld p5 f12'>Hold</span>";
                        }
                        
                        else if(@$projects[$t]->task_status == 5)
                        {
                          echo "<span class='dltd p5 f12'>Deleted</span>";
                        }
                        ?>
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
<script type="text/javascript">
function updateProjectStatus(projectid,oVal,teamid){
 
  $.ajax({
    type:"POST",
    url:"<?php echo base_url();?>home/updateProjectStatus/"+projectid+"/"+oVal+"/"+teamid,
    async:false,
    success:function(response){
      window.location.reload();
    }
  })
}
</script>