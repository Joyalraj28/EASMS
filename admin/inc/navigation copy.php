
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
                    
                    <!-- Overview -->
                    <li style="cursor:pointer;font-size:15px;margin-left: 2px;"  class="nav-item dropdown">
                      <a href="./" class="nav-link nav-home">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                          Overview
                        </p>
                      </a>
                    </li> 

                    <?php if($_settings->userdata('type') == 3): ?>
                      <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=employees/records&id=<?php echo $_settings->userdata('id') ?>" class="nav-link nav-records">
                        <i class="nav-icon fas fa-id-card"></i>
                        <p>
                          My Records
                        </p>
                      </a>
                      </li>
                    <?php else: ?>

                    <!-- Employees Management -->
                    <li style="cursor:pointer;font-size:15px;margin-left: 15px;" class="nav-link" data-toggle="collapse" data-target="#empdrop">
                        <i class="nav-icon fas fa-user-friends"></i>
                        <p>
                          Employees
                        </p>
                    </li>

                    <div style="cursor: pointer;font-size:15px;margin-left: 12px;" id="empdrop" class="collapse">
                      
                     <!-- Employees Management -->
                      <li style="cursor: pointer;font-size:15px;margin-left: 12px;" class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=employees" class="nav-link nav-employees">
                        <i class="nav-icon fas fa-user-friends"></i>
                        <p>
                         List of Employees
                        </p>
                      </a>
                      </li>

                       <!-- Employees Management -->
                       <li style="cursor: pointer;font-size:15px;margin-left: 12px;" class="nav-item dropdown">
                      <a  class="nav-link">
                        <i class="nav-icon fas fa-user-friends"></i>
                        <p>
                        Accessibility
                        </p>
                      </a>
                      </li>
                    </div>

                    <?php endif; ?>

                  
                    <?php if($_settings->userdata('type') != 3): ?>
                    <?php if($_settings->userdata('type') == 1): ?>
                    
                  <!-- Department Management -->
                  <li style="cursor:pointer;font-size:15px;margin-left: 15px;" class="nav-link" data-toggle="collapse" data-target="#depdrop">
                        <i class="nav-icon fas fa-building"></i>
                        <p>Department</p>
                  </li>

                  <div style="cursor: pointer;font-size:15px;margin-left: 12px;" id="depdrop" class="collapse">
                     <!-- Department Management -->
                     <li style="cursor: pointer;font-size:15px;margin-left: 12px;"  class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=maintenance/department" class="nav-link nav-maintenance_department">
                        <i class="nav-icon fas fa-building"></i>
                        <p>
                          Department Management
                        </p>
                      </a>
                    </li>

                 </div>


                   <!-- Designation Management -->
                   <li style="cursor:pointer;font-size:15px;margin-left: 15px;" class="nav-link" data-toggle="collapse" data-target="#decdrop">
                        <i class="nav-icon fas fa-th-list"></i>
                        <p>Designation</p>
                  </li>

                  <div style="cursor: pointer;font-size:15px;margin-left: 12px;" id="decdrop" class="collapse">
                     <!-- Designation Management -->
                     <li style="cursor: pointer;font-size:15px;margin-left: 12px;" class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=maintenance/designation" class="nav-link nav-maintenance_designation">
                        <i class="nav-icon fas fa-th-list"></i>
                        <p>
                         All Designation
                        </p>
                      </a>
                    </li>
                 </div>
                   
                  <!-- Attendance Management -->
                  <?php if(true): ?>


                 <li style="cursor:pointer;font-size:15px;margin-left: 15px;" class="nav-link" data-toggle="collapse" data-target="#attsaldrop">
                        <i class="nav-icon fas fa-user-friends"></i>
                        <p>Attendance & Salary</p>
                  </li>

                 
                <div style="cursor: pointer;font-size:15px;margin-left: 12px;" id="attsaldrop" class="collapse">
                  
                  <!-- Attendance -->
                    <li style="cursor: pointer;font-size:15px;margin-left: 12px;" class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=Attendance" class="nav-link nav-Attendance">
                      <i class="nav-icon fas fa-id-badge"></i>
                        <p>
                        List of Attendance
                        </p>
                      </a>
                    </li>

                     <!-- Salary -->
                     <li style="cursor: pointer;font-size:15px;margin-left: 12px;" class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=Attendance" class="nav-link nav-Attendance">
                      <i class="nav-icon fas fa-id-badge"></i>
                        <p>
                        Salary
                        </p>
                      </a>
                    </li>

                </div>
                   
                  <?php endif; ?>

                  <?php endif; ?>

                  <li style="cursor:pointer;font-size:15px;margin-left: 15px;" class="nav-link" data-toggle="collapse" data-target="#levedrop">
                        <i class="nav-icon fas fa-list"></i>
                        <p>Leave</p>
                  </li>

                   <div style="cursor: pointer;font-size:15px;margin-left: 12px;" id="levedrop" class="collapse">
                      <!-- Leave Type Management -->
                      <li style="cursor: pointer;font-size:15px;margin-left: 12px;" class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=maintenance/leave_type" class="nav-link nav-maintenance_leave_type">
                        <i class="nav-icon fas fa-list"></i>
                        <p>
                          Leave Type Management
                        </p>
                      </a>
                      </li>

                      <!-- Leave history Reports -->
                      <li style="cursor: pointer;font-size:15px;margin-left: 12px;"  class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=reports" class="nav-link nav-reports">
                        <i class="nav-icon fas fa-file"></i>
                        <p>
                         Leave history Reports
                        </p>
                      </a>
                      </li>

                      <!-- Leave Application -->
                      <li style="cursor: pointer;font-size:15px;margin-left: 12px;" class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=leave_applications" class="nav-link nav-leave_applications">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>
                          Application Management
                        </p>
                      </a>
                      </li>

                  </div>

                  <?php if($_settings->userdata('type') == 1): ?>
                  <!-- System Settings -->
                  <li style="cursor:pointer;font-size:15px;margin-left: 2px;" class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=system_info" class="nav-link nav-system_info">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                         Settings
                        </p>
                      </a>
                  </li>
                  <?php endif; ?>
                    
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
             $('.nav-link.nav-'+page).addClass('active')
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