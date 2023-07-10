<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

  <main id="main" class="main">

<div class="pagetitle">
  <h1>View Issues
      <span class="hmenu">
          <a href="<?php echo base_url();?>add-project" class="btn btn-warning">Add Issue</a>
      </span>
  </h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
      <li class="breadcrumb-item active">View Issues</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">List</h5>
          <?php
          if(@$this->session->userdata("tmsmessage") != "")
          {
          ?>
          <div class="alert alert-info"><?php echo @$this->session->userdata("tmsmessage"); @$this->session->unset_userdata("tmsmessage");?></div>
          <?php
          }    

          ?>
          <table class="table datatable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Issue Code</th>
                    <th scope="col">Project Name</th>
                    <th scope="col">Project Mode</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                   try{
                  
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
