<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
  <link rel="stylesheet" href="<?php echo base_url().'/assets/codemirror/css/codemirror.css'; ?>">
    <script src="<?php echo base_url('assets/codemirror/js/codemirror.js'); ?>"></script>
    <script src="<?php echo base_url('assets/codemirror/js/htmlmixed.js'); ?>"></script>
    <script src="<?php echo base_url('assets/codemirror/js/css.js'); ?>"></script>
    <script src="<?php echo base_url('assets/codemirror/js/php.js'); ?>"></script>
    <script src="<?php echo base_url('assets/codemirror/js/matchbrackets.js'); ?>"></script>
    <script src="<?php echo base_url('assets/codemirror/js/javascript.js'); ?>"></script>
    
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/dropzone.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="<?php echo base_url();?>assets/js/dropzone.js"></script>


<link href="<?php echo base_url()?>assets/css/plugins/summernote/summernote.css" rel="stylesheet">
<link href="<?php echo base_url()?>assets/css/plugins/summernote/summernote-bs3.css" rel="stylesheet">
  <main id="main" class="main">

<div class="pagetitle">
  <h1>Add Item
      <span class="hmenu">
          <a href="<?php echo base_url();?>discussions" class="btn btn-light">Back</a>
      </span>
  </h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
      <li class="breadcrumb-item">
        <a href="<?php echo base_url();?>discussions">
        Discussions
        </a>
        </li>
      <li class="breadcrumb-item active">Add Item</li>
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
                <form method="POST" action="<?php echo base_url();?>discussions/saveDiscussion">
                    <div class="col-lg-12 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-12 col-form-label">Topic Title:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="solution_title" placeholder="Enter Title" required />
                            </div>
                        </div>
                    </div>
                
                    <div class="col-lg-12 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-12 col-form-label">Description:</label>
                            <div class="col-sm-12">
                                <textarea class="form-control txtcls" name="solution_desc" id="solution_desc" required ></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-12 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-12 col-form-label">Code</label>
                            <div class="col-sm-12">
                                <textarea id="editor" name="solution_code" class="editorCode"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-12 col-form-label">Search Creteria tags:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="solution_tags" placeholder="Enter Tags" required />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3" style="text-align:center;">
                        <button type="submit" class="btn btn-success" name="saveMember">Save</button>
                        
                    </div>
                </form>
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
</script>

<script>
    document.getElementById("editor").style.height="500px";
        var editor = CodeMirror.fromTextArea(document.getElementById("editor"), {
            mode: "javascript",
            lineNumbers: true,
            theme:'eclipse'
        });
    </script>