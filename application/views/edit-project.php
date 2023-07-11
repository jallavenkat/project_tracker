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

  <main id="main" class="main">

<div class="pagetitle">
  <h1>Edit Project#<?php echo @$project[0]->project_name;?>
      <span class="hmenu">
          <a href="<?php echo base_url();?>index.php/projects" class="btn btn-light">Back</a>
      </span>
  </h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo base_url();?>index.php/">Home</a></li>
      <li class="breadcrumb-item">
        <a href="<?php echo base_url();?>index.php/projects">
            Projects
        </a>
        </li>
      <li class="breadcrumb-item active">Edit Project</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Add Project</h5>
          
            <div class="row mb-3">
              <div class="col-lg-7 mb-3">
                <form method="POST" action="<?php echo base_url();?>index.php/home/updateProject">
                    <div class="col-lg-6 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-4 col-form-label">Project Title</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control stringValidate" autocomplete="off" name="project_name" placeholder="Enter Project Title" value="<?php echo @$project[0]->project_name;?>" required />
                            </div>
                        </div>
                    </div>
                    
                   
                    <div class="col-lg-6 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-4 col-form-label">Mode</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="project_mode" required>
                                    <option value="">Select</option>
                                    <option value="poc" <?php if(@$project[0]->project_mode == "poc"){echo 'selected="selected"';}?>>POC</option>
                                    <option value="production" <?php if(@$project[0]->project_mode == "production"){echo 'selected="selected"';}?>>Production</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-4 col-form-label">Start Date</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control datepicker" name="project_start_date" id="project_start_date" value="<?php echo @$project[0]->project_start_date;?>" required />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-4 col-form-label">End Date</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control datepicker" name="project_end_date" id="project_end_date" value="<?php echo @$project[0]->project_end_date;?>" required />
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-12 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-12 col-form-label">Description</label>
                            <div class="col-sm-12">
                                <textarea class="form-control txtcls" name="project_desc" id="project_desc" required ><?php echo @$project[0]->project_desc;?></textarea>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="col-lg-6 mb-3" style="text-align:center;">
                        <input type="hidden" class="form-control" name="rowid" value="<?php echo @$rowid;?>"  />
                        <button type="submit" class="btn btn-success" name="saveMember">Save</button>
                        
                        
                    </div>
                </form>
              </div>
              <div class="col-lg-5 mb-3">
                <div class="row">
                  <div class="col-lg-12" style="background-color:#eee;padding:15px;text-align:center;">
                  <h4>Upload Project Documents</h4>
                    <form class="dropzone" action="<?php echo base_url();?>index.php/home/uploadProjectFolder/<?php echo @$rowid;?>" id="fileupload" mwthod="POST" enctype="multipart/form-data">
                  
                    
                  </form>
                  <button id="submit-all" class="btn btn-info mt-20p"> Upload files</button>
        
                  </div>
                </div>
                <div class="row mt-40p">
                  <?php
                  if(@sizeOf($projectdocs) > 0)
                  {
                    for($d=0;$d<sizeOf($projectdocs);$d++)
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
                        <?php echo @$projectdocs[$d]->project_doc;?>
                      </div>
                      <div class="col-lg-3">
                        <a href="<?php echo @base_url()."uploads/projects/docs/".$projectdocs[$d]->project_doc;?>" target="_blank" class="btn btn-danger f12">View </a>
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
            //     url: '<?php echo base_url();?>index.php/home/uploadProjectFolder/<?php echo @$rowid;?>',
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

$(".stringValidate").on("keypress",function(event){
    var oVal = $(this).val();
    var regex = new RegExp("^[a-zA-Z0-9 _@-]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
        event.preventDefault();
        return false;
    }

});

</script>