<style>
	.main-header{
		background-color: #E7C52F;
	}

  .notify_dropdown{
    padding: 0;
    min-width: 300px;
  }

  #manage_notification{
    border-bottom: 3px solid #e6e8e9;
    padding: 10px;
  }

  .receive_notify_h2{
    width: 100%;
    float: left;
    font-size: 17px;
    font-weight: 600;
    padding: 0 10px 10px;
    margin: 0;
  }

  .receive_notify{
    padding: 0 10px 0;
    width: 100%;
    float: left;
  }

  .receive_notify h2{
    font-size: 15px;
    font-weight: 600;
    margin: 0;
    width: 100%;
    float: left;
  }

  .receive_notify h2 span:first-child{
    width: 80%;
    float: left;
  }

  .receive_notify h2 span:last-child{
    font-size: 13px;
    font-weight: 400;
  }

  .receive_notify p{
    font-size: 13px;
    margin-bottom: 7px;
    width: 100%;
    float: left;
  }


  .notify_count{
    position: absolute;
    left: 1.2rem;
    top: -2px;
    color: #fff;
    font-size: 8px;
    font-weight: 900;
    background: red;
    padding: 5px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 12px;
    height: 12px;
  }

  .notify_main_conatiner{
    width: 100%;
    float: left;
    padding-bottom: 50px;
  }

</style>
<?php  $login_id = $_SESSION['login_id']; ?>
<!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark ">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <?php if(isset($_SESSION['login_id'])): ?>
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="" role="button"><i class="fas fa-bars"></i></a>
      </li>
    <?php endif; ?>
      <li>
        <a class="nav-link"  href="./" role="button"> <large><b><?php echo $_SESSION['system']['name'] ?></b></large></a>
      </li>
    </ul>

  <ul class="navbar-nav ml-auto">
<!-- 
 <li class="nav-item">
  <a class="nav-link" data-widget="notification" href="#" role="button">
   <i class="fas fa-bell"></i>
   <span id="notification-badge" class="badge badge-pill bg-white">0</span>
  </a>
 </li> -->

    <li class="nav-item dropdown">
        <a class="nav-link"  data-toggle="dropdown" aria-expanded="true" href="javascript:void(0)" id="notification-badge-container">
              <span>
                <div class="d-felx badge-pill" style="position:relative">
                  <span class="fa fa-bell mr-2" id="notification-badge" style="background: transparent !important;color: #fff !important;"></span>
                  <span class="fa fa-angle-down ml-2"></span>
                </div>
              </span>
            </a>

            <div class="dropdown-menu notify_dropdown" aria-labelledby="account_settings" style="left: -2.5em;">
              <a class="dropdown-item mb-2" href="javascript:void(0)" id="manage_notification"><i class="fa fa-bell mr-1"></i> Add Notifications</a>
              <div id="notify_main_container"></div>
            </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
     <li class="nav-item dropdown">
            <a class="nav-link"  data-toggle="dropdown" aria-expanded="true" href="javascript:void(0)">
              <span>
                <div class="d-felx badge-pill">
                  <span class="fa fa-user mr-2"></span>
                  <span><b><?php echo ucwords($_SESSION['login_firstname']) ?></b></span>
                  <span class="fa fa-angle-down ml-2"></span>
                </div>
              </span>
            </a>
            <div class="dropdown-menu" aria-labelledby="account_settings" style="left: -2.5em;">
              <a class="dropdown-item" href="javascript:void(0)" id="manage_account"><i class="fa fa-cog"></i> Manage Account</a>
              <a class="dropdown-item" href="ajax.php?action=logout"><i class="fa fa-power-off"></i> Logout</a>
            </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
  <script>
     $('#manage_account').click(function(){
        uni_modal('Manage Account','manage_user.php?id=<?php echo $_SESSION['login_id'] ?>')
      })
  </script>
<script>
     $('#manage_notification').click(function(){
        uni_modal('Notification','notification.php?id=<?php echo $_SESSION['login_id'] ?>')
      })
  </script>
<script>
$(document).ready(function(){
  // Check for new notifications every 5 seconds
  setInterval(function(){
    $.ajax({
      url: "ajax.php?action=get_notifications",
      method: "POST",
      dataType: "json", // Change the data type to json
      success: function(data) {
    console.log(data.notify_count); // Note the use of 'data', not 'response_data'
    $("#notification-badge").html(data.notify_count);
    $("#notify_main_container").html(data.receive_notify);
    
    if (data.notify_count.trim() !== '') {
        $("#notification-badge").removeClass("bg-white").addClass("bg-danger");
    } else {
        $("#notification-badge").removeClass("bg-danger").addClass("bg-white");
    }
},

      error: function(xhr, status, error) {
        console.error("Error in AJAX request:", error);
        console.log("XHR status:", status);
        console.log("XHR response text:", xhr.responseText);
      }
    });
  }, 5000);
});



</script>

