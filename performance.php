<?php include 'db_connect.php'; ?>

<div class="col-lg-12">
  <div class="card card-outline card-warning">
    <div class="card-body">
      <table class="table table-hover table-bordered" id="list">
        <thead>
          <tr>
            <th class="text-center">#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Department</th>
            <th>Achieved Wordcount</th>
            <th>Target Wordcount</th>
            <th>Percentage</th>
            
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          $type = array('', '', '', '', '', 'Research Analyst', 'Content Writer', '');
          $qry = $conn->query("
            SELECT 
              u.*, 
              CONCAT(u.firstname, ' ', u.lastname) AS name,
			  up.wordcount,
              SUM(up.wordcount) AS total_wordcount
            FROM 
              users u
            LEFT JOIN 
              user_productivity up ON u.id = up.user_id
            WHERE 
              u.type IN (5, 6)
            GROUP BY
              u.id
            ORDER BY 
              CONCAT(u.firstname, ' ', u.lastname) ASC");
          while ($row = $qry->fetch_assoc()):
          ?>
          <tr>
            <th class="text-center"><?php echo $i++ ?></th>
            <td><b><?php echo ucwords($row['name']) ?></b></td>
            <td><b><?php echo $row['email'] ?></b></td>
            <td><b><?php echo $type[$row['type']] ?></b></td>
<!--
            <td><b><?php echo $row['wordcount'] ?></b></td>
            <td><b><?php echo $row['target_wordcount'] ?></b></td>
            <td><b><?php
              if ($row['target_wordcount'] != 0) {
                  echo round(($row['wordcount'] / $row['target_wordcount']) * 100, 2) . "%";
              } else {
                  echo "N/A";
              }
              ?></b></td>
-->
			   <td><b><?php echo $row['total_wordcount'] ?></b></td>
            <td><b><?php echo $row['target_wordcount'] ?></b></td>
            <td><b><?php
              if ($row['target_wordcount'] != 0) {
                  echo round(($row['total_wordcount'] / $row['target_wordcount']) * 100, 2) . "%";
              } else {
                  echo "N/A";
              }
              ?></b></td>
            
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<script>
$(document).ready(function(){
    $('#list').dataTable();

    $('.view_user').click(function(){
        uni_modal("<i class='fa fa-id-card'></i> User Details","view_user.php?id="+$(this).attr('data-id'));
    });
});
</script>
