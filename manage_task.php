<?php 
include 'db_connect.php';
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM task_list where id = ".$_GET['id'])->fetch_array();
	foreach($qry as $k => $v){
		$$k = $v;
	}
}

?>
<div class="container-fluid">
	<form action="" id="manage-task">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<input type="hidden" name="project_id" value="<?php echo isset($_GET['pid']) ? $_GET['pid'] : '' ?>">
		<div class="form-group">
			<label for="">Task</label>
			<input type="text" class="form-control form-control-sm" name="task" value="<?php echo isset($task) ? $task : '' ?>" required>
		</div>
<!--	<div class="form-group">
    <label for="assigned_user">Assign to</label>
    <select name="assigned_user" id="assigned_user" class="select2 form-control-sm">
        <?php
        if (!empty($user_ids)) {
            $user_ids_array = explode(',', $user_ids);
            $user_ids = implode(',', array_map('intval', $user_ids_array));

            $query = "SELECT u.*, CONCAT(u.firstname, ' ', u.lastname) AS name 
                      FROM users u 
                      WHERE u.id IN ($user_ids)"; // Changed query to directly fetch users based on IDs

            $members = $conn->query($query);

            if ($members && $members->num_rows > 0) {
                while ($row = $members->fetch_assoc()): ?>
                    <option value="<?php echo $row['id']; ?>">
                        <?php echo ucwords($row['name']); ?>
                    </option>
                <?php
                endwhile;
            } else {
                echo '<option value="">No users found</option>';
            }
        } else {
            echo '<option value="">User IDs not provided</option>';
        }
        ?>
    </select>
</div>-->





		<div class="form-group">
    <label for="">WordCount</label>
    <input type="number" class="form-control form-control-sm" name="assignedwordcount" value="<?php echo isset($assignedwordcount) ? $assignedwordcount : '' ?>" required>
</div>
		<div class="form-group">
			<label for="">Description</label>
			<textarea name="description" id="" cols="30" rows="10" class="summernote form-control">
				<?php echo isset($description) ? $description : '' ?>
			</textarea>
		</div>
		
		
            <div class="form-group">
              <label for="" class="control-label">Upload File</label>
              <input onchange="checkFileSize(this)" accept=".pdf, .docx, .zip, .rar, .txt, .pptx, .xlsx, .mp3, .wav, .mp4, .avi, .mkv" type="file" class="form-control form-control-sm" name="uploaded_files" value="<?php echo isset($uploaded_files) ? $uploaded_files : ''?>" >
              <script>
function checkFileSize(input) {
    if (input.files && input.files[0]) {
        const maxSize = 32 * 1024 * 1024 * 1024; // 32GB in bytes
        if (input.files[0].size > maxSize) {
            alert('File size exceeds the maximum limit (32GB). Please select a smaller file.');
            input.value = ''; // Reset the file input field
        }
    }
}
</script>
          
          </div>
		<div class="form-group">
			<label for="">Status</label>
			<select name="status" id="status" class="custom-select custom-select-sm">
				<option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Pending</option>
				<option value="2" <?php echo isset($status) && $status == 2 ? 'selected' : '' ?>>On-Progress</option>
				<option value="3" <?php echo isset($status) && $status == 3 ? 'selected' : '' ?>>Done</option>
			</select>
		</div>
	</form>
</div>

<script>
	$(document).ready(function(){


	$('.summernote').summernote({
        height: 300, // Text editor height
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video', 'hr', 'table']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });
     })
    
    $('#manage-task').submit(function(e){
    	e.preventDefault()
    	start_load()
    	$.ajax({
    		url:'ajax.php?action=save_task',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp == 1){
					alert_toast('Data successfully saved',"success");
					setTimeout(function(){
						location.reload()
					},1500)
				}
			}
    	})
    })
</script>