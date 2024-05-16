<?php
ob_start();

date_default_timezone_set("Asia/Karachi");

$currentDateTime = date('Y-m-d H:i:s');

include 'db_connect.php';

include 'admin_class.php';
$crud = new Action();if (isset($_POST['action'])) {
    $user_id = $_POST['user_id'];

    switch ($_POST['action']) {
        case 'check_in':
            $checkin_time = date('Y-m-d H:i:s');
            $conn->query("INSERT INTO monitoring (user_id, checkin_time) VALUES ('$user_id', '$checkin_time')");
            echo "Check-in successful";
            break;

        case 'break_time':
    // Check if the user is currently on break
    if (!isset($_SESSION['on_break']) || !$_SESSION['on_break']) {
        // Starting break
        $break_time_start = date('Y-m-d H:i:s');
        $latest_record = $conn->query("SELECT id FROM monitoring WHERE user_id = '$user_id' ORDER BY id DESC LIMIT 1")->fetch_assoc();
        $conn->query("UPDATE monitoring SET break_time_start = '$break_time_start' WHERE id = '{$latest_record['id']}'");
        $_SESSION['on_break'] = true;
        echo "Break time started";
    } else {
        // Ending break
        $break_time_end = date('Y-m-d H:i:s');
        $latest_record = $conn->query("SELECT id FROM monitoring WHERE user_id = '$user_id' ORDER BY id DESC LIMIT 1")->fetch_assoc();
        $conn->query("UPDATE monitoring SET break_time_end = '$break_time_end' WHERE id = '{$latest_record['id']}'");
        $_SESSION['on_break'] = false;
        echo "Break time ended";
        // Start a new record for the next break
        $checkin_time = date('Y-m-d H:i:s');
        $conn->query("INSERT INTO monitoring (user_id, checkin_time) VALUES ('$user_id', '$checkin_time')");
    }
    break;

        case 'check_out':
            $checkout_time = date('Y-m-d H:i:s');
            
            // Find the latest record for the user
            $latest_record = $conn->query("SELECT id FROM monitoring WHERE user_id = '$user_id' ORDER BY id DESC LIMIT 1")->fetch_assoc();
            
            // Update the checkout_time for the latest record
            $conn->query("UPDATE monitoring SET checkout_time = '$checkout_time' WHERE id = '{$latest_record['id']}';");

           
            
            echo "Check-out successful.";
            break;

        default:
            echo "Invalid action";
            break;
    }
} else {
    echo json_encode(array('error' => 'No action specified'));
}
?>
