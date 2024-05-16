<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-warning">
		<div class="card-header">
			<!--<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-warning" href="./index.php?page=new_user"><i class="fa fa-plus"></i> Add New User</a>
			</div>-->
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Name</th>
						<th>Email</th>
						<th>Department</th>
						<th>Live Streaming</th>
						
					</tr>
				</thead>
				<tbody>
					<?php if($_SESSION['login_type'] == 1): ?>
          <?php
          $i = 1;
          $type = array( '', "Main Admin", "Sales and Support", "QA", "Team Lead", "Research Analyst" );
          $qry = $conn->query( "SELECT *,concat(firstname,' ',lastname) as name FROM users order by concat(firstname,' ',lastname) asc" );
          while ( $row = $qry->fetch_assoc() ):
            ?>
          <tr>
            <th class="text-center"><?php echo $i++ ?></th>
            <td><b><?php echo ucwords($row['name']) ?></b></td>
            <td><b><?php echo $row['email'] ?></b></td>
            <td><b><?php echo $type[$row['type']] ?></b></td>
<td class="text-center">
							<button type="button" class="btn btn-warning btn-sm border-warning wave-effect text-dark" aria-expanded="true">
		                      Live Streaming
		                    </button>
						
          </tr>
          <?php endwhile; ?>
          <?php endif; ?>
					
          <?php if($_SESSION['login_type'] == 4): ?>
          <?php
          $i = 1;

          $type = array('',"","","","", "Research Analyst" );

          $qry = $conn->query( "SELECT *, CONCAT(firstname,' ',lastname) as name FROM users WHERE type = 5 ORDER BY CONCAT(firstname,' ',lastname) ASC" );

          while ( $row = $qry->fetch_assoc() ):
            ?>
          <tr>
            <th class="text-center"><?php echo $i++ ?></th>
            <td><b><?php echo ucwords($row['name']) ?></b></td>
            <td><b><?php echo $row['email'] ?></b></td>
            <td><b><?php echo $type[$row['type']] ?></b></td>
<td class="text-center">
							<button type="button" class="btn btn-warning btn-sm border-warning wave-effect text-dark" aria-expanded="true">
		                     Live Streaming
		                    </button>
						
          </tr>
          <?php endwhile; ?>
          <?php endif; ?>
					
				</tbody>
				
			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('#list').dataTable()
	$('.view_user').click(function(){
		uni_modal("<i class='fa fa-id-card'></i> User Details","view_user.php?id="+$(this).attr('data-id'))
	})
	$('.delete_user').click(function(){
	_conf("Are you sure to delete this user?","delete_user",[$(this).attr('data-id')])
	})
	})
	function delete_user($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_user',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>