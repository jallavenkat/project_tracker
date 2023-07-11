<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

  <main id="main" class="main">

<div class="pagetitle">
  <h1>Assign Members to Lead
      <span class="hmenu">
          <a href="<?php echo base_url();?>index.php/team-members" class="btn btn-light">Back</a>
      </span>
  </h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo base_url();?>index.php/">Home</a></li>
      <li class="breadcrumb-item">
        <a href="<?php echo base_url();?>index.php/team-members">
            Assign Members to Lead
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
                <form method="POST" action="<?php echo base_url();?>index.php/home/saveAssignMember">
                    
                    <div class="col-lg-6 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-4 col-form-label">Select Team Lead</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="team_lead" required>
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
                    <div class="col-lg-6 mb-3">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-4 col-form-label">Select Team Members</label>
                            <div class="col-sm-8">
                                
                            <ul>

                               <?php
                               if(@sizeOf($teams) > 0)
                               {
                                for($t=0;$t<sizeOf($teams);$t++)
                                {
                                ?>
                                <li>
                                <input type="checkbox" name="teammembers[]" class=""members" value="<?php echo @$teams[$t]->id;?>" />&nbsp;<?php echo @$teams[$t]->firstname." ".@$teams[$t]->lastname;?>
                                </li>
                                <?php
                                }
                               }
                               ?>
                               </ul>
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
