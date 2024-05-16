<?php
include('db_connect.php');
session_start();
$meta = array(); // Initialize the $meta array

$value = null;
if (isset($_GET['id'])) {
    $value = $conn->query("SELECT * FROM notification WHERE id = " . $_GET['id']);
    foreach ($value as $key => $val) {
        $meta[$key] = $val;
    }
}

$login_id = $_SESSION['login_id'];

if (isset($_POST['action']) && $_POST['action'] == 'update_user') {
  $notification = $_POST['notification'];
  $login_id = $_POST['login_id'];

  $existingNotification = $conn->query("SELECT * FROM notification WHERE login_id = $login_id");

  if ($existingNotification->num_rows > 0) {
    // User already has a notification, update it
    $sql = "UPDATE notification SET notification = '$notification' WHERE login_id = $login_id";
    $conn->query($sql);

    echo 1;
    exit;
  } else {
    // User does not have a notification, insert a new one
    $sql = "INSERT INTO notification (notification, login_id) VALUES ('$notification', '$login_id')";
    $conn->query($sql);

    echo 2; // or 1 depending on your response format
    exit;
  }
}


if ($login_id != 1) {
    $notification = $conn->query("SELECT * FROM notification");
} else {
    $notification = $conn->query("SELECT * FROM notification WHERE login_id = $login_id");
}

$login_id = $_SESSION['login_id'];
?>

<div class="container-fluid">
    <div id="msg"></div>

    <form id="manage-user">
        <input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id'] : ''; ?>">
        <!-- Remove redundant login_id field -->
        <div class="form-group">
            <label for="notification">Enter your comments</label>
            <textarea name="notification" id="notification" class="form-control" required></textarea>
        </div>

        <input type="hidden" name="action" value="update_user">
        <button type="submit" class="btn btn-warning">Save</button>
    </form>

    <!-- <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Notification</th>
            <th>Login ID</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // while ($row = $notification->fetch_array()) {
        //     echo "<tr>
        //         <td>" . $row['notification'] . "</td>
        //         <td>" . $row['login_id'] . "</td>
        //     </tr>";
        // }
        ?>
        </tbody>
    </table> -->
</div>

<script>
    $('#manage-user').submit(function (e) {
        e.preventDefault();
        start_load();

        var form_data = new FormData($(this)[0]);

        $.ajax({
    url: 'user-ajax.php?action=add_notification',
    data: form_data,
    cache: false,
    contentType: false,
    processData: false,
    method: 'POST',
    dataType: 'json', // Specify the expected data type
    success: function (response) {
        if (response.status === 'success') {
            alert_toast(response.message, 'success');
            $('#uni_modal').hide();
            setTimeout(function () {
                location.reload();
            }, 1500);
        } else {
            $('#msg').html('<div class="alert alert-danger">' + response.message + '</div>');
            end_load();
        }
    },
});

    });
</script>