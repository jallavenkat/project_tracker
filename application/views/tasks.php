<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <main id="main" class="main">

<div class="pagetitle">
  <h1>Tasks
      <span class="hmenu">
          <a href="<?php echo base_url();?>add-task" class="btn btn-warning">Add Task</a>
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
          <h5 class="card-title">&nbsp;</h5>
          <?php
          //echo "<pre>";print_R($tasks);echo "</pre>";
          if(@$this->session->userdata("taskmessage") != "")
          {
          ?>
          <div class="alert alert-info"><?php echo @$this->session->userdata("taskmessage"); @$this->session->unset_userdata("taskmessage");?></div>
          <?php
          }    

          ?>
          <table class="table datatable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Task Code</th>
                    <th scope="col">Task Title</th>
                    <th scope="col">Project Name</th>
                    <th scope="col">Start Date</th>
                    <th scope="col">End Date</th>
                    <th scope="col">Assigned To</th>
                    <th scope="col">AssignedBy</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                   try{
                    
                    if(@sizeOf($tasks) > 0)
                    {
                      
                      for($t=0;$t<sizeOf($tasks);$t++)
                      {
                    ?>
                    <tr>
                      <th scope="row"><?php echo ($t+1);?></th>
                      <td>
                      <?php
                        if(@sizeOf($tasks[$t]->attachments) > 0)
                        {
                        ?>
                        <a href="<?php echo base_url()."view-task/".@$tasks[$t]->task_code;?>">
                          <i class="ri-attachment-2"></i>&nbsp;
                        </a>
                        <?php
                        }
                        ?>
                        <a href="<?php echo base_url()."view-task/".@$tasks[$t]->task_code;?>">
                        <?php 
                          echo @$tasks[$t]->task_code."<br />";
                        ?>
                        </a>
                        <?php
                          $date1 = @date("Y-m-d");
                          $date2 = @$tasks[$t]->task_end_date;
                          $diff = strtotime($date1) - strtotime($date2);
                          // 1 day = 24 hours
                          // 24 * 60 * 60 = 86400 seconds
                          if($diff<0)
                          {
                            $dVal = 0;
                          }
                          else{
                            $dVal = $diff;
                          }
                          $days = @abs(round($dVal / 86400));
                          if($days <= 0 && (@$tasks[$t]->task_status == 1 || @$tasks[$t]->task_status ==2 || @$tasks[$t]->task_status ==3 || @$tasks[$t]->task_status ==5))
                          {
                          ?>
                          <span class="badge bg-success">Ontime</span>
                          <?php
                          }
                          else if($days > 0)
                          {
                          ?>
                          <span class="badge bg-danger">Overdue <?php echo @$days ." day(s)";?></span>
                          <?php
                          }
                          else {
                          ?>
                            <span class="badge bg-danger">Overdue</span>
                          <?php
                          }
                        ?>
                      </td>
                      
                      <td>
                        <?php echo @$tasks[$t]->task_name;?>
                      </td>
                      <td><?php echo @$tasks[$t]->project[0]->project_name;?></td>
                      <td><?php echo @$tasks[$t]->task_start_date;?></td>
                      <td><?php echo @$tasks[$t]->task_end_date;?></td>
                    
                      <td><?php echo @ucfirst($tasks[$t]->assignTo[0]->userinfo[0]->firstname." ".$tasks[$t]->assignTo[0]->userinfo[0]->lastname);?></td>
                      <td><?php echo @ucfirst($tasks[$t]->assignBy[0]->firstname." ".$tasks[$t]->assignBy[0]->lastname);?></td>
                      <td>
                        <select name="proejctStatus" id="proejctStatus" onChange="updateTaskStatus('<?php echo @$tasks[$t]->id;?>', '<?php echo @$tasks[$t]->project_id;?>', this.value)" class="f12" style="border:0px;">
                              <option value="">Update Status</option>
                              <option value="1" <?php if(@$tasks[$t]->task_status == 1){echo "selected='selected'";}?>>InProgress</option>
                              <option value="2" <?php if(@$tasks[$t]->task_status == 2){echo "selected='selected'";}?>>Ready to QA</option>
                              <option value="3" <?php if(@$tasks[$t]->task_status == 3){echo "selected='selected'";}?>>Completed</option>
                              <option value="4" <?php if(@$tasks[$t]->task_status == 4){echo "selected='selected'";}?>>Hold</option>
                              <option value="5" <?php if(@$tasks[$t]->task_status == 5){echo "selected='selected'";}?>>Deleted</option>
                         
                          </select>
                      </td>
                      <td>
                        <a href="<?php echo base_url()."edit-task/".@$tasks[$t]->task_code;?>">
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
<script type="text/javascript">
function updateTaskStatus(taskid,projectid,oVal){
 
  $.ajax({
    type:"POST",
    url:"<?php echo base_url();?>home/updateTaskStatus/"+taskid+"/"+projectid+"/"+oVal,
    async:false,
    success:function(response){
      window.location.reload();
    }
  })
}
</script>