<script src="assets/plugins/summernote/summernote-bs4.min.js"></script> <!-- Add this line if not already added -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
$(document).ready(function() {
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
});
</script>
<?php if(!isset($conn)){ include 'db_connect.php'; } ?>
<div class="col-lg-12">
  <div class="card card-outline card-warning">
    <div class="card-body">
      <form action="" id="manage-project" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Project Name</label>
              <input type="text" class="form-control form-control-sm" required name="name" value="<?php echo isset($name) ? $name : '' ?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="">Status</label>
              <select name="status" id="status" class="custom-select custom-select-sm">
                <option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Pending</option>
                <option value="3" <?php echo isset($status) && $status == 3 ? 'selected' : '' ?>>On-Hold</option>
                <option value="5" <?php echo isset($status) && $status == 5 ? 'selected' : '' ?>>Done</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Start Date</label>
              <input type="date" class="form-control form-control-sm" autocomplete="off" required name="start_date" value="<?php echo isset($start_date) ? date("Y-m-d",strtotime($start_date)) : '' ?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">End Date</label>
              <input type="date" class="form-control form-control-sm" autocomplete="off" required name="end_date" value="<?php echo isset($end_date) ? date("Y-m-d",strtotime($end_date)) : '' ?>">
            </div>
          </div>
        </div>
        <div class="row">
          <?php if($_SESSION['login_type'] == 1 || $_SESSION['login_type'] == 2 || $_SESSION['login_type'] == 3 || $_SESSION['login_type'] == 4 || $_SESSION['login_type'] == 7): ?>
          <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Sales and Support</label>
              <select class="form-control form-control-sm select2" required multiple="multiple" name="manager_id">
                <option></option>
                <?php
                $managers = $conn->query( "SELECT *,concat(firstname,' ',lastname) as name FROM users where type IN (2, 3) order by concat(firstname,' ',lastname) asc" );

                while ( $row = $managers->fetch_assoc() ):
                  ?>
                <option value="<?php echo $row['id'] ?>" <?php echo isset($manager_id) && in_array($row['id'],explode(',',$manager_id)) ? "selected" : '' ?>> <?php echo ucwords($row['name']) ?></option>
                <?php endwhile; ?>
              </select>
            </div>
          </div>
          <?php else: ?>
          <input type="hidden" name="manager_id" value="<?php echo $_SESSION['login_id'] ?>">
          <?php endif; ?>
         
			 <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">QA Team Members</label>
              <select class="form-control form-control-sm select2" required multiple="multiple" name="user_ids[]">
                <option></option>
                <?php
                $employees = $conn->query( "SELECT *,concat(firstname,' ',lastname) as name FROM users where type = 3 order by concat(firstname,' ',lastname) asc " );
                while ( $row = $employees->fetch_assoc() ):
                  ?>
                <option value="<?php echo $row['id'] ?>" <?php echo isset($user_ids) && in_array($row['id'],explode(',',$user_ids)) ? "selected" : '' ?>><?php echo ucwords($row['name']) ?></option>
                <?php endwhile; ?>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Team Lead</label>
              <select class="form-control form-control-sm select2" required multiple="multiple" name="user_ids[]">
                <option></option>
                <?php
                $employees = $conn->query( "SELECT *,concat(firstname,' ',lastname) as name FROM users where type = 4 order by concat(firstname,' ',lastname) asc " );
                while ( $row = $employees->fetch_assoc() ):
                  ?>
                <option value="<?php echo $row['id'] ?>" <?php echo isset($user_ids) && in_array($row['id'],explode(',',$user_ids)) ? "selected" : '' ?>><?php echo ucwords($row['name']) ?></option>
                <?php endwhile; ?>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Research Analyst</label>
              <select class="form-control form-control-sm select2" required multiple="multiple" name="user_ids[]">
                <option></option>
                <?php
                $employees = $conn->query( "SELECT *,concat(firstname,' ',lastname) as name FROM users where type = 5 order by concat(firstname,' ',lastname) asc " );
                while ( $row = $employees->fetch_assoc() ):
                  ?>
                <option value="<?php echo $row['id'] ?>" <?php echo isset($user_ids) && in_array($row['id'],explode(',',$user_ids)) ? "selected" : '' ?>><?php echo ucwords($row['name']) ?></option>
                <?php endwhile; ?>
              </select>
            </div>
          </div>
			 <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Content Writer</label>
              <select class="form-control form-control-sm select2" multiple="multiple" name="user_ids[]">
                <option></option>
                <?php
                $employees = $conn->query( "SELECT *,concat(firstname,' ',lastname) as name FROM users where type = 6 order by concat(firstname,' ',lastname) asc " );
                while ( $row = $employees->fetch_assoc() ):
                  ?>
                <option value="<?php echo $row['id'] ?>" <?php echo isset($user_ids) && in_array($row['id'],explode(',',$user_ids)) ? "selected" : '' ?>><?php echo ucwords($row['name']) ?></option>
                <?php endwhile; ?>
              </select>
            </div>
          </div>
			 <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Development Team Lead</label>
              <select class="form-control form-control-sm select2" multiple="multiple" name="user_ids[]">
                <option></option>
                <?php
                $employees = $conn->query( "SELECT *,concat(firstname,' ',lastname) as name FROM users where type = 7 order by concat(firstname,' ',lastname) asc " );
                while ( $row = $employees->fetch_assoc() ):
                  ?>
                <option value="<?php echo $row['id'] ?>" <?php echo isset($user_ids) && in_array($row['id'],explode(',',$user_ids)) ? "selected" : '' ?>><?php echo ucwords($row['name']) ?></option>
                <?php endwhile; ?>
              </select>
            </div>
          </div>
			<div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Word Count</label>
              <input type="number" class="form-control form-control-sm" required name="wordcount" value="<?php echo isset($wordcount) ? $wordcount : '' ?>">
            </div>
          </div>
			<div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Upload File</label>
              <input type="file" class="form-control form-control-sm" required name="uploaded_files" value="<?php echo isset($uploaded_files) ? $uploaded_files : ''?>">
            </div>
          </div>
		
        </div>
        <div class="row">
          <div class="col-md-10">
            <div class="form-group">
              <label for="" class="control-label">Description</label>
              <textarea name="description" id="" cols="30" rows="10" required class="form-control summernote">
						<?php echo isset($description) ? $description : '' ?>
					</textarea>
            </div>
          </div>
        </div>
      </form>
    </div>
    <div class="card-footer border-top border-warning">
      <div class="d-flex w-100 justify-content-center align-items-center">
        <button class="btn bg-gradient-warning mx-2" form="manage-project">Save</button>
        <button class="btn btn-flat bg-gradient-secondary mx-2" type="button" onclick="location.href='index.php?page=project_list'">Cancel</button>
      </div>
    </div>
  </div>
</div>



<script>

	$('#manage-project').submit(function(e){
		e.preventDefault()
		start_load()
		
		var formData = new FormData(this);

		$.ajax({
			url:'ajax.php?action=save_project',
			data: formData,
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp == 1){
					alert_toast('Data successfully saved',"success");
					setTimeout(function(){
						location.href = 'index.php?page=project_list'
					},2000)
				}
			}
		});
	});
</script> 



