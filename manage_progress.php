<?php 
include 'db_connect.php';
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM user_productivity where id = ".$_GET['id'])->fetch_array();
    foreach($qry as $k => $v){
        $$k = $v;
    }
}
?>
<div class="container-fluid">
    <form action="" id="manage-progress">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <input type="hidden" name="project_id" value="<?php echo isset($_GET['pid']) ? $_GET['pid'] : '' ?>">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-md-5">
                    <?php if(!isset($_GET['tid'])): ?>
                     <div class="form-group">
                        <label for="" class="control-label">Task Name</label>
                        <select class="form-control form-control-sm select2" name="task_id" onchange="showWordcount(this)">
                            <?php 
                            $tasks = $conn->query("SELECT * FROM task_list where project_id = {$_GET['pid']} order by task asc ");
                            // Add an empty option only if no task is selected
                            if (!isset($task_id)) {
                                echo '<option></option>';
                            }
                            while($row= $tasks->fetch_assoc()):
                            ?>
                            <option value="<?php echo $row['id'] ?>" <?php echo isset($task_id) && $task_id == $row['id'] ? "selected" : '' ?>><?php echo ucwords($row['task']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                            <?php else: ?>
                    <input type="hidden" name="task_id" value="<?php echo isset($_GET['tid']) ? $_GET['tid'] : '' ?>">
                            <?php endif; ?>
                    <div class="form-group">
                        <label for="">Subject</label>
                        <input type="text" class="form-control form-control-sm" name="subject" value="<?php echo isset($subject) ? $subject : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="">Date</label>
                        <input type="date" class="form-control form-control-sm" name="date" value="<?php echo isset($date) ? date("Y-m-d",strtotime($date)) : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="">Start Time</label>
                        <input type="time" class="form-control form-control-sm" name="start_time" value="<?php echo isset($start_time) ? date("H:i",strtotime("2020-01-01 ".$start_time)) : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="">End Time</label>
                        <input type="time" class="form-control form-control-sm" name="end_time" value="<?php echo isset($end_time) ? date("H:i",strtotime("2020-01-01 ".$end_time)) : '' ?>" required>
                    </div>
                    
                   <?php 
// Assuming $task_id is set based on user input or some other source
$task_id = isset($_GET['task_id']) ? $_GET['task_id'] : null;

// Now you can use $task_id safely
?>

<div class="form-group" id="assigned-wordcount" style="display: none;">
    <label for="" class="control-label">Assigned Wordcount</label><br>
    <?php
// Assuming $conn is your database connection
$project_id = $_GET['pid']; // Assuming you're getting project_id from somewhere

// Fetch tasks along with their wordcounts
$tasks = $conn->query("SELECT id, task, assignedwordcount FROM task_list WHERE project_id = $project_id ORDER BY task ASC");

// Display tasks and their wordcounts
while ($row = $tasks->fetch_assoc()): ?>
    <div class="task">
        <label class="task-name"><?php echo ucwords($row['task']); ?></label>
        <span class="wordcount"><?php echo $row['assignedwordcount']; ?></span>
    </div>
<?php endwhile; ?>

</div>
                    <div class="form-group">
                        <label for="">WordCount</label>
                        <input type="number" class="form-control form-control-sm" name="wordcount" value="<?php echo isset($wordcount) ? $wordcount : '' ?>" required>
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
                </div>
                <div class="col-md-7">
                    <div class="form-group">
                        <label for="">Comment/Progress Description</label>
                        <textarea name="comment" id="" cols="30" rows="10" class="summernote form-control" required="">
                            <?php echo isset($comment) ? $comment : '' ?>
                        </textarea>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function showWordcount(select) {
    var assignedWordcount = document.getElementById("assigned-wordcount");
    var selectedOption = select.options[select.selectedIndex];
    var wordcountInput = document.querySelector('input[name="wordcount"]');
    
    if (selectedOption.value !== "") {
        assignedWordcount.style.display = "block";
        wordcountInput.value = selectedOption.getAttribute('data-wordcount');
    } else {
        assignedWordcount.style.display = "none";
        wordcountInput.value = '';
    }
}


    $(document).ready(function(){
    $('.summernote').summernote({
        height: 200,
        toolbar: [
            [ 'style', [ 'style' ] ],
            [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
            [ 'fontname', [ 'fontname' ] ],
            [ 'fontsize', [ 'fontsize' ] ],
            [ 'color', [ 'color' ] ],
            [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],

            [ 'table', [ 'table' ] ],
            ['insert', ['link', 'picture', 'video', 'hr']],
            [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
        ]
    })
     $('.select2').select2({
        placeholder:"Please select here",
        width: "100%"
      });
     })
    $('#manage-progress').submit(function(e){
        e.preventDefault()
        start_load()
        $.ajax({
            url:'ajax.php?action=save_progress',
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
