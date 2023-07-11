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
                <form method="POST" action="<?php echo base_url();?>index.php/home/updateTeamMember">
                    <div class="col-lg-6 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-4 col-form-label">Firstname</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="team_firstname" placeholder="Enter First Name" value="<?php echo @$team[0]->firstname;?>" required />
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-4 col-form-label">Last Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="team_lastname" placeholder="Enter Last Name" value="<?php echo @$team[0]->lastname;?>" required />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-4 col-form-label">Email ID</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" name="team_email" placeholder="Enter Email Address" value="<?php echo @$team[0]->email;?>" required />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-4 col-form-label">Mobile Number</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="team_mobile_no" placeholder="Enter Mobile Number" value="<?php echo @$team[0]->mobile_no;?>" required />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-4 col-form-label">Position</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="team_position" required>
                                    <option value="">Select</option>
                                    <option value="team-executive" <?php if(@$team[0]->position == "team-executive-ui"){echo 'selected="selected"';}?>>Team Executive</option>
                                    <!-- <option value="team-executive-python" <?php if(@$team[0]->position == "team-executive-python"){echo 'selected="selected"';}?>>Team Executive (Python)</option> -->
                                    <option value="team-lead" <?php if(@$team[0]->position == "team-lead"){echo 'selected="selected"';}?>>Team Lead</option>
                                    <option value="delivery-manager" <?php if(@$team[0]->position == "delivery-manager"){echo 'selected="selected"';}?>>Delivery Manager</option>
                                    <option value="project-manager" <?php if(@$team[0]->position == "project-manager"){echo 'selected="selected"';}?>>Project Manager</option>
                                    <option value="management" <?php if(@$team[0]->position == "management"){echo 'selected="selected"';}?>>Management</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3" style="text-align:center;">
                        <input type="hidden" class="form-control" name="rowid" value="<?php echo @$rowid;?>"  />
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
