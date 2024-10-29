
     <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-light-primary text-white disabled elevation-4 sidebar-no-expand">
        <!-- Brand Logo -->
        <a href="<?php echo base_url ?>admin" class="brand-link bg-lightblue text-sm">
        <img src="<?php echo validate_image($_settings->info('logo'))?>" alt="Store Logo" class="brand-image img-circle elevation-3" style="opacity: .8;width: 1.7rem;height: 1.7rem;max-height: unset">
        <span class="brand-text font-weight-light"><?php echo $_settings->info('short_name') ?></span>
        </a>
        <!-- Sidebar -->
        <div class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-transition os-host-scrollbar-horizontal-hidden">
          <div class="os-resize-observer-host observed">
            <div class="os-resize-observer" style="left: 0px; right: auto;"></div>
          </div>
          <div class="os-size-auto-observer observed" style="height: calc(100% + 1px); float: left;">
            <div class="os-resize-observer"></div>
          </div>
          <div class="os-content-glue" style="margin: 0px -8px; width: 249px; height: 646px;"></div>
          <div class="os-padding">
            <div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;">
              <div class="os-content" style="padding: 0px 8px; height: 100%; width: 100%;">
                <!-- Sidebar user panel (optional) -->
                <div class="clearfix"></div>
                <!-- Sidebar Menu -->
                <nav class="mt-3">
                  <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-compact nav-flat nav-child-indent nav-collapse-hide-child" data-widget="treeview" role="menu" data-accordion="false">
                    
                    <?php $_settings->userdata("login_type") ?>

                    <!-- Overview -->
                    <li  class="nav-link nav-home">
                      <a href="./">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                          Overview
                        </p>
                      </a>
                    </li> 

                    <!-- Employees Management -->
                    <?php if($_settings->userdata('login_type') == 1): ?>
                    <li class="nav-link employee" data-toggle="collapse" data-target="#employeesdropdown">
                    <a>
                      <i class="nav-icon fas fa-user-friends"></i>
                        <p>
                          Employees
                        </p>
                    </a>
                    </li>

                    <div id="employeesdropdown" class="collapse">
                      
                     <!-- Employees Management -->
                      <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=employees" class="nav-link nav-employees">
                        <i class="nav-icon fas fa-user-friends"></i>
                        <p>
                         List of Employees
                        </p>
                      </a>
                      </li>

                       <!-- Employees Management -->
                       <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=maintenance/accessibility" class="nav-link nav-maintenance_accessibility" class="nav-link">
                        <i class="nav-icon fas fa-user-friends"></i>
                        <p>
                        Accessibility
                        </p>
                      </a>
                      </li>
                    </div>
                  <?php endif; ?>

                  <!-- Department Management -->
                  <?php if($_settings->userdata('login_type') == 1): ?>
                   <li class="nav-link" data-toggle="collapse" data-target="#maintenance_departmentdropdown">
                   <a>
                   <i class="nav-icon fas fa-building"></i>
                   <p>Department</p>
                   </a>  
                   </li>
                  <?php endif; ?>

                  <?php if($_settings->userdata('login_type') == 1): ?>
                    <div id="maintenance_departmentdropdown" class="collapse">
                     <!-- Department Management -->
                     <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=maintenance/department" class="nav-link nav-maintenance_department">
                        <i class="nav-icon fas fa-building"></i>
                        <p>
                          Department Management
                        </p>
                      </a>
                    </li>
                

                 </div>


                   <!-- Designation Management -->
                   <li class="nav-link" data-toggle="collapse" data-target="#maintenance_designationdropdown">
                    <a>  
                    <i class="nav-icon fas fa-th-list"></i>
                    <p>Designation</p>
                    </a>  
                  </li>

                  <div id="maintenance_designationdropdown" class="collapse">
                     <!-- Designation Management -->
                     <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=maintenance/designation" class="nav-link nav-maintenance_designation">
                        <i class="nav-icon fas fa-th-list"></i>
                        <p>
                         All Designation
                        </p>
                      </a>
                    </li>
                 </div>

                 <?php endif; ?>

                 <li class="nav-link" data-toggle="collapse" data-target="#AttendSalarydropdown">
                  <a>    
                    <i class="nav-icon fas fa-user-friends"></i>
                    <p>Attendance & Salary</p>
                  </a>   
                  </li>


                 <div id="AttendSalarydropdown" class="collapse">


                  <!-- Attendance -->
                    <li class="nav-item dropdown">
                    
                 

                      <a href="<?php echo base_url."admin/?page=maintenance/" ?><?php echo $_settings->userdata("login_type") == 3 ?"view_attendance&id=".$_settings->userdata("EmployeeID") : "attendance" ?>" class="nav-link nav-maintenance_attendance">
                      <i class="nav-icon fas fa-calendar"></i>
                        <p>List of Attendance</p>
                      </a>
                    </li>

                     <!-- Salary -->
                     <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=maintenance/<?php echo $_settings->userdata("login_type") == 3 ?"view_salary&id=".$_settings->userdata("EmployeeID") : "salary" ?>" class="nav-link nav-maintenance_salary">
                      <i class="nav-icon fas fa-money-bill-wave"></i>
                        <p>Salary</p>
                      </a>
                    </li>

                 </div>


                 <li class="nav-link" data-toggle="collapse" data-target="#leavedropdown">
                   <a>
                        <i class="nav-icon fas fa-list"></i>
                        <p>Leave</p>
                  </a>
                  </li>

                  <div id="leavedropdown" class="collapse">
                      <!-- Leave Type Management -->
                      <?php if(($_settings->userdata('login_type') == 1 && $_settings->userdata('AdminManageLeave'))): ?>
                      <li  class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=leavemanagement/leave_type" class="nav-link nav-leavemanagement_leave_type">
                        <i class="nav-icon fas fa-list"></i>
                        <p>
                          Leave Type Management
                        </p>
                      </a>
                      </li>
                      <?php endif; ?>

                      <!-- Leave history Reports  -->
                      <?php if(($_settings->userdata('login_type') == 1 && $_settings->userdata('AdminManageLeave')) 
                               || ($_settings->userdata('login_type') == 2 && $_settings->userdata('AccManageAttendance'))): ?>
                      <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=leavemanagement/leavereport" class="nav-link nav-leavemanagement_leavereport">
                        <i class="nav-icon fas fa-file"></i>
                        <p>
                         Leave history Reports
                        </p>
                      </a>
                      </li>
                      <?php endif; ?>

                      <!-- Leave Application -->
                     
                      <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=leavemanagement/leave_applications" class="nav-link nav-leavemanagement_leave_applications">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>
                          Application Management
                        </p>
                      </a>
                      </li>

                  </div>


                  

                  <!-- System Settings -->
                  <?php if($_settings->userdata('login_type') == 1): ?>
                   <li>
                      <a href="<?php echo base_url ?>admin/?page=system_info" class="nav-link nav-system_info">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>Settings</p>
                      </a>
                   </li>

                  <?php endif; ?>

                  </ul>
                </nav>
                <!-- /.sidebar-menu -->
              </div>
            </div>
          </div>
          <div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden">
            <div class="os-scrollbar-track">
              <div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px, 0px);"></div>
            </div>
          </div>
          <div class="os-scrollbar os-scrollbar-vertical os-scrollbar-auto-hidden">
            <div class="os-scrollbar-track">
              <div class="os-scrollbar-handle" style="height: 55.017%; transform: translate(0px, 0px);"></div>
            </div>
          </div>
          <div class="os-scrollbar-corner"></div>
        </div>
        <!-- /.sidebar -->
      </aside>
      <script>
        
    $(document).ready(function(){

      var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
      var s = '<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>';
      page = page.split('/');
      page = page.join('_');

      

      if($('.nav-link.nav-'+page).length > 0){
        $('.nav-link.nav-'+page).addClass('active');
      
        console.log(page);

        pageid = '#'+page+'dropdown'

        if(page ==  "maintenance_salary" || page == "maintenance_attendance")
        {
            pageid = "#AttendSalarydropdown";
        }

        if(page == "leavemanagement_leave_type" || page == "leavemanagement_leavereport" || page == "leavemanagement_leave_applications")
        {
          pageid = "#leavedropdown";
        }
        
        console.log(pageid);

        //Remove defult class
        $(pageid).removeClass("collapse");
        //Add select class
        $(pageid).toggleClass("visable");
      


        if($('.nav-link.nav-'+page).hasClass('tree-item') == true){

          $('.nav-link.nav-'+page).closest('.nav-treeview').siblings('a').addClass('active')
          $('.nav-link.nav-'+page).closest('.nav-treeview').parent().addClass('menu-open')
          
          
        }
        if($('.nav-link.nav-'+page).hasClass('nav-is-tree') == true){
          $('.nav-link.nav-'+page).parent().addClass('menu-open')
        }

      }
     
    })
  </script>