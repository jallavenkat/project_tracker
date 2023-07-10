<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/dropzone.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="<?php echo base_url();?>assets/js/dropzone.js"></script>


<link href="<?php echo base_url()?>assets/css/plugins/summernote/summernote.css" rel="stylesheet">
<link href="<?php echo base_url()?>assets/css/plugins/summernote/summernote-bs3.css" rel="stylesheet">

<link rel="stylesheet" href=
"https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css">
 
 
    <script src=
"https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js">
    </script>
 

<main id="main" class="main">

<div class="pagetitle">
  <h1>Add Task
      <span class="hmenu">
          <a href="<?php echo base_url();?>tasks" class="btn btn-light">Back</a>
      </span>
  </h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
      <li class="breadcrumb-item">
        <a href="<?php echo base_url();?>tasks">
            Tasks
        </a>
        </li>
      <li class="breadcrumb-item active">Add Task</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Add Task</h5>
          <form method="POST" action="<?php echo base_url();?>home/saveTask" id="cTask" enctype="multipart/form-data">
              
            <div class="row mb-3">
                    <div class="col-lg-12 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Select Project</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="project_id" id="project_id" <?php if(@sizeOf($parentTask) > 0){echo 'disabled';}?> required>
                                    <option value="">Select</option>
                                    <?php
                                    if(@sizeOf($projects) > 0)
                                    {
                                        foreach($projects as $project)
                                        {
                                            if(@$parentTask[0]->project_id == @$project->id)
                                            {
                                                $sel ='selected="selected"';
                                            }
                                            else{
                                                $sel = '';
                                            }
                                    ?>
                                    <option <?php echo $sel;?> value="<?php echo @$project->id;?>"><?php echo @$project->project_name;?></option>
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
                            <label for="inputText" class="col-sm-2 col-form-label">Task Title</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" autocomplete="off" name="task_name" id="task_name" placeholder="Enter Task Title" autocomplete="off" required />
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-3 col-form-label">Start Date</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control datepicker" name="task_start_date" id="task_start_date" autocomplete="off" required />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-3 col-form-label">End Date</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control datepicker" name="task_end_date" id="task_end_date" autocomplete="off" required />
                            </div>
                        </div>
                    </div>
                   
                    <div class="col-lg-4 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-3 col-form-label">Assign To</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="team_id" id="team_id" required>
                                    <option value="">Select</option>
                                    <?php
                                    if(@sizeOf($teams) > 0)
                                    {
                                        foreach($teams as $team)
                                        {
                                    ?>
                                    <option value="<?php echo @$team->id;?>"><?php echo @$team->firstname;?> <?php echo @$team->lastname;?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-3 col-form-label">Severity</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="severity" id="team_severity" required>
				                    <option value="">Select</option>
				                    <option value="10">feature</option>
                                    <option value="20">trivial</option>
                                    <option value="30">text</option>
                                    <option value="40">tweak</option>
                                    <option value="50">minor</option>
                                    <option value="60">major</option>
                                    <option value="70">crash</option>
                                    <option value="80">block</option>			
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-3 col-form-label">Priority</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="priority" id="team_priority" required>
				                    <option value="">Select</option>
                                    <option value="10">none</option>
                                    <option value="20">low</option>
                                    <option value="30">normal</option>
                                    <option value="40">high</option>
                                    <option value="50">urgent</option>
                                    <option value="60">immediate</option>	
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-3 col-form-label">Resolution</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="resoltuion" id="team_resoltuion" required>
				                    <option value="">Select</option>
                                    <option value="10">open</option>
                                    <option value="20">fixed</option>
                                    <option value="30">reopened</option>
                                    <option value="40">unable to reproduce</option>
                                    <option value="50">not fixable</option>
                                    <option value="60">duplicate</option>
                                    <option value="70">no change required</option>
                                    <option value="80">suspended</option>
                                    <option value="90">won't fix</option>			
                                </select>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                    
                    <div class="col-lg-12 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-3 col-form-label">Task Monitored By</label>
                            <div class="col-sm-8">
                                <select class="form-control mul-select" id="multiple-select" multiple name="task_owners[]" required>
				                    <option value="">Select</option>
                                    <?php
                                    if(@sizeOf($teams) > 0)
                                    {
                                        foreach($teams as $team)
                                        {
                                    ?>
                                    <option value="<?php echo @$team->id;?>"><?php echo @$team->firstname;?> <?php echo @$team->lastname;?></option>
                                    <?php
                                        }
                                    }
                                    ?>		
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-12 col-form-label">Description</label>
                            <div class="col-sm-12">
                                <textarea class="form-control txtcls" name="task_desc" id="task_desc" required ></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-12 col-form-label">Notes</label>
                            <div class="col-sm-12">
                                <textarea class="form-control txtcls" name="task_notes" id="task_notes"  ></textarea>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="col-lg-12 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-12 col-form-label">Attachments</label>
                            <div class="col-sm-12">
                            <div class="dropzone" id="fileupload" ></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6 mb-3" style="text-align:center;">
                    <?php
                    if(@sizeOf($parentTask) > 0)
                    {
                        $ptaskid = @$parentTask[0]->id;
                    }
                    else{
                        $ptaskid = 0;
                    }
                    ?>
                        <input type="hidden" name="parentTaskID" id="parentTaskID" value="<?php echo @$ptaskid;?>" />
                        <button type="button" class="btn btn-success" name="saveMember" id="submit-all">Save</button>
                    </div>
            </div>
            </form>
        </div>
      </div>

    </div>

  </div>
</section>

</main>
<script>
     $(document).ready(function() {
            $(".mul-select").select2({
                placeholder: "Select",
                tags: true,
                search: true,
                selectAll: true
            });

        })
  $( function() {
    $( ".datepicker" ).datepicker({dateFormat:"yy-mm-dd"});
  } );
  </script>

<script src="<?php echo base_url()?>assets/js/plugins/summernote/summernote.min.js"></script>
  
<script>
$(document).ready(function(){

	$('.txtcls').summernote({
        height: 300,
    });

});
var edit = function() {
	$('.click2edit').summernote({focus: true});
};
var save = function() {
	var aHTML = $('.click2edit').code(); //save HTML If you need(aHTML: array).
	$('.click2edit').destroy();
}; 

Dropzone.options.fileupload = {
        // Prevents Dropzone from uploading dropped files immediately
        url:"<?php echo base_url();?>home/saveTask",
        uploadMultiple: true,
        paramName: "file",
        maxFilesize: 100,
        maxFiles: 10,
        createImageThumbnails: true,
        acceptedFiles: ".png,.jpg,.jpeg,.pdf,.doc,.docx,.ppt,.pptx,.pdfx,.xls,.xlsx",
        clickable: true,
        thumbnailWidth: 150,
        thumbnailHeight: 150,
        autoProcessQueue: false,
        sending: function(file, xhr, formData) {
            // Send additional form data along with the file
            formData.append("task_name", jQuery("#task_name").val());
            formData.append("project_id", jQuery("#project_id").val());
            formData.append("task_start_date", jQuery("#task_start_date").val());
            formData.append("task_end_date", jQuery("#task_end_date").val());
            formData.append("team_id", jQuery("#team_id").val());
            formData.append("severity", jQuery("#team_severity").val());
            formData.append("priority", jQuery("#team_priority").val());
            formData.append("resoltuion", jQuery("#team_resoltuion").val());
            formData.append("task_desc", jQuery("#task_desc").val());
            formData.append("task_owners", jQuery("#multiple-select").val());
        },
        init: function () {
            // $.ajax({
            //     url: '<?php echo base_url();?>home/uploadTaskFolder/<?php echo @$rowid;?>',
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
            
                submitButton.addEventListener("click", function (e) {
                    
                    var ufiles = fileupload.getQueuedFiles().length;
                    console.log("ufiles ", ufiles)
                    if(ufiles > 0)
                    {
                        fileupload.processQueue();
                    }
                    else{
                        e.preventDefault();
                        e.stopPropagation();
                        $("form#cTask").submit()
                    }

                });
                // to handle the added file event
                this.on('completemultiple', function (file, json) {
                    // window.location.reload()
                    
                    console.log("fileHere",file)
                });
            
                this.on('queuecomplete', function(resp){
                //   fileupload.emit("resetFiles");
                    // console.log("Here",resp)
                    // setTimeout(()=>{
                    //     // window.location.reload()
                    // },1000)
                })
            
        },
        success: function(file,response){
            // console.log("response ",response)
          if(response == 1 || response == "1")
          {
            window.location.href="<?php echo base_url();?>tasks";
          }
        }
};

$(function(){
    $("#task_name").on("keypress",function(event){
        var oVal = $(this).val();
        var regex = new RegExp("^[a-zA-Z0-9 _@-]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }

    })
});

</script>