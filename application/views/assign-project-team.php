<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

  <main id="main" class="main">

<div class="pagetitle">
  <h1>Assign Project to Lead
      <span class="hmenu">
          <a href="<?php echo base_url();?>index.php/team-members" class="btn btn-light">Back</a>
      </span>
  </h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo base_url();?>index.php/">Home</a></li>
      <li class="breadcrumb-item">
        <a href="<?php echo base_url();?>index.php/team-members">
            Assign Project to Lead
        </a>
        </li>
      <li class="breadcrumb-item active">Assign Member</li>
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
                <form method="POST" action="<?php echo base_url();?>index.php/home/saveAssignProjectToLead">
                    <?php
                    if(@$user[0]->role == "superadmin")
                    {
                    ?>
                    <div class="col-lg-6 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-4 col-form-label">Select Manger</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="p_manager" required>
                                    <option value="">Select</option>
                                <?php
                                if(@sizeOf($managers) > 0)
                                {
                                    for($m=0;$m<sizeOf($managers);$m++)
                                    {
                                ?>
                                    <option value="<?php echo @$managers[$m]->id;?>"><?php echo @$managers[$m]->firstname." ".@$managers[$m]->lastname;?></option>
                                <?php
                                    }
                                }
                                ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-4 col-form-label">Select Delivery Manger</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="d_manager" required>
                                    <option value="">Select</option>
                                <?php
                                if(@sizeOf($dmanagers) > 0)
                                {
                                    for($d=0;$d<sizeOf($dmanagers);$d++)
                                    {
                                ?>
                                    <option value="<?php echo @$dmanagers[$d]->id;?>"><?php echo @$dmanagers[$d]->firstname." ".@$dmanagers[$d]->lastname;?></option>
                                <?php
                                    }
                                }
                                ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-4 col-form-label">Select Team Lead</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="team_lead_id" required>
                                    <option value="">Select</option>
                                <?php
                                if(@sizeOf($leads) > 0)
                                {
                                    for($a=0;$a<sizeOf($leads);$a++)
                                    {
                                ?>
                                    <option value="<?php echo @$leads[$a]->id;?>"><?php echo @$leads[$a]->firstname." ".@$leads[$a]->lastname;?></option>
                                <?php
                                    }
                                }
                                ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <?php   
                    }
                    else  if(@$user[0]->role == "project-manager")
                    {
                    ?>
                    
                    <div class="col-lg-6 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-4 col-form-label">Select Delivery Manger</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="d_manager" required>
                                    <option value="">Select</option>
                                <?php
                                if(@sizeOf($dmanagers) > 0)
                                {
                                    for($d=0;$d<sizeOf($dmanagers);$d++)
                                    {
                                ?>
                                    <option value="<?php echo @$dmanagers[$d]->id;?>"><?php echo @$dmanagers[$d]->firstname." ".@$dmanagers[$d]->lastname;?></option>
                                <?php
                                    }
                                }
                                ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-4 col-form-label">Select Team Lead</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="team_lead_id" required>
                                    <option value="">Select</option>
                                <?php
                                if(@sizeOf($leads) > 0)
                                {
                                    for($a=0;$a<sizeOf($leads);$a++)
                                    {
                                ?>
                                    <option value="<?php echo @$leads[$a]->id;?>"><?php echo @$leads[$a]->firstname." ".@$leads[$a]->lastname;?></option>
                                <?php
                                    }
                                }
                                ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <?php   
                    }
                    else if(@$user[0]->role == "delivery-manager")
                    {
                    ?>
                    
                    <div class="col-lg-6 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-4 col-form-label">Select Team Lead</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="team_lead_id" required>
                                    <option value="">Select</option>
                                <?php
                                if(@sizeOf($leads) > 0)
                                {
                                    for($a=0;$a<sizeOf($leads);$a++)
                                    {
                                ?>
                                    <option value="<?php echo @$leads[$a]->id;?>"><?php echo @$leads[$a]->firstname." ".@$leads[$a]->lastname;?></option>
                                <?php
                                    }
                                }
                                ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <?php   
                    }
                    else{
                    ?>
                    <div class="col-lg-6 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-4 col-form-label">Select Team Member</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="team_id" required>
                                    <option value="">Select</option>
                                <?php
                                if(@sizeOf($members) > 0)
                                {
                                    for($a1=0;$a1<sizeOf($members);$a1++)
                                    {
                                ?>
                                    <option value="<?php echo @$members[$a1]->id;?>"><?php echo @$members[$a1]->firstname." ".@$members[$a1]->lastname;?></option>
                                <?php
                                    }
                                }
                                ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                    
                    
                    <div class="col-lg-6 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-4 col-form-label">Select Project</label>
                            <div class="col-sm-8">
                                
                                <select class="form-control" name="project_id" required>
                                    <option value="">Select</option>
                                <?php
                                if(@sizeOf($projects) > 0)
                                {
                                    for($a1=0;$a1<sizeOf($projects);$a1++)
                                    {
                                ?>
                                    <option value="<?php echo @$projects[$a1]->id;?>"><?php echo @$projects[$a1]->project_name;?></option>
                                <?php
                                    }
                                }
                                ?>
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
