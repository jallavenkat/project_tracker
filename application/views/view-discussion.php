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
    
  <main id="main" class="main">

<div class="pagetitle">
  <h1>View Discussion - #<?php echo @$code;?>
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
      <li class="breadcrumb-item active"><?php echo @$discussions[0]->solution_title;?></li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Discussions:</h5>
            <div class="row mb-3 editbg">
                <div class="col-lg-12 mb-3">
                    <h4><?php echo @$discussions[0]->solution_title;?></h4>
               </div>
               
               <div class="col-lg-12 mb-3">
                    <?php echo @$discussions[0]->solution_desc;?>
                    <div class="editorContainer">
                        <button id="copy-btn" class="copy-btn">Copy Code</button>
                        <textarea id="editor"><?php echo @$discussions[0]->solution_code;?></textarea>
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
    document.getElementById("editor").style.height="500px";
        var editor = CodeMirror.fromTextArea(document.getElementById("editor"), {
            mode: "javascript",
            lineNumbers: true,
            theme:'eclipse'
        });

        var code = document.getElementById("editor").value;
var copyBtn = document.getElementById("copy-btn");
copyBtn.addEventListener("click", function() {
  navigator.clipboard.writeText(code);
});

var rawBtn = document.getElementById("raw-btn");
rawBtn.addEventListener("click", function() {
  var encodedCode = encodeURIComponent(code);
  var url = "data:text/plain;charset=utf-8," + encodedCode;
  window.open(url, "_blank");
});

    </script>