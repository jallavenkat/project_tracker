<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <main id="main" class="main">

<div class="pagetitle">
  <h1>Discussions
      <span class="hmenu">
          <a href="<?php echo base_url();?>index.php/add-item" class="btn btn-warning">Add Discussion</a>
      </span>
  </h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo base_url();?>index.php/">Home</a></li>
      <li class="breadcrumb-item active">Discussions</li>
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
          if(@$this->session->userdata("discussionmessage") != "")
          {
          ?>
          <div class="alert alert-info"><?php echo @$this->session->userdata("discussionmessage"); @$this->session->unset_userdata("discussionmessage");?></div>
          <?php
          }    

          ?>
          <table class="table datatable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Code</th>
                    <th scope="col">Topic Title</th>
                    <th scope="col">Created By</th>
                    <th scope="col">Created On</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                   try{
                    
                    if(@sizeOf($discussions) > 0)
                    {
                      
                      for($t=0;$t<sizeOf($discussions);$t++)
                      {
                    ?>
                    <tr>
                      <th scope="row"><?php echo ($t+1);?></th>
                      <td>
                            <a href="<?php echo base_url();?>index.php/view-topic/<?php echo @$discussions[$t]->s_code;?>">
                                <?php echo @$discussions[$t]->s_code;?>
                            </a>
                      </td>
                      <td>
                     
                        <?php 
                          echo @$discussions[$t]->solution_title;
                        ?>
                      </td>
                      
                      <td>
                        <?php echo @$discussions[$t]->created_by;?>
                      </td>
                      
                      <td>
                        <?php echo @date("d M Y",strtotime($discussions[$t]->created_on));?>
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
    url:"<?php echo base_url();?>index.php/home/updateTaskStatus/"+taskid+"/"+projectid+"/"+oVal,
    async:false,
    success:function(response){
      window.location.reload();
    }
  })
}
</script>