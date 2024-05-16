<style>
  .main-footer a {
    color: #E7C52F;
  }
</style>


<!DOCTYPE html>
<html lang="en">
<?php session_start() ?>
<?php 
	if(!isset($_SESSION['login_id']))
	    header('location:login.php');
    include 'db_connect.php';
    ob_start();
  if(!isset($_SESSION['system'])){

    $system = $conn->query("SELECT * FROM system_settings")->fetch_array();
    foreach($system as $k => $v){
      $_SESSION['system'][$k] = $v;
    }
  }
  ob_end_flush();

	include 'header.php' 
?>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  <?php include 'topbar.php' ?>
  <?php include 'sidebar.php' ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  	 <div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
	    <div class="toast-body text-white">
	    </div>
	  </div>
    <div id="toastsContainerTopRight" class="toasts-top-right fixed"></div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"><b><?php echo $title ?></b></h1>
		  
      </div><!-- /.col -->
			<div class="col-sm-6">
        <div class="container mt-3">
          <div class="row justify-content-end">
            <div class="col-md-4">
              <button type="button" class="btn btn-success btn-block" id="checkInButton" style="padding-bottom: 10px; margin-bottom: 10px;">Check In</button>
            </div>
            <div class="col-md-4">
              <button type="button" class="btn btn-primary btn-block" id="breakTimeButton" style="padding-bottom: 10px; margin-bottom: 10px;">Break Time</button>
            </div>
            <div class="col-md-4">
              <button type="button" class="btn btn-danger btn-block" id="checkOutButton" style="padding-bottom: 10px; margin-bottom: 10px;">Check Out</button>
            </div>
			  <div id="timer"></div>
<div id="status"></div>
          </div>
        </div>	
        </div><!-- /.row -->
            <hr class="border-warning">
      </div><!-- /.container-fluid -->
	  
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
         <?php 
            $page = isset($_GET['page']) ? $_GET['page'] : 'home';
            if(!file_exists($page.".php")){
                include '404.html';
            }else{
            include $page.'.php';

            }
          ?>
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
    <div class="modal fade" id="confirm_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Confirmation</h5>
      </div>
      <div class="modal-body">
        <div id="delete_content"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn" id='confirm' onclick="">Continue</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="uni_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
        <button type="button" class="btn" data-dismiss="modal">Cancel</button>
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="uni_modal_right" role='dialog'>
    <div class="modal-dialog modal-full-height  modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="fa fa-arrow-right"></span>
        </button>
      </div>
      <div class="modal-body">
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="viewer_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
              <button type="button" class="btn-close" data-dismiss="modal"><span class="fa fa-times"></span></button>
              <img src="" alt="">
      </div>
    </div>
  </div>
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
	  
    <strong>Copyright &copy; 2024<span class="yel"> <a href="./">Precise Tech Group</a>.</strong></span>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b><?php echo $_SESSION['system']['name'] ?></b>
    </div>
  </footer>
</div>


<?php include 'footer.php' ?>
</body>
</html>


<script>
    $(document).ready(function () {
        var user_id = <?php echo $_SESSION['login_id']; ?>;
		var breakTimeStarted = false;


        // Event listener for Check In button
        $('.btn-success').click(function () {
            $.ajax({
                type: 'POST',
                url: 'timeajax.php', // Assuming you have an AJAX handler file
                data: {
                    action: 'check_in',
                    user_id: user_id
                },
                success: function (response) {
                    console.log(response);
                    // You can handle the response as needed, maybe show a message to the user
                }
            });
        });

        // Event listener for Break Time button
        $('.btn-primary').click(function () {
            $.ajax({
                type: 'POST',
                url: 'timeajax.php',
                data: {
                    action: 'break_time',
                    user_id: user_id
                },
                success: function (response) {
					
                    console.log(response);
                }
            });
        });

        // Event listener for Check Out button
        $('.btn-danger').click(function () {
            $.ajax({
                type: 'POST',
                url: 'timeajax.php',
                data: {
                    action: 'check_out',
                    user_id: user_id
                },
                success: function (response) {
                    console.log(response);
                }
            });
        });
    });
</script>

<script>
$(document).ready(function () {
    var startTime; // Variable to store the start time
    var timerInterval; // Variable to store the interval ID for the timer
    var isBreakTime = false; // Variable to track break time
    var breakCount = 0; // Variable to count break clicks

    // Check if there is a previous timer state stored in local storage
    var storedStartTime = localStorage.getItem('startTime');
    var storedIsBreakTime = localStorage.getItem('isBreakTime');
    if (storedStartTime && storedIsBreakTime !== null) {
        startTime = new Date(storedStartTime);
        isBreakTime = JSON.parse(storedIsBreakTime);
        startTimer(); // Resume the timer
    }

    // Event listener for Check In button
    $('#checkInButton').click(function () {
        startTime = new Date(); // Set the start time when Check In is clicked
        isBreakTime = false; // Reset break time flag
        breakCount = 0; // Reset break count
        localStorage.setItem('startTime', startTime); // Store start time in local storage
        localStorage.setItem('isBreakTime', JSON.stringify(isBreakTime)); // Store break time flag in local storage
        updateDisplay();
        startTimer(); // Start the timer
    });

    // Event listener for Break Time button
    $('#breakTimeButton').click(function () {
        if (!isBreakTime) { // If it's not break time, pause the timer
            breakCount++; // Increment break count
            if (breakCount === 2) {
                // Add break time to existing time on the second click
                addBreakTime();
            } else {
                // Pause the timer
                clearInterval(timerInterval);
                isBreakTime = true;
            }
        } else { // If it's break time, resume the timer
            startTimer();
            isBreakTime = false;
        }
        localStorage.setItem('isBreakTime', JSON.stringify(isBreakTime)); // Update break time flag in local storage
        updateDisplay();
    });

    // Event listener for Check Out button
    $('#checkOutButton').click(function () {
        clearInterval(timerInterval); // Stop the timer when Check Out is clicked
        localStorage.removeItem('startTime'); // Remove start time from local storage
        localStorage.removeItem('isBreakTime'); // Remove break time flag from local storage
        startTime = null; // Reset the start time
        updateDisplay();
    });


    // Function to start the timer
    function startTimer() {
        timerInterval = setInterval(function () {
            updateDisplay();
        }, 1000); // Update display every second
    }

    // Function to update the display with the current status and elapsed time
    function updateDisplay() {
        var status = startTime ? (isBreakTime ? 'Break Time' : 'In Progress') : 'Check Out';
        var elapsedTime = startTime ? calculateElapsedTime() : 0;

        // Update display elements here, for example:
        $('#timer').text(formatTime(elapsedTime));
        $('#status').text(status);

        // Update button text based on status
        if (status === 'Check Out') {
            $('#checkInButton').text('Check In');
            $('#breakTimeButton').text('Break Time');
            $('#checkOutButton').text('Check Out Successful');
        } else if (status === 'Break Time') {
            $('#checkInButton').text('Check In Successful');
            $('#breakTimeButton').text('End Break');
            $('#checkOutButton').text('Check Out');
        } else { // In Progress
            $('#checkInButton').text('Check In Successful');
            $('#breakTimeButton').text('Break Time');
            $('#checkOutButton').text('Check Out ');
        }
    }

    // Function to format time in HH:mm:ss
    function formatTime(milliseconds) {
        var seconds = Math.floor(milliseconds / 1000);
        var hours = Math.floor(seconds / 3600);
        seconds %= 3600;
        var minutes = Math.floor(seconds / 60);
        seconds %= 60;

        return (
            (hours < 10 ? '0' : '') + hours + ':' +
            (minutes < 10 ? '0' : '') + minutes + ':' +
            (seconds < 10 ? '0' : '') + seconds
        );
    }

    // Function to calculate elapsed time
    function calculateElapsedTime() {
        return new Date().getTime() - startTime.getTime();
    }

    // Function to add break time to existing time
    function addBreakTime() {
        clearInterval(timerInterval); // Pause the timer
        isBreakTime = false; // Reset break time flag
        startTime.setSeconds(startTime.getSeconds() + calculateElapsedTime() / 1000); // Add elapsed time to start time
        localStorage.setItem('startTime', startTime); // Update start time in local storage
        startTimer(); // Resume the timer
    }
});

</script>