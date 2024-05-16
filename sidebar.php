<?php
// Define $page variable
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>

<style>
    .nav-pills .nav-item.active > .nav-link {
        background-color: yellow; /* Change the color to the desired one, e.g., yellow */
    }
</style>

<aside class="main-sidebar sidebar-dark-warning elevation-4">
    <div class="dropdown">
   	<a href="./" class="brand-link">
        <?php if($_SESSION['login_type'] == 1): ?>
		<img src="assets/uploads/favicon.png" width="50%"/>
        <h5 class="text-center p-0 m-0"><b>Precise Tech Group</b></h5>
		
        <?php else: ?>
		<img src="assets/uploads/favicon.png" width="50%"/>
        <h5 class="text-center p-0 m-0"><b>Precise Tech Group</b></h5>
        <?php endif; ?>

    </a>
      
    </div>
	  </br></br></br></br>
    <div class="sidebar pb-4 mb-4">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item dropdown">
            <a href="./" class="nav-link nav-home">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li> 
          </li> 

          <li class="nav-item">
            <a href="#" class="nav-link nav-edit_project nav-view_project">
              <i class="nav-icon fas fa-layer-group"></i>
              <p>
                Projects
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
			  
            <ul class="nav nav-treeview">
            <?php if($_SESSION['login_type'] == 1 || $_SESSION['login_type'] == 2 || $_SESSION['login_type'] == 3 || $_SESSION['login_type'] == 4 || $_SESSION['login_type'] == 7 ): ?>
              <li class="nav-item">
                <a href="./index.php?page=new_project" class="nav-link nav-new_project tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Add New</p>
                </a>
              </li>
            <?php endif; ?>
				
              <li class="nav-item">
                <a href="./index.php?page=project_list" class="nav-link nav-project_list tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>List</p>
                </a>
              </li>
            </ul>
          </li>
			
          <li class="nav-item">
                <a href="./index.php?page=task_list" class="nav-link nav-task_list">
                  <i class="fas fa-tasks nav-icon"></i>
                  <p>Task</p>
                </a>
          </li>
			
          <?php if($_SESSION['login_type'] == 1 || $_SESSION['login_type'] == 2 || $_SESSION['login_type'] == 3 || $_SESSION['login_type'] == 4 || $_SESSION['login_type'] == 7 ): ?>
           <li class="nav-item">
                <a href="./index.php?page=reports" class="nav-link nav-reports">
                  <i class="fas fa-th-list nav-icon"></i>
                  <p>Report</p>
                </a>
          </li>
			
          <?php endif; ?>
			
          <?php if($_SESSION['login_type'] == 1): ?>
          <li class="nav-item">
            <a href="#" class="nav-link nav-edit_user">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.php?page=new_user" class="nav-link nav-new_user tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Add New</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.php?page=user_list" class="nav-link nav-user_list tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>List</p>
                </a>
              </li>
            </ul>
          </li>
		
        <?php endif; ?>
		  <?php if($_SESSION['login_type'] == 1): ?>
          <li class="nav-item">
            <a href="#" class="nav-link nav-performance">
              <i class="nav-icon fas fa-chart-line"></i>

              <p>
                Production Performance
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.php?page=performance" class="nav-link nav-performance tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Performance report</p>
                </a>
              </li>
              
            </ul>
          </li>
		
        <?php endif; ?>
		  
			
			<?php if ($_SESSION['login_type'] == 5 || $_SESSION['login_type'] == 4 || $_SESSION['login_type'] == 3 || $_SESSION['login_type'] == 2 || $_SESSION['login_type'] == 1 || $_SESSION['login_type'] == 6 || $_SESSION['login_type'] == 7): ?>
          <li class="nav-item">
            <a href="#" class="nav-link nav-edit_orders">
              <i class="nav-icon fas fa-vote-yea"></i>
              <p>
                Orders
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.php?page=today_orders" class="nav-link nav-todayorders tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Today Orders</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.php?page=tomorrow_orders" class="nav-link nav-tomorroworders_list tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Tomorrow Orders</p>
                </a>
              </li>
				<li class="nav-item">
                <a href="./index.php?page=week_orders" class="nav-link nav-weekorders_list tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Week Orders</p>
                </a>
              </li>
            </ul>
          </li>
        <?php endif; ?>
			
			<?php if ($_SESSION['login_type'] == 4 || $_SESSION['login_type'] == 1 || $_SESSION['login_type'] == 7): ?>
          <li class="nav-item">
            <a href="#" class="nav-link nav-edit_orders">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Status
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.php?page=active_users" class="nav-link nav-active tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Active</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.php?page=not_active_users" class="nav-link nav-notactive tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Not Active</p>
                </a>
              </li>
            </ul>
          </li>
        <?php endif; ?>
			
<!--
			<?php if ($_SESSION['login_type'] == 4 || $_SESSION['login_type'] == 1 || $_SESSION['login_type'] == 7): ?>
          <li class="nav-item">
            <a href="#" class="nav-link nav-edit_orders">
              
				<small><i>Coming Soon.</i></small></br>
			  <i class="nav-icon fas fa-desktop"></i>
              <p>
                Employee Monitoring
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.php?page=screenshots" class="nav-link nav-screenshots tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Screenshots</p>
                </a>
              </li>
				<li class="nav-item">
                <a href="./index.php?page=screen_recording" class="nav-link nav-recording tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Screen Recording</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.php?page=visited_links" class="nav-link nav-links tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Visited Links</p>
                </a>
              </li>
				<li class="nav-item">
                <a href="./index.php?page=idle_time" class="nav-link nav-idle tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Idle Time</p>
                </a>
              </li>
				<li class="nav-item">
                <a href="./index.php?page=live_streaming" class="nav-link nav-live tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Live Streaming</p>
                </a>
              </li>
            </ul>
          </li>
        <?php endif; ?>
-->
		
			<?php if ($_SESSION['login_type'] == 4 || $_SESSION['login_type'] == 1 || $_SESSION['login_type'] == 7): ?>
          <li class="nav-item">
            <a href="#" class="nav-link nav-edit_orders">
              <i class="nav-icon fas fa-clock"></i>
              <p>
                Time
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.php?page=check_in" class="nav-link nav-checkin tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Login Time/ Logout Time</p>
                </a>
              </li>
            </ul>
			   <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.php?page=time_record" class="nav-link nav-checkin tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Time Record</p>
                </a>
              </li>
            </ul>
          </li>
        <?php endif; ?>
		
			<?php if ($_SESSION['login_type'] == 1 || $_SESSION['login_type'] == 4 || $_SESSION['login_type'] == 7 ): ?>
          <li class="nav-item">
            <a href="#" class="nav-link nav-edit_orders">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Team
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.php?page=team" class="nav-link nav-team tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Team</p>
                </a>
              </li>
            </ul>
          </li>
        <?php endif; ?>

        </ul>
      </nav>
    </div>
  </aside>

  <script>
  	$(document).ready(function(){
      var page = '<?php echo $page; ?>';

      $(document).ready(function(){
        var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
        var s = '<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>';
        if(s!='')
        page = page+'_'+s;
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

      });
});

  </script>