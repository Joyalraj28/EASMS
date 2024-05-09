
<h1>Overview</h1>
<hr class="bg-light">
<?php if($_settings->userdata('type') != 3):
      ($_settings->userdata('type'));
  ?>
<div class="row">

           <!-- Total Attendance -->
           <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-green elevation-1"><i class="fas fa-id-badge"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Attendance</span>
                <span class="info-box-number text-right">
                  <?php 
                    $pending = $conn->query("SELECT Count(*) FROM `leaveapplication`")->num_rows;
                    echo number_format($pending);
                  ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <!-- Pending Applications -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-light elevation-1"><i class="fas fa-file-alt"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Pending Applications</span>
                <span class="info-box-number text-right">
                  <?php 
                    $pending = $conn->query("SELECT Count(*) FROM `leaveapplication`")->num_rows;
                    echo number_format($pending);
                  ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <!-- Total Departments -->
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-building"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Departments</span>
                <span class="info-box-number text-right">
                  <?php 
                    $department = $conn->query("SELECT Count(*) FROM `department`")->num_rows;
                    echo number_format($department);
                  ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <!-- Total Designations -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-lightblue elevation-1"><i class="fas fa-th-list"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Designations</span>
                <span class="info-box-number text-right">
                <?php 
                    $designation = $conn->query("SELECT Count(*) FROM `designation`")->num_rows;
                    echo number_format($designation);
                  ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <!-- Total Type of Leave -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-purple elevation-1"><i class="fas fa-list"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Type of Leave</span>
                <span class="info-box-number text-right">
                <?php 
                    $leave_types = $conn->query("SELECT Count(*) FROM `leavetype`")->num_rows;
                    echo number_format($leave_types);
                  ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
        </div>
<?php else: ?>
  <div class="row">
    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box">
        <span class="info-box-icon bg-light elevation-1"><i class="fas fa-file-alt"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Pending Applications</span>
          <span class="info-box-number text-right">
            <?php 
              $pending = $conn->query("SELECT Count(*) FROM `leaveapplication`")->num_rows;
              echo number_format($pending);
            ?>
            <?php ?>
          </span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box">
        <span class="info-box-icon bg-lightblue elevation-1"><i class="fas fa-th-list"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Upcoming Leave</span>
          <span class="info-box-number text-right">
            <?php 
              $upcoming = $conn->query("SELECT Count(*) FROM `leave_applications`")->num_rows;
              echo number_format($upcoming);
            ?>
            <?php ?>
          </span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
  </div>
<?php endif; ?>
