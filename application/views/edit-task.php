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



<link rel="stylesheet" href=
"https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css">
 
 
    <script src=
"https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js">
    </script>
 
<main id="main" class="main">

<div class="pagetitle">
  <h1>Edit Task#<?php echo @$task[0]->task_name;?>
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
          <h5 class="card-title">&nbsp;</h5>
          
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
                                <input type="text" class="form-control" name="task_name" id="task_name" value="<?php echo @$task[0]->task_name;?>" autocomplete="off" placeholder="Enter Task Title" required />
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
                                            if(@$teamtask[0]->team_id == @$team->id)
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
                                <input type="text" class="form-control datepicker" name="task_start_date" id="task_start_date" autocomplete="off" value="<?php echo @$task[0]->task_start_date;?>" required />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-3 col-form-label">End Date</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control datepicker" name="task_end_date" id="task_end_date" autocomplete="off" value="<?php echo @$task[0]->task_end_date;?>" required />
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-12 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-3 col-form-label">Severity</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="severity" id="team_severity" required>
				                            <option value="">Select</option>
				                            <option value="10" <?php if(@$task[0]->severity == "10"){ echo 'selected="selected"';}?>>feature</option>
                                    <option value="20" <?php if(@$task[0]->severity == "20"){ echo 'selected="selected"';}?>>trivial</option>
                                    <option value="30" <?php if(@$task[0]->severity == "20"){ echo 'selected="selected"';}?>>text</option>
                                    <option value="40" <?php if(@$task[0]->severity == "20"){ echo 'selected="selected"';}?>>tweak</option>
                                    <option value="50" <?php if(@$task[0]->severity == "20"){ echo 'selected="selected"';}?>>minor</option>
                                    <option value="60" <?php if(@$task[0]->severity == "20"){ echo 'selected="selected"';}?>>major</option>
                                    <option value="70" <?php if(@$task[0]->severity == "20"){ echo 'selected="selected"';}?>>crash</option>
                                    <option value="80" <?php if(@$task[0]->severity == "20"){ echo 'selected="selected"';}?>>block</option>			
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-3 col-form-label">Priority</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="priority" id="team_priority" required>
				                    <option value="">Select</option>
                                    <option value="10" <?php if(@$task[0]->priority == "10"){ echo 'selected="selected"';}?>>none</option>
                                    <option value="20" <?php if(@$task[0]->priority == "20"){ echo 'selected="selected"';}?>>low</option>
                                    <option value="30" <?php if(@$task[0]->priority == "30"){ echo 'selected="selected"';}?>>normal</option>
                                    <option value="40" <?php if(@$task[0]->priority == "40"){ echo 'selected="selected"';}?>>high</option>
                                    <option value="50" <?php if(@$task[0]->priority == "50"){ echo 'selected="selected"';}?>>urgent</option>
                                    <option value="60" <?php if(@$task[0]->priority == "60"){ echo 'selected="selected"';}?>>immediate</option>	
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-12 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-3 col-form-label">Resolution</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="resoltuion" id="team_resoltuion" required>
				                    <option value="">Select</option>
                                    <option value="10" <?php if(@$task[0]->resoltuion == "10"){ echo 'selected="selected"';}?>>open</option>
                                    <option value="20" <?php if(@$task[0]->resoltuion == "20"){ echo 'selected="selected"';}?>>fixed</option>
                                    <option value="30" <?php if(@$task[0]->resoltuion == "30"){ echo 'selected="selected"';}?>>reopened</option>
                                    <option value="40" <?php if(@$task[0]->resoltuion == "40"){ echo 'selected="selected"';}?>>unable to reproduce</option>
                                    <option value="50" <?php if(@$task[0]->resoltuion == "50"){ echo 'selected="selected"';}?>>not fixable</option>
                                    <option value="60" <?php if(@$task[0]->resoltuion == "60"){ echo 'selected="selected"';}?>>duplicate</option>
                                    <option value="70" <?php if(@$task[0]->resoltuion == "70"){ echo 'selected="selected"';}?>>no change required</option>
                                    <option value="80" <?php if(@$task[0]->resoltuion == "80"){ echo 'selected="selected"';}?>>suspended</option>
                                    <option value="90" <?php if(@$task[0]->resoltuion == "90"){ echo 'selected="selected"';}?>>won't fix</option>			
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="col-lg-12 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-12 col-form-label">Task Monitored By</label>
                            <div class="col-sm-8">
                                <select class="form-control mul-select" id="multiple-select" multiple name="task_owners[]" required>
				                    <option value="">Select</option>
                                    <?php
                                    $ownd = @$task[0]->task_owners;
                                    if($ownd != "")
                                    {
                                      $owners = explode("|",$ownd);
                                    }
                                    else{
                                      $owners = array();
                                    }
                                    // print_R($owners);
                                    if(@sizeOf($teams) > 0)
                                    {
                                        foreach($teams as $team)
                                        {
                                          if(@sizeOf($owners) > 0)
                                          {
                                            if(@in_array($team->id,$owners))
                                            {
                                              $ss = 'selected="selected"';
                                            }
                                            else{
                                              $ss='';
                                            }
                                          }
                                          else{
                                            $ss='';
                                          }
                                    ?>
                                    <option value="<?php echo @$team->id;?>" <?php echo @$ss;?>><?php echo @$team->firstname;?> <?php echo @$team->lastname;?></option>
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
                            <label for="inputText" class="col-sm-12 col-form-label">Description</label>
                            <div class="col-sm-12">
                                <textarea class="form-control txtcls" name="task_desc" id="task_desc" required ><?php echo @$task[0]->task_desc;?></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-12 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-12 col-form-label">Notes</label>
                            <div class="col-sm-12">
                                <textarea class="form-control txtcls" name="task_notes" id="task_notes" ><?php echo @$task[0]->task_notes;?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 mb-3" style="text-align:center;">
                        <input type="hidden" class="form-control " name="rowid" value="<?php echo @$rowid;?>"  />
                        <button type="submit" class="btn btn-success" name="saveMember">Save</button>
                        
                        
                    </div>
                </form>
              </div>
              <div class="col-lg-5 mb-3">
                <div class="row">
                  <div class="col-lg-12" style="background-color:#eee;padding:15px;text-align:center;">
                  <h4>Upload Task Documents</h4>
                    <form class="dropzone" action="<?php echo base_url();?>index.php/home/uploadTaskFolder/<?php echo @$task[0]->project_id;?>/<?php echo @$rowid;?>" id="fileupload" mwthod="POST" enctype="multipart/form-data">
                  
                    
                  </form>
                  <button id="submit-all" class="btn btn-info mt-20p"> Upload files</button>
        
                  </div>
                </div>
                <div class="row mt-40p">
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
                        <a href="<?php echo @base_url()."uploads/tasks/docs/".$taskdocs[$d]->task_doc;?>" style="padding:0px 5px" target="_blank" class="btn btn-danger f12">View </a>
                      </div>
                    </div>
                  </div>
                  <?php
                    }
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

$("#task_name").on("keypress",function(event){
    var oVal = $(this).val();
    var regex = new RegExp("^[a-zA-Z0-9 _@-]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
        event.preventDefault();
        return false;
    }

})
</script>