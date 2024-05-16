<?php include 'db_connect.php' ?>

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
							<th>Total Break Time</th>
							<th>Total Productivity Hours</th>
						</tr>
					</thead>
					<tbody>
						
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
			
		</div>
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
						<th>Total Hours</th>
					</tr>
				</thead>
				<tbody>
					<?php if ($_SESSION['login_type'] == 1 || $_SESSION['login_type'] == 4 || $_SESSION['login_type'] == 7): ?>
						<?php
						$i = 1;
						$type = array('', "Main Admin", "Sales and Support", "QA", "Team Lead", "Research Analyst", "Content Writer", "Development Team Lead");
					
						$qry = $conn->query("
    SELECT 
        users.*, 
        COALESCE(monitoring.checkin_time, '') AS checkin_time, 
        CASE 
            WHEN monitoring.checkout_time IS NULL OR monitoring.checkout_time = '' THEN '' 
            ELSE monitoring.checkout_time 
        END AS checkout_time,
        CASE
            WHEN monitoring.checkout_time IS NULL OR monitoring.checkout_time = '' THEN ''
            ELSE TIMEDIFF(monitoring.checkout_time, monitoring.checkin_time)
        END AS total_productivity
    FROM 
        users 
        LEFT JOIN (
            SELECT user_id, MAX(id) AS max_status_id 
            FROM monitoring 
            GROUP BY user_id
        ) AS latest_status ON users.id = latest_status.user_id 
        LEFT JOIN monitoring ON latest_status.user_id = monitoring.user_id AND latest_status.max_status_id = monitoring.id 
    ORDER BY 
        users.id ASC
");
						while ($row = $qry->fetch_assoc()):
							$row['name'] = $row['firstname'] . ' ' . $row['lastname'];
							$checkin_time = isset($row['checkin_time']) ? $row['checkin_time'] : '';
							$checkout_time = isset($row['checkout_time']) ? $row['checkout_time'] : '';
							$total_productivity = isset($row['total_productivity']) ? $row['total_productivity'] : '';

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
								<td class="text-left">
									<?php if ($row['checkin_time'] != '') { ?>
										<p class="wave-effect text-dark"
											aria-expanded="true">
											<?php echo $row['checkin_time'] ?>
										</p>
									<?php } ?>
								<td class="text-left">
									<?php if ($row['checkout_time'] != '') { ?>
										<p class="wave-effect text-dark"
											aria-expanded="true">
											<?php echo $row['checkout_time'] ?>
										</p>
									<?php } ?>
								</td>
								<td class="text-left">
									<?php if ($row['total_productivity'] != '') { ?>
										<p class="wave-effect text-dark"
											aria-expanded="true">
											<?php echo $row['total_productivity'] ?>
										</p>
									<?php } ?>
								</td>
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
                userDataTable.clear().draw();
                var type = ['', "Main Admin", "Sales and Support", "QA", "Team Lead", "Research Analyst", "Content Writer", "Development Team Lead"];
                var counter = 1;
                if (Array.isArray(data) && data.length > 0) {
                    data.forEach(function (user_data) {
                        console.log(user_data);
                        var checkin_time = user_data.checkin_time ? user_data.checkin_time : '';
                        var checkout_time = user_data.checkout_time ? user_data.checkout_time : '';
                        var total_productivity = user_data.total_productivity ? user_data.total_productivity : '';
                        var row = [
                            counter++,
                            user_data.name,
                            user_data.email,
                            type[user_data.type],
                            checkin_time,
                            checkout_time,
                            user_data.total_hours,
                            user_data.total_break_time,
                            total_productivity
                        ];
                        userDataTable.row.add(row);
                    });
                    userDataTable.draw();
                } else {
                    console.log("No data found");
                }
            },
            error: function () {
                console.log("Error fetching data");
            }
        });
    });
});


</script>