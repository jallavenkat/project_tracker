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
  <h1>Add Project
      <span class="hmenu">
          <a href="<?php echo base_url();?>projects" class="btn btn-light">Back</a>
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
     
        <li class="breadcrumb-item active">Add Project</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Add Project</h5>
          
          <form method="POST" action="<?php echo base_url();?>home/saveProject">
            <div class="row mb-3">
                    <div class="col-lg-6 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-4 col-form-label">Project Title</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control stringValidate" autocomplete="off" name="project_name" placeholder="Enter Project Title" required />
                            </div>
                        </div>
                    </div>
                    
                   
                    <div class="col-lg-6 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-4 col-form-label">Mode</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="project_mode" required>
                                    <option value="">Select</option>
                                    <option value="poc">POC</option>
                                    <option value="production">Production</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-4 col-form-label">Start Date</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control datepicker" name="project_start_date" id="project_start_date" autocomplete="off" required />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-4 col-form-label">End Date</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control datepicker" name="project_end_date" id="project_end_date" autocomplete="off" required />
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-12 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-12 col-form-label">Description</label>
                            <div class="col-sm-12">
                                <textarea class="form-control txtcls" name="project_desc" id="project_desc" required ></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6 mb-3" style="text-align:center;">
                        <button type="submit" class="btn btn-success" name="saveMember">Save</button>
                        
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
  $( function() {
    $( ".datepicker" ).datepicker({dateFormat:"yy-mm-dd"});
  } );
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
    var regex = new RegExp("^[a-zA-Z0-9 _@.-]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
        event.preventDefault();
        return false;
    }

});
  </script>