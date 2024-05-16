<?php
include 'db_connect.php'; // Add semicolon after include statement

if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT * FROM task_list where id = " . $_GET['id'])->fetch_array();
    foreach ($qry as $k => $v) {
        $$k = $v;
    }
}
?>
<div class="container-fluid">
    <dl>
        <dt><b class="border-bottom border-primary">Task</b></dt>
        <dd><?php echo ucwords($task) ?></dd>
    </dl>
    <dl>
        <dt><b class="border-bottom border-primary">Status</b></dt>
        <dd>
            <?php
            if ($status == 1) {
                echo "<span class='badge badge-secondary'>Pending</span>";
            } elseif ($status == 2) {
                echo "<span class='badge badge-primary'>On-Progress</span>";
            } elseif ($status == 3) {
                echo "<span class='badge badge-success'>Done</span>";
            }
            ?>
        </dd>
    </dl>
    <dl>
        <dt><b class="border-bottom border-primary">Description</b></dt>
        <dd><?php echo html_entity_decode($description) ?></dd>
    </dl>
	 <dl>
        <dt><b class="border-bottom border-primary">Wordcount</b></dt>
        <dd><?php echo html_entity_decode($assignedwordcount) ?></dd>
    </dl>
    <dl>
        <dt><b class="border-bottom border-primary">Attachment</b></dt>
        <dd>
            <?php
            if (!empty($uploaded_files)) {
                // Escape the filename to prevent potential security vulnerabilities
                $escaped_filename = htmlspecialchars($uploaded_files);
                echo "<a href='assets/files/$escaped_filename' download='$uploaded_files'>$uploaded_files</a>";
            } else {
                echo 'No Attachment';
            }
            ?>
        </dd>
    </dl>
</div>
