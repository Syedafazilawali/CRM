<!DOCTYPE html>
<html lang="en">
	<link rel="icon" href="assets/uploads/favicon.png" type="image/x-icon">
	<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

	
<style>
	
	.w3layouts-main {
  background-image: url('assets/uploads/bg.png');
  background-repeat: no-repeat; /* Changed 'repeat-x' to 'no-repeat' */
  animation: slideleft 20000s infinite linear;
  -webkit-animation: slideleft 20000s infinite linear;
  background-size: cover;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  background-attachment: cover;
  position: relative;
  min-height: 100vh;

  /* Overlay a black color with some transparency */
  background-color: rgba(0, 0, 0, 0.5) !important;
}

</style>
<?php 
session_start();
include('./db_connect.php');
 ob_start();
 // if(!isset($_SESSION['system'])){

  $system = $conn->query("SELECT * FROM system_settings")->fetch_array();
  foreach($system as $k => $v){
   $_SESSION['system'][$k] = $v;
  }
 // }
 ob_end_flush();
?>
<?php 
if(isset($_SESSION['login_id']))

header("location:index.php?page=home");

?>
<?php include 'header.php' ?>
<body class="w3layouts-main login-page">
	<img src="assets/uploads/favicon.png"/>
	<br>
<div class="login-box">
 <div class="login-logo">
  <a href="#" class="text-white"><b><?php echo $_SESSION['system']['name'] ?> - CRM</b></a>
 </div>
 <!-- /.login-logo -->
 <div class="card">
  <div class="card-body login-card-body">
   <form action="ajax.php" id="login-form">
    <div class="input-group mb-3">
     <input type="email" class="form-control" name="email" required placeholder="Email">
     <div class="input-group-append">
      <div class="input-group-text">
       <span class="fas fa-envelope"></span>
      </div>
     </div>
    </div>
   <div class="input-group mb-3">
    <input type="password" class="form-control" name="password" id="password" required placeholder="Password">
    <div class="input-group-append">
        <div class="input-group-text">
            <span class="fas fa-lock"></span>
        </div>
        <div class="input-group-text">
            <span id="show-password" class="fas fa-eye" onclick="togglePassword()"></span>
        </div>
    </div>
</div>
    <div class="row">
     <div class="col-4">
      
     </div>
     
     <div class="col-4">
      <button type="submit" class="btn btn-warning btn-block"><b>Log In</b></button>
     </div>
     
    </div>
   </form>
  </div>
 
 </div>
</div>

	
<script>
    function togglePassword() {
        var passwordField = document.getElementById('password');
        var showPasswordButton = document.getElementById('show-password');

        if (passwordField.type === "password") {
            passwordField.type = "text";
            showPasswordButton.className = "fas fa-eye-slash";
        } else {
            passwordField.type = "password";
            showPasswordButton.className = "fas fa-eye";
        }
    }
</script>
<script>
 $(document).ready(function(){
  $('#login-form').submit(function(e){
  e.preventDefault()
  start_load()
  if($(this).find('.alert-danger').length > 0 )
   $(this).find('.alert-danger').remove();
  $.ajax({
   url:'ajax.php?action=login',
   method:'POST',
   data:$(this).serialize(),
   error:err=>{
    console.log(err)
    end_load();

   },
   success:function(resp){
    if(resp == 1){
     location.href ='index.php?page=home';
    }else{
     $('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>')
     end_load();
    }
   }
  })
 })
 })
</script>
<?php include 'footer.php' ?>

</body>
</html>