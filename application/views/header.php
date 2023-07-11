<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?php echo base_url();?>assets/img/favicon.png" rel="icon">
  <link href="<?php echo base_url();?>assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?php echo base_url();?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/vendor/simple-datatables/style.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Mar 09 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="<?php echo base_url();?>index.php/" class="logo d-flex align-items-center">
        <img src="<?php echo base_url();?>assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">Admin</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

       

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="<?php echo base_url();?>assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo @ucfirst($user[0]->username);?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?php echo @$user[0]->email;?></h6>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="<?php echo base_url();?>index.php/">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="<?php echo base_url();?>index.php/login/logout">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link  <?php if(@$menu == "dashboard"){echo "";}else{echo "collapsed";}?>" href="<?php echo base_url();?>index.php/">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <?php
        if(@$menu == "projects")
        {
          $pcol = "";
          $pcolshow = "show";
        }
        else{
          $pcol = "collapsed";
          $pcolshow = "";
        }
        
        ?>
        <a class="nav-link <?php echo @$pcol;?>" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Projects</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse <?php echo @$pcolshow;?> " data-bs-parent="#sidebar-nav">
        <?php
        if(@sizeOf($user) > 0)
        {
          if(@$user[0]->role != "team-executive" && @$user[0]->role != "executive")
          {
        ?>  
          <li>
            <a href="<?php echo base_url();?>index.php/projects" class="<?php if(@$smenu == "projects"){echo "active";}?>">
              <i class="bi bi-circle"></i><span>View All Projects</span>
            </a>
          </li>
          
          <li>
            <a href="<?php echo base_url();?>index.php/team-projects" class="<?php if(@$smenu == "teamprojects"){echo "active";}?>">
              <i class="bi bi-circle"></i><span>Team Projects</span>
            </a>
          </li>
            <?php
            }
            else{
          ?>
          <li>
            <a href="<?php echo base_url();?>index.php/team-projects" class="<?php if(@$smenu == "teamprojects"){echo "active";}?>">
              <i class="bi bi-circle"></i><span>My Projects</span>
            </a>
          </li>
          
          <?php    
            }
          }
          ?>
        </ul>
      </li><!-- End Components Nav -->
      
      <?php
        if(@sizeOf($user) > 0)
        {
          if(@$user[0]->role != "team-executive" && @$user[0]->role != "executive")
          {
        ?>
      <li class="nav-item">
        <a class="nav-link <?php if(@$menu == "teams"){echo "";}else{echo "collapsed";}?>" href="<?php echo base_url();?>index.php/team-members">
          <i class="bi bi-card-list"></i>
          <span>Team Members</span>
        </a>
      </li><!-- End Register Page Nav -->
      <?php
          }
        }
      ?>

      <li class="nav-item">
        <a class="nav-link  <?php if(@$menu == "tasks"){echo "";}else{echo "collapsed";}?>" href="<?php echo base_url();?>index.php/tasks">
          <i class="bi bi-box-arrow-in-right"></i>
          <span>Tasks</span>
        </a>
      </li><!-- End Login Page Nav -->
      
    
      
      <li class="nav-item">
        <a class="nav-link  <?php if(@$menu == "discussions"){echo "";}else{echo "collapsed";}?>" href="<?php echo base_url();?>index.php/discussions">
          <i class="bi bi-people"></i>
          <span>Discussions</span>
        </a>
      </li><!-- End Login Page Nav -->

    </ul>

  </aside><!-- End Sidebar-->
