<?php include 'db_connect.php' ?>

<!-- Modal -->
<div class="modal fade userModal" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="userModalLabel">User Details</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body modalContent" id="modalContent">
				<table id="userDataTable" class="table tabe-hover table-bordered userDataTable">
					<thead>
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Email</th>
							<th>Department</th>
							<th>Check-in Time</th>
							<th>Check-out Time</th>
							<th>Total Working Hours</th>
						</tr>
					</thead>
					<tbody>
						<!-- Table rows will be appended here -->
					</tbody>
				</table>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<div class="col-lg-12">
	<div class="card card-outline card-warning">
		<div class="card-header">
			<!--<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-warning" href="./index.php?page=new_user"><i class="fa fa-plus"></i> Add New User</a>
			</div>-->
		</div>
		<!-- Button trigger modal -->
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Name</th>
						<th>Email</th>
						<th>Department</th>
						<th>Check-in Time</th>
						<th>Check-out Time</th>
						<th>Total Working Hours</th>
					</tr>
				</thead>
				<tbody>
					<?php if ($_SESSION['login_type'] == 1): ?>
						<?php
						$i = 1;
						$type = array('', "Main Admin", "Sales and Support", "QA", "Team Lead", "Research Analyst");
						$qry = $conn->query("SELECT users.*, COALESCE(user_status.login_time, '') AS login_time, CASE WHEN user_status.logout_time IS NULL OR user_status.logout_time = '' THEN '' ELSE user_status.logout_time END AS logout_time FROM users LEFT JOIN (SELECT user_id, MAX(id) AS max_status_id FROM user_status GROUP BY user_id) AS latest_status ON users.id = latest_status.user_id LEFT JOIN user_status ON latest_status.user_id = user_status.user_id AND latest_status.max_status_id = user_status.id ORDER BY users.id ASC");
						while ($row = $qry->fetch_assoc()):
							$row['name'] = $row['firstname'] . ' ' . $row['lastname'];
							// if ($row['logout_time'] == '') {
							// 	$row['login_time'] = '';
							// }
							$login_time = $row['login_time'];
							$logout_time = $row['logout_time'];

							$login_datetime = new DateTime($login_time);
							$logout_datetime = new DateTime($logout_time);

							// Calculate the time difference
							$time_difference = $login_datetime->diff($logout_datetime);

							// Extract hours, minutes, and seconds
							$hours = sprintf('%02d', $time_difference->h);
							$minutes = sprintf('%02d', $time_difference->i);
							$seconds = sprintf('%02d', $time_difference->s);

							$totalHours = $hours . ':' . $minutes . ':' . $seconds;
							?>
							<tr>
								<th class="text-center">
									<?php echo $i++ ?>
								</th>
								<td>
									<button type="button"
										class="btn btn-warning btn-sm border-warning wave-effect text-dark open-modal"
										data-id="<?php echo $row['id']; ?>" data-toggle="modal" data-target="#userModal">
										<b>
											<?php echo ucwords($row['name']) ?>
										</b>
									</button>
								</td>
								<td><b>
										<?php echo $row['email'] ?>
									</b></td>
								<td><b>
										<?php echo $type[$row['type']] ?>
									</b></td>
								<td class="text-center">
									<?php if ($row['login_time'] != '') { ?>
										<button type="button" class="btn btn-warning btn-sm border-warning wave-effect text-dark"
											aria-expanded="true">
											<?php echo $row['login_time'] ?>
										</button>
									<?php } ?>
								<td class="text-center">
									<?php if ($row['logout_time'] != '') { ?>
										<button type="button" class="btn btn-warning btn-sm border-warning wave-effect text-dark"
											aria-expanded="true">
											<?php echo $row['logout_time'] ?>
										</button>
									<?php } ?>
								</td>
								<td class="text-center">
									<?php if ($row['logout_time'] != '') { ?>
										<button type="button" class="btn btn-warning btn-sm border-warning wave-effect text-dark"
											aria-expanded="true">
											<?php echo $totalHours; ?>
										</button>
									<?php } ?>
							</tr>
						<?php endwhile; ?>
					<?php endif; ?>

					<?php if ($_SESSION['login_type'] == 4): ?>
						<?php
						$i = 1;

						$type = array('', "Main Admin", "Sales and Support", "QA", "Team Lead", "Research Analyst");

						$qry = $conn->query("SELECT users.*, COALESCE(user_status.login_time, '') AS login_time, CASE WHEN user_status.logout_time IS NULL OR user_status.logout_time = '' THEN '' ELSE user_status.logout_time END AS logout_time FROM users LEFT JOIN (SELECT user_id, MAX(id) AS max_status_id FROM user_status GROUP BY user_id) AS latest_status ON users.id = latest_status.user_id LEFT JOIN user_status ON latest_status.user_id = user_status.user_id AND latest_status.max_status_id = user_status.id ORDER BY users.id ASC");
						while ($row = $qry->fetch_assoc()):
							$row['name'] = $row['firstname'] . ' ' . $row['lastname'];
							// if ($row['logout_time'] == '') {
							// 	$row['login_time'] = '';
							// }

							$login_time = $row['login_time'];
							$logout_time = $row['logout_time'];

							$login_datetime = new DateTime($login_time);
							$logout_datetime = new DateTime($logout_time);

							// Calculate the time difference
							$time_difference = $login_datetime->diff($logout_datetime);

							// Extract hours, minutes, and seconds
							$hours = sprintf('%02d', $time_difference->h);
							$minutes = sprintf('%02d', $time_difference->i);
							$seconds = sprintf('%02d', $time_difference->s);

							$totalHours = $hours . ':' . $minutes . ':' . $seconds;
							?>
							<tr>
								<th class="text-center">
									<?php echo $i++ ?>
								</th>
								<td>
								<button type="button"
										class="btn btn-warning btn-sm border-warning wave-effect text-dark open-modal"
										data-id="<?php echo $row['id']; ?>" data-toggle="modal" data-target="#userModal">
										<b>
											<?php echo ucwords($row['name']) ?>
										</b>
									</button>
								</td>
								<td><b>
										<?php echo $row['email'] ?>
									</b></td>
								<td><b>
									
										<?php echo $type[$row['type']] ?>
									</b></td>
									<td class="text-center">
									<?php if ($row['login_time'] != '') { ?>
										<button type="button" class="btn btn-warning btn-sm border-warning wave-effect text-dark"
											aria-expanded="true">
											<?php echo $row['login_time'] ?>
										</button>
									<?php } ?>
								<td class="text-center">
									<?php if ($row['logout_time'] != '') { ?>
										<button type="button" class="btn btn-warning btn-sm border-warning wave-effect text-dark"
											aria-expanded="true">
											<?php echo $row['logout_time'] ?>
										</button>
									<?php } ?>
								</td>
								<td class="text-center">
									<?php if ($row['logout_time'] != '') { ?>
										<button type="button" class="btn btn-warning btn-sm border-warning wave-effect text-dark"
											aria-expanded="true">
											<?php echo $totalHours; ?>
										</button>
									<?php } ?>
							</tr>
						<?php endwhile; ?>
					<?php endif; ?>

				</tbody>

			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function () {
		$('#list').dataTable()
		$('.view_user').click(function () {
			uni_modal("<i class='fa fa-id-card'></i> User Details", "view_user.php?id=" + $(this).attr('data-id'))
		})
		$('.delete_user').click(function () {
			_conf("Are you sure to delete this user?", "delete_user", [$(this).attr('data-id')])
		})
	})
	function delete_user($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_user',
			method: 'POST',
			data: { id: $id },
			success: function (resp) {
				if (resp == 1) {
					alert_toast("Data successfully deleted", 'success')
					setTimeout(function () {
						location.reload()
					}, 1500)

				}
			}
		})
	}

	$(document).ready(function () {
    var userDataTable = $('.userDataTable').DataTable();

    $('.userModal').on('show.bs.modal', function (e) {
        var userId = $(e.relatedTarget).data('id');
        $.ajax({
            url: 'user-ajax.php',
            type: 'GET',
            data: { user_id: userId },
			dataType: 'json',
            success: function (data) {
				console.log(data);
				userDataTable.clear();
                var type = ['', "Main Admin", "Sales and Support", "QA", "Team Lead", "Research Analyst"];
                var counter = 1;
				if (Array.isArray(data) && data.length > 0) {
                
                data.forEach(function (user_data) {
					console.log(user_data);
					var login_time = user_data.login_time;
					var logout_time = user_data.logout_time;
					var totalHours = '';
					if (logout_time !== '') {
						var login_datetime = new Date(login_time);
						var logout_datetime = new Date(logout_time);
						var time_difference = Math.abs(logout_datetime - login_datetime) / 1000;
						var hours = Math.floor(time_difference / 3600);
						var minutes = Math.floor((time_difference % 3600) / 60);
						var seconds = Math.floor(time_difference % 60);
						totalHours = hours + ':' + minutes + ':' + seconds;
					}
					var row = [
                        counter++,
                        user_data.firstname,
                        user_data.email,
                        type[user_data.type],
                        user_data.login_time,
                        user_data.logout_time,
                        totalHours
                    ];
                    userDataTable.row.add(row);
                });
                userDataTable.draw();
			} else {
				userDataTable.draw();
				
				// modal.find('.modalContent').load(location.href + ' .modalContent');
					//$('.userModal').load(location.href + ' .userModal');
				}
            },
            error: function () {
                // Handle the error when the AJAX call fails
				
               //$('.modalContent').html('<p></p>');
            }
        });
    });
});

</script>