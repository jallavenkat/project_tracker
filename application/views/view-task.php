<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?php echo base_url()?>assets/css/plugins/summernote/summernote.css" rel="stylesheet">
<link href="<?php echo base_url()?>assets/css/plugins/summernote/summernote-bs3.css" rel="stylesheet">


<link rel="stylesheet" href="<?php echo base_url();?>assets/css/dropzone.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="<?php echo base_url();?>assets/js/dropzone.js"></script>

  <main id="main" class="main">

<div class="pagetitle">
  <h1>View Task#<?php echo @$task[0]->task_name;?>
      <span class="hmenu">
          <a href="<?php echo base_url();?>index.php/tasks" class="btn btn-light">Back</a>
      </span>
  </h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo base_url();?>index.php/">Home</a></li>
      <li class="breadcrumb-item">
        <a href="<?php echo base_url();?>index.php/tasks">
            Tasks
        </a>
        </li>
      <li class="breadcrumb-item active">Edit Task</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">&nbsp;
            <a href="<?php echo base_url();?>index.php/edit-task/<?php echo @$task[0]->task_code;?>" class="btn btn-light float-left f12"><i class="fa fa-edit"></i> Edit</a>
            <a href="<?php echo base_url();?>index.php/add-subtask/<?php echo @$task[0]->task_code;?>" class="btn btn-secondary float-right f12"><i class="fa fa-plus"></i> Add Subtask</a>
          </h5>
          
            <div class="row mb-3">
              <div class="col-lg-7 mb-3">
                <form method="POST" action="<?php echo base_url();?>index.php/home/updateTask">
                <div class="col-lg-12 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-3 col-form-label">Select Project</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="project_id" required>
                                    <option value="">Select</option>
                                    <?php
                                    if(@sizeOf($projects) > 0)
                                    {
                                        foreach($projects as $project)
                                        {
                                            if(@$task[0]->project_id == $project->id)
                                            {
                                                $psel="selected='selected'";
                                            }
                                            else{
                                                $psel = '';
                                            }
                                    ?>
                                    <option <?php echo @$psel;?> value="<?php echo @$project->id;?>"><?php echo @$project->project_name;?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-3 col-form-label">Task Title</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="task_name" value="<?php echo @$task[0]->task_name;?>" placeholder="Enter Task Title" required />
                            </div>
                        </div>
                    </div>
                    
                   
                    <div class="col-lg-12 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-3 col-form-label">Assign To</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="team_id" required>
                                    <option value="">Select</option>
                                    <?php
                                    if(@sizeOf($teams) > 0)
                                    {
                                        foreach($teams as $team)
                                        {
                                            if(@$teamtasks[0]->team_id == @$team->id)
                                            {
                                                $tsel='selected="selected"';
                                            }
                                            else{
                                                $tsel='';
                                            }
                                    ?>
                                    <option <?php echo @$tsel;?> value="<?php echo @$team->id;?>"><?php echo @$team->firstname;?> <?php echo @$team->lastname;?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-3 col-form-label">Start Date</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control datepicker" name="task_start_date" id="task_start_date" value="<?php echo @$task[0]->task_start_date;?>" required />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-3 col-form-label">End Date</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control datepicker" name="task_end_date" id="task_end_date" value="<?php echo @$task[0]->task_end_date;?>" required />
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-12 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-3 col-form-label">Description</label>
                            <div class="col-sm-8">
                                <div class="form-control" name="task_desc" id="task_desc" required ><?php echo @$task[0]->task_desc;?></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-12 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-3 col-form-label">Notes</label>
                            <div class="col-sm-8">
                                <div class="form-control" name="task_notes" id="task_notes" required ><?php if(@$task[0]->task_notes != ""){echo @$task[0]->task_notes;}else{ echo "&nbsp;";}?></div>
                            </div>
                        </div>
                    </div>
                </form>
              </div>
              <div class="col-lg-5 mb-3">
                <div class="row">
                    <div class="col-lg-12">
                        <h5><i class="ri-attachment-2"></i>&nbsp;Attachments</h5>
                    </div>
                </div>
                <div class="row" style="background:#eee !important;height:300px;padding:20px;overflow-y:auto;">
                  <?php
                  if(@sizeOf($taskdocs) > 0)
                  {
                    for($d=0;$d<sizeOf($taskdocs);$d++)
                    {
                      if($d % 2 == 0)
                      {
                        $ev="bluebg";
                      }
                      else{
                        $ev="";
                      }
                  ?>
                  <div class="col-lg-12 <?php echo $ev;?> p10 f12">
                    
                    <div class="row">
                      <div class="col-lg-9">
                        <?php echo @$taskdocs[$d]->task_doc;?>
                      </div>
                      <div class="col-lg-3">
                        <a href="<?php echo @base_url()."uploads/tasks/docs/".$taskdocs[$d]->task_doc;?>" target="_blank" style="padding:0px 5px" class="btn btn-danger f12">View </a>
                      </div>
                    </div>
                  </div>
                  <?php
                    }
                  }
                  
                  else{
                    echo "No attachments found.";
                  }
                  ?>
                  
                </div>
                <div class="row" style="margin-top:20px;">
                  <?php
                  if(@sizeOf($subtasks) >0)
                  {
                  ?>
                   <h5>View Sub Tasks</h5>
                 <?php
                    for($s=0;$s<sizeOf($subtasks);$s++)
                    {
                  ?>
                  <div class="col-sm-12">
                      <a href="<?php echo base_url()."home/viewTask/".@$subtasks[$s]->task_code;?>">
                          <?php echo @$subtasks[$s]->task_name;?>
                      </a>
                  </div>
                  <?php
                    }
                  ?>
                  
                  <?php
                  }
                  ?>
                  
                </div>
              </div>
            </div>
        </div>
      </div>

    </div>

  </div>
</section>

</main>
<script>
  $( function() {
    $( ".datepicker" ).datepicker({dateFormat:"yy-mm-dd"});

    Dropzone.options.fileupload = {
		    acceptedFiles: 'image/*',
		    maxFilesize: 10, // MB,
        autoProcessQueue: false,
        init: function () {
            // Set up any event handlers
            this.on('completemultiple', function () {
                location.reload();
            });

            
        }
      };
     

  } );

 
  </script>

<script type="text/javascript">
    Dropzone.options.fileupload = {
        // Prevents Dropzone from uploading dropped files immediately
        uploadMultiple: true,
        paramName: "file",
        maxFilesize: 100,
        maxFiles: 2,
        createImageThumbnails: true,
        acceptedFiles: ".png,.jpg,.jpeg,.pdf,.doc,.docx,.ppt,.pptx,.pdfx,.xls,.xlsx",
        clickable: true,
        thumbnailWidth: 150,
        thumbnailHeight: 150,
        autoProcessQueue: false,
        init: function () {
            // $.ajax({
            //     url: '<?php echo base_url();?>index.php/home/uploadTaskFolder/<?php echo @$rowid;?>',
            //     type: 'get',
            //     dataType: 'json',
            //     success: function (response) {
            //         $.each(response, function (key, value) {
            //             var mockFile = { name: value.name, size: value.size }

            //             fileupload.emit('addedfile', mockFile)
            //             fileupload.emit('thumbnail', mockFile, value.path)
            //             fileupload.emit('complete', mockFile)
            //         })
            //     }
            // });



            var submitButton = document.querySelector("#submit-all")
            fileupload = this;
            submitButton.addEventListener("click", function () {
              fileupload.processQueue();
            });
            // to handle the added file event
            this.on('completemultiple', function (file, json) {
                window.location.reload()
            });
           
            this.on('queuecomplete', function(){
              fileupload.emit("resetFiles");
            })
            
        }
    };
    // $(function () {
    //     $(".dropzone").sortable({
    //         items: '.dz-preview',
    //         cursor: 'move',
    //         opacity: 0.5,
    //         containment: '.dropzone',
    //         distance: 20,
    //         tolerance: 'pointer',
    //         update: function(event, ui){
    //             console.log(ui);
    //             var itemOrder = $('.dropzone').sortable("toArray");
    //             for (var i = 0; i < itemOrder.length; i++) {

    //                 //alert("Position: " + i + " ID: " + itemOrder[i]);
    //             }
    //         }
    //     });
    // });
</script>


<script src="<?php echo base_url()?>assets/js/plugins/summernote/summernote.min.js"></script>
  
<script>
$(document).ready(function(){

	$('.txtcls').summernote({
        height: 200,
    });

});
var edit = function() {
	$('.click2edit').summernote({focus: true});
};
var save = function() {
	var aHTML = $('.click2edit').code(); //save HTML If you need(aHTML: array).
	$('.click2edit').destroy();
}; 
</script>