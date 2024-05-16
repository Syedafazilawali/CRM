<?php
ob_start();
date_default_timezone_set("Asia/Karachi");

$currentDateTime = date('Y-m-d H:i:s');

include 'db_connect.php';
$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();

if($action == 'login'){
	$login = $crud->login();
	if($login){
		$user_id = $_SESSION['login_id'];
		$insert = "INSERT INTO `user_status` (`user_id`, `login_time`, `logout_time`) VALUES ('$user_id', '$currentDateTime', '')";
		$qry = mysqli_query($con, $insert);
	 echo $login;
	}
}
if($action == 'login2'){
	$login = $crud->login2();
	if($login){
		$user_id = $_SESSION['login_id'];
			$insert = "INSERT INTO `user_status` (`user_id`, `login_time`, `logout_time`) VALUES ('$user_id', '$currentDateTime', '')";
			$qry = mysqli_query($con, $insert);
		 echo $login;
		}
} 
if($action == 'logout'){
	   $user_id = $_SESSION['login_id'];
		$check = "SELECT `user_id` FROM `user_status` WHERE user_id='$user_id' ORDER BY login_time DESC LIMIT 1";
		$qry = mysqli_query($con, $check);
		if (mysqli_num_rows($qry) > 0) {
    	$update = "UPDATE `user_status` SET `logout_time`='$currentDateTime' WHERE user_id='$user_id' ORDER BY login_time DESC LIMIT 1";
        $qry = mysqli_query($con, $update);
		} 
	$logout = $crud->logout();
	if($logout)
		echo $logout;
	
}
if($action == 'logout2'){
	$user_id = $_SESSION['login_id'];
	$check = "SELECT `user_id` FROM `user_status` WHERE user_id='$user_id'";
	$qry = mysqli_query($con, $check);
	if (mysqli_num_rows($qry) > 0) {
	$update = "UPDATE `user_status` SET `logout_time`='$currentDateTime', `login_time`='' WHERE user_id='$user_id'";
	$qry = mysqli_query($con, $update);
	} 
	$logout = $crud->logout2();
	if($logout)
		echo $logout;
}


if($action == 'signup'){
	$save = $crud->signup();
	if($save){
		$user_id = $_SESSION['login_id'];
		$check = "SELECT `user_id` FROM `user_status` WHERE user_id='$user_id'";
		$qry = mysqli_query($con, $check);
		if (mysqli_num_rows($qry) > 0) {
    	$update = "UPDATE `user_status` SET `login_time`='$currentDateTime', `logout_time`='' WHERE user_id='$user_id'";
    	$qry = mysqli_query($con, $update);
		} else {
			$insert = "INSERT INTO `user_status` (`user_id`, `login_time`, `logout_time`) VALUES ('$user_id', '$currentDateTime', '')";
			$qry = mysqli_query($con, $insert);
		}
		echo $save;
	}
}

if($action == 'save_user'){
	$save = $crud->save_user();
	if($save)
		echo $save;		
}
if($action == 'update_user'){
	$save = $crud->update_user();
	if($save)
		echo $save;
}
if($action == 'delete_user'){
	$save = $crud->delete_user();
	if($save)
		echo $save;
}
if ($action == 'save_project') {
    $login_id = $_SESSION['login_id'];
    $save = $crud->save_project();
	//echo '<pre>';print_r($save);exit;
    if ($save) {
        $get_last_id_query = "SELECT id FROM `project_list` ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($con, $get_last_id_query);
        if ($result) {
			$row = mysqli_fetch_assoc($result);
			$last_inserted_project_id = $row['id'];  
			$user_ids = isset($_POST['user_ids']) ? $_POST['user_ids'] : [];
			foreach ($user_ids as $receiver_id) {
				$receiver_id = mysqli_real_escape_string($con, $receiver_id);
						if (isset($_POST['id']) && $_POST['id'] != '') {
					$notification_message = ' Your order has been updated';
				} else {
					$notification_message =  ' You have a new order assigned';
				}
				$insert_notification_query = "INSERT INTO notification (notification, login_id, receiver_id, project_id) VALUES ('$notification_message', '$login_id', '$receiver_id', '$last_inserted_project_id')";
				$qry = mysqli_query($con, $insert_notification_query);
			}
			
		}
		echo $save;
    } 
}

if($action == 'delete_project'){
	$save = $crud->delete_project();
	if($save)
		echo $save;
}
if($action == 'save_task'){
	$save = $crud->save_task();
	if($save)
		echo $save;
}
if($action == 'delete_task'){
	$save = $crud->delete_task();
	if($save)
		echo $save;
}
if($action == 'save_progress'){
	$save = $crud->save_progress();
	if($save)
		echo $save;
}
if($action == 'delete_progress'){
	$save = $crud->delete_progress();
	if($save)
		echo $save;
}
if($action == 'get_report'){
	$get = $crud->get_report();
	if($get)
		echo $get;
}

if ($action == 'get_notifications') {
    $login_id = $_SESSION['login_id'];

    $notification_query = $conn->query("SELECT users.*, notification.*, project_list.* FROM users INNER JOIN notification ON users.id = notification.login_id LEFT JOIN project_list ON notification.project_id = project_list.id WHERE notification.receiver_id = $login_id AND users.id != $login_id ORDER BY notification.created_at DESC LIMIT 30");

    if ($notification_query) {
        $html_content = '';

        while ($row = $notification_query->fetch_assoc()) {
            date_default_timezone_set('Asia/Karachi');
            $created_at = strtotime($row['created_at']);
            $current_time = time();  // Use time() to get the current timestamp
            $time_diff = $current_time - $created_at;

            if ($time_diff < 60) {
                // Less than a minute
                $time_ago = $time_diff . 's. ago';
            } elseif ($time_diff < 3600) {
                // Less than an hour
                $minutes = floor($time_diff / 60);
                $time_ago = $minutes . 'm. ago';
            } elseif ($time_diff < 86400) {
                // Less than a day
                $hours = floor($time_diff / 3600);
                $time_ago = $hours . 'h. ago';
            } else {
                // More than a day
                $days = floor($time_diff / 86400);
                $time_ago = $days . 'd. ago';
            }

            $row['name'] = $row['firstname'] . ' ' . $row['lastname'];
            $html_content .= "<div class='receive_notify'>
                    <h2><span>" . $row['name'] . "</span></span><span class='float-right'>" . $time_ago . "</span></h2>
                    <p><span>" . $row['notification'] . "</p>
                </div>";
        }

        // Display the total count
        $total_count = $notification_query->num_rows;
        $notification_count = ($total_count > 0) ? '<span class="notify_count">' . $total_count . '</span>' : '';

        // Prepare the response data for JSON
        $response_data = array(
            'notify_count' => $notification_count,
            'receive_notify' => $html_content
        );

        // Send the JSON-encoded response
        echo json_encode($response_data);
    } else {
        // Handle SQL query error
        echo json_encode(array('error' => 'Error in SQL query execution'));
    }
}



ob_end_flush();


?>
