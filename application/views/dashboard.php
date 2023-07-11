<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">
			<?php
			if(@$user[0]->role != "executive" && @$user[0]->role != "team-executive")
			{
				$clsas = 'col-xxl-4 col-md-6';
			}
			else{
				$clsas = 'col-xxl-6 col-md-6';
			}
			?>
            <!-- Sales Card -->
            <div class="<?php echo @$clsas;?>">
              <div class="card info-card sales-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Projects<span></span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="fa fa-cubes"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo @sizeOf($projects);?></h6>

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
            <div class="<?php echo @$clsas;?>">
              <div class="card info-card revenue-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Tasks <span></span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="fa fa-list"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo @sizeOf($tasks);?></h6>

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->
          <?php 
          if(@$user[0]->role != "executive" && @$user[0]->role != "team-executive")
          {
          ?>
            <!-- Customers Card -->
            <div class="col-xxl-4 col-xl-12">

              <div class="card info-card customers-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Users <span></span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo @sizeOf($teams);?></h6>

                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End Customers Card -->
            <?php
            }
            ?>

            <!-- Reports -->
            

            <!-- Recent Sales -->
            <div class="col-12">
              <div class="card recent-sales overflow-auto">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Recent Tasks <span></span></h5>

                  <table class="table table-borderless datatable">
                    <thead>
                      <tr>
                        <th scope="col">#Code</th>
                        <th scope="col">Task Name</th>
                        <th scope="col">Task Duration</th>
                        <th scope="col">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if(@sizeOf($recenttasks) > 0)
                      {
                        for($r=0;$r<sizeOf($recenttasks);$r++)
                        {
                      ?>
                      <tr>
                        <th scope="row">
                          <a href="<?php echo base_url();?>index.php/view-task/<?php echo @$recenttasks[$r]->task_code;?>">
                            # <?php 
                              echo @$recenttasks[$r]->task_code."<br />";
                              $date1 = @date("Y-m-d");
                              $date2 = @$recenttasks[$r]->task_end_date;
                              $diff = strtotime($date1) - strtotime($date2);
                              // 1 day = 24 hours
                              // 24 * 60 * 60 = 86400 seconds
                              if($diff<0)
                              {
                                $dVal = 0;
                              }
                              else{
                                $dVal = $diff;
                              }
                              $days = @abs(round($dVal / 86400));
                              if($days <= 0 && (@$recenttasks[$r]->task_status == 1 || @$recenttasks[$r]->task_status ==2 || @$recenttasks[$r]->task_status ==3 || @$recenttasks[$r]->task_status ==5) )
                              {
                              ?>
                              <span class="badge bg-success">Ontime</span>
                              <?php
                              }
                              else if($days > 0)
                              {
                              ?>
                              <span class="badge bg-danger">Overdue <?php echo @$days ." day(s)";?></span>
                              <?php
                              }
                              else{
                              ?>
                                <span class="badge bg-danger">Overdue</span>
                              <?php
                              }
                              
                            ?>
                        </a>
                        </th>
                        <td>
                          <?php 
                          echo @$recenttasks[$r]->task_name;
                          ?>
                      </td>
                        <td>
                          <span class="text-primary">
                            <?php 
                              echo @date("d-M-Y",strtotime($recenttasks[$r]->task_start_date))." - ".@date("d-M-Y",strtotime($recenttasks[$r]->task_end_date));
                            ?>
                          </span>
                        </td>
                        <td>
                          <?php 
                          if(@$recenttasks[$r]->task_status == 0)
                          {
                          ?>
                          <span class="badge bg-primary">New</span>
                          <?php
                          }
                          else if(@$recenttasks[$r]->task_status == 1)
                          {
                            ?>
                          <span class="badge bg-success">Inprogress</span>
                            <?php
                          }
                          else if(@$recenttasks[$r]->task_status == 2)
                          {
                            ?>
                          <span class="badge bg-warning">Reqcy to QA</span>
                            <?php
                          }
                          else if(@$recenttasks[$r]->task_status == 3)
                          {
                            ?>
                          <span class="badge bg-success">Completed</span>
                            <?php
                          }
                          else if(@$recenttasks[$r]->task_status == 4)
                          {
                            ?>
                          <span class="badge bg-success">Deleted</span>
                            <?php
                          }
                          
                          else if(@$recenttasks[$r]->task_status == 5)
                          {
                            ?>
                          <span class="badge bg-success">Hold</span>
                            <?php
                          }
                          else{
                            ?>
                            <span class="badge bg-default">Closed</span>
                            <?php
                          }

                          ?>
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
            </div><!-- End Recent Sales -->


          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">

          <!-- Recent Activity -->
          <div class="card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>

            <div class="card-body">
              <h5 class="card-title">Recent Activity <span></span></h5>

              <div class="activity" style="max-height:500px;height:510px;overflow-y:auto;">
              <?php
              if(@sizeOf($logs) > 0)
              {
                for($l=0;$l<sizeOf($logs);$l++)
                {
              ?>
                <div class="activity-item d-flex">
                  <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                  <div class="activity-content">
                    <?php echo @$logs[$l]->log_message;?><br />
                    created on <?php
                    echo @date("d-M-Y",strtotime($logs[$l]->created_on));
                    ?>
                  </div>
                </div><!-- End activity item-->

              <?php
                }
              }
              ?>
              </div>

            </div>
          </div><!-- End Recent Activity -->

          <!-- Budget Report -->
          

          <!-- Website Traffic -->
          <div class="card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>

            <div class="card-body pb-0">
              <h5 class="card-title">Task Status <span></span></h5>

              <div id="trafficChart" style="min-height: 445px;" class="echart"></div>

              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  echarts.init(document.querySelector("#trafficChart")).setOption({
                    tooltip: {
                      trigger: 'item'
                    },
                    legend: {
                      top: '5%',
                      left: 'center'
                    },
                    series: [{
                      name: 'Access From',
                      type: 'pie',
                      radius: ['40%', '70%'],
                      avoidLabelOverlap: false,
                      label: {
                        show: false,
                        position: 'center'
                      },
                      emphasis: {
                        label: {
                          show: true,
                          fontSize: '18',
                          fontWeight: 'bold'
                        }
                      },
                      labelLine: {
                        show: false
                      },
                      data: [{
                          value: '<?php echo (int)@$chartSeries["ontime"];?>',
                          name: 'Ontime'
                        },
                        {
                          value: '<?php echo (int)@$chartSeries["overdue"];?>',
                          name: 'Overdue >0 and <=2 days'
                        },
                        {
                          value: '<?php echo (int)@$chartSeries["overdue2"];?>',
                          name: 'Overdue >2 and <=4 days'
                        },
                        {
                          value: '<?php echo (int)@$chartSeries["overdue3"];?>',
                          name: 'Overdue >4 days'
                        }
                      ]
                    }]
                  });
                });
              </script>

            </div>
          </div><!-- End Website Traffic -->

          

        </div><!-- End Right side columns -->

      </div>
    </section>

  </main><!-- End #main -->
