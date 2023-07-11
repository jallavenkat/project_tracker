<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

  <main id="main" class="main">

<div class="pagetitle">
  <h1>Team Members
      <span class="hmenu">
          <a href="<?php echo base_url();?>index.php/team-members" class="btn btn-default float-right mr-10p">Back</a>
      </span>
  </h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo base_url();?>index.php/">Home</a></li>
      <li class="breadcrumb-item active">Team</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Members List</h5>
          <?php
          if(@$this->session->userdata("teammessage") != "")
          {
          ?>
          <div class="alert alert-info"><?php echo @$this->session->userdata("teammessage"); @$this->session->unset_userdata("teammessage");?></div>
          <?php
          }    

          ?>
          <table class="table datatable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Image</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Mobile No</th>
                    <th scope="col">Position</th>
                    <th scope="col">No of Projects</th>
                    <th scope="col">No of Tasks</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if(@sizeOf($teams) > 0)
                  {
                    for($t=0;$t<sizeOf($teams);$t++)
                    {
                  ?>
                   <tr>
                    <th scope="row"><?php echo ($t+1);?></th>
                    <td><img src="<?php echo base_url()."uploads/users/".@$teams[$t]->logininfo[0]->avatar;?>" /></td>
                    <td>
                      <?php
                      if(@$teams[$t]->position == "team-lead")
                      {
                        echo '<i class="bi bi-star-fill"></i>';
                      }
                      ?>
                      <?php echo @$teams[$t]->firstname;?>
                    </td>
                    <td><?php echo @$teams[$t]->lastname;?></td>
                    <td><?php echo @$teams[$t]->email;?></td>
                    <td><?php echo @$teams[$t]->mobile_no;?></td>
                    <td><?php echo @$teams[$t]->position;?></td>
                    <td><?php echo @sizeOf($teams[$t]->projects);?></td>
                    <td><?php echo @sizeOf($teams[$t]->tasks);?></td>
                    <td>
                      <a href="<?php echo base_url()."home/editTeamMember/".@$teams[$t]->id;?>"><i class="bi bi-pencil-square"></i> Edit</a>
                    </td>
                  </tr>
                  <?php
                    }
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
