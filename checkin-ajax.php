<?php
session_start();
include 'db_connect.php';
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["user_id"])) {
     $user_id = $_GET["user_id"];
	 $currentYear = date('Y');
     $query = $conn->query("SELECT users.*,user_status.* FROM users,user_status WHERE users.id=$user_id AND user_status.user_id=$user_id AND YEAR(user_status.login_time) = $currentYear ORDER BY user_status.login_time DESC");
    if ($query->num_rows > 0) {
		$user_data = array();
        while ($user = $query->fetch_assoc()) {
			$user_data[] = $user;
		}
		header('Content-Type: application/json');
        echo json_encode($user_data);
    } else {
		echo json_encode("User not found");
    }
}



//if (isset($_GET['action']) && $_GET['action'] == 'add_notification') {
//  $notification = isset($_POST['notification']) ? $_POST['notification'] : '';
//  $login_id = $_SESSION['login_id'];
//  $query = "SELECT * FROM `users`";
//  $run = mysqli_query($con, $query);
//  while ($row = mysqli_fetch_assoc($run)) {
//    $receiver_id = $row['id'];  
//    $insert = "INSERT INTO `notification` (`notification`, `login_id`, `receiver_id`) VALUES ('$notification', '$login_id', '$receiver_id')";
//    $qry = mysqli_query($con, $insert);
//    
//    $response = array();
//
//    if ($qry) {
//        $response['status'] = 'success';
//        $response['message'] = 'Data successfully saved';
//    } else {
//        $response['status'] = 'error';
//        $response['message'] = 'Failed to save data';
//    }
//}
//
//// Echo the JSON response after the loop
//echo json_encode($response);
//
//}


?>
