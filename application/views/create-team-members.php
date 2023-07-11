<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

  <main id="main" class="main">

<div class="pagetitle">
  <h1>Add Team Members
      <span class="hmenu">
          <a href="<?php echo base_url();?>index.php/team-members" class="btn btn-light">Back</a>
      </span>
  </h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo base_url();?>index.php/">Home</a></li>
      <li class="breadcrumb-item">
        <a href="<?php echo base_url();?>index.php/team-members">
            Team Members
        </a>
        </li>
      <li class="breadcrumb-item active">Add Member</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Add Member</h5>
          
            <div class="row mb-3">
                <form method="POST" action="<?php echo base_url();?>index.php/home/saveTeamMember">
                    <div class="col-lg-6 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-4 col-form-label">Firstname</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="team_firstname" placeholder="Enter First Name" required />
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-4 col-form-label">Last Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="team_lastname" placeholder="Enter Last Name" required />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-4 col-form-label">Email ID</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" name="team_email" placeholder="Enter Email Address" required />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-4 col-form-label">Mobile Number</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="team_mobile_no" placeholder="Enter Mobile Number" required />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-4 col-form-label">Position</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="team_position" required>
                                    <option value="">Select</option>
                                    <option value="team-executive">Team Executive</option>
                                    <!-- <option value="team-executive">Team Executive (Python)</option> -->
                                    <option value="team-lead">Team Lead</option>
                                    <option value="delivery-manager">Delivery Manager</option>
                                    <option value="project-manager">Project Manager</option>
                                    <option value="management">Management</option>
                                </select>
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
