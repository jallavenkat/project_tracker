<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


<link rel="stylesheet" href="<?php echo base_url();?>assets/css/dropzone.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="<?php echo base_url();?>assets/js/dropzone.js"></script>

  <main id="main" class="main">

<div class="pagetitle">
  <h1>View Project #<?php echo @$project[0]->project_name;?>
      <span class="hmenu">
        <?php
        if(@$actionfrom == "teams")
        {
        ?>
            <a href="<?php echo base_url();?>team-projects" class="btn btn-light">Back</a>
        <?php
        }
        else{
        ?>
        <a href="<?php echo base_url();?>projects" class="btn btn-light">Back</a>
        <?php
        }
        ?>
      </span>
  </h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
      <li class="breadcrumb-item">
        <a href="<?php echo base_url();?>projects">
            Projects
        </a>
        </li>
      <li class="breadcrumb-item active">View Project#<?php echo @$project[0]->project_name;?></li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">View Project#<?php echo @$project[0]->project_name;?></h5>
          
            <div class="row mb-3">
              <div class="col-lg-7 mb-3">
                <form method="POST" action="">
                    <div class="col-lg-6 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-4 col-form-label">Project Title</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="project_name" placeholder="Enter Project Title" value="<?php echo @$project[0]->project_name;?>" required />
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
                    
                    
                </form>
              </div>
              <div class="col-lg-5 mb-3">
                <div class="row">
                    <div class="col-lg-12">
                        <h5><i class="ri-attachment-2"></i>&nbsp;Attachments</h5>
                    </div>
                </div>
                <div class="row">
                
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
                  else{
                    echo "No attachments found.";
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
            //     url: '<?php echo base_url();?>home/uploadProjectFolder/<?php echo @$rowid;?>',
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